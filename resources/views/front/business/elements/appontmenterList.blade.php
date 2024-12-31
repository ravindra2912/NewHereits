@foreach ($appontmenters as $appontmenter)

<div class="col-md-4 col-12 mb-3">
<div class="banner">
  <div class="banner-header">
    <h1>Dr. Cons<br><small style="font-size: 12px; color: #666;">Your personal doctor</small></h1>
    <div class="appointment">Set Your<br>Appointment</div>
  </div>
  <div class="banner-image">
    <img src="{{ getImage($appontmenter->appointmenter_image) }}" alt="Doctor">
  </div>
  <div class="banner-body">
    <h2>Your Health is Our Concern</h2>
    <p>Reallygreatsite.com</p>
  </div>
</div>
</div>

@endforeach



@php
/*
@foreach ($appontmenters as $appontmenter)
<div class="col-md-6 col-12 ">
  <div class="bg-white shadow-md rounded p-3 mb-2 list-store">
    <div class="row">
      <div class="col-md-4 col-4 text-center">
        @if (Auth::check())
        <span class="cf store-fav border rounded-pill text-nowrap">
          <i class="far fa-heart"></i>
          <!-- <i class="fas fa-heart"></i> -->
        </span>
        @endif
        <a href="#"><img class="img-fluid align-top appoinmenter-img" src="{{ getImage($appontmenter->appointmenter_image) }}" alt="{{ $appontmenter->appointmenter_name }}"></a>
      </div>
      <div class="col-md-8 col-8 pl-3 pl-md-0 mt-3 mt-md-0">
        <div class="row no-gutters">
          <div class="col-sm-9">
            <h4><a href="#" title="{{ $appontmenter->appointmenter_name }}" class="text-dark text-5 store-name">{{ $appontmenter->appointmenter_name }}</a></h4>

            <span class="mr-2">
              <i class="fas fa-star text-warning"></i>
              <i class="fas fa-star text-warning"></i>
              <i class="fas fa-star text-warning"></i>
              <i class="fas fa-star text-warning"></i>
              <i class="fas fa-star text-gray"></i>
              <i class="text-black-50" href="#">(245 reviews)</i>
            </span>

            <!-- <p class=" d-flex align-items-center mb-2 text-4">
                     <span class="cf border rounded-pill text-1 text-nowrap px-2">verified</span>
                   </p> -->
            <!-- <p class="reviews mb-2">
                      <span class="reviews-score px-2 py-1 rounded font-weight-600 text-light">8.2</span> <span class="font-weight-600">Excellent</span> <a class="text-black-50" href="#">(245 reviews)</a>
                    </p> -->
            @if (isset($appontmenter->department) && !empty($appontmenter->department->department_name))
            <div class="text-black-50 mb-0 mb-sm-2 order-3 d-sm-block">{{ $appontmenter->department->department_name }}</div>
            @endif

          </div>
          <div class="col-sm-3 text-right d-flex d-sm-block align-items-center">
            <p class="text-success mb-0">Open</p>
            <!-- <p class="text-danger mb-0">close</p> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach

*/
@endphp