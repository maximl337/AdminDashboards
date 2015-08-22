<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Payout;
use App\User;
use App\Order;
use App\Commission;
use App\Template;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Contracts\Payout as PayoutContract;

class PayoutController extends Controller
{

    public function test($id, PayoutContract $payoutContract)
    {

        $user = User::findOrFail($id);

        $earnings = $payoutContract->earnings($user);

        return $earnings;
        
    }

    public function testPaypal()
    {
        // $payouts = new \PayPal\Api\Payout();

        // return $payouts;

        // After Step 1
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                env('PAYPAL_CLIENT_ID'),     // ClientID
                env('PAYPAL_CLIENT_SECRET')      // ClientSecret
            )
        );

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
                                        "currency":"USD"
                                    }'));

        $payouts->setSenderBatchHeader($senderBatchHeader)
                ->addItem($senderItem);


        $request = clone $payouts;


        try {
            $output = $payouts->createSynchronous($apiContext);
        } catch (Exception $ex) {

            // ResultPrinter::printError("Created Single Synchronous Payout", "Payout", null, $request, $ex);
            // exit(1);

            return response()->json([
                    $output, $ex
                ]);
        }

        //ResultPrinter::printResult("Created Single Synchronous Payout", "Payout", $output->getBatchHeader()->getPayoutBatchId(), $request, $output);



        return $output;

    }
}
