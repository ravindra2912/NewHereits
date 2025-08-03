<?php

namespace App\Http\Controllers\Business;

use App\Traits\CashFreePayment;
use App\Models\City;
use App\Models\Business;
use App\Models\CityArea;
use App\Models\Subscription;
use Illuminate\Http\Request;

use App\Models\Appointmenter;
use App\Models\BusinessCredit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    use CashFreePayment;

    public function Payment(Request $request, $type, $id)
    {
        // dd($this->getRefund('credit-22'));
        
        $data = (object)array();
        $business_id = '';
        $data->type = $type;
        $data->orderid = $type . '-' . $id;
        $success = false;
        if ($type == 'subscription') {
            $subscribData = Subscription::with('transaction')->find($id);
            if ($subscribData && $subscribData->status == 'pending_for_payment' && $subscribData->transaction->status == 'pending') {
                $business_id = $subscribData->business_id;
                $data->total = $subscribData->transaction->amount;
                $data->redirectUrl = route('business.setting.business.plan');
                $success = true;
            }
        } else if ($type == 'credit') {
            $creditDetail = BusinessCredit::with(['transaction'])->find($id);
            if ($creditDetail && $creditDetail->status == 'pending_for_payment' && $creditDetail->transaction->status == 'pending') {
                $business_id = $creditDetail->business_id;
                $data->total = $creditDetail->transaction->amount;
                $data->redirectUrl = route('business.setting.business.credit');
                $success = true;
            }
        }

        if ($success && !empty($business_id)) {
            $details = Business::select('id', 'name', 'contact', 'owner_id')
                ->with(['owner'])
                ->where('id', $business_id)
                ->first();
            $data->name = $details->name;
            $data->email = $details->owner->email;
            $data->contact = $details->contact;
            $data->owner_id = $details->owner_id;

            // cashfree create order

            $payment_session_id = $this->createSessionId($data->orderid, $data->total, $data->email, $data->contact, $data->owner_id);
            return view('business.payment.payment', compact('payment_session_id', 'data'));
        }

        exit('Something went wrong!');
        // return view('business.payment.payment');
    }

    public function paymentResponce(Request $request)
    {
        $success = true;
        $message = 'Something Wrong!';
        $redirect = $request->redirectUrl;
        $data = array();

        try {
            if (!empty($request->order)) {
                $order_success = $this->checkPaymentStatus($request->order, true);
                $message = $order_success ? 'success' : $message;
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }
}
