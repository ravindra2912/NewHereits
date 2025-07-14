<?php

namespace App\Observers;

use App\Models\Business;
use App\Mail\TokenCancelledMail;
use App\Mail\TokenComplitedMail;
use App\Models\AppointmentBooking;
use App\Mail\TokenConfirmationMail;
use App\Jobs\PuhsNotificationToUser;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentCancelledMail;
use App\Mail\AppointmentComplitedMail;
use App\Mail\AppointmentConfirmationMail;

class AppointmentBookingObserver
{
    /**
     * Handle the AppointmentBooking "created" event.
     */
    public function created(AppointmentBooking $appointmentBooking): void
    {
        // dd($appointmentBooking->status);

        $appointment_details = AppointmentBooking::query()
            ->select('id', 'token_number', 'business_id', 'appointmenter_id', 'user_id', 'user_name', 'user_contact', 'slot_start_time', 'slot_end_time', 'booking_date', 'note', 'status')
            ->with([
                'appontmenter:id,appointmenter_name,slug,is_appointment_book_with_time_slot',
                'business:id,name,slug,address',
                'user:id,first_name,email'
            ])
            ->find($appointmentBooking->id);

            dd($appointment_details->appointmenter->is_appointment_book_with_time_slot);

        if ($appointment_details && $appointment_details->user_id != null) {
            if ($appointment_details->appointmenter->is_appointment_book_with_time_slot) {
                if ($appointment_details->status == 'pending') {
                } else if ($appointment_details->status == 'confirmed') {
                    Mail::to($appointment_details->user->email)->send(new AppointmentConfirmationMail($appointment_details));
                }
            } else {
                if ($appointment_details->status == 'pending') {
                } else if ($appointment_details->status == 'confirmed') {
                    Mail::to($appointment_details->user->email)->send(new TokenConfirmationMail($appointment_details));
                }
            }
        }

        Business::find($appointment_details->business_id)->decrement('credit', 1);
    }

    /**
     * Handle the AppointmentBooking "updated" event.
     */
    public function updated(AppointmentBooking $appointmentBooking): void
    {
        $insert = $appointmentBooking;
        $notification = '';

        //send mail
        if ($insert->wasChanged('status')) {
            $changes = $appointmentBooking->getChanges();
            if (in_array($changes['status'], ['confirmed', 'completed', 'cancel'])) {
                $appointment_details = AppointmentBooking::query()
                    ->select('id', 'token_number', 'business_id', 'appointmenter_id', 'user_id', 'user_name', 'user_contact', 'slot_start_time', 'slot_end_time', 'booking_date', 'note', 'status')
                    ->with([
                        'appontmenter:id,appointmenter_name,slug,is_appointment_book_with_time_slot',
                        'business:id,name,slug,address',
                        'user:id,first_name,email,notification_token'
                    ])
                    ->find($insert->id); 

                if ($appointment_details && $appointment_details->user_id != null) {
                    if ($appointment_details->appontmenter->is_appointment_book_with_time_slot) {
                        if ($changes['status'] == 'confirmed') {
                            Mail::to($appointment_details->user->email)->send(new AppointmentConfirmationMail($appointment_details));

                            if ($appointment_details->user->notification_token) {
                                $notification = [
                                    'include_player_ids' => [$appointment_details->user->notification_token],
                                    'title' => 'Hello ' . $appointment_details->user->first_name,
                                    'message' => 'Your appointment with ' . $appointment_details->appontmenter->appointmenter_name . ' has been confirmed.',
                                    // 'data' => [],
                                    'url' =>  route('account.booking.details',  $appointment_details->id),
                                    // 'schedule' => now()->addMinutes(1)
                                ];
                            }
                        } else if ($changes['status'] == 'completed') {
                            if ($appointment_details->user->notification_token) {
                                $notification = [
                                    'include_player_ids' => [$appointment_details->user->notification_token],
                                    'title' => 'Hello ' . $appointment_details->user->first_name,
                                    'message' => 'Your appointment with ' . $appointment_details->appontmenter->appointmenter_name . ' has been completed.',
                                    // 'data' => [],
                                    'url' =>  route('account.booking.details',  $appointment_details->id),
                                    // 'schedule' => now()->addMinutes(1)
                                ];
                            }
                            Mail::to($appointment_details->user->email)->send(new AppointmentComplitedMail($appointment_details));
                        } else if ($changes['status'] == 'cancel' || $changes['status'] == 'cancel_by_user') {
                            $notification = [
                                'include_player_ids' => [$appointment_details->user->notification_token],
                                'title' => 'Hello ' . $appointment_details->user->first_name,
                                'message' => 'Your appointment with ' . $appointment_details->appontmenter->appointmenter_name . ' has been cancelled.',
                                // 'data' => [],
                                'url' =>  route('account.booking.details',  $appointment_details->id),
                                // 'schedule' => now()->addMinutes(1)
                            ];
                            Mail::to($appointment_details->user->email)->send(new AppointmentCancelledMail($appointment_details));
                        }
                    } else {
                        if ($changes['status'] == 'confirmed') {
                            $notification = [
                                'include_player_ids' => [$appointment_details->user->notification_token],
                                'title' => 'Hello ' . $appointment_details->user->first_name,
                                'message' => 'Your appointment with ' . $appointment_details->appontmenter->appointmenter_name . ' has been confirmed.',
                                // 'data' => [],
                                'url' =>  route('account.booking.details',  $appointment_details->id),
                                // 'schedule' => now()->addMinutes(1)
                            ];
                            Mail::to($appointment_details->user->email)->send(new TokenConfirmationMail($appointment_details));
                        } else if ($changes['status'] == 'completed') {

                            if ($appointment_details->user->notification_token) {
                                $notification = [
                                    'include_player_ids' => [$appointment_details->user->notification_token],
                                    'title' => 'Hello ' . $appointment_details->user->first_name,
                                    'message' => 'Your appointment with ' . $appointment_details->appontmenter->appointmenter_name . ' has been completed.',
                                    // 'data' => [],
                                    'url' =>  route('account.booking.details',  $appointment_details->id),
                                    // 'schedule' => now()->addMinutes(1)
                                ];
                            }

                            Mail::to($appointment_details->user->email)->send(new TokenComplitedMail($appointment_details));
                        } else if ($changes['status'] == 'cancel' || $changes['status'] == 'cancel_by_user') {

                            $notification = [
                                'include_player_ids' => [$appointment_details->user->notification_token],
                                'title' => 'Hello ' . $appointment_details->user->first_name,
                                'message' => 'Your appointment with ' . $appointment_details->appontmenter->appointmenter_name . ' has been cancelled.',
                                // 'data' => [],
                                'url' =>  route('account.booking.details',  $appointment_details->id),
                                // 'schedule' => now()->addMinutes(1)
                            ];

                            Mail::to($appointment_details->user->email)->send(new TokenCancelledMail($appointment_details));
                        }
                    }
                }
            }
        }
        if (!empty($notification)) {
            PuhsNotificationToUser::dispatch($notification);
        }
    }

    /**
     * Handle the AppointmentBooking "deleted" event.
     */
    public function deleted(AppointmentBooking $appointmentBooking): void
    {
        //
    }

    /**
     * Handle the AppointmentBooking "restored" event.
     */
    public function restored(AppointmentBooking $appointmentBooking): void
    {
        //
    }

    /**
     * Handle the AppointmentBooking "force deleted" event.
     */
    public function forceDeleted(AppointmentBooking $appointmentBooking): void
    {
        //
    }
}
