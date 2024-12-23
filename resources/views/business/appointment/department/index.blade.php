@extends('business.layouts.main')
@section('content')
@section('title', 'Department Page')

@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/dist/css/jquery.dataTables.css') }}" />
<style>

.filter input{
  width: max-content;
}

</style>
@endpush


<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Department list</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Department list</li>
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
            <h3 class="card-title">Department list</h3>
            <div class="float-right">
              <a href="{{ route('business.appointment.department.create') }}" class="btn btn-primary" title="Add"><i class="fas fa-plus"></i></a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive">
            <div class="row filter">
            <!-- <input type="date" class="form-control"  id="filterdate" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" > -->
            </div>
          
            <table class="table table-hover text-nowrap" id="data-table">
              <thead>
                <tr>
                  <th>Department Name</th>
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
      ajax: "{{ route('business.appointment.department.index') }}",
      columns: [{
          data: 'department_name',
          name: 'department_name'
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


  // delete user
  function destroy(url, id) {
    Swal.fire({
        title: 'Are you sure?',
        icon: 'error',
        html: "You want to delete this department?",
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
      })
      .then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: url,
            type: "POST",
            data: {
              '_method': 'DELETE'
            },
            dataType: "json",
            headers: {
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            beforeSend: function() {
              $('.btn_delete-' + id + ' #buttonText').addClass('d-none');
              $('.btn_delete-' + id + ' #loader').removeClass('d-none');
              $('.btn_delete-' + id).prop('disabled', true);
            },
            success: function(result) {
              if (result.success) {
                toastr.success(result.message);
                location.reload()
              } else {
                toastr.error(result.message);
              }
              $('.btn_delete-' + id + ' #buttonText').removeClass('d-none');
              $('.btn_delete-' + id + ' #loader').addClass('d-none');
              $('.btn_delete-' + id).prop('disabled', false);
            },
            error: function(e) {
              toastr.error('Somthing Wrong');
              console.log(e);
              $('.btn_delete-' + id + ' #buttonText').removeClass('d-none');
              $('.btn_delete-' + id + ' #loader').addClass('d-none');
              $('.btn_delete-' + id).prop('disabled', false);
            }
          });
        }
      })
  }
</script>
@endpush
@endsection