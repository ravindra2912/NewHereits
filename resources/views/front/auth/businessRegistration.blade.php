@extends('front.layouts.main', ['seo' => [
'title' => 'Register your business | Hereits',
'description' => 'Register your business with Hereits and get more customers',
'keywords' => 'register, business, hereits',
'image' => '' ,
'city' => '',
'state' => '',
'position' => ''
]
])
@section('content')
@section('title', 'Register your business')

@push('style')
<style>
    .avtar_img {
        height: 160px;
        width: 160px;
        object-fit: contain;
        border-radius: 20px;
    }

    .avtar {
        border: 1px solid #ced4da;
        border-radius: 10px 10px 0px 0px;
        width: fit-content;
        padding: 10px;
        text-align: center;
    }

    .avtar-label {
        background: #0071cc;
        color: white;
        padding: 0px 3px 1px 5px;
        border-radius: 0px 0px 10px 10px;
        width: 100%;
        text-align: center;
    }

    .avtar_input {
        opacity: 0;
        height: 0px;
    }
</style>
@endpush

<section>

    <div class="container mt-3">
        <div class="bg-white shadow-md rounded p-4">
            <h4 class="mb-4">Fill your business Information</h4>
            <hr class="mx-n4 mb-4">

            <form id="loginForm" action="{{ route('register.business.store') }}" data-action="reload" class="formaction">
                @csrf
                <div class="row">

                    <div class="col-md-12 " style="justify-items: center;">
                        <div class="">
                            <div class="avtar">
                                <img src="{{ getImage('') }}" class="avtar_img" />

                            </div>
                            <label class="avtar-label" for="profile" title="Change Image">choose business image</label>
                        </div>
                        <input type="file" name="business_image" class="avtar_input" id="profile" accept="image/png, image/webp, image/jpeg" />
                    </div>

                    @if(!Auth::check())
                    <div class="form-group col-lg-6">
                        <label for="business_name">Your registered email</label>
                        <input type="email" class="form-control" id="email" name="user_email" required placeholder="Email">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="business_name">Your password</label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Password">
                    </div>
                    @endif
                    <div class="form-group col-lg-6">
                        <label for="business_name">Business name</label>
                        <input type="text" class="form-control" id="business_name" name="business_name" placeholder="First Name">
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="contact">Contact</label>
                        <input type="text" class="form-control" id="business_contact" name="business_contact" placeholder="Mobile Number">
                    </div>

                    <div class="form-group col-lg-6">
                        <div class="form-group">
                            <label>Business Category <span class="error">*</span></label>
                            <select class="form-control" name="business_category_id">
                                <option value="">Select Business Category</option>
                                @foreach ( $businessCat as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Address">
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>State <span class="error">*</span></label>
                            <select class="form-control" name="state_id" id="state_id">
                                <option value="">Select State</option>
                                @foreach ( getStates() as $state)
                                <option value="{{ $state->id }}" {{ $state->id == 12?'selected':'' }}>{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>City <span class="error">*</span></label>
                            <select class="form-control" name="city_id" id="city_id">
                                <option value="">Select City</option>
                                @foreach ( getCities(12) as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Area <span class="error">*</span></label>
                            <select class="form-control" name="area_id" id="area_id">
                                <option value="">Select Area</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Pincode <span class="error">*</span></label>
                            <input type="text" class="form-control" name="pincode" placeholder="Pincode" />
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary btn_action" type="submit">
                    <span id="buttonText">Submit</span>
                    <span id="loader" class="d-none">Submiting ...</span>
                </button>
            </form>
        </div>
    </div>
</section>


@push('js')
<script>
    $('#state_id').on('change', function(event) {
        $.ajax({
            type: "POST",
            url: "{{ route('admin.getCities') }}",
            data: {
                state_id: $(this).val()
            },
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('#city_id').html('<option value="">Loading ...</option>');
            },
            success: function(states) {
                $('#city_id').html('<option value="">Select CitY</option>');
                $.each(states, function(index, item) {
                    $('#city_id').append('<option value="' + item.id + '">' + item.name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
                $('#city_id').html('<option value="">Select CitY</option>');
                alert("There was an error state chnage.");
            }
        });
    });

    $('#city_id').on('change', function(event) {
        $.ajax({
            type: "POST",
            url: "{{ route('admin.getCitieArea') }}",
            data: {
                city_id: $(this).val()
            },
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('#area_id').html('<option value="">Loading ...</option>');
            },
            success: function(states) {
                $('#area_id').html('<option value="">Select area</option>');
                $.each(states, function(index, item) {
                    $('#area_id').append('<option value="' + item.id + '">' + item.area_name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
                $('#area_id').html('<option value="">Select area</option>');
                alert("There was an error state chnage.");
            }
        });
    });

    $('.avtar_input').on('change', function(event) {
        var input = event.target;
        var image = $('.avtar_img');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                image.attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    })
</script>
@endpush

@endsection