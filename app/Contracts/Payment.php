<?php

namespace App\Contracts;

interface Payment {

    public function sendSinglePayment($recipient, $amount, $senderItemId, $senderBatchId, $type= 'Email', $currency = 'CAD', $note = '');

    public function sendBatchPayment(array $recipientsAndAmountAndSenderItemId, $senderBatchId, $type= 'Email',  $currency = 'CAD', $note = '');

    public function getBatchPaymentDetails($batchPaymentId);

}