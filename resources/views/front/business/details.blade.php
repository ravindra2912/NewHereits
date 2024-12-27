@extends('front.layouts.main')
@section('content')
@section('title', $business->name)

<section>
  <div class="hero-wrap section pb-3" id="store_info">
    <div class="hero-bg" style="background-image:url({{ asset('front/img/store-bg.jpg') }});"></div>
    <div class="hero-content">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-4 text-center " style="align-self: center;">
            <img class="img-fluid store-img" alt="" src="{{ getImage($business->business_image) }}" style="border-radius: 20px;">
          </div>
          <div class="col-lg-8 col-8 text-lg-left mt-4">
            <h2 class=" font-weight-600 text-light store-name">{{ $business->name }} </h2>
            <p class="mb-2">
              <span class="mr-2">
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star text-warning"></i>
                <i class="fas fa-star text-warning"></i>
              </span>
              <span class="text-light product-description"><i class="fas fa-map-marker-alt "></i> {{ $business->address }} </span>
            <p class="reviews mb-3">
              <span class="reviews-score px-2 py-1 rounded font-weight-600 text-light">8.2</span> <span class="font-weight-600 text-light">Excellent</span> <a class="text-light" href="#">(245 reviews)</a>
            </p>
            <p class=" d-flex align-items-center mb-2 text-4">

              <!-- store fevourit -->
              <span class="cf border rounded-pill text-3 text-nowrap px-2 text-light mr-2" data-toggle="tooltip" data-original-title="Favourite" id="fav" item_id="{{ $business->id }}" store_id="{{ $business->id }}"><i class="{{ 1 == 1? 'fas fa-heart':'far fa-heart' }}"></i></span>

              <a href="tel:{{ $business->contact }}" target="_blank" data-toggle="tooltip" data-original-title="Call" class="cf border rounded-pill text-3 text-nowrap px-2 text-light mr-2"><i class="fas fa-phone-alt"></i></a>
              <a href="#" id="copylink" data-toggle="tooltip" data-original-title="Copy Link To Shere" class="cf border rounded-pill text-3 text-nowrap px-2 text-light mr-2"><i class="far fa-copy"></i></a>
              <a href="http://maps.google.com/maps?q={{ $business->latitude.','.$business->longitude }}&ll={{ $business->latitude.','.$business->longitude }}&z=17" target="_blank" data-toggle="tooltip" data-original-title="get directions" class="cf border rounded-pill text-3 text-nowrap px-2 text-light mr-2"><i class="fas fa-map-marker-alt"></i></a>
              <a href="https://wa.me/91{{ $business->contact }}/?text=i want to know about" target="_blank" data-toggle="tooltip" data-original-title="Chat With Store" class="cf border rounded-pill text-3 text-nowrap px-2 text-light mr-2"><i class="fab fa-whatsapp"></i></a>
            </p>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if (isset($setting->is_appointment_system) && $setting->is_appointment_system)
  <div>
      <h3>Appontment </h3>
  </div>
  @endif

</section>


@push('js')
<script>

</script>
@endpush

@endsection