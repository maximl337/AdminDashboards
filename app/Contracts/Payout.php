<?php

namespace App\Contracts;

use App\User;
use App\Template;
use App\Contracts\Payment;

interface Payout {


    public function earnings(User $user);

    public function commission(Template $template);

    public function massPay(Payment $payment); // send mass payout

    
}