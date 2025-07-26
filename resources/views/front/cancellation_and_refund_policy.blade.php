@extends('front.layouts.main', ['seo' => [
'title' => 'Cancellation & refund policy | Hereits',
'description' => 'Cancellation & refund policy',
'keywords' => 'Cancellation & refund policy' ,
'image' => '' ,
'city' => '',
'state' => '',
'position' => ''
]
])
@section('content')
@section('title', 'Copy right')

@push('style')

@endpush

<div id="content">
	<div class="bg-white mt-1 p-4">
		<h2 class="text-center my-2">Cancellation & refund policy</h2>
		{!! $data->description !!}
	</div>
</div>

@endsection