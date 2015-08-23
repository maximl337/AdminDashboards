<?php

namespace App\Contracts;

interface Payment {

    public function sendSinglePayment($type, $recipient, $amount, $senderItemId, $currency = 'CAD', $note = '');

    public function sendBatchPayment($type, array $recipientsAndAmountAndSenderItemId, $senderBatchId, $currency = 'CAD', $note = '');

    public function getBatchPaymentDetails($batchPaymentId);

}