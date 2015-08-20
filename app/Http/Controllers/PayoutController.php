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

class PayoutController extends Controller
{


    public function test($id, PayoutContract $payoutContract)
    {

        $user = User::findOrFail($id);

        $earnings = $payoutContract->earnings($user);

        return $earnings;
        
    }
}
