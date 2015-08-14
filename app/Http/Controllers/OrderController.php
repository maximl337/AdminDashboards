<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Guzzle\Service\Client as GuzzleClient;
use Log;
use App\PaypalIpn;
use App\PaypalDump;
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
        $pp_hostname = env('PAYPAL_HOST_URL'); 

        //$req = '?cmd=_notify-synch';

        $req = [
            "cmd" => "_notify-synch",
            "tx"  => $tx_token,
            "at"  => $auth_token
        ];


        $preValidateUrl = http_build_query($req);

        $validateUrl = '?' . $preValidateUrl;
         
        $tx_token = $transaction_id;
        $auth_token = env('PAYPAL_PDT_TOKEN');
        //$req .= "&tx=$tx_token&at=$auth_token";

        $client = new GuzzleClient(getenv('PAYPAL_HOST_URL'));

        $response = $client->post($validateUrl)->send();

        $res = $response->getBody();

        if(!$res){
            abort(404);
        } else {
            return $res;
            // parse the data
            $lines = explode("\n", $res);
            $keyarray = array();
            if (strcmp ($lines[0], "SUCCESS") == 0) {

                for ($i=1; $i<count($lines);$i++){

                    list($key,$val) = explode("=", $lines[$i]);
                    $keyarray[urldecode($key)] = urldecode($val);
                }
                // check the payment_status is Completed
             
                // check that txn_id has not been previously processed
                // check that receiver_email is your Primary PayPal email
                // check that payment_amount/payment_currency are correct
                // process payment
                $firstname = $keyarray['first_name'];
                $lastname  = $keyarray['last_name'];
                $itemname  = $keyarray['item_name'];
                $amount    = $keyarray['payment_gross'];
                 
                echo ("<p><h3>Thank you for your purchase!</h3></p>");
                echo ("<b>Payment Details</b><br>\n");
                echo ("<li>Name: $firstname $lastname</li>\n");
                echo ("<li>Item: $itemname</li>\n");
                echo ("<li>Amount: $amount</li>\n");
                echo ("");
            }
            else if (strcmp ($lines[0], "FAIL") == 0) {
                // log for manual investigation
            }
            
        
        }
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
