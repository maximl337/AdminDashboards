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

                return $lines;
 
                $response = [];

                for ($i=0; $i<count($lines);$i++) {

                    list($key,$val) = explode("=", $lines[$i]);

                    $response[urldecode($key)] = urldecode($val);

                }

                return $response;
                

                //return $contents;

                $c = explode("\n", $contents);

                return $c;

            }
        }

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, env('PAYPAL_HOST_URL'));
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        // // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        // // //set cacert.pem verisign certificate path in curl using 'CURLOPT_CAINFO' field here,
        // // //if your server does not bundled with default verisign certificates.
        // // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: www.sandbox.paypal.com"));
        // $res = curl_exec($ch);
        // curl_close($ch);

        // if(!$res){
        //     return "error";
        // } else {
        //      // parse the data
        //     $lines = explode(" ", $res);

        //     $keyarray = [];

        //     if (strcmp ($lines[0], "SUCCESS") == 0) {

        //         for ($i=1; $i<count($lines);$i++) {

        //             list($key,$val) = explode("=", $lines[$i]);

        //             $keyarray[urldecode($key)] = urldecode($val);

        //         }

        //     return $res;
        //     }
        //     else if (strcmp ($lines[0], "FAIL") == 0) {
        //         // log for manual investigation
        //         return "error";
        //     }
        // }
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
