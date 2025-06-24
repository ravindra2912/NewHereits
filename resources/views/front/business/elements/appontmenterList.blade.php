@php
/*
@foreach ($appontmenters as $appontmenter)

<a href="{{ route('expert', $appontmenter->slug) }}" title="{{ $appontmenter->appointmenter_name }}" class="col-md-4 col-sm-6 col-12 mb-3" data-departmentid="{{ (isset($appontmenter->department) && !empty($appontmenter->department->id)) ? $appontmenter->department->id: '' }}">
  <div class="banner">
    <div class="banner-header">
      <!-- <h1>Dr. Cons<br><small style="font-size: 12px; color: #666;">Your personal doctor</small></h1> -->
      <h1>
        @if (isset($appontmenter->department) && !empty($appontmenter->department->department_name))
        {{ $appontmenter->department->department_name }}
        @endif
      </h1>
      <div class="appointment">Book<br>appointment</div>
    </div>
    <div class="banner-image">
      <img src="{{ getImage($appontmenter->appointmenter_image) }}" alt="Doctor">
    </div>
    <div class="banner-body">
      <h2>{{ $appontmenter->appointmenter_name }}</h2>
      <span class="mr-2">
        <i class="fas fa-star text-warning"></i>
        <i class="fas fa-star text-warning"></i>
        <i class="fas fa-star text-warning"></i>
        <i class="fas fa-star text-warning"></i>
        <i class="fas fa-star text-gray"></i>
        <!-- <i class="text-black-50" href="#">(245 reviews)</i> -->
      </span>

    </div>
  </div>
</a>

@endforeach
*/
@endphp



@foreach ($appontmenters as $appontmenter)
<a href="{{ route('expert', $appontmenter->slug) }}" title="{{ $appontmenter->appointmenter_name }}" class="col-md-12 col-12 " data-departmentid="{{ (isset($appontmenter->department) && !empty($appontmenter->department->id)) ? $appontmenter->department->id: '' }}">
  <div class="bg-white shadow-md rounded p-3 mb-2 list-store">
    <div class="row">
      <div class="col-md-3 col-5 text-center">
        @if (Auth::check())
        <!-- <span class="cf store-fav border rounded-pill text-nowrap">
          <i class="far fa-heart"></i>
           <i class="fas fa-heart"></i>
        </span> -->
        @endif
        <img class="img-fluid align-top appoinmenter-img" src="{{ getImage($appontmenter->appointmenter_image, 'expert') }}" alt="{{ $appontmenter->appointmenter_name }}">
      </div>
      <div class="col-md-5 col-7 pl-3 pl-md-0 mt-3 mt-md-0">
        <div class="row no-gutters">
          <div class="col-sm-9">
            <h4 title="{{ $appontmenter->appointmenter_name }}" class="text-dark text-5 store-name">{{ $appontmenter->appointmenter_name }}</h4>
            <span class="mr-2">
              @for ($i = 1; $i <= 5; $i++)
                <i class="fas fa-star {{ $appontmenter->rating >= $i? 'text-warning':'text-muted' }}"></i>
                @endfor
            </span>
            @if (isset($appontmenter->title) && !empty($appontmenter->title))
            <div class="text-black-50 mb-0 mb-sm-2 order-3 d-sm-block">{{ $appontmenter->title }}</div>
            @endif
            @if (isset($appontmenter->department) && !empty($appontmenter->department->department_name))
            <div class="text-black-50 mb-0 mb-sm-2 order-3 d-sm-block">{{ $appontmenter->department->department_name }}</div>
            @endif


            <!-- <p class=" d-flex align-items-center mb-2 text-4">
                     <span class="cf border rounded-pill text-1 text-nowrap px-2">verified</span>
                   </p> -->
            <!-- <p class="reviews mb-2">
                      <span class="reviews-score px-2 py-1 rounded font-weight-600 text-light">8.2</span> <span class="font-weight-600">Excellent</span> <a class="text-black-50" href="#">(245 reviews)</a>
                    </p> -->


          </div>
        </div>
      </div>
      <div class="col-md-4 col-12 pl-3 pl-md-0 mt-md-3 mt-0 mt-md-0 d-flex flex-column justify-content-center">
        @php
        $timing = isExpertAvailable($appontmenter->id);
        @endphp
        @if($timing['status'] == 'close')
        <p class="text-danger mb-0 text-center h5 pt-2">Close</p>
        @elseif($timing['status'] == 'open')
        @if ($timing['data'])
        <div class="my-2 mx-3 text-center align-self-center ">
          <div class="pt-2">
            <h4 class="">Token No.</h4>
            <h3>{{ $timing['data']->token_number }}</h3>
          </div>
        </div>
        @else
        <p class="text-success mb-0 text-center h5 pt-2">Available</p>
        @endif
        @elseif($timing['status'] == 'break')
        <div class="my-2 mx-3 text-center align-self-center ">
          <div class="pt-2">
            <h4 class="text-danger mb-0">Break</h4>
            @if ($timing['data'])
            <p class="mb-0">Open at : {{ get_time($timing['data']->start_time) }}</p>
            @endif
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</a>
@endforeach