<?php 

namespace App\Services;

use App\Contracts\Payment;
use App\User;

class PaypalService implements Payment {


    protected $apiContext;

    function __construct(\PayPal\Rest\ApiContext $apiContext) {

        $this->apiContext = $apiContext;

    }

    public function sendSinglePayment($type, $recipient, $amount, $senderItemId, $currency = 'CAD', $note = '') {

        $payouts = new \PayPal\Api\Payout();

        $senderBatchHeader = new \PayPal\Api\PayoutSenderBatchHeader();

        $senderBatchHeader->setSenderBatchId(uniqid())
                            ->setEmailSubject("You have a Payout!");

        $senderItem = new \PayPal\Api\PayoutItem();

        $senderItem->setRecipientType('Email')
                    ->setNote('Thanks for your patronage!')
                    ->setReceiver('shirt-supplier-one@gmail.com')
                    ->setSenderItemId("2014031400023")
                    ->setAmount(new \PayPal\Api\Currency('{
                                        "value":"1.0",
                                        "currency":"CAD"
                                    }'));

        $payouts->setSenderBatchHeader($senderBatchHeader)
                ->addItem($senderItem);


        $request = clone $payouts;


        try {
            $output = $payouts->createSynchronous($this->apiContext);
        } catch (Exception $ex) {

            return response()->json([
                    $output, $ex
                ]);
        }

        return $output;

    }

    public function sendBatchPayment($type, array $recipientsAndAmountAndSenderItemId, $currency = 'CAD', $note = '') {


    }

    public function getBatchPaymentDetails($batchPaymentId) {


    }

}