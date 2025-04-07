<div class="section pt-2 mx-3 row">
  <div class="col-md-7 col-sm-7 col-12 my-sm-2">
    <div class="resp-tabs-container bg-white shadow-md rounded p-3">
      <div class="resp-tab-content resp-tab-content-active" style="display:block" aria-labelledby="tab_item-0">
        <h2 class="text-6 mb-1">Book your appointment</h2>
        <p>Book your appointment with {{ $expert->appointmenter_name }}. Please fill the form below to book your appointment.</p>
        <form id="appointment-form" action="{{ route('book.appointment') }}" data-action="call" data-reset="true" class="row formaction">
          @csrf

          <input type="hidden" name="expert_id" id="expert_id" value="{{ $expert->id }}">
          <input type="hidden" name="business_id" id="business_id" value="{{ $expert->business_id }}">
          <input type="hidden" name="department_id" value="{{ $expert->department_id }}">
          <input type="hidden" value="{{ $expert->businessSetting['is_appointment_book_with_time_slote'] }}" id="with-timing">

          <div class="col-md-6 col-sm-6 col-12 mb-3">
            <label for="booking_date" class="form-label">Appointment date</label>
            <input type="date" name="booking_date" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="booking_date" required="" placeholder="Appointment date">
          </div>

          @if ($expert->businessSetting['is_appointment_book_with_time_slote'])
          <div class="col-md-6 col-sm-6 col-12 mb-3">
            <label for="operator" class="form-label">Appointment Time</label>
            <select class="form-control" name="timeslote" id="timeslote" required="">
              <option value="">Select Your Appointment Time</option>
              @foreach ($timeSlots as $time)
              <option value="{{ $time['time'] }}" {{ $time['is_booked'] || $time['is_available'] == false ?'disabled':'' }}>{{ $time['time'] }}</option>
              @endforeach
            </select>
          </div>
          @endif

          <div class="col-md-6 col-sm-6 col-12 mb-3">
            <label for="user_name" class="form-label">Your Name</label>
            <div class="input-group">
              <input class="form-control" name="user_name" id="user_name" placeholder="Enter Your Name" required="" type="text">
            </div>
          </div>

          <div class="col-md-6 col-sm-6 col-12 mb-3">
            <label for="user_contact" class="form-label">Mobile Number</label>
            <input type="text" name="user_contact" class="form-control" id="user_contact" required="" placeholder="Enter Mobile Number">
          </div>

          <div class="col-12 mb-3">
            <button class="btn btn-primary btn_action" href="recharge-order-summary.html">
              <span id="buttonText"> Appointment Book</span>
              <span id="loader" class="d-none"> Booking ...</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-5 col-sm-5 col-12 my-sm-2 mt-3 text-center">

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
        <button type="button" class="close close-outside" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        <div class="row">
          <div class="col-11 col-md-10 mx-auto">

            <div class="text-center">
              <i class="fas fa-check-circle text-success mb-3"></i>
              <h2 class="text-success">Appointment Book Successfully</h2>
              <p>Thank you for booking your appointment, <!-- strong id="userName">John Doe</strong -->.</p>
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
    console.log(res);
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
        success: function(states) {
          console.log(states);
          $('#timeslote').html('<option value="">Select Timing</option>');
          $.each(states, function(index, item) {
            var disable = item.is_booked ? 'disabled' : '';
            $('#timeslote').append('<option value="' + item.time + '" ' + disable + '>' + item.time + '</option>');
          });
        },
        error: function(xhr, status, error) {
          console.error("Error: " + error);
          $('#timeslote').html('<option value="">Select Timing</option>');
          alert("There was an error on appointmenter change.");
        }
      });
    });
  });
</script>
@endpush