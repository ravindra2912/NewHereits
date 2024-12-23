@extends('admin.layouts.main')
@section('content')
@section('title', 'Create Business')

@push('style')
<!-- summernote -->
<style>
  .avtar_img {
    height: 160px;
    width: 160px;
    object-fit: contain;
    border-radius: 20px;
  }

  .avtar {
    border: 1px solid #ced4da;
    border-radius: 10px;
    width: fit-content;
    padding: 10px;
    text-align: center;
  }

  .avtar label {
    position: absolute;
    top: 3px;
    right: 29%;
    background: gray;
    color: white;
    padding: 0px 3px 1px 5px;
    border-radius: 100%;
  }

  .avtar_input {
    opacity: 0;
    height: 0px;
  }
</style>
@endpush

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Create Business</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.business.index') }}">Business list</a></li>
          <li class="breadcrumb-item active">Create Business</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-outline card-info">
        <div class="card-header">
          <h3 class="card-title">
            Creat Business
          </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <form action="{{ route('admin.business.store') }}" data-action="redirect" class="row formaction">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <div class="col-md-12 row">
              <div class="col-md-4 " style="justify-items: center;">
                <div class="avtar">
                  <img src="{{ getImage('') }}" class="avtar_img" />
                  <label for="profile" title="Change Image"><i class="far fa-edit"></i></label>
                </div>
                <input type="file" name="business_image" class="avtar_input" id="profile" accept="image/png, image/webp, image/jpeg" />
              </div>

              <div class="col-md-8 row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Owner ID <span class="error">*</span></label>
                    <input type="text" class="form-control" name="owner_id" placeholder="owner Id" />
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Business name <span class="error">*</span></label>
                    <input type="text" class="form-control" name="name" placeholder="Business name" />
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Address <span class="error">*</span></label>
                    <input type="text" class="form-control" name="address" placeholder="Address" />
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Contact <span class="error">*</span></label>
                    <input type="text" class="form-control" name="contact" placeholder="Contact" />
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4">
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
                <label>Business Type <span class="error">*</span></label>
                <select class="form-control" name="business_type">
                  <option value="">Select Business Type</option>
                  @foreach ( config('const.business_type') as $type)
                  <option value="{{ $type }}">{{ $type }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Status <span class="error">*</span></label>
                <select class="form-control" name="status">
                  <option value="">Select status</option>
                  @foreach ( config('const.business_status') as $status)
                  <option value="{{ $status }}">{{ $status }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-sm-12 text-right">
              <button class="btn btn-danger" type="button" onclick="history.back()">Back</button>
              <button class="btn btn-primary btn_action" type="submit">
                <span id="loader" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                <span id="buttonText">Submit</span>
              </button>

            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.col-->
  </div>
</section>
<!-- /.content -->

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