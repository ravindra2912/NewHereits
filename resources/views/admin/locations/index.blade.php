@extends('admin.layouts.main')
@section('content')
@section('title', 'Area Page')

@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/dist/css/jquery.dataTables.css') }}" />
@endpush


<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Area list</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Area list</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Area list</h3>
            <div class="float-right">
              <a href="{{ route('admin.locations.areas.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add</a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive">

            <table class="table table-hover text-nowrap w-100" id="data-table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>City</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>

  </div>
</section>
<!-- /.content -->



@push('js')
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
  $(function() {
    var table = $('#data-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('admin.locations.areas') }}",
      columns: [{
          data: 'area_name',
          name: 'area_name'
        }, {
          data: 'city.name',
          name: 'city.name'
        },
        {
          data: 'status',
          name: 'status'
        },
        {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable: false
        },
      ]
    });
  });
</script>
@endpush
@endsection