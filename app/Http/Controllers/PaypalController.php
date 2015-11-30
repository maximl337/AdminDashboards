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

        // check if IPN is legit
        $ipn_valid = $this->verfiryIpn($input);

        // create a dump anyway
        $dump = PaypalDump::create([
                    'dump'      => serialize($input),
                ]);

        if ($ipn_valid) {

            // check txn type
            $txn_type = $input['txn_type'];

            // Save dump txn type
            $dump->update(['type' => $txn_type]);

            if($txn_type == 'web_accept') {

                //  Find a way to store transaction IPN in case PDT fails
                //  Make a mechanism where buyers can ask for refund

            }
            elseif($txn_type == 'masspay') {

                // Check payment status
                if($input['payment_status'] == 'Denied') {

                    // Mail Admin of payment failure ( maybe email directly from papertrail?)
                    Log::info('Masspay IPN: Denied', [serialize($input)]);
                } 

                // Parse to get manageable array
                $arr = $this->processMassPayIpn($input);

                // update payout items 
                foreach($arr as $v) {

                    $payout = Payout::where('unique_id', $v['unique_id']);

                    $payout->update($v);
                }
                
            }

        } 
        else {

            Log::error("PAYPAL IPN: Paypal Ipn Failed");

        }
    }

    /**
     * Verify incoming IPN is legit
     * @param  array  $input incoming request
     * @return boolean    
     */
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

    /**
     * Parse incoming Masspay IPN
     * @param  array  $inarray incoming ipn request
     * @return array          parsed array
     */
    protected function processMassPayIpn(array $inarray) {

        $outarray = [];

        foreach ( $inarray as $k => $v ) {

            if ( preg_match( "/^receiver_email_(\d+)$/", $k, $m ) ) {
                $outarray[ $m[1] ][ 'email' ] = $v;
            }
            
            if ( preg_match( "/^unique_id_(\d+)$/", $k, $m ) ) {
                $outarray[ $m[1] ][ 'unique_id' ] = $v;
            }
            
            if ( preg_match( "/^masspay_txn_id_(\d+)$/", $k, $m ) ) {
                $outarray[ $m[1] ][ 'masspay_txn' ] = $v;
            }
            
            if ( preg_match( "/^status_(\d+)$/", $k, $m ) ) {
                $outarray[ $m[1] ][ 'status' ] = strtolower($v);
            }

            if ( preg_match( "/^reason_code_(\d+)$/", $k, $m ) ) {
                $outarray[ $m[1] ][ 'reason_code' ] = strtolower($v);
            }

            if ( preg_match( "/^mc_gross_(\d+)$/", $k, $m ) ) {
                $outarray[ $m[1] ][ 'mc_gross' ] = strtolower($v);
            }

            if ( preg_match( "/^mc_fee_(\d+)$/", $k, $m ) ) {
                $outarray[ $m[1] ][ 'mc_fee' ] = strtolower($v);
            }
        }

        return $outarray;
    }
    
}
