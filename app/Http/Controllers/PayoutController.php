<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Payout;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PayoutController extends Controller
{
    
    public function test()
    {
        // Get user for testing
        $user = User::where('email', 'angad_dby@hotmail.com')->firstOrFail();

        // Get total orders of user
        $orders = $user->orders()->with('template')->get();

        $grand_total = 0;

        foreach( $orders as $order ) {

            $amount = ( (float) $order->payment_gross - (float) $order->tax );

            $grand_total += $amount;

        }

        return [

            'total_orders' => $orders->count(),

            'grand_total' => $grand_total
            
        ];
        


        // // get all payouts
        // $payouts = $user->payouts()->where('status', 'complete')->get();

        // // init payout amunt
        // $payout_amount = 0;

        // // init pre total
        // $pre_total = 0;

        // // init previous payout total
        // $previous_payout_total = 0;

        // // init commision percentation
        // $commision_rate = 50;

        // // init commission percentage
        // $commision_percentage = ( $commision_rate / 100 );

        // // init commision amount
        // $commission_amount = 0;

        // // grand total
        // $grand_total = 0;

        // // iterate through all orders
        // foreach($total_orders as $order) {

        //     // iterate through templates for price
        //     foreach($order->template as $template) {

        //         if(count($template) > 2000) {

        //             $commision_rate = 45;

        //         }
        //         elseif(count($template) > 3000) {

        //             $commision_rate = 40;

        //         }

        //         //if($template->exclusive) $commision_rate = 35;

        //         // This is the total amount made by seller 
        //         $grand_total += $template->price;

        //     } // EO inner foreach

        // } // eo order foreach

        // // Now we deduct previous successful payouts from the $pre_total

        // foreach($payouts as $payout) {

        //     $previous_payout_total += $payout->amount;

        // }

        // Now the final calculation

        // Commission amount



    }
}
