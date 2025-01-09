@extends('front.layouts.main', ['seo' => [
'title' => 'Privacy Policy | Hereits',
'description' => 'Privacy Policy',
'keywords' => 'Privacy Policy' ,
'image' => '' ,
'city' => '',
'state' => '',
'position' => ''
]
])
@section('content')
@section('title', 'Privacy Policy')

@push('style')

@endpush

<div id="content">
		<div class="bg-white mt-1 p-4">
			<h2 class="text-center my-2">Privacy Policy</h2>
				{!! $privacy->description !!}
		</div>
</div>

@endsection