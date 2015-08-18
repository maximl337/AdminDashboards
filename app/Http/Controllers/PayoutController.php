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

class PayoutController extends Controller
{
    
    public function test()
    {
        // Get user for testing
        $user = User::where('email', 'angad_dby@hotmail.com')->firstOrFail();

        $templates = $user->templates()->get();

        $seller_payment = 0;

        $grand_total = 0;

        foreach($templates as $template) {

            $order_amount_per_template = 0;

            $orders = $template->orders()->get();

            foreach($orders as $order) {

                $order_amount_per_template += ( $order->payment_gross - $order->tax );
            
            }

            $commission = Commission::where('amount', '<=', $order_amount_per_template)->orderBy('amount', 'DESC')->first();

            //$seller_payment += $order_amount_per_template * 50 / 100;

            $seller_payment += $order_amount_per_template * $commission->percentage / 100;

            $grand_total += $order_amount_per_template;

            $commission_amount += $grand_total - $seller_payment;

        }

        
        return [

            'earnings' => $seller_payment,

            'commission' => $commission_amount,

            'grand_total' => $grand_total

        ];

    }
}
