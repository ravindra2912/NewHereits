@extends('front.layouts.main')
@section('content')
@section('title', 'User Profile')

@push('style')
<style>

</style>
@endpush

<div class="container mt-4 mb-4">
    <div class="row">
        <!-- this for user sidebar -->
        @include('front.account.sidebar')

        <div class="col-lg-9">
            <div class="bg-white shadow-md rounded p-4">
                <h4 class="mb-4">Booking details</h4>
                <hr class="mx-n4 mb-4">

                <div class="row">
                    <div class="col-12 bg-light rounded p-3 mb-3 shadow-sm d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0"><b>Token number</b> : {{ $booking->token_number }}</p>
                            <p class="mb-0"><b>Booking date</b> : {{ get_date($booking->booking_date) }}</p>
                        </div>
                        <div>
                            @if($booking->status == 'pending')
                            <span class="badge badge-warning">Pending</span>
                            @elseif($booking->status == 'cancel')
                            <span class="badge badge-danger">Cancelled</span>
                            @elseif($booking->status == 'complete')
                            <span class="badge badge-primary">Completed</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-12">
                        <h5>Booking information</h5>
                        <div class="row">
                            <div class="col-sm-6 col-12">
                                <p class="mb-0"> <b>Booking id : </b> {{ $booking->id}} </p>
                                <p class="mb-0"> <b>Appointmrnt to : </b> {{ $booking->business->name}} </p>
                                <p class="mb-0"> <b>Expert : </b> {{ $booking->appontmenter->appointmenter_name}} </p>
                                @if($booking->slot_start_time != null && $booking->slot_end_time != null)
                                <p class="mb-0"> <b>Time : </b> {{ get_time($booking->slot_start_time) }} - {{ get_time($booking->slot_end_time) }}</p>
                                @endif
                            </div>
                            <div class="col-sm-6 col-12">
                                <p class="mb-0"> <b>User : </b> {{ $booking->user_name}} </p>
                                <p class="mb-0"> <b>Contact : </b> {{ $booking->user_contact}} </p>
                            </div>
                            @if ($booking->note)
                            <div class="col-12 mt-3">
                                <label>Note</label>
                                <p class="bg-light rounded p-3 mb-3"> {{ $booking->note}} </p>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        @if($booking->status == 'pending')
                        <button class="btn btn-danger btn-sm mt-3" onclick="cancelBooking({{ $booking->id}})">Cancel booking</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('js')
<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function cancelBooking(booking_id) {
        Swal.fire({
                title: 'Are you sure?',
                icon: 'error',
                html: "You want to cancel this booking?",
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            })
            .then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('account.booking.cancel') }}",
                        data: {
                            booking_id: booking_id,
                        },
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function() {
                            loader(true);
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                location.reload();
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        complete: function() {
                            loader(false);
                        },
                        error: function(xhr, status, error) {
                            toastr.error('Something went wrong! Please try again.');
                        }
                    });
                }
            })
    }
</script>
@endpush

@endsection