@foreach ($bookings as $booking)
<a href="{{ route('account.booking.details', $booking->id) }}" class="card mb-3 text-dark" style="box-shadow: inset 0px 0px 2px 0px gray;">
    <div class="card-body pt-1">
        <div class="row">
            <div class="col-12 border-bottom font-weight-bold mb-3 d-flex justify-content-between align-items-center">
                <p class="mb-1">Token No. {{ $booking->token_number }}</p>
                <div>
                    @if($booking->status == 'pending')
                    <span class="badge badge-warning">Pending</span>
                    @elseif($booking->status == 'confirmed')
                    <span class="badge badge-info">Confirmed</span>
                    @elseif($booking->status == 'in_progress')
                    <span class="badge badge-primary">in_progress</span>
                    @elseif($booking->status == 'cancel')
                    <span class="badge badge-danger">Cancelled</span>
                    @elseif($booking->status == 'cancel_by_user')
                    <span class="badge badge-danger">Cancelled by user</span>
                    @elseif($booking->status == 'completed')
                    <span class="badge badge-success">Completed</span>
                    @endif
                </div>
            </div>
            <div class="col-sm-2 col-12 text-sm-right  booking-border">
                {{ get_date($booking->booking_date, 'd M') }}<br>
                10:00 AM
            </div>
            <div class="col-sm-10 col-12 row ml-0">
                <div class="col-sm-6 col-12">
                    <p class="mb-0"><i class="fas fa-building pr-2"></i> {{ $booking->business->name }}</p>
                    <p class="mb-0"><i class="fas fa-user pr-2"></i> {{ $booking->user_name }}</p>
                </div>
                <div class="col-sm-6 col-12">
                    <p class="mb-0"><i class="fas fa-user-tie pr-2"></i> {{ $booking->appontmenter->appointmenter_name }}</p>
                    @if($booking->slot_start_time != null && $booking->slot_end_time != null)
                    <p class="mb-0"><i class="fas fa-clock pr-2"></i> {{ get_time($booking->slot_start_time) }} - {{ get_time($booking->slot_end_time) }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</a>
@endforeach