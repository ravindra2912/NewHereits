@extends('front.layouts.main', ['seo' => [
'title' => $expert->appointmenter_name.' | Hereits',
'description' => $expert->appointmenter_name,
'keywords' => $expert->appointmenter_name ,
'image' => getImage($expert->appointmenter_image) ,
'city' => '',
'state' => '',
'position' => ''
]
])
@section('content')
@section('title', $expert->appointmenter_name)

@push('style')

<style>
  .hero-banner.hero-banner-auther {
    position: relative;
    overflow: unset;
    background-size: cover;
    background-repeat: no-repeat;
  }

  .hero-banner {
    background: linear-gradient(106.08deg, #efeffe 0.38%, rgba(239, 239, 254, 0) 99.04%);
    padding: 30px 0 60px;
    position: relative;
    z-index: 0;
    overflow: hidden;
    background-image: url("{{ asset('front/images/expert-bg.jpg') }}");
    padding-bottom: 20px !important;
  }

  .hero-banner.hero-banner-auther .inner .auth-img-wrap img {
    max-height: 300px;
    max-width: 300px;
    -o-object-fit: cover;
    object-fit: cover;
    width: 100%;
    border-radius: 10px;
  }

  .title-sub h1,
  .title-sub h2 {
    position: relative;
    font-weight: 600;
  }

  .title-sub h1:after,
  .title-sub h2:after {
    content: "";
    display: block;
    width: 85px;
    height: 3px;
    margin-top: 7px;
    background: #ffc107;
  }

  .hero-banner.hero-banner-auther .inner .auth-content-wrap h5 {
    font-size: 20px;
    margin: 10px 0;
    text-transform: capitalize;
    font-weight: 400;
    color: white;
  }

  .hero-banner.hero-banner-auther .inner .auth-content-wrap p {
    font-size: 16px;
    line-height: 24px;
    margin: 15px 0;
  }




  .form-select:not(.form-select-sm) {
    height: calc(3.05rem + 2px);
    /* min-height: 100%; */
    padding-top: .700rem;
    padding-bottom: .700rem;
  }

  .form-select:invalid {
    color: #b1b4b6;
  }

  .form-control,
  .form-select {
    border-color: #d5d3d3;
    color: #777;
  }

  .form-select {
    display: block;
    width: 100%;
    padding: .375rem 2.25rem .375rem .75rem;
    -moz-padding-start: calc(.75rem - 3px);
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    /* background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e); */
    background-repeat: no-repeat;
    background-position: right .75rem center;
    background-size: 16px 12px;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    appearance: none;
  }

  select {
    word-wrap: normal;
  }

  button,
  select {
    text-transform: none;
  }

  .fa-check-circle {
    font-size: 60px;
  }

  .googleMap {
    width: -webkit-fill-available;
    height: 300px;
  }
</style>


@endpush

<section>
  <div class="hero-banner white-content pb-0 hero-banner-auther">
    <div class="container">
      <div class="inner row justify-content-center">
        <div class="col-12 col-lg-3 col-md-4 mb-md-0 mb-4 auth-img-wrap">
          <img src="{{ getImage($expert->appointmenter_image) }}" alt="{{ $expert->appointmenter_name }}" title="{{ $expert->appointmenter_name }}" class="">
        </div>
        <div class="col-12 col-lg-8 col-md-7 auth-content-wrap">
          <div class="title-sub mb-md-4 mb-3">
            <h1 class="text-white">{{ $expert->appointmenter_name }}</h1>
          </div>
          <h5 class="pb-0 mb-0">{{ $expert->title }}</h5>
          <p class="text-white mt-3">{{ $expert->description }}</p>
        </div>
      </div>
    </div>
  </div>



  <div class="section mx-3 row">
    <div class="col-md-7 col-sm-7 col-12 my-sm-5">
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
              <select class="form-select" name="timeslote" id="timeslote" required="">
                <option value="">Select Your Appointment Time</option>
                @foreach ($timeSlots as $time)
                <option value="{{ $time['time'] }}" {{ $time['is_booked']?'disabled':'' }}>{{ $time['time'] }}</option>
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
    <div class="col-md-5 col-sm-5 col-12 my-sm-5 text-center">

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

</section>


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

@endsection