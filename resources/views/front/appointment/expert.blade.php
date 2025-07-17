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
    background-image: url("{{ asset('front/images/expert-bg.webp') }}");
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



  @media (max-width: 767px) {
    .banner-info {
      text-align: center;
      justify-items: center;
    }

    .hero-banner.hero-banner-auther .inner .auth-img-wrap img {
      object-fit: cover;
      height: 150px;
      width: 150px;
    }

    .title-sub h1:after {
      justify-self: center;
      width: 150px;
      margin-left: auto;
      margin-right: auto;
    }

    .expert-name {
      font-size: 1.5rem;
    }
  }

  .fa-check-circle {
    font-size: 60px;
  }

  .googleMap {
    width: -webkit-fill-available;
    height: 300px;
  }

  .toen-no {
    font-weight: 600;
    font-size: 60px;
  }
</style>


@endpush

<section>
  <div class="hero-banner white-content pb-0 hero-banner-auther">
    <div class="container">
      <div class="inner row justify-content-center">
        <div class="col-12 col-lg-3 col-md-4 mb-md-0 mb-4 auth-img-wrap d-flex justify-content-center">
          <img src="{{ getImage($expert->appointmenter_image, 'expert') }}" alt="{{ $expert->appointmenter_name }}" title="{{ $expert->appointmenter_name }}" class="">
        </div>
        <div class="col-12 col-lg-8 col-md-7 auth-content-wrap banner-info">
          <div class="title-sub mb-md-4 mb-3 row">
            <div class="col-sm-8 col-12">
              <h1 class="text-white expert-name">{{ $expert->appointmenter_name }}</h1>
              <span class="mr-2">
                @for ($i = 1; $i <= 5; $i++)
                  <i class="fas fa-star {{ $expert->rating >= $i? 'text-warning':'text-muted' }}"></i>
                  @endfor
              </span>
              <h5 class="pb-0 mb-0">{{ $expert->title }}</h5>
              <!-- <p class="text-white mt-3">{{ $expert->description }}</p> -->
              <div>
                <p class=" d-flex align-items-center justify-content-md-start justify-content-center mb-2 text-4">
                  <a href="javascript:void(0)" id="copylink" data-url="{{ route('expert', $expert->slug) }}" data-toggle="tooltip" data-original-title="Copy Link To Shere" class="cf border rounded-pill text-3 text-nowrap px-2 text-light mr-2"><i class="far fa-copy"></i></a>
                  <a href="{{ route('expert.board', $expert->slug) }}" target="_blank" data-toggle="tooltip" data-original-title="Board" class="cf border rounded-pill text-3 text-nowrap px-2 text-light mr-2"><i class="far fa-clipboard"></i></a>
                </p>
              </div>
            </div>
            <div class="col-sm-4 col-12 text-center mt-md-0 mt-2 align-content-center" style="height: min-content">
            <div class="border rounded">
              @if($expert->timing['status'] == 'close')
              <h4 class="text-danger mb-0 text-center ">Close</h4>
              @elseif($expert->timing['status'] == 'open')
              @if ($expert->timing['data'])
              <div class="my-2 mx-3 text-center align-self-center ">
                <div class=" py-2">
                  <h4 class="text-white">Token No.</h4>
                  <h3 class="text-white">{{ $expert->timing['data']->token_number }}</h3>
                </div>
              </div>

              @else
              <h4 class="text-success mb-0 text-center h5">Available</h4>
              @endif
              @elseif($expert->timing['status'] == 'break')
              <div class="my-2 mx-3 text-center align-self-center ">
                <div class="py-2">
                  <h4 class="text-danger">Break</h4>
                  @if ($expert->timing['data'])
                  <p class="text-white">Open at : {{ get_time($expert->timing['data']->start_time) }}</p>
                  @endif
                </div>
              </div>
              @endif
            </div>
            </div>
          </div>


        </div>
      </div>
    </div>
  </div>



  @include('front.appointment.appointmentForm')

  <!-- review and rating  -->
  <div class="section mx-md-4 mx-3 py-2">
    <div class="resp-tabs-container bg-white shadow-md rounded p-3">
      <h2 id="reviews" class="text-6 mb-3 mt-2">Reviews</h2>
      <div class="row">
        <div class="col-sm-4 col-md-3">
          <div id="review-summary" class="bg-primary text-light rounded px-2 py-4 mb-4 mb-sm-0 text-center">
            <div class="text-10 font-weight-600 line-height-1 d-block">{{ number_format($expert->rating, 1) }}</div>
            <div class="font-weight-500 my-1">{{ config('const.business_rating.'.floor($expert->rating)) }}</div>
            <small class="d-block">Based on {{ $expert->ReviewAndRating->totalReview }} reviews</small>
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
                if($expert->ReviewAndRating->totalReview > 0){
                $reviewper = (100 * (int)$expert->ReviewAndRating->$reviewCount) / (int)$expert->ReviewAndRating->totalReview;
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
      @if (isset($expert->reviews) && count($expert->reviews) > 0)
      @foreach ($expert->reviews as $reviews)
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


      <!-- <div class="text-center"> <a href="#" class="btn btn-sm btn-outline-dark shadow-none">view more reviews</a> </div> -->

    </div>
  </div>

</section>


@push('js')
@endpush

@endsection