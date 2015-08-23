<?php 

namespace App\Services;

use App\Contracts\Payment;
use App\User;

class PaypalService implements Payment {

    /**
     * [$apiContext description]
     * @var [type]
     */
    protected $apiContext;

    function __construct(\PayPal\Rest\ApiContext $apiContext) {

        $this->apiContext = $apiContext;

    }

    /**
     * [sendSinglePayment description]
     * @param  [type] $type         [description]
     * @param  [type] $recipient    [description]
     * @param  [type] $amount       [description]
     * @param  [type] $senderItemId [description]
     * @param  string $currency     [description]
     * @param  string $note         [description]
     * @return [type]               [description]
     */
    public function sendSinglePayment($recipient, $amount, $senderItemId, $senderBatchId, $type= 'Email', $currency = 'CAD', $note = '') {

        $payouts = new \PayPal\Api\Payout();

        $senderBatchHeader = new \PayPal\Api\PayoutSenderBatchHeader();

        $senderBatchHeader->setSenderBatchId($senderBatchId)
                            ->setEmailSubject("You have a Payout!");

        $senderItem = new \PayPal\Api\PayoutItem();

        $amount = (float) $amount;

        $senderItem->setRecipientType('Email')
                    ->setNote('Thanks for your patronage!')
                    ->setReceiver($recipient)
                    ->setSenderItemId($senderItemId)
                    ->setAmount(new \PayPal\Api\Currency('{
                                        "value":$amount,
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

    /**
     * [sendBatchPayment description]
     * @param  array  $recipientsAndAmountAndSenderItemId [description]
     * @param  [type] $senderBatchId                      [description]
     * @param  string $type                               [description]
     * @param  string $currency                           [description]
     * @param  string $note                               [description]
     * @return [type]                                     [description]
     */
    public function sendBatchPayment(array $recipientsAndAmountAndSenderItemId, $senderBatchId, $type= 'Email',  $currency = 'CAD', $note = '') {

        $payouts = new \PayPal\Api\Payout();

        $senderBatchHeader = new \PayPal\Api\PayoutSenderBatchHeader();

        $senderBatchHeader->setSenderBatchId($senderBatchId)
                            ->setEmailSubject("You have a Payout!");

        
        $payouts->setSenderBatchHeader($senderBatchHeader);

        foreach ($recipientsAndAmountAndSenderItemId as $payoutItem) {

            $emailExists = (isset($payoutItem['email']) && !empty($payoutItem['email']));

            $amountExists = (isset($payoutItem['amount']) && !empty($payoutItem['amount']));

            $senderItemIdExists = (isset($payoutItem['sender_item_id']) && !empty($payoutItem['sender_item_id']));

            if(!$emailExists || !$amountExists || !$senderItemIdExists) continue;

            $receiver = $payoutItem['email'];

            $item_id = $payoutItem['sender_item_id'];

            $value = (float) $payoutItem['amount'];

            $senderItem = new \PayPal\Api\PayoutItem();

            $senderItem->setRecipientType('Email')
                        ->setNote('Bootstrap Dashboard Payments')
                        ->setReceiver($receiver)
                        ->setSenderItemId($item_id)
                        ->setAmount(new \PayPal\Api\Currency('{
                                            "value":"1.00",
                                            "currency":"CAD"
                                        }'));


            $payouts->addItem($senderItem);


        } // EO foreach

        $request = clone $payouts;

        try {

            $output = $payouts->create(null, $this->apiContext);

        } catch (Exception $e) {

            return $e;
        }

        return $output;


    }

    /**
     * [getBatchPaymentDetails description]
     * @param  [type] $payoutBatchId [description]
     * @return [type]                [description]
     */
    public function getBatchPaymentDetails($payoutBatchId) {

        try {

             $output = \PayPal\Api\Payout::get($payoutBatchId, $this->apiContext);

        } catch (\Exception $e) {

            return $e->getMessage();

        }

        return $output;
    }

}