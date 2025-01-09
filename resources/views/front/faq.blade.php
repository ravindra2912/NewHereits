@extends('front.layouts.main', ['seo' => [
'title' => 'Frequently Asked Questions | Hereits',
'description' => 'Frequently Asked Questions',
'keywords' => 'Frequently Asked Questions' ,
'image' => '' ,
'city' => '',
'state' => '',
'position' => ''
]
])
@section('content')
@section('title', 'Frequently Asked Questions')

@push('style')

@endpush

<div id="content">
	<div class="container mt-5 mb-5">
		<div class="bg-white shadow-md rounded p-4">
			<h2 class="text-center my-5">Frequently Asked Questions</h2>
			@foreach ($faqs as $key => $value)
			<div class="row mb-3">
				<div class="col-md-12">
					<h4 class="mb-4">{{ $key }}</h4>
					<div class="accordion" id="accordionDefault">
						@foreach ($value as $faq)
						<div class="card">
							<h6 class="mb-0">{{ $faq->question }}</h6>
							<p class="card-body">{{ $faq->answer }} </p>
						</div>
						@endforeach
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
@endsection