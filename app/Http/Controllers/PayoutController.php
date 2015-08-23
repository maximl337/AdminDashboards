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

class PayoutController extends Controller
{

    public function test($id, PayoutContract $payoutContract, Payment $payment)
    {

    
        $orders = Order::with('template')->get();

        $templates = [];

        $users = [];

        $payouts = [];

        $earnings = [];

        $payoutItems = [];

        $payoutBatchId = uniqid() . microtime(true);

        // Get users of orders
        foreach($orders as $order) {

            $users[] = $order->template->user()->first();

        } // end for each

        $users = array_unique($users);

        foreach($users as $user) {

            $earnings = $payoutContract->earnings($user); 

            $payoutItemId = $user->id . '-' . microtime(true) . uniqid();

            $payoutItems[] = [

                'sender_item_id'    => $payoutItemId,
                'email'             => $user->email,
                'amount'            => $earnings['pending']

            ];

            Payout::create([
                    'user_id' => $user->id,
                    'amount' => $earnings['pending'],
                    'payout_batch_id' => $payoutBatchId,
                    'payout_item_id' => $payoutItemId,
                ]);

        } // EO foreach

        return $payment->sendBatchPayment($payoutItems, $payoutBatchId);
        
    }

    // public function testPayment(Payment $payment)
    // {
    //     $payout = $payment->sendSinglePayment('tst', 'tst', 'tst', 'tst');

    //     return $payout;
    // }

    
}
