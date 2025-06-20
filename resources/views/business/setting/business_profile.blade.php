@extends('business.layouts.main')
@section('content')
@section('title', 'Business Profile')

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
        <h1 class="m-0">Business Profile</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Setting</a></li>
          <li class="breadcrumb-item active">Edit Business Profile</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="row">

    <div class="col-12">
      <div class="card card-info card-outline card-tabs">
        <div class="card-header p-0 pt-1 border-bottom-0">
          <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="custom-tabs-three-profiles-tab" data-toggle="pill" href="#custom-tabs-three-profiles" role="tab" aria-controls="custom-tabs-three-profiles" aria-selected="true"><i class="fas fa-store pr-1"></i>Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-three-seo-tab" data-toggle="pill" href="#custom-tabs-three-seo" role="tab" aria-controls="custom-tabs-three-seo" aria-selected="false"><i class="fas fa-search-location pr-1"></i>SEO</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-three-share-tab" data-toggle="pill" href="#custom-tabs-three-share" role="tab" aria-controls="custom-tabs-three-share" aria-selected="false"><i class="fas fa-share-square pr-1"></i>Share</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-three-setting-tab" data-toggle="pill" href="#custom-tabs-three-setting" role="tab" aria-controls="custom-tabs-three-setting" aria-selected="false"><i class="fas fa-cog pr-1"></i>Setting</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="custom-tabs-three-tabContent">
            <div class="tab-pane fade show active" id="custom-tabs-three-profiles" role="tabpanel" aria-labelledby="custom-tabs-three-profiles-tab">
              <form id="businessprofileform" action="{{ route('business.setting.business.update', $business->id) }}" data-action="none" class="row formaction">
                @csrf
                <input type="hidden" name="_method" value="post">
                <div class="col-md-12 row">
                  <div class="col-md-4 " style="justify-items: center;">
                    <div class="avtar">
                      <img src="{{ getImage($business->business_image) }}" class="avtar_img" />
                      <label for="profile" title="Change Image"><i class="far fa-edit"></i></label>
                    </div>
                    <input type="file" name="business_image" class="avtar_input" id="profile" accept="image/png, image/webp, image/jpeg" />
                  </div>

                  <div class="col-md-8 row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Business name <span class="error">*</span></label>
                        <input type="text" class="form-control" value="{{ $business->name }}" name="name" placeholder="Business name" />
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Contact <span class="error">*</span></label>
                        <input type="text" class="form-control" value="{{ $business->contact }}" name="contact" placeholder="Contact" />
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Business Type </label>
                        <input type="text" class="form-control" value="{{ $business->business_type }}" readonly />
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Business Category </label>
                        <input type="text" class="form-control" value="{{ isset($business->businessCategory) ? $business->businessCategory->name :'' }}" readonly />
                      </div>
                    </div>

                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label>Listing expiry date </label>
                    <input type="date" class="form-control" value="{{ $business->subscription_expiry_date }}" disabled />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label>Address <span class="error">*</span></label>
                    <input type="text" class="form-control" value="{{ $business->address }}" name="address" placeholder="Address" />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label>State <span class="error">*</span></label>
                    <select class="form-control" name="state_id" id="state_id">
                      <option value="">Select State</option>
                      @foreach ( getStates() as $state)
                      <option value="{{ $state->id }}" {{ $state->id == $business->state_id ?'selected':'' }}>{{ $state->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label>City <span class="error">*</span></label>
                    <select class="form-control" name="city_id" id="city_id">
                      <option value="">Select City</option>
                      @foreach ( getCities($business->state_id) as $city)
                      <option value="{{ $city->id }}" {{ $city->id == $business->city_id ?'selected':'' }}>{{ $city->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label>Area <span class="error">*</span></label>
                    <select class="form-control" name="area_id" id="area_id">
                      <option value="">Select Area</option>
                      @foreach ( getCitieArea($business->city_id) as $area)
                      <option value="{{ $area->id }}" {{ $area->id == $business->area_id ?'selected':'' }}>{{ $area->area_name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label>Pincode <span class="error">*</span></label>
                    <input type="text" class="form-control" value="{{ $business->pincode }}" name="pincode" placeholder="Pincode" />
                  </div>
                </div>



                <div class="col-sm-12 text-right">
                  <!-- <button class="btn btn-danger" type="button" onclick="history.back()">Back</button> -->
                  <button class="btn btn-primary btn_action" type="submit">
                    <span id="loader" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span id="buttonText">Update</span>
                  </button>

                </div>
              </form>
            </div>
            <div class="tab-pane fade" id="custom-tabs-three-seo" role="tabpanel" aria-labelledby="custom-tabs-three-seo-tab">

              <form action="{{ route('business.setting.seo.update', $business->id) }}" data-action="none" class="row formaction">
                @csrf
                <input type="hidden" name="_method" value="post">


                <div class="col-md-12">
                  <div class="form-group">
                    <label>Description <span class="error">*</span></label>
                    <input type="text" class="form-control" value="{{ $business->seo_description }}" name="seo_description" placeholder="Description" />
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label>Keyword <span class="error">*</span></label>
                    <input type="text" class="form-control" value="{{ $business->seo_keyword }}" name="seo_keyword" placeholder="Keyword" />
                  </div>
                </div>





                <div class="col-sm-12 text-right">
                  <!-- <button class="btn btn-danger" type="button" onclick="history.back()">Back</button> -->
                  <button class="btn btn-primary btn_action" type="submit">
                    <span id="loader" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span id="buttonText">Update</span>
                  </button>

                </div>
              </form>

            </div>
            <div class="tab-pane fade" id="custom-tabs-three-share" role="tabpanel" aria-labelledby="custom-tabs-three-share-tab">
              <div class="row">
                <div class="col-md-6 col-12">
                  <label>QR code</label><br>
                  <div class="text-center">
                    <img src="{{ $BusinessSticker }}" height="400" /></br>
                    <a href="{{ $BusinessSticker }}" class="btn btn-sm btn-outline-primary mt-3" download>Download QR</a>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Link</label>
                    <div class="input-group mb-3">
                      <input type="text" id="qrText" class="form-control" value="{{ route('business-details', $business->slug) }}">
                      <div class="input-group-append" id="copylink" data-url="{{ route('business-details', $business->slug) }}">
                        <span class="input-group-text">Copy</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            
            <div class="tab-pane fade" id="custom-tabs-three-setting" role="tabpanel" aria-labelledby="custom-tabs-three-setting-tab">
              
            <form action="{{ route('business.setting.systemsetting.update') }}" data-action="none" class="row formaction">
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

            <div class="col-md-2 text-center">
              <div class="form-group">
                <label>Booking confirmation </label><br>
                <input type="checkbox" name="is_need_booking_confirmetion" {{ $setting->is_need_booking_confirmetion ? 'checked':''}} data-bootstrap-switch data-off-color="danger" data-on-color="success">
              </div>
            </div>
            
            <div class="col-sm-12 text-right">
              <!-- <button class="btn btn-danger" type="button" onclick="history.back()">Back</button> -->
              <button class="btn btn-primary btn_action" type="submit">
                <span id="loader" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                <span id="buttonText">Update</span>
              </button>

            </div>
          </form>

            </div>

          </div>
        </div>
        <!-- /.card -->
      </div>
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
        $('#area_id').html('<option value="">Select Area</option>');
      },
      success: function(states) {
        $('#city_id').html('<option value="">Select City</option>');
        $.each(states, function(index, item) {
          $('#city_id').append('<option value="' + item.id + '">' + item.name + '</option>');
        });
      },
      error: function(xhr, status, error) {
        console.error("Error: " + error);
        $('#city_id').html('<option value="">Select City</option>');
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
        $('#area_id').html('<option value="">Select Area</option>');
        $.each(states, function(index, item) {
          $('#area_id').append('<option value="' + item.id + '">' + item.area_name + '</option>');
        });
      },
      error: function(xhr, status, error) {
        console.error("Error: " + error);
        $('#area_id').html('<option value="">Select Area</option>');
        alert("There was an error city change.");
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

<!-- for share section -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    $('#copylink').click(function() {
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val($(this).data('url')).select();
      document.execCommand("copy");
      $temp.remove();
      alert("Link copied to clipboard");
    });
  });
</script>


<!-- for setting -->
 <script src="{{ asset('admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script>
  
  $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })
</script>

@endpush
@endsection