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



  @media (max-width: 767px) {
    .banner-info {
      text-align: center;
      justify-items: center;
    }

    .hero-banner.hero-banner-auther .inner .auth-img-wrap img {
      object-fit: contain;
      height: 150px;
      max-width: unset;
    }

    .title-sub h1:after {
      justify-self: center;
      width: 150px;
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
</style>


@endpush

<section>
  <div class="hero-banner white-content pb-0 hero-banner-auther">
    <div class="container">
      <div class="inner row justify-content-center">
        <div class="col-12 col-lg-3 col-md-4 mb-md-0 mb-4 auth-img-wrap">
          <img src="{{ getImage($expert->appointmenter_image) }}" alt="{{ $expert->appointmenter_name }}" title="{{ $expert->appointmenter_name }}" class="">
        </div>
        <div class="col-12 col-lg-8 col-md-7 auth-content-wrap banner-info">
          <div class="title-sub mb-md-4 mb-3">
            <h1 class="text-white expert-name">{{ $expert->appointmenter_name }}</h1>
            <h5 class="pb-0 mb-0">{{ $expert->title }}</h5>
            <p class="text-white mt-3">{{ $expert->description }}</p>
            
          </div>
          <div>
          <p class=" d-flex align-items-center mb-2 text-4">
              <a href="javascript:void(0)" id="copylink" data-url="{{ route('expert', $expert->slug) }}" data-toggle="tooltip" data-original-title="Copy Link To Shere" class="cf border rounded-pill text-3 text-nowrap px-2 text-light mr-2"><i class="far fa-copy"></i></a>
              <a href="{{ route('expert.board', $expert->slug) }}" target="_blank" data-toggle="tooltip" data-original-title="Board" class="cf border rounded-pill text-3 text-nowrap px-2 text-light mr-2"><i class="far fa-clipboard"></i></a>
          </p>
            </div>

        </div>
      </div>
    </div>
  </div>



  @include('front.appointment.appointmentForm')

  <!-- review and rating  -->
  <div class="section mx-5 py-2">
    <div class="resp-tabs-container bg-white shadow-md rounded p-3">
      <h2 id="reviews" class="text-6 mb-3 mt-2">Reviews</h2>
      <div class="row">
        <div class="col-sm-4 col-md-3">
          <div id="review-summary" class="bg-primary text-light rounded px-2 py-4 mb-4 mb-sm-0 text-center">
            <div class="text-10 font-weight-600 line-height-1 d-block">{{ $expert->ReviewAndRating->avgRating > 0 ?$expert->ReviewAndRating->avgRating:0.0 }}</div>
            <div class="font-weight-500 my-1">{{ config('const.business_rating.'.round($expert->ReviewAndRating->avgRating > 0 ?$expert->ReviewAndRating->avgRating:0)) }}</div>
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