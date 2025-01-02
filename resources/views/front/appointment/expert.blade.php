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
    min-height: 100%;
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
          <h5 class="pb-0 mb-0">Business Development Manager</h5>
          <p class="text-white mt-3">Jayveer Ker serves as the Business Development Manager at PSDtoHTMLNinja.com, specializing in assisting organizations with overcoming web development hurdles. His insightful and informative posts deliver practical solutions and valuable insights.</p>
        </div>
      </div>
    </div>
  </div>



  <div class="section mx-3 row">
    <div class="col-md-8 col-sm-8 col-12 my-sm-5">
      <div class="resp-tabs-container bg-white shadow-md rounded p-3">
        <div class="resp-tab-content resp-tab-content-active" style="display:block" aria-labelledby="tab_item-0">
          <h2 class="text-6 mb-1">Book your appointment</h2>
          <p>Book your appointment with {{ $expert->appointmenter_name }}. Please fill the form below to book your appointment.</p>
          <form id="appointment-form" action="{{ route('business.appointment.bookings.store') }}" data-action="redirect" class="formaction">
            @csrf

            <input type="hidden" name="expert_id" value="{{ $expert->id }}">
            <input type="hidden" name="business_id" value="{{ $expert->business_id }}">
            <input type="hidden" name="department_id" value="{{ $expert->department_id }}">
            

            <div class="mb-3">
              <label for="appointmentdate" class="form-label">Appointment date</label>
              <input type="date" name="booking_date" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="booking_date" required="" placeholder="Appointment date">
            </div>

            @if ($expert->businessSetting['is_appointment_book_with_time_slote'])
            <div class="mb-3">
              <label for="operator" class="form-label">Appointment Time</label>
              <select class="form-select" id="appointmenttime" required="">
                <option value="">Select Your Appointment Time</option>
                @foreach ($timeSlots as $time)
                <option value="{{ $time['time'] }}" {{ $time['is_booked']?'disabled':'' }}>{{ $time['time'] }}</option>
                @endforeach
              </select>
            </div>
            @endif

            <div class="mb-3">
              <label for="user_name" class="form-label">Your Name</label>
              <div class="input-group">
                <input class="form-control" name="user_name" id="user_name" placeholder="Enter Your Name" required="" type="text">
              </div>
            </div>

            <div class="mb-3">
              <label for="user_contact" class="form-label">Mobile Number</label>
              <input type="text" name="user_contact" class="form-control" id="user_contact" required="" placeholder="Enter Mobile Number">
            </div>

            <div class="d-grid mt-4"> 
              <button class="btn btn-primary" href="recharge-order-summary.html">Book Appointment</button> 
            </div>
          </form>
        </div>
      </div>


      <div class="text-center mt-5"><a href="#" class="btn-link text-4">See more people review<i class="fas fa-chevron-right text-2 ms-2"></i></a></div>
    </div>
    <div class="col-md-4 col-sm-4 col-12 my-sm-5 text-center">
      <p>for advertisement</p>
    </div>
  </div>
</section>


@push('js')
<script>
  $(document).ready(function() {

  });
</script>
@endpush

@endsection