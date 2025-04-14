@extends('front.layouts.main')
@section('content')
@section('title', 'Home')

@push('style')
<style>
  .list-business-btn {
    background-color: #dc3545;
  }
</style>
@endpush


<div class="hero-wrap" style="background: linear-gradient(to right, #3f36b9 0%,#20206b 100%);">
  <div class="opacity-9 bg-white"></div>
  <div class="hero-content banner-taxt-container">
    <div class="container">
      <h2 class="text-7 text-center font-weight-600 mb-2" style="color: white;">BOOK SMART, SAVE TIME, SIMPLIFY LIFE</h2>
      <p class="text-5 text-center mb-4" style="color: white;">Book In Advance and No Longer Waiting in Que At your Favorite Restaurant, salon or Hospital.</p>
      <div class="text-center mb-4 mobile-hide">
        <span class="redirect-btn mr-2"><a href="{{ route('business') }}" title="Stores"> <i class="fas fa-store-alt"></i> Stores </a></span>
        <!-- <span class="redirect-btn mr-2"><a href="Product"><i class="fab fa-dropbox"></i> Products </a></span> -->
        <!-- <span class="redirect-btn mr-2"><a href="Services"><i class="fas fa-list-ul"></i> Services </a></span> -->
      </div>

    </div>
  </div>
</div>



@if ($businesses && count($businesses) <= 0)
  <section class="section py-2 bg-white ">
  <div class="container d-flex justify-content-center align-items-center" style="height: 300px;">
    <h1 class=""> We are coming soon. </h1>
  </div>
  </section>
  @else



  <!-- Categories -->
  @if ($businessCategory)
  <section class="section bg-white pt-3 pb-2">
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

  @if ($businesses && count($businesses) > 0)
  <section class="section py-2 bg-white">
    <div class="container ">
      <div class="d-flex justify-content-between align-items-center">
        <h2 id="reviews" class="text-6 mb-3">Businesses</h2>
        <a href="{{ route('business') }}" class="view-more" title="view-more">View More -></a>
      </div>

      <div class="row ">
        @foreach($businesses as $res)
        <a href="{{ route('business-details', $res->slug) }}" title="{{ $res->name }}" class="col-lg-2 col-md-3 col-sm-4 col-6 p-1">
          <div class="card shadow-md border-0 mb-2">
            
            <div class="pt-2 pl-2 pr-2"><img src="{{ getImage($res->business_image) }}" class="card-img-top d-block store-img pb-2" alt="{{ $res->name }}"></div>
            <h5 class="store-name text-3 mb-2 text-center text-black-500" style="padding: 2px 10px 2px 10px;">{{ $res->name }}</h5>
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </section>
  @endif


  @if ($fevoriteBusinesses)
  <section class="section  py-2 bg-white">
    <div class="container ">
      <div class="d-flex justify-content-between align-items-center">
        <h2 id="reviews" class="text-6 mb-3">Favourite Businesses</h2>
        <a href="{{ route('business') }}" class="view-more" title="view-more">View More -></a>
      </div>

      <div class="row ">
        @foreach($fevoriteBusinesses as $res)
        <a href="{{ route('business-details', $res->business->slug) }}" title="{{ $res->business->name }}" class="col-md-2 col-6 p-1">
          <div class="card shadow-md border-0 mb-2">
            <h5 class="store-name text-3 mb-0 text-black-500" style="padding: 2px 10px 2px 10px;">{{ $res->business->name }}</h5>
            <div class="pt-2 pl-2 pr-2"><img src="{{ getImage($res->business->business_image) }}" class="card-img-top d-block store-img pb-2" alt="{{ $res->business->name }}"></div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </section>


  @endif
  @endif
  <section class="section  py-2 bg-white">
    <div class="container mt-3">
      <div class="row  flex-column-reverse flex-md-row  rounded p-3" style="background-image: url({{ asset('front/img/cta-bg-3.webp') }});">
        <div class="col-lg-7 col-md-7 col-sm-7 col-12 text-md-left text-center ">
          <h1 class="h2 mb-0 text-white mb-2">List Your Business</h1>
          <p class="text-3 text-white" style="line-height: 1.25;">Join our platform today and boost your business visibility. Reach more customers, increase your sales, and grow your brand with us. Simple, effective, and made for success! </p>
          <div class="text-md-left text-center">
          <button class="btn btn-outline-danger btn-sm list-business-btn"><a href="{{ route('register.business') }}" class="text-white">Register your business</a></button>
          </div>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-12 d-flex text-center justify-content-center align-items-center mb-md-0 mb-2">
            <img src="{{ asset('front/img/store.webp') }}" height="150"  alt="List Your Business">
        </div>
      </div>
    </div>
  </section>
  @endsection