@extends('front.layouts.main', ['seo' => [
'title' => $business->name,' | Hereits',
'description' => $business->name,
'keywords' => $business->name ,
'image' => getImage($business->business_image) ,
'city' => '',
'state' => '',
'position' => $business->latitude.':'.$business->longitude
]
])
@section('content')
@section('title', $business->name)

@push('style')

<style>
  .banner {
    /* width: 350px; */
    height: 300px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    text-align: center;
  }

  .banner-header {
    background-color: #e1ebf3;
    /* background-color: #eef3f7; */
    padding: 15px;
    display: flex;
    justify-content: space-between;
    /* align-items: center; */
    height: 50%;
  }

  .banner-header h1 {
    font-size: 18px;
    margin: 0;
    color: #333;
  }

  .banner-header .appointment {
    font-size: 14px;
    color: #336699;
    font-weight: bold;
  }

  .banner-image {
    /* margin-top: 20px; */
    position: relative;
  }

  .banner-image img {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    border: 2px solid #ffa500;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    object-fit: cover;
  }

  .banner-body {
    background-color: #336699;
    color: white;
    padding: 20px 10px;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    height: 50%;
  }

  .banner-body h2 {
    font-size: 18px;
    /* margin: 10px 0; */
    color: white;
    margin-bottom: 0px;
  }

  .banner-body p {
    font-size: 14px;
    /* margin: 5px 0; */
    margin-bottom: 0px;
    color: #cce7ff;
  }


  /* store Banner  */
  .store-avtar {
    height: 200px;
    width: 200px;
    object-fit: contain;
  }

  @media (max-width: 767px) {
    .banner-info {
      text-align: center;
      justify-items: center;
    }

    .store-avtar {
      height: 150px;
      width: 150px;
      object-fit: cover;
      border-radius: 8px;
    }
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
  <div class="hero-wrap section pb-3" id="store_info">
    <div class="hero-bg" style="background-image:url({{ asset('front/img/store-bg.webp') }});"></div>
    <div class="hero-content">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-12 text-center align-self-center mt-md-0 mt-3">
            <img class="store-avtar" alt="{{ $business->name }}" src="{{ getImage($business->business_image) }}">
          </div>
          <div class="col-lg-8 col-12 banner-info">
            <h2 class=" font-weight-600 text-light store-name">{{ $business->name }} </h2>
            <p class="mb-2">
              <span class="mr-2">
                @for ($i = 1; $i <= 5; $i++)
                  <i class="fas fa-star {{ $business->rating >= $i? 'text-warning':'text-muted' }}"></i>
                  @endfor
              </span>
              <span class="text-light product-description"><i class="fas fa-map-marker-alt pr-1"></i> {{ $business->address }} </span>
              <!-- <p class="reviews mb-2">
              <span class="reviews-score px-2 py-1 rounded font-weight-600 text-light">{{ $business->rating }}</span>
              <span class="font-weight-600">{{ config('const.business_rating.'.round($business->rating)) }}</span>
              <a class="text-black-50" href="#">(245 reviews)</a>
            </p> -->
            <p class=" d-flex align-items-center justify-content-md-start justify-content-center mb-2 text-4">

              <!-- store fevourit -->
              @if (Auth::check())
              <span class="cf border rounded-pill text-3 text-nowrap px-2 text-light mr-2" data-toggle="tooltip" data-original-title="Favourite" id="fav" onclick="favorite({{ $business->id }})"><i class="{{ $business->is_favorite ? 'fas fa-heart':'far fa-heart' }}"></i></span>
              @else
              <span class="cf border rounded-pill text-3 text-nowrap px-2 text-light mr-2" data-toggle="modal" data-target="#login-modal" title="Favourite">
                <i class="far fa-heart"></i>
              </span>
              @endif

              <a href="tel:{{ $business->contact }}" target="_blank" data-toggle="tooltip" data-original-title="Call" class="cf border rounded-pill text-3 text-nowrap px-2 text-light mr-2"><i class="fas fa-phone-alt"></i></a>
              <a href="javascript:void(0)" id="copylink" data-url="{{ url()->current() }}" data-toggle="tooltip" data-original-title="Copy Link To Shere" class="cf border rounded-pill text-3 text-nowrap px-2 text-light mr-2"><i class="far fa-copy"></i></a>
              <a href="http://maps.google.com/maps?q={{ $business->latitude.','.$business->longitude }}&ll={{ $business->latitude.','.$business->longitude }}&z=17" target="_blank" data-toggle="tooltip" data-original-title="get directions" class="cf border rounded-pill text-3 text-nowrap px-2 text-light mr-2"><i class="fas fa-map-marker-alt"></i></a>
              <a href="https://wa.me/91{{ $business->contact }}/?text=i want to know about" target="_blank" data-toggle="tooltip" data-original-title="Chat With Store" class="cf border rounded-pill text-3 text-nowrap px-2 text-light mr-2"><i class="fab fa-whatsapp"></i></a>
            </p>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>


  @if (isset($expert) && !empty($expert))

  <div class="section pt-3 pb-0 mx-3 row">
    <a href="{{ route('expert', $expert->slug) }}" title="{{ $expert->appointmenter_name }}" class="col-md-7 col-sm-7 col-12 ">
      <div class="bg-white shadow-md rounded p-3 mb-2 list-store">
        <div class="row">
          <div class="col-md-3 col-5 text-center">

            <img class="img-fluid align-top appoinmenter-img" src="{{ getImage($expert->appointmenter_image) }}" alt="{{ $expert->appointmenter_name }}" />
          </div>
          <div class="col-md-5 col-7 pl-3 pl-md-0 mt-3 mt-md-0">
            <div class="row no-gutters">
              <div class="col-sm-9">
                <h4 class="text-dark text-5 store-name">{{ $expert->appointmenter_name }}</h4>
                @if (isset($expert->title) && !empty($expert->title))
                <div class="text-black-50 mb-0 mb-sm-2 order-3 d-sm-block">{{ $expert->title }}</div>
                @endif
                @if (isset($expert->department) && !empty($expert->department->department_name))
                <div class="text-black-50 mb-0 mb-sm-2 order-3 d-sm-block">{{ $expert->department->department_name }}</div>
                @endif
                <!-- <span class="mr-2">
                  <i class="fas fa-star text-warning"></i>
                  <i class="fas fa-star text-warning"></i>
                  <i class="fas fa-star text-warning"></i>
                  <i class="fas fa-star text-warning"></i>
                  <i class="fas fa-star text-gray"></i>
                  <i class="text-black-50" href="#">(245 reviews)</i>
                </span> -->

              </div>
            </div>
          </div>
          <div class="col-md-4 col-12 pl-3 pl-md-0 mt-md-3 mt-0 mt-md-0 d-flex flex-column justify-content-center">
            @if($expert->getLastBooking['status'] == 'close')
            <p class="text-danger mb-0 text-center h5 pt-2">Available soon</p>
            @elseif($expert->getLastBooking['status'] == 'open')
            @if ($expert->getLastBooking['data'])
            <div class="my-2 mx-3 text-center align-self-center ">
              <div class=" py-2">
                <h4 class="">Token No.</h4>
                <h3>{{ $expert->getLastBooking['data']->token_number }}</h3>
              </div>
            </div>

            @else
            <p class="text-success mb-0 text-center h5 pt-2">Available</p>
            @endif
            @elseif($expert->getLastBooking['status'] == 'break')
            <div class="my-2 mx-3 text-center align-self-center ">
              <div class="py-2">
                <h4 class="text-danger mb-0">Break</h4>
                @if ($expert->getLastBooking['data'])
                <p class="mb-0">Open at : {{ get_time($expert->getLastBooking['data']->start_time) }}</p>
                @endif
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </a>
  </div>

  @include('front.appointment.appointmentForm')
  @elseif(isset($setting->is_appointment_system) && $setting->is_appointment_system && $appontmentersHtml != null)

  <div class="mt-5 mb-5 mx-3">
    <div class="row">
      <div class="col-lg-2 mt-2 mt-lg-2 col-0">
        <p class="text-center"> for advertisement </p>
      </div>
      <div class="col-lg-8 mt-1 mt-lg-0">
        @if ($setting->is_appointment_with_department)
        <!-- Sort Filters ============================================= -->
        <div class=" mb-2 pb-2">
          <div class="row align-items-center">
            <div class="col-12 col-md-12">
              <div class="row no-gutters ml-auto">
                <label class="col col-form-label-sm text-right mr-2 mb-0" for="input-sort">Departments:</label>
                <select class="custom-select custom-select-sm col" id="sort_by">
                  <option value="" selected>All</option>
                  @foreach ($departments as $department)
                  <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div><!-- Sort Filters end -->
        @endif

        <div class="row" id="list-obj">
          {!! $appontmentersHtml !!}
        </div>

      </div>
      <div class="col-lg-2 mt-2 mt-lg-2 col-0">
        <p class="text-center"> for advertisement </p>
      </div>
    </div>
  </div>
  @endif

  <!-- review and rating  -->
  <div class="section mx-5 mt-2 py-2">
    <div class="resp-tabs-container bg-white shadow-md rounded p-3">
      <h2 id="reviews" class="text-6 mb-3 mt-2">Reviews</h2>
      <div class="row">
        <div class="col-sm-4 col-md-3">
          <div id="review-summary" class="bg-primary text-light rounded px-2 py-4 mb-4 mb-sm-0 text-center">
            <div class="text-10 font-weight-600 line-height-1 d-block">{{ number_format($business->rating, 1) }}</div>
            <div class="font-weight-500 my-1">{{ config('const.business_rating.'.floor($business->rating)) }}</div>
            <small class="d-block">Based on {{ $business->ReviewAndRating->totalReview }} reviews</small>
          </div>
        </div>
        <div class="col-sm-8 col-md-9">
          @for ($i = 5; $i >= 1; $i--)
          @php
          $reviewCount = 'reviewCount'.$i;
          @endphp
          <div class="row">
            <div class="col-8 col-sm-9 col-lg-10">
              <div class="progress mb-3">
                @php
                $reviewper = 0;
                if($business->ReviewAndRating->totalReview > 0){
                $reviewper = (100 * (int)$business->ReviewAndRating->$reviewCount) / (int)$business->ReviewAndRating->totalReview;
                }
                @endphp
                <div class="progress-bar" role="progressbar" style="width: {{ $reviewper }}%" aria-valuenow="{{ $reviewper }}" aria-valuemin="0" aria-valuemax="100">{{ round($reviewper) }}%</div>
              </div>
            </div>
            <div class="col-4 col-sm-3 col-lg-2"><small class="font-weight-600 align-text-top line-height-1">{{ config('const.business_rating.'.$i)}}</small></div>
          </div>
          @endfor
        </div>
      </div>
      <hr class="mb-4">
      @if (isset($business->reviews) && count($business->reviews) > 0)
      @foreach ($business->reviews as $reviews)
      <div class="row">
        <div class="col-12 col-sm-3 text-center">
          <div class="review-tumb bg-dark-5 text-light rounded-circle d-inline-block mb-2 text-center text-8">{{ $reviews->user->first_name[0]}}</div>
          <p class="mb-0 line-height-1">{{ $reviews->user->first_name.' '.$reviews->user->last_name }}</p>
          <small><em>{{ get_date($reviews->createdat, 'd M Y') }}</em></small>
        </div>
        <div class="col-12 col-sm-9 text-center text-sm-left" style="min-height: 105px; align-content: end;">
          <span class="text-2">
            @for ($i = 1; $i <= 5; $i++)
              <i class="fas fa-star {{ $reviews->rating >= $i? 'text-warning':'text-muted opacity-4' }}"></i>
              @endfor

          </span>
          <!-- <p class="font-weight-600 mb-1">Excellent hotel with great location</p> -->
          <p>{{ $reviews->review }}</p>
          <hr>
        </div>
      </div>
      @endforeach
      @endif


      <!-- <div class="text-center"> <a href="#" class="btn btn-sm btn-outline-dark shadow-none">view more reviews</a> </div>
      <h5 class="mb-3 mt-2">Write a review</h5>
      <form>
        <div class="form-group">
          <label for="yourName">Your Name</label>
          <input type="email" class="form-control" id="yourName" required="" aria-describedby="yourName" placeholder="Enter your name">
        </div>
        <div class="form-group">
          <label for="yourReview">Your Review</label>
          <textarea class="form-control" rows="5" id="yourReview" required="" placeholder="Enter Your Review"></textarea>
        </div>
        <div class="form-group">
          <label>Rating</label>
          <div>
            <div class="custom-control custom-radio custom-control-inline">
              <input id="bad" name="reviewRating" class="custom-control-input" checked="" required="" type="radio">
              <label class="custom-control-label" for="bad">Bad</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input id="poor" name="reviewRating" class="custom-control-input" checked="" required="" type="radio">
              <label class="custom-control-label" for="poor">Poor</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input id="fair" name="reviewRating" class="custom-control-input" checked="" required="" type="radio">
              <label class="custom-control-label" for="fair">Fair</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input id="good" name="reviewRating" class="custom-control-input" checked="" required="" type="radio">
              <label class="custom-control-label" for="good">Good</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input id="excellent" name="reviewRating" class="custom-control-input" checked="" required="" type="radio">
              <label class="custom-control-label" for="excellent">Excellent</label>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form> -->
    </div>
  </div>

</section>


@push('js')
<script>
  $(document).ready(function() {
    $('#sort_by').change(function() {
      var department_id = $(this).val();
      const innerDivs = document.querySelectorAll('#list-obj > a');
      innerDivs.forEach(div => {
        if (department_id != '') {
          if ($(div).data('departmentid') == department_id) {
            $(div).removeClass('d-none');
          } else {
            $(div).addClass('d-none');
          }
        } else {
          $(div).removeClass('d-none');
        }
      });
    });
  });

  function favorite(id) {
    $.ajax({
      type: "POST",
      url: "{{ route('businessFavorite') }}",
      data: {
        business_id: id,
      },
      dataType: "json",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      beforeSend: function() {
        loader(true)
      },
      success: function(res) {
        if (res.is_favorite) {
          $('#fav').html('<i class="fas fa-heart"></i>');
        } else {
          $('#fav').html('<i class="far fa-heart"></i>');
        }
        loader(false)
      },
      error: function(xhr, status, error) {
        console.error("Error: " + error);
        loader(false)
        alert("There was an error on favourite.");
      }
    });
  }
</script>
@endpush

@endsection