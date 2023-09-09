<?php

namespace App\Http\Controllers;

use App\Custom\Payment\PaymentRepository;
use App\Events\PaymentCompleted;
use App\Models\Payment;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function PaymentInit()
    {
        $amount = request()->amount;

        /* session()->put('amount', $amount);
        session()->put('message', "Recharge my account");
        session()->put('email', Auth::user()->email);
        session()->put('transactionType', $transaction_type); */
        return PaymentRepository::initPay($amount, Auth::user()->email);
    }

    public function PaymentStatus()
    {
        if (request()->OrderTrackingId) {
            $notification_type = request()->OrderNotificationType;
            
            if($notification_type == 'CALLBACKURL')
            {
                // the user attempted to make payment
                $updated = Payment::where('transaction_tracking_id', request()->OrderTrackingId)->update(['attempted'=>true]);
            }
            else if ($notification_type == 'IPNCHANGE')
            {
                $status = PaymentRepository::checkPaymentStatus(request()->OrderTrackingId);
                PaymentRepository::processPaymentStatus(request()->OrderTrackingId, $status);
            }
        } else {
            // check if the user attempted to make payment
            $tracking_id = request()->tracking_id;
            $payment = Payment::where('transaction_tracking_id', $tracking_id)->first();
            if($payment && $payment->attempted){
                $status = PaymentRepository::checkPaymentStatus($tracking_id);
                PaymentRepository::processPaymentStatus($tracking_id, $status);
                return $status;
            }else{
                return [];
            }
        }
    }
}
