@extends('front.layouts.main')
@section('content')
@section('title', 'User Profile')

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

<div class="container mt-4 mb-4">
  <div class="row">
    <!-- this for user sidebar -->
    @include('front.account.sidebar')

    <div class="col-lg-9">
      <div class="bg-white shadow-md rounded p-4">
        <!-- Personal Information
          ============================================= -->
        <h4 class="mb-4">Personal Information</h4>
        <hr class="mx-n4 mb-4">

        <form id="loginForm" action="{{ route('account.userprofile.update', $user->id) }}" data-action="reload" class="formaction">
          @csrf
          <div class="row"> 

            <div class="col-md-12 " style="justify-items: center;">
              <div class="">
              <div class="avtar">
                <img src="{{ getImage($user->profile) }}" class="avtar_img" />
                
              </div>
              <label class="avtar-label" for="profile" title="Change Image">Change</label>
              </div>
              <input type="file" name="profile" class="avtar_input" id="profile" accept="image/png, image/webp, image/jpeg" />
            </div>

            <div class="form-group col-lg-6">
              <label for="frist_name">First Name</label>
              <input type="text" value="{{ $user->first_name }}" class="form-control" id="first_name" name="first_name" placeholder="First Name">
            </div>
            <div class="form-group col-lg-6">
              <label for="last_name">Last Name</label>
              <input type="text" value="{{ $user->last_name }}" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
            </div>
            <div class="form-group col-lg-6">
              <label for="contact">Mobile Number</label>
              <input type="text" value="{{ $user->contact }}" class="form-control" id="contact" name="contact" placeholder="Mobile Number">
            </div>
            <div class="form-group col-lg-6">
              <label for="email">Email ID</label>
              <input type="text" value="{{ $user->email }}" class="form-control" id="email" name="email" placeholder="Email ID">
            </div>
            <div class="form-group col-lg-6">
              <label for="email">DOB</label>
              <input type="date" value="{{ $user->dob }}" class="form-control" id="dob" name="dob" placeholder="DOB">
            </div>

            <div class="form-group col-lg-6">
              <label for="email">Gender</label>
              <select class="form-control" name="gender">
                <option value="">Select Gender</option>
                @foreach ( config('const.gender') as $gender)
                <option value="{{ $gender }}" {{ $gender == $user->gender ? 'selected':'' }}>{{ $gender }}</option>
                @endforeach
              </select>
            </div>

          </div>

          <button class="btn btn-primary btn_action" type="submit">
            <span id="buttonText">Update</span>
            <span id="loader" class="d-none">Updating ...</span>
          </button>
          <a class="btn btn-danger" href="{{ route('account.changePassword') }}">Reset Password</a>
        </form>

      </div>
    </div>
  </div>
</div>

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