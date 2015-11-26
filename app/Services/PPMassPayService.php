<?php

namespace App\Services;

use Log;
use PayPal\PayPalAPI;
use PayPal\Service;
use PayPal\CoreComponentTypes;

class PPMassPayService
{

	protected $config;

	public function __construct()
	{

		$this->config = [
		
			"mode" => env('PAYPAL_MODE'),
			"acct1.UserName" => env('PAYPAL_API_USERNAME'),
        	"acct1.Password" => env('PAYPAL_API_PASSWORD'),
        	"acct1.Signature" => env('PAYPAL_API_SIGNATURE')

		];
		
	}

	public function send(array $recipients)
	{

			if(empty($recipients)) throw new Exception("No recipients given");

			$massPayRequest = new PayPalAPI\MassPayRequestType();

			$massPayRequest->MassPayItem = array();

			for($i=0; $i<count($recipients); $i++) {

				if(empty($recipients[$i]->email) || empty($recipients[$i]->amount)) continue;

				$masspayItem = new PayPalAPI\MassPayRequestItemType();
				
				$masspayItem->Amount = new CoreComponentTypes\BasicAmountType('CAD', $recipients[$i]->amount);

				$masspayItem->ReceiverEmail = $recipients[$i]->email;

				$masspayItem->UniqueId = $recipients[$i]->unique_id;
				
				$massPayRequest->MassPayItem[] = $masspayItem;
			}

			$massPayReq = new PayPalAPI\MassPayReq();

			$massPayReq->MassPayRequest = $massPayRequest;
			
			$paypalService = new Service\PayPalAPIInterfaceServiceService($this->config);

		try {
			
			$massPayResponse = $paypalService->MassPay($massPayReq);
			
		} catch (\Exception $ex) {

			Log::error('PPMassPay:Error', [$ex->getMessage()]);

			throw $ex;

		}
		
		
		Log::info('PPMassPay:Response', [
				'request' => $paypalService->getLastRequest(),
				'response' => $paypalService->getLastResponse()
			]);

		if(isset($massPayResponse)) {

			Log::info('PPMassPay:MassPayResponse', [serialize($massPayResponse)]);

			return $massPayResponse->Ack;

		}

		throw new Exception("Did not receive a response");
		
	}

}