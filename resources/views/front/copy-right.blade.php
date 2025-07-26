@extends('front.layouts.main', ['seo' => [
'title' => 'Copy right | Hereits',
'description' => 'Copy right',
'keywords' => 'Copy right' ,
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
			<h2 class="text-center my-2">Copy right policy</h2>
				{!! $CopyRight->description !!}
		</div>
</div>

@endsection