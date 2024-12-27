@extends('front.layouts.main')
@section('content')
@section('title', 'Home')

@push('style')
<style>
  .hero-wrap:before {
    content: "";
    background: url("{{ asset(" front/img/shape-12.svg") }}");
    position: absolute;
    height: 100%;
    width: 100%;
    opacity: 0.06;
  }
</style>
@endpush


<div class="hero-wrap" style="background: linear-gradient(to right, #3f36b9 0%,#20206b 100%);">
  <div class="opacity-9 bg-white"></div>
  <div class="hero-content banner-taxt-container">
    <div class="container">
      <h2 class="text-7 text-center font-weight-600 mb-2" style="color: white;">Discover The City Gems</h2>
      <p class="text-5 text-center mb-4" style="color: white;">Find great places, shop products, or book services from local experts.</p>
      <div class="text-center mb-4 mobile-hide">
        <span class="redirect-btn mr-2"><a href="{{ route('business') }}" title="Stores"> <i class="fas fa-store-alt"></i> Stores </a></span>
        <!-- <span class="redirect-btn mr-2"><a href="Product"><i class="fab fa-dropbox"></i> Products </a></span> -->
        <!-- <span class="redirect-btn mr-2"><a href="Services"><i class="fas fa-list-ul"></i> Services </a></span> -->
      </div>

    </div>
  </div>
</div>

<!-- Categories -->
@if ($businessCategory)
<section class="section bg-white" style="padding-top: 15px;">
  <div class="container ">
    <h5 class="font-weight-600 mb-3">Business Category</h5>
    <div class="row">
      <div class="col-lg-12 mx-auto">
        <div class="owl-carousel owl-theme" data-autoplay="false" data-loop="false" data-margin="10" data-items-xs="4" data-items-sm="5" data-items-md="5" data-items-lg="9">
          @foreach($businessCategory as $val)
          <div class="item">
            <a href="{{ route('business', $val->slug) }}" class="text-center text-black">
              <img class="img-fluid border" src="{{ getImage($val->image) }}" alt="{{ $val->name }}" />
              <p class="pt-1 text-1 " style="color: black;">{{ $val->name }}</p>
            </a>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
@endif

@if ($businesses)
<section class="section  pt-3 bg-white" style="margin-top: -75px;">
  <div class="container ">
    <div class="d-flex justify-content-between align-items-center">
      <h2 id="reviews" class="text-6 mb-3">Businesses</h2>
      <a href="{{ route('business') }}" class="view-more" title="view-more">View More -></a>
    </div>

    <div class="row ">
      @foreach($businesses as $res)
      <a href="{{ route('business-details', $res->slug) }}" title="{{ $res->name }}" class="col-md-2 col-6 p-1">
        <div class="card shadow-md border-0 mb-2">
          <h5 class="store-name text-3 mb-0 text-black-500" style="padding: 2px 10px 2px 10px;">{{ $res->name }}</h5>
          <div class="pt-2 pl-2 pr-2"><img src="{{ getImage($res->business_image) }}" class="card-img-top d-block store-img pb-2" alt="{{ $res->name }}"></div>
        </div>
      </a>
      @endforeach
    </div>

  </div>
</section>
@endif

@push('js')

<script>
  function setSession(key, val) {
    return sessionStorage.setItem(key, val)
  }

  function getSession(val) {
    return sessionStorage.getItem(val)
  }

  function removeSession(val) {
    return sessionStorage.removeItem(val); //cleare single session variable
    // sessionStorage.clear(); // clear all sessi
  }

  setSession('user_city', 'surat');
  setSession('user_area', 'vesu');

  let username = getSession('user_area');
  console.log(username);
</script>

@endpush

@endsection