@extends('front.layouts.main', ['seo' => [
'title' => $business->name,' | Hereits',
'description' => $business->name,
'keywords' => $business->name ,
'image' => getImage($business->business_image) ,
'city' => '',
'state' => '',
'position' => ''
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
    }
  }
</style>


@endpush

<section>
  <div class="hero-wrap section pb-3" id="store_info">
    <div class="hero-bg" style="background-image:url({{ asset('front/img/store-bg.jpg') }});"></div>
    <div class="hero-content">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-12 text-center " style="align-self: center;">
            <img class="store-avtar" alt="{{ $business->name }}" src="{{ getImage($business->business_image) }}">
          </div>
          <div class="col-lg-8 col-12 banner-info">
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
  <div class="mt-5 mb-5 mx-3">
    <div class="row">
      <div class="col-lg-2 mt-2 mt-lg-2 col-0">
        <p class="text-center"> for advertisement </p>
      </div>
      <div class="col-lg-8 mt-1 mt-lg-0">
        @if ($setting->is_appointment_with_department)
        <!-- Sort Filters
          ============================================= -->
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

</section>


@push('js')
<script>
  $(document).ready(function() {
    $('#sort_by').change(function() {
      var department_id = $(this).val();
      const innerDivs = document.querySelectorAll('#list-obj > div');
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
</script>
@endpush

@endsection