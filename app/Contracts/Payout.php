<?php

namespace App\Contracts;

use App\User;
use App\Template;

interface Payout {


    public function earnings(User $user);

    public function commission(Template $template);

    public function massPay(); // send mass payout

    
}