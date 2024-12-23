@extends('business.layouts.main')
@section('content')
@section('title', 'Edit User')

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
        <h1 class="m-0">Profile</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Setting</a></li>
          <li class="breadcrumb-item active">Profile</li>
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
            Profile
          </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <form action="{{ route('business.setting.profile.update', $user->id) }}" data-action="reload" class="row formaction">
            @csrf
            <input type="hidden" name="_method" value="post">
            <div class="col-md-12 row">
              <div class="col-md-4 " style="justify-items: center;">
                <div class="avtar">
                  <img src="{{ getImage($user->profile) }}" class="avtar_img" />
                  <label for="profile" title="Change Image"><i class="far fa-edit"></i></label>
                </div>
                <input type="file" name="profile" class="avtar_input" id="profile" accept="image/png, image/webp, image/jpeg" />
              </div>

              <div class="col-md-8 row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>First name <span class="error">*</span></label>
                    <input type="text" class="form-control" value="{{ $user->first_name }}" name="first_name" placeholder="First name" />
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Last name <span class="error">*</span></label>
                    <input type="text" class="form-control" value="{{ $user->last_name }}" name="last_name" placeholder="Last name" />
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Email <span class="error">*</span></label>
                    <input type="text" class="form-control" value="{{ $user->email }}" name="email" placeholder="Email" />
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Contact <span class="error">*</span></label>
                    <input type="text" class="form-control" value="{{ $user->contact }}" name="contact" placeholder="Contact" />
                  </div>
                </div>
              </div>
            </div>


            <div class="col-md-4">
              <div class="form-group">
                <label>DOB </label>
                <input type="date" class="form-control" value="{{ $user->dob }}" name="dob" placeholder="DOB" />
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Gender </label>
                <select class="form-control" name="gender">
                  <option value="">Select gender</option>
                  @foreach ( config('const.gender') as $gender)
                  <option value="{{ $gender }}" {{ $gender == $user->gender ? 'selected':'' }}>{{ $gender }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control"  name="password" placeholder="Password" autocomplete="FALSE" />
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