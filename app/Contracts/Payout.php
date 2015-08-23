<?php

namespace App\Contracts;

use App\User;
use App\Contracts\Payment;

interface Payout {


    public function earnings(User $user);

    public function commission(User $user);

    //public function pay(Payment $payment); // send mass payout

    
}