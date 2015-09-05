<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Contracts\Payout;
use App\User;
use App\Order;
use App\Template;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth', ['only' => ['dashboard', 'adminDashboard']]);

        $this->middleware('admin', ['only' => ['adminDashboard']]);

    }

    public function home(Request $request)
    {
        $limit = $request->get('limit') ?: 4;

        $page = $request->get('page') ?: 0;

        $templates  = Template::approved()->latest()->with('orders')->paginate($limit);

        if($request->get('sort') == 'price_highest') $templates =  Template::approved()->orderBy('price', 'desc')->with('orders')->paginate($limit);

        if($request->get('sort') == 'price_lowest') $templates = Template::approved()->orderBy('price', 'asc')->with('orders')->paginate($limit);

        $recent     = Template::approved()->latest()->take(2)->get();

        $popular    = Template::approved()->take(3)->get();


        return view('pages.home')->with([

                'templates' => $templates,
                'recent'    => $recent,
                'popular'   => $popular

            ]);
    }

    public function dashboard(Payout $payout)
    {
        $templates = Auth::user()->templates()->get();

        $orders = Auth::user()->orders()->with('template')->get();

        foreach($orders as $order) {

            $order->commission = $payout->commission($order->template);

            $order->earning = $order->template->price * $order->commission / 100;        
            
        }

        $earnings = $payout->earnings(Auth::user());

        $data = [
            'templates'     => $templates,
            'orders'        => $orders,
            'earnings'      => $earnings
        ];

        return view('pages.dashboard', compact('data'));
    }

    public function adminDashboard()
    {
        return view('admin.index');
    }
}
