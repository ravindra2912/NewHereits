@extends('front.layouts.main')
@section('content')
@section('title', 'User Profile')

@push('style')

@endpush

<div class="container mt-4 mb-4">
  <div class="row">
    <!-- this for user sidebar -->
    @include('front.account.sidebar')

    <div class="col-lg-9">
      <div class="bg-white shadow-md rounded p-4">
        <!-- Personal Information
          ============================================= -->
        <h4 class="mb-4">Reset Password</h4>
        <hr class="mx-n4 mb-4">

        <form id="loginForm" action="{{ route('account.changePassword.update') }}" data-action="reload" class="formaction">
          @csrf
          <div class="row">
            <div class="form-group col-lg-6">
              <label for="old_password">Old Password</label>
              <input type="password" class="form-control" id="old_password" name="old_password" required="" placeholder="Old Password">
            </div>

            <div class="form-group col-lg-6">
              <label for="password">New Password</label>
              <input type="password" class="form-control" id="password" name="password" required="" placeholder="New Password">
            </div>

            <div class="form-group col-lg-6">
              <label for="confirm_password">Conform Password</label>
              <input type="password" class="form-control" id="confirm_password" name="confirm_password" required="" placeholder="Conform Password">
            </div>
          </div>

          <button class="btn btn-primary btn_action" type="submit">
            <span id="buttonText">Reset Password</span>
            <span id="loader" class="d-none">Reseting ...</span>
          </button>
        </form>

      </div>
    </div>
  </div>
</div>

@push('js')

<script>
  
</script>

@endpush

@endsection