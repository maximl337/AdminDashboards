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
        // $pp_hostname = env('PAYPAL_HOST_URL'); 

        // //$req = '?cmd=_notify-synch';

        // $tx_token = $transaction_id;
        // $auth_token = env('PAYPAL_PDT_TOKEN');

        // $req = [
        //     "cmd" => "_notify-synch",
        //     "tx"  => $tx_token,
        //     "at"  => $auth_token
        // ];


        // $preValidateUrl = http_build_query($req);

        // $validateUrl = '?' . $preValidateUrl;

        // $client = new GuzzleClient(getenv('PAYPAL_HOST_URL'));

        // $response = $client->post($validateUrl)->send();

        // $res = $response->getBody();
        // 
        // SUCCESS 
        // mc_gross=23.50 
        // protection_eligibility=Eligible 
        // address_status=confirmed 
        // payer_id=S9H3YCCR9VKX2 
        // tax=3.50 
        // address_street=1+Maire-Victorin 
        // payment_date=20%3A02%3A41+Aug+13%2C+2015+PDT 
        // payment_status=Completed 
        // charset=windows-1252 
        // address_zip=M5A+1E1 
        // first_name=Angad 
        // mc_fee=0.98 
        // address_country_code=CA 
        // address_name=Angad+Dubey 
        // custom=12%2Csingle 
        // payer_status=verified 
        // business=angad_dubey_bd_seller%40gmail.com 
        // address_country=Canada 
        // address_city=Toronto 
        // quantity=1 
        // payer_email=angad_dubey_bd_buyer%40hotmail.com 
        // txn_id=63W73412XG250043F 
        // payment_type=instant 
        // last_name=Dubey 
        // address_state=Ontario 
        // receiver_email=angad_dubey_bd_seller%40gmail.com 
        // payment_fee= 
        // receiver_id=H3JF3H2DJ7EKG 
        // txn_type=web_accept 
        // item_name=Deserunt+perferendis+molestias+reiciendis+adipisci+animi. 
        // mc_currency=CAD 
        // item_number= 
        // residence_country=CA 
        // handling_amount=0.00 
        // transaction_subject=12%2Csingle 
        // payment_gross= 
        // shipping=0.00

        $req = 'cmd=_notify-synch';
        $tx_token = $_GET['tx'];
        $auth_token = env('PAYPAL_PDT_TOKEN');
        $req .= '&tx='.$tx_token.'&at='.$auth_token;
        // Post back to PayPal to validate
        $c = curl_init(env('PAYPAL_HOST_URL')); // SANDBOX
        curl_setopt($c, CURLOPT_POST, true);
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
              
                // Do success stuff
                $lines = explode("\n", $res);
 
                $response = array();

                for ($i=1; $i<count($lines);$i++) {

                    list($key,$val) = explode("=", $lines[$i]);

                    $response[urldecode($key)] = urldecode($val);

                }
                

              return $response;

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
