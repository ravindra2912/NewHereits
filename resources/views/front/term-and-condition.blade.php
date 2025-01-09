@extends('front.layouts.main', ['seo' => [
'title' => 'Term and condition | Hereits',
'description' => 'Term and condition',
'keywords' => 'Term and condition' ,
'image' => '' ,
'city' => '',
'state' => '',
'position' => ''
]
])
@section('content')
@section('title', 'Term and condition')

@push('style')

@endpush

<div id="content">
		<div class="bg-white mt-1 p-4">
			<h2 class="text-center my-2">Term and condition</h2>
				{!! $term->description !!}
		</div>
</div>

@endsection