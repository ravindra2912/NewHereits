<div class="section pt-2 mx-3 row">
  <div class="col-md-7 col-sm-7 col-12 my-sm-2 p-md-2 p-0">
    <div class="resp-tabs-container bg-white shadow-md rounded p-3">
      <div class="resp-tab-content resp-tab-content-active" style="display:block" aria-labelledby="tab_item-0">
        <h2 class="text-6 mb-1">Book your appointment</h2>
        <p>Book your appointment with {{ $expert->appointmenter_name }}. Please fill the form below to book your appointment.</p>
        <form id="appointment-form" action="{{ route('book.appointment') }}" data-action="call" data-reset="true" class="row formaction">
          @csrf

          <input type="hidden" name="expert_id" id="expert_id" value="{{ $expert->id }}">
          <input type="hidden" name="business_id" id="business_id" value="{{ $expert->business_id }}">
          <input type="hidden" name="department_id" value="{{ $expert->department_id }}">
          <input type="hidden" value="{{ $expert->is_appointment_book_with_time_slot }}" id="with-timing">

          <div class="col-12 mb-3">
            <label for="booking_date" class="form-label">Appointment For </label></br>
            <div class="form-check form-check-inline">
              <input id="Self" value="self" name="appointment_for" class="form-check-input" checked="" type="radio">
              <label class="form-check-label" for="Self">Self</label>
            </div>
            <div class="form-check form-check-inline">
              <input id="Other" value="other" name="appointment_for" class="form-check-input" type="radio">
              <label class="form-check-label" for="Other">Other</label>
            </div>
          </div>

          <div class="col-md-6 col-sm-6 col-12 mb-3">
            <label for="booking_date" class="form-label ">Appointment date</label>
            <input type="date" name="booking_date" class="form-control required" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="booking_date" required="" placeholder="Appointment date">
          </div>

          @if ($expert->is_appointment_book_with_time_slot)
          <div class="col-md-6 col-sm-6 col-12 mb-3">
            <label for="operator" class="form-label ">Appointment Time</label>
            <select class="form-control required" name="timeslote" id="timeslote" required="">
              <option value="">Select Your Appointment Time</option>
              @foreach ($timeSlots as $time)
              @if(!$time['is_booked'] && $time['is_available'] == true)
              <option value="{{ $time['time'] }}">{{ $time['time'] }}</option>
              @endif
              @endforeach
            </select>
          </div>
          @endif

          <div class="col-md-6 col-sm-6 col-12 mb-3 appointment-for-other d-none">
            <label for="user_name" class="form-label ">Name</label>
            <input class="form-control required" name="user_name" id="user_name" placeholder="Enter Your Name" type="text">
          </div>

          <div class="col-md-6 col-sm-6 col-12 mb-3 appointment-for-other d-none">
            <label for="user_contact" class="form-label ">Mobile Number</label>
            <input type="text" name="user_contact" class="form-control required" id="user_contact" placeholder="Enter Mobile Number">
          </div>

          <div class="col-12 mb-3">
            <label for="note" class="form-label">Note (optional)</label>
            <textarea name="note" class="form-control" id="note" placeholder="Enter... "></textarea>
          </div>

          <div class="col-12 mb-3">
            @if($expert->business->credit > 0)
            @if (Auth::check())
            <button class="btn btn-primary btn_action btn-block ">
              <span id="buttonText">Book</span>
              <span id="loader" class="d-none"> Booking ...</span>
            </button>
            @else
            <button class="btn btn-primary btn_action btn-block" type="button" data-toggle="modal" data-target="#login-modal">
              <span id="buttonText"> Book</span>
            </button>
            @endif
            @else
            <button class="btn btn-secondary disabled btn-block" type="button">
              <span> Unable to book</span>
            </button>
            @endif

          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-5 col-sm-5 col-12 my-sm-2 mt-3 text-center p-md-2 p-0">

    <iframe
      src="https://www.google.com/maps?q={{ $expert->business->latitude.','.$expert->business->longitude }}&hl=es;z=14&output=embed"
      allowfullscreen
      loading="lazy" class="googleMap">
    </iframe>

    <p>for advertisement</p>
  </div>
</div>




<!-- thank you Modal Start-->
<div id="thank-you-modal" class="modal fade" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content border-0">
      <div class="modal-body py-4 px-0">
        <button type="button" class="close close-outside" data-dismiss="modal" aria-label="Close"> <span class="h1" aria-hidden="true">&times;</span> </button>
        <div class="row">
          <div class="col-11 col-md-10 mx-auto">

            <div class="text-center">
              <i class="fas fa-check-circle text-success mb-3"></i>
              <h2 class="text-success">Appointment Book Successfully</h2>
              <p>Thank you for booking your appointment, <!-- strong id="userName">John Doe</strong -->.</p>
              <a href="" class="btn btn-outline-danger status-checker" >Check Booking status</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- thank you Modal End -->

@push('js')
<script>
  function responce(res) {
    $('#thank-you-modal').modal('show');
    $('.status-checker').attr('href', res.data.status_url);
    console.log(res.data.status_url);
  }
  $(document).ready(function() {
    // get appoinmenters time slote
    $('#booking_date').on('change', function(event) {
      // $('#timeslote').html('<option value="">Select Timing</option>');
      if ($('#booking_date').val() == '' || $('#with-timing').val() != 1) {
        return
      }
      $.ajax({
        type: "POST",
        url: "{{ route('get.appoinmenter.timing') }}",
        data: {
          appointmenter_id: $('#expert_id').val(),
          business_id: $('#business_id').val(),
          date: $('#booking_date').val()
        },
        dataType: "json",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
          $('#timeslote').html('<option value="">Loading ...</option>');
        },
        success: function(res) {
          console.log(res);
          $('#timeslote').html('<option value="">Select Timing</option>');
          $.each(res, function(index, item) {
            if (!item.is_booked && item.is_available == true) {
              $('#timeslote').append('<option value="' + item.time + '" >' + item.time + '</option>');
            }
          });
        },
        error: function(xhr, status, error) {
          console.error("Error: " + error);
          $('#timeslote').html('<option value="">Select Timing</option>');
          alert("There was an error on appointmenter change.");
        }
      });
    });

    // appointment for other
    $('input[name="appointment_for"]').on('change', function() {
      if ($(this).val() == 'other') {
        $('.appointment-for-other').removeClass('d-none');
      } else {
        $('.appointment-for-other').addClass('d-none');
      }
    });
  });
</script>
@endpush