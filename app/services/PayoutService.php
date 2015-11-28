<?php

namespace App\Services;

use App\User;
use App\Payout;
use App\Template;
use App\Order;
use App\Commission;
use App\Contracts\Payout as PayoutContract;
use App\Contracts\Payment;
use App\Services\PPMassPayService;


class PayoutService implements PayoutContract
{
    
    protected $nonexclusive_commission = 35;

    protected $base_exclusive_commission = 55;

    /**
     * Get Users Earnings and commission
     * 
     * @param  User   $user 
     * @return array  earnings
     */
    public function earnings(User $user) {

        // Get users templates
        $templates = $user->templates()->get();

        // Init lifetime earning
        $lifetime_earnings = 0;

        // Init grand total
        $grand_total = 0;

        // Init paid earnings
        $paid_earnings = 0;

        // Init commision rate
        $commission_rate = $this->nonexclusive_commission;

        // Iterate through templates
        foreach($templates as $template) {

                // Init earnings per template
                $order_amount_per_template = 0;

                // Get orders
                $orders = $template->orders()->get();

                // Iterate through orders
                foreach($orders as $order) {

                    // Calculate total earnings
                    // for single template
                    $order_amount_per_template += ( $order->payment_gross - $order->tax );
                
                }

                // Get commision rate for
                // exclusive templates
                if($template->exclusive) {

                    // Get base exclusive commission rate
                    $commission_rate = $this->base_exclusive_commission;

                    $commission = Commission::where('amount', '<=', $order_amount_per_template)->orderBy('amount', 'DESC')->first();

                    // Adjust commission rate
                    // according to order volume
                    if($commission) $commission_rate = $commission->percentage;

                }

                // Calculate lifetime earnings 
                // with commision rate
                $lifetime_earnings += $order_amount_per_template * $commission_rate / 100;
                
                // Running grand total
                $grand_total += $order_amount_per_template;

        }

        $payouts = $user->payouts()->where('payment_status', 'Processed')->get();

        foreach($payouts as $payout) {

            $paid_earnings += $payout->amount;

        }
        
        return [

            'lifetime'      => $lifetime_earnings,

            'paid'          => $paid_earnings,

            'pending'       => $lifetime_earnings - $paid_earnings,

            'grand_total'   => $grand_total,

            'commission'    => $grand_total - $lifetime_earnings

        ];

    }

    /**
     * Return commision rate for template
     * based on sales volume
     *         
     * @param  Template $template App\Template
     * @return int             commission rate
     */
    public function commission(Template $template)
    {

        // Init commision rate
        $commission_rate = $this->nonexclusive_commission;

        $total_amount = 0;

        // get total orders of template
        $total_orders = $template->orders()->get();

        foreach($total_orders as $perOrder) {

            $total_amount += ( $perOrder->payment_gross - $perOrder->tax );
        }

        // Get commision rate for
        // exclusive templates
        if($template->exclusive) {

            // Get base exclusive commission rate
            $commission_rate = $this->base_exclusive_commission;

            $commission = Commission::where('amount', '<=', $total_amount)->orderBy('amount', 'DESC')->first();

            // Adjust commission rate
            // according to order volume
            if($commission) $commission_rate = $commission->percentage;

        }

        return $commission_rate;


    }

    public function massPay() {

        // GET ORDERS
        $orders = Order::with('template')->get();

        $templates = [];

        $users = [];

        $payouts = [];

        $earnings = [];

        $recipients = [];

        // Get users of orders
        foreach($orders as $order) {

            $users[] = $order->template->user()->first();

        } // end for each

        $users = array_unique($users);

        foreach($users as $user) {

            $earnings = $this->earnings($user);

            //if($earnings['pending'] < 100) continue;

            $user->amount = $earnings['pending'];

            $user->unique_id = $user->id . "-" . uniqid();

            $recipients[] = $user;

            Payout::create([
                    'user_id'   => $user->id,
                    'amount'    => $user->amount,
                    'uniqueid' => $user->unique_id
                ]);

        } // EO foreach

        try {

            $resp = (new PPMassPayService)->send($recipients);

        } catch(Exception $e) {

            Log::error('Paypal Masspay:' . $e->getMessage(). [serialize($e)]);
        }
       

    } // send mass payout
}