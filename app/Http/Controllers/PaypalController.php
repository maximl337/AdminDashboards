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

        $dump = PaypalDump::create([
                    'dump'      => serialize($input),
                ]);

        if ($ipn_valid) {

            // check txn type
            $txn_type = $input['txn_type'];

            $dump->update(['type' => $txn_type]);

            if($txn_type == 'web_accept') {


            }
            elseif($txn_type == 'masspay') {

                // parse input;
            }
           

        } 
        else {

            Log::error("PAYPAL IPN: Paypal Ipn Failed");


        }
    }

    protected function verfiryIpn(array $input)
    {
        $input = ['cmd' => '_notify-validate'] + $input;

        $preValidateUrl = http_build_query($input);

        $validateUrl = '?' . $preValidateUrl;

        // $client = new GuzzleClient(env('PAYPAL_HOST_URL'));
        
        // $response = $client->post($validateUrl)->send();

        $response = (new GuzzleClient)->request('POST', env('PAYPAL_HOST_URL') . $validateUrl, []);

        $res = $response->getBody();

        Log::info('PAYPAL IPN: VERIFY', [$res]);

        if (strcmp ($res, "VERIFIED") == 0) return true;

        return false;
    }
    
}
