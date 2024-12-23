@extends('business.layouts.main')
@section('content')
@section('title', 'Edit Appointment')

@push('style')
<!-- summernote -->

@endpush

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit Appointment</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('business.appointment.bookings.index') }}">Appointment list</a></li>
          <li class="breadcrumb-item active">Edit Appointment</li>
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
            Edit Appointment
          </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <input type="hidden" value="{{ $businessSetting->is_appointment_book_with_time_slote }}" id="with-timing">
          <form action="{{ route('business.appointment.bookings.update', $appontment->id) }}" data-action="redirect" class="row formaction">
            @csrf
            <input type="hidden" id="appoinment_id" value="{{ $appontment->id }}">
            <input type="hidden" name="_method" value="PATCH">

            <div class="col-md-6">
              <div class="form-group">
                <label>Token Number <span class="error">*</span></label>
                <input type="text" class="form-control" value="{{ $appontment->token_number }}" name="token_number" placeholder="Token Number" readonly />
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Booking Date <span class="error">*</span></label>
                <input type="date" class="form-control" value="{{ $appontment->booking_date }}" name="booking_date" id="booking_date" placeholder="Date" />
              </div>
            </div>

            @if ($businessSetting->is_appointment_with_department)
            <div class="col-md-6">
              <div class="form-group">
                <label>Department <span class="error">*</span></label>
                <select class="form-control" name="department_id" id="department_id">
                  <option value="">Select Department</option>
                  @foreach ( $departments as $department)
                  <option value="{{ $department->id }}" {{ $appontment->department_id ==  $department->id ? 'selected':''}}>{{ $department->department_name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            @endif

            <div class="col-md-6">
              <div class="form-group">
                <label>Appointmenter <span class="error">*</span></label>
                <select class="form-control" name="appointmenter_id" id="appointmenter_id">
                  <option value="">Select Appointmenter</option>
                  @foreach ( $appontmenters as $appontmenter)
                  <option value="{{ $appontmenter->id }}" {{ $appontment->appointmenter_id ==  $appontmenter->id ? 'selected':''}}>{{ $appontmenter->appointmenter_name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            @if ($businessSetting->is_appointment_book_with_time_slote)
            <div class="col-md-6">
              <div class="form-group">
                <label>Timing <span class="error">*</span></label>
                <select class="form-control" name="timeslote" id="timeslote">
                  <option value="">Select Timing</option>
                  @foreach ($timeSlots as $time)
                  <option value="{{ $time['time'] }}" {{ $appontment->bookdate == $time['time'] ? 'selected' : ' ' }} {{ $time['is_booked']?'disabled':'' }}>{{ $time['time'] }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            @endif

            <div class="col-md-6">
              <div class="form-group">
                <label>User name <span class="error">*</span></label>
                <input type="text" class="form-control" value="{{ $appontment->user_name }}" name="user_name" placeholder="User name" />
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>User Contact <span class="error">*</span></label>
                <input type="text" class="form-control" value="{{ $appontment->user_contact }}" name="user_contact" placeholder="User Contact" />
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Status <span class="error">*</span></label>
                <select class="form-control" name="status">
                @foreach ( config('const.appointment_status') as $status )
                <option value="{{ $status }}" {{ $appontment->status == $status ? 'selected':'' }}>{{ ucfirst($status) }}</option>
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

@push('js')

<script>
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

  // get appoinmenters time slote
  $('#appointmenter_id, #booking_date').on('change', function(event) {
    $('#timeslote').html('<option value="">Select Timing</option>');
    if ($('#booking_date').val() == '' || $('#appointmenter_id').val() == '' || $('#with-timing').val() != 1) {
      return
    }
    $.ajax({
      type: "POST",
      url: "{{ route('business.appointment.bookings.get.appointmrnter.timing') }}",
      data: {
        appointmenter_id: $('#appointmenter_id').val(),
        date: $('#booking_date').val(),
        appoinment_id: $('#appoinment_id').val()
      },
      dataType: "json",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      beforeSend: function() {
        $('#timeslote').html('<option value="">Loading ...</option>');
      },
      success: function(states) {
        $('#timeslote').html('<option value="">Select Timing</option>');
        $.each(states, function(index, item) {
          var disable = item.is_booked?'disabled':'';
          $('#timeslote').append('<option value="' + item.time + '" '+disable+'>' + item.time + '</option>');
        });
      },
      error: function(xhr, status, error) {
        console.error("Error: " + error);
        $('#timeslote').html('<option value="">Select Timing</option>');
        alert("There was an error on appointmenter change.");
      }
    });
  });
</script>

@endpush
@endsection