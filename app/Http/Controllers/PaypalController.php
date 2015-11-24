<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Log;
use App\User;
use App\Order;
use App\Payout;
use App\Template;
use App\PaypalPdt;
use App\PaypalIpn;
use App\Commission;
use App\PaypalDump;
use App\Http\Requests;
use App\Contracts\Payment;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client as GuzzleClient;
use App\Contracts\Payout as PayoutContract;

class PaypalController extends Controller
{

    public function ipn(Request $request)
    {
        $input = $request->input();

        $ipn_valid = $this->verfiryIpn($input);

        if ($ipn_valid) {

            PaypalDump::create([
                'dump'      => serialize($input),
            ]);

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

                    Log::info('PAYPAL IPN: Created a paypal transaction record');
                }

            }
            elseif($txn_type == 'masspay') {


            }
           

        } 
        else {

            Log::error("PAYPAL IPN: Paypal Ipn Failed");


        }
    }

    protected function verfiryIpn(array $input)
    {
        $input = ['cmd' => '_notify-validate'] + $input;

        // $preValidateUrl = http_build_query($input);

        // $client = new GuzzleClient(env('PAYPAL_HOST_URL'));

        // $validateUrl = '?' . $preValidateUrl;

        // $response = $client->post($validateUrl)->send();

        $response = (new GuzzleClient)->request('POST', env('PAYPAL_HOST_URL'), $input);

        $res = $response->getBody();

        if (strcmp ($res, "VERIFIED") == 0) return true;

        return false;
    }
    
}
