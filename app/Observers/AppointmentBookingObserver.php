<?php

namespace App\Observers;

use App\Models\Business;
use App\Mail\TokenCancelledMail;
use App\Mail\TokenComplitedMail;
use App\Models\AppointmentBooking;
use App\Mail\TokenConfirmationMail;
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
                'appontmenter:id,appointmenter_name,slug',
                'business:id,name,slug,address',
                'user:id,first_name,email'
            ])
            ->find($appointmentBooking->id);

        if ($appointment_details && $appointment_details->user_id != null) {
            $businessSetting = getBusinessSettings($appointment_details->business_id);
            if ($businessSetting->is_appointment_book_with_time_slote) {
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


        //send mail
        if ($insert->user_id != null && $insert->wasChanged('status')) {
            $changes = $appointmentBooking->getChanges();
            if (in_array($changes['status'], ['confirmed', 'completed', 'cancel'])) {
                $appointment_details = AppointmentBooking::query()
                    ->select('id', 'token_number', 'business_id', 'appointmenter_id', 'user_id', 'user_name', 'user_contact', 'slot_start_time', 'slot_end_time', 'booking_date', 'note', 'status')
                    ->with([
                        'appontmenter:id,appointmenter_name,slug',
                        'business:id,name,slug,address',
                        'user:id,first_name,email'
                    ])
                    ->find($insert->id);

                if ($appointment_details) {
                    $businessSetting = getBusinessSettings($appointment_details->business_id);

                    if ($businessSetting->is_appointment_book_with_time_slote) {
                        if ($changes['status'] == 'confirmed') {
                            Mail::to($appointment_details->user->email)->send(new AppointmentConfirmationMail($appointment_details));
                        } else if ($changes['status'] == 'completed') {
                            Mail::to($appointment_details->user->email)->send(new AppointmentComplitedMail($appointment_details));
                        } else if ($changes['status'] == 'cancel') {
                            Mail::to($appointment_details->user->email)->send(new AppointmentCancelledMail($appointment_details));
                        }
                    } else {
                        if ($changes['status'] == 'confirmed') {
                            Mail::to($appointment_details->user->email)->send(new TokenConfirmationMail($appointment_details));
                        } else if ($changes['status'] == 'completed') {
                            Mail::to($appointment_details->user->email)->send(new TokenComplitedMail($appointment_details));
                        } else if ($changes['status'] == 'cancel') {
                            Mail::to($appointment_details->user->email)->send(new TokenCancelledMail($appointment_details));
                        }
                    }
                }
            }
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
