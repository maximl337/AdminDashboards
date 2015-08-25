<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Payout;
use App\Contracts\Payment;

class UpdatePayout extends Command
{
    protected $payment;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updatePayouts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates Payouts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
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
        // get payouts that are null
        $payouts = Payout::whereNull('transaction_status')
                            ->orWhere('transaction_status', '<>', 'SUCCESS')
                            ->get();

        // call paypal to get info
        foreach($payouts as $payout) {

            $payoutItemId = $payout->payout_item_id;

             // get payoutItem
            $payoutItem = $this->payment->getPaymentItemDetails($payoutItemId);

            //sender item id
            $senderItemId = $payoutItem->payout_item->getSenderItemId();

            // trasaction_id
            $transactionId = $payoutItem->getTransactionId();

            // trasaction_status 
            $transactionStatus = $payoutItem->getTransactionStatus();
            
            Payout::where('sender_item_id', $senderItemId)
                    ->update([
                            'transaction_id'        => $transactionId,
                            'transaction_status'    => $transactionStatus
                        ]);


        }
        // update payout 
    }
}
