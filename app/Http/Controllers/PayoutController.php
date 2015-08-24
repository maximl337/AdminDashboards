<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use App\Payout;
use App\User;
use App\Order;
use App\Commission;
use App\Template;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Contracts\Payout;
use App\Contracts\Payment;

class PayoutController extends Controller
{

    public function test(Payout $payoutContract, Payment $payment)
    {

        return $payoutContract->massPay($payment);
        
    }


    public function testPayout($id, Payout $payoutContract)
    {
        $user = User::findOrFail($id);

        return $payoutContract->earnings($user);
    }

    public function payoutDetails($id, Payment $payment)
    {
        return $payment->getBatchPaymentDetails($id);
    }

    public function PaypalIpn(Request $request)
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
