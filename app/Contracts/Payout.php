<?php

namespace App\Contracts;

interface Payout {


    public function earnings($user);

    public function commission($user);

    public function pay(); // send mass payout

    
}