<?php

namespace App\Contracts;

use App\User;

interface Payout {


    public function earnings(User $user);

    public function commission(User $user);

    public function pay(); // send mass payout

    
}