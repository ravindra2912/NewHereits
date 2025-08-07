@extends('business.layouts.main')
@section('content')
@section('title', 'Users Page')

@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/dist/css/jquery.dataTables.css') }}" />
@endpush


<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Users list</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Users list</li>
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
            <h3 class="card-title">Users list</h3>


          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive">

            <table class="table table-hover text-nowrap" id="data-table">
              <thead>
                <tr>
                  <th></th>
                  <th>First name</th>
                  <th>Last name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Complete</br> Appointments</th>
                  <th>Un-Complete</br> Appointments</th>
                  <th>Convert Rate(%)</th>
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
<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
  $(function() {
    var table = $('#data-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('business.appointment.appointment-user.index') }}",
      columns: [{
          data: 'img',
          name: 'img',
          orderable: false,
          searchable: false
        },
        {
          data: 'first_name',
          name: 'first_name'
        },
        {
          data: 'last_name',
          name: 'last_name'
        },
        {
          data: 'email',
          name: 'email'
        },
        {
          data: 'contact',
          name: 'contact',
          orderable: false,
        },
         {
          data: 'completed_appointments',
          name: 'completed_appointments',
          searchable: false,
        },
        {
          data: 'uncompleted_appointments',
          name: 'uncompleted_appointments',
          searchable: false,
        },
        {
          data: 'convertRate',
          name: 'convertRate',
          searchable: false,
        },
        {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable: false,
          visible:false
        },
      ]
    });
  });

  function getUserDetails(user_id){
    alert(user_id);
  }
</script>
@endpush
@endsection