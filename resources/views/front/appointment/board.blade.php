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

  .next p {
    font-size: 20px;
    font-weight: 900;
  }

  .next-list {
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
      @if ($timing['status'] == 'open')
      @if ($appointmentFirst)
      <h1 class="text-center mb-0">Token No.</h1>
      <h1 class="token-no">{{ $appointmentFirst->token_number }}</h1>
      <h4 class="text-center">{{ $appointmentFirst->user_name }}</h4>
      <div class="next mt-5">
        <p>Next is : </p>
      </div>
      @else
      <h1 class="text-success text-center">Available</h1>
      <p class="text-center">Waiting for new appointment</p>
      @endif
      @elseif($timing['status'] == 'close')
      <h1 class="text-center">Closed</h1>
      @elseif($timing['status'] == 'break')
      <h1 class="text-center">Break</h1>
      <p class="text-center">Open at :- {{ get_time($timing['data']->start_time) }}</p>
      @endif

      @foreach ($appointmentList as $index => $list)
      <div class="row next-list">
        <div class="col-2 border-right text-center">{{ $list->token_number }}</div>
        <div class="col-7 border-right">{{ $list->user_name }}</div>
        <div class="col-3">{{ $expert->timing_per_appointment*($index+1) }} Min</div>
      </div>
      @endforeach

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