<?php

namespace App\Contracts;

interface Payment {

    public function sendSinglePayment($type, $recipient, $amount, $senderItemId, $currency = 'CAD', $note = '');

    public function sendBatchPayment(array $recipientsAndAmountAndSenderItemId, $senderBatchId, $type= 'Email',  $currency = 'CAD', $note = '');

    public function getBatchPaymentDetails($batchPaymentId);

}