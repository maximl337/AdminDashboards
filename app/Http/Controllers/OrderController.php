<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Guzzle\Service\Client as GuzzleClient;
use Log;
use App\PaypalIpn;
use App\PaypalDump;
use App\PaypalPdt;
use App\Order;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    public function confirmation(Request $request)
    {
        //tx=4M99706209265834U&st=Completed&amt=23%2e50&cc=CAD&cm=2%2csingle&item_number=

        $transaction_id     = $request->get('tx');
        $status             = $request->get('st'); 
        $customVars         = explode(", ", $request->get('cm'));
        $template_id        = $request->get('item_number');
        $licence_type       = $customVars[0];
        $user_id            = isset($customVars[1]) ? $customVars[1] : "";

        $res = $this->paypalPDT($transaction_id);


        // user comes back on the payment confirmation
        // check if PDT of the transaction
        // if transaction was successful create an order 


                                                                              

        
        return view('payment.confirmation', compact('res'));

    }

    protected function paypalPDT($transaction_id)
    {


        $req = 'cmd=_notify-synch';
        $tx_token = $_GET['tx'];
        $auth_token = env('PAYPAL_PDT_TOKEN');
        $req .= '&tx='.$tx_token.'&at='.$auth_token;



        // Post back to PayPal to validate
        $c = curl_init(env('PAYPAL_HOST_URL')); // SANDBOX
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $req);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $contents = curl_exec($c);
        $response_code = curl_getinfo($c, CURLINFO_HTTP_CODE);
        curl_close($c);

        if(!$contents || $response_code != 200) {
            // HTTP error or bad response, do something
            abort($response_code);
        } else {
           // Check PayPal verification (FAIL or SUCCESS)
           $status = substr($contents, 0, 4);

           if($status == 'FAIL') {

              abort(422);

            } elseif($status == 'SUCC') {
              
                //Do success stuff
                $lines = explode("\n", $contents);

                $response = [];

                foreach($lines as $line) {

                    if($line == 'SUCCESS') continue;

                    $t = explode("=", $line);

                    if(!isset($t[1])) $t[1] = null;

                    $response[urldecode($t[0])] = urldecode($t[1]);

                } // end foreach

                $response['template_id'] = $response['item_number'];

                $paypalpdt = PaypalPdt::create($response);

                return $paypalpdt->toArray();

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
