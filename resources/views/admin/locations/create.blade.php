@extends('admin.layouts.main')
@section('content')
@section('title', 'Cteate Area')

@push('style')

@endpush

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Create Area</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.locations.areas') }}">Area list</a></li>
          <li class="breadcrumb-item active">Create Area</li>
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
            Create Area
          </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <form action="{{ route('admin.locations.areas.store') }}" data-action="redirect" class="row formaction">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <div class="col-md-6">
              <div class="form-group">
                <label>City name <span class="error">*</span></label>
                <select class="form-control" name="city_id">
                  <option value="">Select city</option>
                  @foreach ($cities as $city)
                  <option value="{{ $city->id }}">{{ $city->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Area name <span class="error">*</span></label>
                <input type="text" class="form-control" name="area_name" placeholder="Area name" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Pincode <span class="error">*</span></label>
                <input type="number" class="form-control" name="pincode" placeholder="pincode" />
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Status <span class="error">*</span></label>
                <select class="form-control" name="status">
                  <option value="">Select status</option>
                  @foreach ( config('const.common_status') as $status)
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

@endsection