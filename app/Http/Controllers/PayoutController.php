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

        //$user = User::findOrFail($id);

        return $payoutContract->massPay($payment);
        
    }

    // public function testPayment(Payment $payment)
    // {
    //     $payout = $payment->sendSinglePayment('tst', 'tst', 'tst', 'tst');

    //     return $payout;
    // }

    
}
