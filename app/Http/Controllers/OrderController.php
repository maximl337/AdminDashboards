<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Guzzle\Service\Client as GuzzleClient;
use Log;
use App\PaypalIpn;
use App\Order;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    public function paypalIPN(Request $request)
    {
        //Log::debug($request->all());

        $input = $request->input();

        $input = ['cmd' => '_notify-validate'] + $input;

        $preValidateUrl = http_build_query($input);

        $client = new GuzzleClient(getenv('PAYPAL_IPN_URL'));

        $validateUrl = '?' . $preValidateUrl;

        $response = $client->post($validateUrl)->send();

        $res = $response->getBody();

        
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

                //create order
                    
            }

        } 
        else if (strcmp ($res, "INVALID") == 0) {

            return "Payment is not legit yo!!!";
        }
        
    }
}
