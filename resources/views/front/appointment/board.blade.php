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
  .token-no {
    text-align: center;
    font-size: 120px;
    font-weight: 900;
  }
  .next p{
    font-size: 20px;
    font-weight: 900;
  }

  .next-list{
    border-bottom: 1px solid lightgray;
    font-size: 20px;
    padding: 11px 8px;
  }
</style>
@endpush

<section class="containerr">




  <div class="section mx-3 row">
    <div class="col-md-4 col-sm-4 col-12 my-sm-5 text-center">
      <p>For Advertisement</p>
    </div>
    <div class="col-md-4 col-sm-4 col-12 my-sm-5">
      <h1 class="text-center mb-0">Token No.</h1>
      <h1 class="token-no">01</h1>
      <h4 class="text-center">Ravindra gausvami</h4>
      <div class="next mt-5">
        <p>Next is : </p>
      </div>
      @php
        $time = 10;
      @endphp
      @for ($i=2; $i<=6;$i++)
      <div class="row next-list">
        <div class="col-2 border-right text-center">{{ $i }}</div>
        <div class="col-7 border-right">Ravindra gausvami</div>
        <div class="col-3">{{ $time*$i }} Min</div>
      </div>
      @endfor
      
    </div>
    <div class="col-md-4 col-sm-4 col-12 my-sm-5 text-center">
    <p>For Advertisement</p>
    </div>
  </div>


</section>


@push('js')
<script>

</script>
@endpush

@endsection