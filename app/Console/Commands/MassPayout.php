<?php

namespace App\Console\Commands;

use Log;
use App\Contracts\Payout;
use Illuminate\Console\Command;

class MassPayout extends Command
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
    public function __construct(Payout $payout)
    {
        $this->payout = $payout;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        //if(date('d') == 15) {

            //Log::info('Attempted Mass Payout - DISABLED FOR TESTING');

            $this->payout->massPay();

        //}

        
    }
}
