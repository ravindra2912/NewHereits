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
</style>


@endpush

<section>
  <div class="hero-banner white-content pb-0 hero-banner-auther">
    <div class="container">
      <div class="inner row justify-content-center">
        <div class="col-12 col-lg-3 col-md-4 mb-md-0 mb-4 auth-img-wrap">
          <img src="{{ getImage($expert->appointmenter_image) }}" alt="{{ $expert->appointmenter_name }}" title="{{ $expert->appointmenter_name }}" class="">
        </div>
        <div class="col-12 col-lg-8 col-md-7 auth-content-wrap">
          <div class="title-sub mb-md-4 mb-3">
            <h1 class="text-white">{{ $expert->appointmenter_name }}</h1>
          </div>
          <h5 class="pb-0 mb-0">Business Development Manager</h5>
          <p class="text-white mt-3">Jayveer Ker serves as the Business Development Manager at PSDtoHTMLNinja.com, specializing in assisting organizations with overcoming web development hurdles. His insightful and informative posts deliver practical solutions and valuable insights.</p>
        </div>
      </div>
    </div>
  </div>



  <div class="section mx-3 row">
    <div class="col-8 my-sm-5">
      <h2 class="text-9 text-center">Book your appointment</h2>
      <p class="lead text-center mb-5">Send a top-up experience people love to talk about</p>
      <div class="row g-4">
        <div class="col-md-12">
          <div class="testimonial h-100 bg-white rounded shadow-sm text-center p-4">
            <p class="text-3">“Easy to use, reasonably priced simply dummy text of the printing and typesetting industry. Quidam lisque persius interesset his et, in quot quidam possim iriure.”</p>
            <span class="text-warning"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span> <span class="d-block fw-500">Jay Shah from India</span>
          </div>
        </div>


      </div>
      <div class="text-center mt-5"><a href="#" class="btn-link text-4">See more people review<i class="fas fa-chevron-right text-2 ms-2"></i></a></div>
    </div>
    <div class="col-4 my-sm-5 text-center">
      <p>for advertisement</p>
    </div>
  </div>
</section>


@push('js')
<script>
  $(document).ready(function() {

  });
</script>
@endpush

@endsection