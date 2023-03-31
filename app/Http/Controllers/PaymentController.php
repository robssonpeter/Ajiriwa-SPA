<?php

namespace App\Http\Controllers;

use App\Custom\Payment\PaymentRepository;
use Auth;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function PaymentInit(){
        $amount = request()->amount;
        $transaction_type = "balance-recharge";

        session()->put('amount', $amount);
        session()->put('message', "Recharge my account");
        session()->put('email', Auth::user()->email);
        session()->put('transactionType', $transaction_type);

        return PaymentRepository::initiatePayment();
    }
}
