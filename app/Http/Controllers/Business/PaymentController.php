<?php

namespace App\Http\Controllers\Business;

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
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{

    public function Payment(Request $request, $type, $id)
    {
        // dd($type, $id);
        $data = (object)array();
        $business_id = '';
        $data->type = $type;
        $data->orderid = $id;
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
            return view('business.payment.payment', compact('data'));
        }

        exit('Something went wrong!');
        // return view('business.payment.payment');
    }


    public function paymentResponce(Request $request)
    {
        $success = false;
        $message = 'Something Wrong!';
        $redirect = '';
        $data = array();
        DB::beginTransaction();
        try {
            if (!empty($request->razorpay_payment_id)) {
                if ($request->type == 'subscription') {
                    $subscribData = Subscription::with('transaction')->find($request->order);
                    if ($subscribData && $subscribData->status == 'pending_for_payment' && $subscribData->transaction->status == 'pending') {
                        $subscribData->transaction()->update([
                            'status' => 'completed',
                            'payment_id' => $request->razorpay_payment_id,
                        ]);

                        // Update subscription
                        $subscribData->update([
                            'status' => 'payment_success',
                        ]);

                        Business::where('id', $subscribData->business_id)->update([
                            'subscription_expiry_date' => $subscribData->end_date,
                        ]);

                        DB::commit();
                        $redirect = $request->redirectUrl;
                        $success = true;
                        $message = 'Payment updated successfully!';
                    }
                } else if ($request->type == 'credit') {
                    $creditDetail = BusinessCredit::with(['transaction'])->find($request->order);
                    if ($creditDetail && $creditDetail->status == 'pending_for_payment' && $creditDetail->transaction->status == 'pending') {
                        $creditDetail->transaction()->update([
                            'status' => 'completed',
                            'payment_id' => $request->razorpay_payment_id,
                        ]);

                        // Update credit
                        $creditDetail->update([
                            'status' => 'payment_success',
                        ]);

                        Business::where('id', $creditDetail->business_id)->increment('credit', $creditDetail->credit);

                        DB::commit();
                        $redirect = $request->redirectUrl;
                        $success = true;
                        $message = 'Payment updated successfully!';
                    }
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // Optionally: Log the error or return a response
            // $message = 'Payment update failed.';
            $message = $e->getMessage();
        }
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data, 'redirect' => $redirect]);
    }
}
