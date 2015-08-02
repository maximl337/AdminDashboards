<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Http\Requests;
use App\Http\Requests\UpdatePaymentSettingRequest;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updatePaymentSettings(UpdatePaymentSettingRequest $request)
    {
        
        Auth::user()->update($request->input());

        return redirect()->back()->with('status', 'Payment settings updated!');

    }
}
