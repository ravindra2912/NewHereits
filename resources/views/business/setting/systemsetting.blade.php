@extends('business.layouts.main')
@section('content')
@section('title', 'System Setting')

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
        <h1 class="m-0">System Setting</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Setting</a></li>
          <li class="breadcrumb-item active">System Setting</li>
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
          System Setting
          </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <form action="{{ route('business.setting.systemsetting.update') }}" data-action="reload" class="row formaction">
            @csrf
            <input type="hidden" name="_method" value="post">
            

            @if ($setting->is_appointment_system)
            <div class="col-md-2 text-center">
              <div class="form-group">
                <label>Departments </label><br>
                <input type="checkbox" name="is_appointment_with_department" {{ $setting->is_appointment_with_department ? 'checked':''}} data-bootstrap-switch data-off-color="danger" data-on-color="success">
              </div>
            </div>
            
            <div class="col-md-2 text-center">
              <div class="form-group">
                <label>Time Slote Booking </label><br>
                <input type="checkbox" name="is_appointment_book_with_time_slote" {{ $setting->is_appointment_book_with_time_slote ? 'checked':''}}  data-bootstrap-switch data-off-color="danger" data-on-color="success">
              </div>
            </div>
            @endif
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
<script src="{{ asset('admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script>
  
  $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })
</script>

@endpush
@endsection