@extends('business.layouts.main')
@section('content')
@section('title', 'Appointment Page')

@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/dist/css/jquery.dataTables.css') }}" />
<style>
  .filter input,
  .filter select {
    width: max-content;
    margin-right: 5px;
  }
</style>
@endpush


<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Appointment list</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Appointment list</li>
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
            <h3 class="card-title">Appointment list</h3>
            <div class="float-right">
              <a href="{{ route('business.appointment.bookings.create') }}" class="btn btn-primary" title="Add"><i class="fas fa-plus"></i></a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive">
            <div class="row filter mb-3">
              <input type="hidden" value="{{ $businessSetting->is_appointment_with_department }}" id="is_appointment_with_department">
              <input type="hidden" value="{{ $businessSetting->is_appointment_book_with_time_slote }}" id="is_appointment_book_with_time_slote">

              <input type="date" class="form-control" id="filterdate" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
              @if ($businessSetting->is_appointment_with_department)
              <select class="form-control" id="department_id">
                <option value="">Select Department</option>
                @foreach ( $departments as $department)
                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                @endforeach
              </select>
              @endif

              <select class="form-control" id="appointmenter_id">
                <option value="">Select Appointmenter</option>
                @foreach ( $appontmenters as $appontmenter)
                <option value="{{ $appontmenter->id }}">{{ $appontmenter->appointmenter_name }}</option>
                @endforeach
              </select>

              <select class="form-control" id="status">
                <option value="">Status</option>
                @foreach ( config('const.appointment_status') as $status )
                <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                @endforeach
              </select>
            </div>

            <table class="table table-hover text-nowrap" id="data-table">
              <thead>
                <tr>
                  <th>Token Number</th>
                  <th>department</th>
                  <th>Appontmenter</th>
                  <th>User name</th>
                  <th>User Contact</th>
                  <th>Booking date</th>
                  <th>Start Time</th>
                  <th>End Time</th>
                  <th>status</th>
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
      // ajax: "{{ route('business.appointment.bookings.index') }}",
      ajax: {
        url: "{{ route('business.appointment.bookings.index') }}",
        data: function(d) {
          d.date = $('#filterdate').val();
          d.department_id = $('#department_id').val();
          d.appointmenter_id = $('#appointmenter_id').val();
          d.status = $('#status').val();
        }
      },
      columns: [{
          data: 'token_number',
          name: 'token_number'
        }, {
          data: 'department',
          name: 'department.department_name',
          visible: $('#is_appointment_with_department').val() == 1 ? true : false
        }, {
          data: 'appontmenter.appointmenter_name',
          name: 'appontmenter.appointmenter_name'
        }, {
          data: 'user_name',
          name: 'user_name'
        },
        {
          data: 'user_contact',
          name: 'user_contact'
        },
        {
          data: 'booking_date',
          name: 'booking_date'
        }, {
          data: 'start_time',
          name: 'slot_start_time',
          searchable: false,
          visible: $('#is_appointment_book_with_time_slote').val() == 1 ? true : false
        }, {
          data: 'end_time',
          name: 'slot_end_time',
          searchable: false,
          visible: $('#is_appointment_book_with_time_slote').val() == 1 ? true : false
        },{
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

    $('#filterdate, #department_id, #appointmenter_id, #status').on('change', function() {
      table.ajax.reload()
    })
  });

  // get appoinmenters on deparment id
  $('#department_id').on('change', function(event) {
    $.ajax({
      type: "POST",
      url: "{{ route('business.appointment.bookings.get.appointmrnter') }}",
      data: {
        department_id: $(this).val()
      },
      dataType: "json",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      beforeSend: function() {
        $('#appointmenter_id').html('<option value="">Loading ...</option>');
        $('#timeslote').html('<option value="">Select Timing</option>');
      },
      success: function(states) {
        $('#appointmenter_id').html('<option value="">Select Appointmenter</option>');
        $.each(states, function(index, item) {
          $('#appointmenter_id').append('<option value="' + item.id + '">' + item.appointmenter_name + '</option>');
        });
      },
      error: function(xhr, status, error) {
        console.error("Error: " + error);
        $('#appointmenter_id').html('<option value="">Select Appointmenter</option>');
        alert("There was an error on department change.");
      }
    });
  });

  // delete user
  function destroy(url, id) {
    Swal.fire({
        title: 'Are you sure?',
        icon: 'error',
        html: "You want to delete this user?",
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
              $('.btn_action-' + id + ' #buttonText').removeClass('d-none');
              $('.btn_action-' + id + ' #loader').addClass('d-none');
              $('.btn_action-' + id).prop('disabled', false);
            },
            error: function(e) {
              toastr.error('Somthing Wrong');
              console.log(e);
              $('.btn_action-' + id + ' #buttonText').removeClass('d-none');
              $('.btn_action-' + id + ' #loader').addClass('d-none');
              $('.btn_action-' + id).prop('disabled', false);
            }
          });
        }
      })
  }
</script>
@endpush
@endsection