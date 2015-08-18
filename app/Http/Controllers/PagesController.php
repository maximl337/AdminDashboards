<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Order;
use App\Template;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['dashboard']]);
    }

    public function home()
    {
        return view('pages.home');
    }

    public function dashboard()
    {
        $templates = Auth::user()->templates->toArray();

        $incomingOrders = Auth::user()->orders()->with('template')->get();

        $orders = $incomingOrders->toArray();

        $earnings = 0;

        foreach($orders as $order) {

            $earnings += $order['template']['price'];

        }

        $data = [
            'templates' => $templates,
            'orders' => $orders,
            'earnings'      => $earnings
        ];

        return view('pages.dashboard', compact('data'));
    }
}
