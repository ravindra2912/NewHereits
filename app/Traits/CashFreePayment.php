<?php

namespace App\Traits;

use App\Models\Business;
use App\Models\Subscription;
use App\Models\BusinessCredit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

trait CashFreePayment
{
    public $app_id;
    public $secret_key;
    public $mode;
    public function initCashFree()
    {
        $this->mode = env('CASHFREE_MODE', 'test');
        $prefix = $this->mode === 'production' ? 'CASHFREE_PRODUCTION_' : 'CASHFREE_SANDBOX_';

        $this->app_id     = env("{$prefix}APP_ID");
        $this->secret_key = env("{$prefix}SECRET_KEY"); 
    }
    public function __construct()
    {
        $this->initCashFree();
    }

    public function createSessionId($order_id, $order_amount, $email, $phone, $customer_id)
    {
        if ($this->mode == 'production') {
            $url = 'https://api.cashfree.com/pg/orders';
        } else { // test credentials
            $url = 'https://sandbox.cashfree.com/pg/orders';
        }
        // dd($this->app_id, $this->secret_key, $this->mode, $url);
        $payload = [
            "customer_details" => [
                "customer_id" => "12345",
                "customer_email" => $email,
                "customer_phone" => "$phone",
            ],
            "order_id" => $order_id, // Unique ID
            "order_amount" => $order_amount, // Amount
            "order_currency" => "INR"
        ];

        $response = Http::withHeaders([
            'x-client-id' => $this->app_id,
            'x-client-secret' => $this->secret_key,
            'x-api-version' => '2022-09-01',
            'Content-Type' => 'application/json',
        ])->post($url, $payload);
        $response = $response->json();

        if (isset($response['order_id'])) {
            return $response['payment_session_id'];
        } else {
            exit('Something went wrong! ' . $response['message']);
            // dd($response['message']);
        }
    }

    public function checkPaymentStatus($order_id, $is_update_status = false)
    {
        $base_url = $this->mode == 'production' ? 'https://api.cashfree.com' : 'https://sandbox.cashfree.com';

        $response = Http::withHeaders([
            'x-client-id' => $this->app_id,
            'x-client-secret' => $this->secret_key,
            'x-api-version' => '2022-09-01',
        ])->get("$base_url/pg/orders/$order_id");

        $result = $response->json();
        if (!$is_update_status) {
            return $result;
        }

        $success = false;
        try {
            $parts = explode("-", $result['order_id']);
            $type = $parts[0];
            $id = $parts[1];

            if (isset($result['order_status']) && $result['order_status'] == 'FAILED') {
                if ($type == 'subscription') {
                    $subscribData = Subscription::with('transaction')->find($id);
                    if ($subscribData && $subscribData->status == 'pending_for_payment' && $subscribData->transaction->status == 'pending') {
                        $subscribData->transaction()->update([
                            'status' => 'failed',
                            'payment_id' => $result['order_id'],
                        ]);

                        // Update subscription
                        $subscribData->update([
                            'status' => 'payment_failed',
                        ]);

                        $success = true;
                        DB::commit();
                    }
                } else if ($type == 'credit') {
                    $creditDetail = BusinessCredit::with(['transaction'])->find($id);
                    if ($creditDetail && $creditDetail->status == 'pending_for_payment' && $creditDetail->transaction->status == 'pending') {
                        $creditDetail->transaction()->update([
                            'status' => 'failed',
                            'payment_id' => $result['order_id'],
                        ]);

                        // Update credit
                        $creditDetail->update([
                            'status' => 'payment_failed',
                        ]);

                        $success = true;
                        DB::commit();
                    }
                }
            } else if (isset($result['order_status']) && $result['order_status'] == 'PAID') {

                // dd($type, $id);
                if ($type == 'subscription') {
                    $subscribData = Subscription::with('transaction')->find($id);
                    if ($subscribData && $subscribData->status == 'pending_for_payment' && $subscribData->transaction->status == 'pending') {
                        $subscribData->transaction()->update([
                            'status' => 'completed',
                            'payment_id' => $result['order_id'],
                        ]);

                        // Update subscription
                        $subscribData->update([
                            'status' => 'payment_success',
                        ]);

                        Business::where('id', $subscribData->business_id)->update([
                            'subscription_expiry_date' => $subscribData->end_date,
                        ]);
                        $success = true;
                        DB::commit();
                    }
                } else if ($type == 'credit') {
                    $creditDetail = BusinessCredit::with(['transaction'])->find($id);
                    if ($creditDetail && $creditDetail->status == 'pending_for_payment' && $creditDetail->transaction->status == 'pending') {
                        $creditDetail->transaction()->update([
                            'status' => 'completed',
                            'payment_id' => $result['order_id'],
                        ]);

                        // Update credit
                        $creditDetail->update([
                            'status' => 'payment_success',
                        ]);

                        Business::where('id', $creditDetail->business_id)->increment('credit', $creditDetail->credit);
                        $success = true;
                        DB::commit();
                    }
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $success = false;
        }

        // You can store the result or return it
        return $success;
    }

    public function issueRefund($orderId)
    {
        // $order = $this->checkPaymentStatus($orderId);
        // dd($order);
        $base_url = $this->mode == 'production' ? 'https://api.cashfree.com' : 'https://sandbox.cashfree.com';

        // get data
        $parts = explode("-", $orderId);
        $type = $parts[0];
        $id = $parts[1];
        $refundAmount = 0;
        if ($type == 'subscription') {
            $subscribData = Subscription::with('transaction')->find($id);
            if ($subscribData && $subscribData->transaction->status == 'completed') {
                $refundAmount =  $subscribData->transaction->amount;
            }
        } else if ($type == 'credit') {
            $creditDetail = BusinessCredit::with(['transaction'])->find($id);
            if ($creditDetail && $creditDetail->transaction->status == 'completed') {
                $refundAmount =  $creditDetail->transaction->amount;
            }
        }


        $response = Http::withHeaders([
            'x-client-id' => $this->app_id,
            'x-client-secret' => $this->secret_key,
            'x-api-version' => '2022-09-01',
            'Content-Type' => 'application/json'
        ])->post("$base_url/pg/orders/$orderId/refunds", [
            'refund_amount' => $refundAmount,
            'refund_id' => 'refund-' . $orderId,
        ]);

        $result = $response->json();
        // dd($result);

        DB::beginTransaction();
        $success = false;
        try {

            if (isset($result['refund_status']) && $result['refund_status'] == 'PENDING') {
                if ($type == 'subscription') {
                    if ($subscribData && $subscribData->transaction->status == 'completed') {
                        $subscribData->transaction()->update([
                            'status' => 'refunded_requested',
                        ]);

                        $success = true;
                        DB::commit();
                    }
                } else if ($type == 'credit') {
                    if ($creditDetail && $creditDetail->transaction->status == 'completed') {
                        $creditDetail->transaction()->update([
                            'status' => 'refunded_requested',
                        ]);

                        $success = true;
                        DB::commit();
                    }
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $success = false;
        }

        return $success;

        return response()->json($response->json());
    }

    public function getRefund($orderId)
    {
        $base_url = $this->mode == 'production' ? 'https://api.cashfree.com' : 'https://sandbox.cashfree.com';

        $response = Http::withHeaders([
            'x-client-id' => $this->app_id,
            'x-client-secret' => $this->secret_key,
            'x-api-version' => '2022-09-01',
            'Content-Type' => 'application/json'
        ])->get("$base_url/pg/orders/$orderId/refunds/refund-$orderId");

        $result = $response->json();
        // dd($response->json());

        $success = false;
        try {
            $parts = explode("-", $orderId);
            $type = $parts[0];
            $id = $parts[1];
            if (isset($result['refund_status']) && $result['refund_status'] == 'SUCCESS') {
                if ($type == 'subscription') {
                    $subscribData = Subscription::with('transaction')->find($id);
                    if ($subscribData) {
                        $subscribData->transaction()->update([
                            'status' => 'refunded',
                        ]);

                        // Update subscription
                        $subscribData->update([
                            'status' => 'refunded',
                        ]);

                        $success = true;
                        DB::commit();
                    }
                } else if ($type == 'credit') {
                    $creditDetail = BusinessCredit::with(['transaction'])->find($id);
                    if ($creditDetail) {
                        $creditDetail->transaction()->update([
                            'status' => 'refunded',
                        ]);

                        // Update credit
                        $creditDetail->update([
                            'status' => 'refunded',
                        ]);

                        $success = true;
                        DB::commit();
                    }
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $success = false;
        }

        return $success;
    }
}
