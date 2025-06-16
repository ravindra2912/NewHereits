@extends('front.layouts.main', ['seo' => [
'title' => 'Reset password | Hereits',
'description' => 'Reset password',
'keywords' => 'Reset, password, hereits',
'image' => '' ,
'city' => '',
'state' => '',
'position' => ''
]
])
@section('content')
@section('title', 'Reset password')

@push('style')

<section>

    <div class="container mt-3">
        <div class="bg-white shadow-md rounded p-4">
            <h4 class="mb-4">Reset password</h4>
            <hr class="mx-n4 mb-4">


            <form id="loginForm" action="{{ route('password.reset.update') }}" data-action="redirect" class="formaction">
                @csrf
                <input type="hidden" name="email" value="{{$email}}" />
                <input type="hidden" name="token" value="{{$token}}" />
                <div class="form-group">
                    <label>Password</label>
                    <input type="text" class="form-control" name="password" placeholder="Password">
                </div>

                <div class="form-group">
                    <label>Confirm password</label>
                    <input type="text" class="form-control" name="confirm_password" placeholder="Confirm password">
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