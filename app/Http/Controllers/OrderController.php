<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Guzzle\Service\Client as GuzzleClient;
use Log;
use App\PaypalIpn;
use App\PaypalDump;
use App\PaypalPdt;
use App\Template;
use App\Order;
use App\Contracts\FileStorage;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    protected $storage;

    public function __construct(FileStorage $storage)
    {
        $this->storage = $storage;
    }

    public function confirmation(Request $request)
    {

        $transaction_id     = $request->get('tx');
        $status             = $request->get('st'); 
        $customVars         = explode(", ", $request->get('cm'));
        $template_id        = $request->get('item_number');
        $licence_type       = $customVars[0];
        $user_id            = isset($customVars[1]) ? $customVars[1] : "";

        $res = $this->paypalPDT($transaction_id);
        
        return view('payment.confirmation', compact('res'));

    }

    protected function paypalPDT($transaction_id)
    {


        $internalResp = [
            'status'    => false
        ];

        // params to post
        $req = 'cmd=_notify-synch';
        $tx_token = $_GET['tx'];
        $auth_token = env('PAYPAL_PDT_TOKEN');
        $req .= '&tx='.$tx_token.'&at='.$auth_token;

        // Post back to PayPal to validate
        $c = curl_init(env('PAYPAL_HOST_URL'));
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $req);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $contents = curl_exec($c);
        $response_code = curl_getinfo($c, CURLINFO_HTTP_CODE);
        curl_close($c);

        PaypalDump::create([
            'dump'      => serialize($contents)
            ]);

        if(!$contents || $response_code != 200) {

            // HTTP error or bad response, do something
            $internalResp['message'] = 'There was an HTTP failure. Transaction details have been recorded and will be investigated.'; 

            return $internalResp;

        } else {

           // Check PayPal verification (FAIL or SUCCESS)
           $status = substr($contents, 0, 4);

           if($status == 'FAIL') {

              $internalResp['message'] = 'Paypal reported transaction as Failed. We have recorded all the information and will investigate.';

              return $internalResp;

            } elseif($status == 'SUCC') {
              
                // Parser
                $lines = explode("\n", $contents);

                $response = [];

                foreach($lines as $line) {

                    if($line == 'SUCCESS') continue;

                    $t = explode("=", $line);

                    if(!isset($t[1])) $t[1] = null;

                    $response[urldecode($t[0])] = urldecode($t[1]);

                } // end foreach
                // EO Parser

                $response['template_id'] = $response['item_number'];

                $template = Template::find($response['template_id']);

                if(!$template) {

                    $internalResp['message'] = 'The request Template was not found in the system. We have recorded the transaction and will investigate';

                    return $internalResp;

                }

                // check that txn_id has not been previously processed
                $orderExists = Order::where('txn_id', $response['txn_id'])->exists();

                if($orderExists) {

                    $internalResp['message'] = 'Our records indicate that this Transaction has been previously fullfilled.';

                    return $internalResp;
                }
            
                // check that receiver_email is your Primary PayPal email

                if($response['receiver_id'] != env('PAYPAL_MERCHANT_ACCOUNT_ID')) {

                    $internalResp['message'] = 'The transaction was not wired to the right account. We have recorded the transaction and will investigate';

                    return $internalResp;

                }

                // check that payment_amount/payment_currency are correct

                $paypalTxnPrice = (float) $response['mc_gross'] - (float) $response['tax'];

                if($response['custom'] == 'single') {

                    $templatePrice = $template->price;
                }
                elseif ($response['custom'] == 'multiple') {

                    $templatePrice = $template->price_multiple;

                }
                elseif ($response['custom'] == 'extended') {

                    $templatePrice = $template->price_extended;

                }
                elseif (empty($response['custom'])) {

                    $internalResp['message'] = 'The correct licence was not provided. We have recorded the transaction and will investigate.';

                    return $internalResp;

                }

                if($paypalTxnPrice != $templatePrice) {

                    $internalResp['message'] = "The payment price of the transaction does not match the price in our records for the template. Expected: " . $template->price . " | Given: " . $paypalTxnPrice . "<br /> We have recoded the transaction and will investigate";

                    return $internalResp;
                }

                   

                $paypalpdt = PaypalPdt::create($response);

                // process the order

                $order = Order::create([
                        'template_id'               => $response['item_number'],
                        'licence_type'              => $response['custom'],
                        'txn_id'                    => $response['txn_id'],
                        'payment_gross'             => $response['mc_gross'],
                        'email'                     => $response['payer_email'],
                        'tax'                       => $response['tax']
                    ]);

                if($response['payment_status'] !== 'Completed') {

                    $internalResp['message'] = 'Paypal indicates this transaction as: ' . $response['payment_status'] . '<br /> We have recorded the transaction and will investigate.';

                    return $internalResp;

                }

                // get rackspack link
                $fileUrl = $this->storage->getTempUrl($template->files_url);
                
                $order->update([
                        'status' => 'complete'
                    ]);

                $internalResp['status'] = true;

                $internalResp['message'] = 'Thank you for your payment. Your transaction has been completed, and a receipt for your purchase has been emailed to you. You may log into your account at www.sandbox.paypal.com/ca to view details of this transaction.';

                $internalResp['transaction'] = [
                    'first_name' => $response['first_name'],
                    'last_name' => $response['last_name'],
                    'amount' => $response['mc_gross'],
                    'template' => $template

                ];

                $internalResp['file'] = [
                    'url' => $fileUrl,
                    'message' => 'This URL will only work for One Hour!'
                ];
                
                return $internalResp;

            } // EO success

        } // EO HTTP ok

    }

    public function paypalIPN(Request $request)
    {

        $input = $request->input();

        $input = ['cmd' => '_notify-validate'] + $input;

        $preValidateUrl = http_build_query($input);

        $client = new GuzzleClient(getenv('PAYPAL_HOST_URL'));

        $validateUrl = '?' . $preValidateUrl;

        $response = $client->post($validateUrl)->send();

        $res = $response->getBody();

        PaypalDump::create([
            'dump'      => serialize($input),
            'response'  => $res
            ]);

        
        if (strcmp ($res, "VERIFIED") == 0) {

            $customVars = explode(",", $input['custom']);

            $input['template_id'] = $customVars[0];

            $input['licence_type'] = $customVars[1];

            //check if payment was successful
            $paymentSuccessful = $input['payment_status'] == 'Completed';

            $oldTransaction = PaypalIpn::where('txn_id', $input['txn_id'])->exists();

            // Payment was successful and Transaction is new
            if($paymentSuccessful && !$oldTransaction) {

                $paypalIpn = PaypalIpn::create($input);

                // GET TXN ID
                // CHECK IF AN ORDER EXISTS WITH TXN ID AND ITEM NUMBER
                // IF EXISTS CHECK STATUS AND UPDATE IF REQUIRED
                // IF NOT EXISTS CREATE ORDER
                Log::info('created a paypal transaction record');
            }

        } 
        else if (strcmp ($res, "INVALID") == 0) {

            
            Log::error('Payment was not successful or transaction was old');

            throw new \Exception('Payment was not successful or transaction was old');
        }
        else {
            Log::error("Paypal Ipn Failed" . $res);

            throw new \Exception("Paypal Ipn Failed" . $res);
        }
    }
}
