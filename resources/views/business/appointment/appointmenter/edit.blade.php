@extends('business.layouts.main')
@section('content')
@section('title', 'Create Professionals')

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
        <h1 class="m-0">Create Professionals</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('business.appointment.appointmenter.index') }}">Professionals list</a></li>
          <li class="breadcrumb-item active">Create Professionals</li>
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
            Edit Professionals
          </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <form action="{{ route('business.appointment.appointmenter.update', $appointmenter->id) }}" data-action="redirect" class="row formaction">
            @csrf
            <input type="hidden" name="_method" value="PATCH">

            <div class="col-md-12 row">
              <div class="col-md-4 " style="justify-items: center;">
                <div class="avtar">
                  <img src="{{ getImage($appointmenter->appointmenter_image) }}" class="avtar_img" />
                  <label for="profile" title="Change Image"><i class="far fa-edit"></i></label>
                </div>
                <input type="file" name="appointmenter_image" class="avtar_input" id="profile" accept="image/png, image/webp, image/jpeg" />
              </div>
              <div class="col-md-8 row">
                @if ($businessSetting->is_appointment_with_department)
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Department <span class="error">*</span></label>
                    <select class="form-control" name="department_id">
                      <option value="">Select Department</option>
                      @foreach ( $departments as $department)
                      <option value="{{ $department->id }}" {{ $appointmenter->department_id == $department->id?'selected':'' }}>{{ $department->department_name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                @endif

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Name <span class="error">*</span></label>
                    <input type="text" class="form-control" value="{{ $appointmenter->appointmenter_name }}" name="appointmenter_name" placeholder="Appointmenter name" />
                  </div>
                </div>
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