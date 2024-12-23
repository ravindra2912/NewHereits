@extends('business.layouts.main')
@section('content')
@section('title', 'Appointmenter Timing')

@push('style')
<!-- summernote -->
<style>

</style>
@endpush

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Appointmenter Timing</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('business.appointment.appointmenter.index') }}">Appointmenter list</a></li>
          <li class="breadcrumb-item active">Appointmenter Timing</li>
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
            Timing
          </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            @foreach ( $timing as $day)
            @php
            $day = (object)$day;
            @endphp
            <div class="col-md-4 col-12">
              <div class="card card-outline card-primary">
                <div class="card-header">
                  <h3 class="card-title">{{ $day->day }}</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-sm btn-primary" onclick="addTiming('{{ $day->day }}')">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  @if (count($day->timing) > 0)
                  @foreach ($day->timing as $time)
                  <div class="bg-lightblue rounded px-2 row mb-1">
                    <p class="col-9 mb-0">{{ get_time($time->start_time).' - '. get_time($time->end_time) }}</p>
                    <p class="col-3 mb-0 text-right btn_delete-{{ $time->id }}" onclick="destroy({{ $time->id }})">
                      <i class="fas fa-trash-alt" id="buttonText"></i>
                      <span id="loader" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </p>
                  </div>
                  @endforeach
                  @else
                  <div class="text-center text-danger">Close</div>
                  @endif
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- model for add timimg -->
  <div class="modal fade" id="modal-timig">
    <div class="modal-dialog">
      <form action="{{ route('business.appointment.appointmenter.timing.store', $appointmenter->id) }}" id="timing-form" data-action="reload" class="modal-content formaction">
        <div class="modal-header">
          <h4 class="modal-title">Add time</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row ">
            @csrf
            <div class="col-md-12">
              <div class="form-group">
                <label>Day <span class="error">*</span></label>
                <select class="form-control" name="day" id="week_day">
                  <option value="">Select Day</option>
                  @foreach ( config('const.week_day_name') as $day)
                  <option value="{{ $day }}">{{ $day }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
                <label>Start Time <span class="error">*</span></label>
                <input type="time" class="form-control" name="start_time" placeholder="Start Time" />
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>End Time <span class="error">*</span></label>
                <input type="time" class="form-control" name="end_time" placeholder="End Time" />
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn_action">
            <span id="loader" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            <span id="buttonText">Submit</span>
          </button>
        </div>
      </form>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</section>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function addTiming(day) {
    $('#week_day').val(day);
    $('#modal-timig').modal('show');
  }

  // delete time
  function destroy(id) {
    Swal.fire({
        title: 'Are you sure?',
        icon: 'error',
        html: "You want to delete this time?",
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
      })
      .then((result) => {
        if (result.isConfirmed) {
          url = "{{ route('business.appointment.appointmenter.timing.destroy') }}";
          $.ajax({
            url: url,
            type: "POST",
            data: {
              '_method': 'post',
              'id':id
            },
            dataType: "json",
            headers: {
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            beforeSend: function() {
              $('.btn_delete-'+id+' #buttonText').addClass('d-none');
              $('.btn_delete-'+id+' #loader').removeClass('d-none');
              $('.btn_delete-'+id).prop('disabled', true);
            },
            success: function(result) {
              if (result.success) {
                toastr.success(result.message);
                location.reload()
              } else {
                toastr.error(result.message);
              }
            },
            error: function(e) {
              toastr.error('Somthing Wrong');
              console.log(e);
              $('.btn_delete-'+id+' #buttonText').removeClass('d-none');
              $('.btn_delete-'+id+' #loader').addClass('d-none');
              $('.btn_delete-'+id).prop('disabled', false);
            }
          });
        }
      })
  }
</script>

@endpush
@endsection