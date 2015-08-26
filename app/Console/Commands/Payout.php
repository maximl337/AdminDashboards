<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contracts\Payout as PayoutContract;
use App\Contracts\Payment;

class Payout extends Command
{   
    protected $payout;

    protected $payment;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mass payout';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PayoutContract $payout, Payment $payment)
    {
        $this->payout = $payout;

        $this->payment = $payment;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        if(date('d') != '25') return;

        $this->payout->massPay($this->payment);
    }
}
