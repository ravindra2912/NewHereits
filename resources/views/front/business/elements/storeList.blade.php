@foreach ($businesses as $res)
<div class=" bg-white shadow-md rounded p-3 mb-2 list-store">
  <div class="row">
    <div class="col-md-4 col-4" style="align-self: center;">
      @if (Auth::check())
      <span class="cf store-fav border rounded-pill text-nowrap" id="store-fav-{{ $res->id }}" onclick="store_fevourit({{ $res->id }})">
        <i class="far fa-heart"></i>
        <!-- <i class="fas fa-heart"></i> -->
      </span>
      @endif
      <a href="{{ route('business-details', $res->slug) }}"><img class="img-fluid rounded align-top store-img" src="{{ getImage($res->business_image) }}" alt="{{ $res->name }}"></a>
    </div>
    <div class="col-md-8 col-8 pl-3 pl-md-0 mt-3 mt-md-0">
      <div class="row no-gutters">
        <div class="col-sm-9">
          <h4><a href="{{ route('business-details', $res->slug) }}" title="{{ $res->name }}" class="text-dark text-5 store-name">{{ $res->name }}</a></h4>

          <span class="mr-2">
            <i class="fas fa-star text-warning"></i>
            <i class="fas fa-star text-warning"></i>
            <i class="fas fa-star text-warning"></i>
            <i class="fas fa-star text-warning"></i>
          </span>
          <p class="mb-2 store-address"><span><a href="{{ route('business-details', $res->slug) }}" title="{{ $res->name }}" class="text-black-50"><i class="fas fa-map-marker-alt pr-1"></i>{{ $res->address }}</a></span>
          </p>
          <!-- <p class=" d-flex align-items-center mb-2 text-4">
            <span class="cf border rounded-pill text-1 text-nowrap px-2">verified</span>
          </p> -->
          <p class="reviews mb-2">
            <span class="reviews-score px-2 py-1 rounded font-weight-600 text-light">8.2</span> <span class="font-weight-600">Excellent</span> <a class="text-black-50" href="#">(245 reviews)</a>
          </p>
          @if (isset($res->businessCategory) && !empty($res->businessCategory))
          <div class="text-black-50 mb-0 mb-sm-2 order-3 d-sm-block">{{ $res->businessCategory->name }}</div>
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

@endforeach