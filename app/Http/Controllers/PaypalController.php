<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Payout;
use App\User;
use App\Order;
use App\Commission;
use App\Template;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Contracts\Payout as PayoutContract;
use App\Contracts\Payment;

class PaypalController extends Controller
{

    public function ipn(Request $request)
    {
        $input = $request->input();

        $ipn_valid = $this->verfiryIpn($input);

        PaypalDump::create([
            'dump'      => serialize($input),
            ]);

        if ($ipn_valid) {

            // check txn type
            $txn_type = $input['txn_type'];

            if($txn_type == 'web_accept') {

                $customVars = explode(",", $input['custom']);

                $input['template_id'] = $customVars[0];

                $input['licence_type'] = $customVars[1];

                //check if payment was successful
                $paymentSuccessful = $input['payment_status'] == 'Completed';

                $oldTransaction = PaypalIpn::where('txn_id', $input['txn_id'])->exists();

                // Payment was successful and Transaction is new
                if($paymentSuccessful && !$oldTransaction) {

                    $paypalIpn = PaypalIpn::create($input);

                    Log::info('created a paypal transaction record');
                }

            }
            elseif($txn_type == 'masspay') {


            }
           

        } 
        else {

            Log::error("Paypal Ipn Failed" . $res);


        }
    }

    protected function verfiryIpn(array $input)
    {
        $input = ['cmd' => '_notify-validate'] + $input;

        $preValidateUrl = http_build_query($input);

        $client = new GuzzleClient(env('PAYPAL_HOST_URL'));

        $validateUrl = '?' . $preValidateUrl;

        $response = $client->post($validateUrl)->send();

        $res = $response->getBody();

        if (strcmp ($res, "VERIFIED") == 0) return true;

        return false;
    }
    
}
