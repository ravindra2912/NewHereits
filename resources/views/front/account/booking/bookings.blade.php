@extends('front.layouts.main')
@section('content')
@section('title', 'User Profile')

@push('style')
<!-- summernote -->
<style>
    .booking-border {
        border-right: 1px solid #e0e0e0;
    }

    @media (max-width: 768px) {
        .booking-border {
            border-right: none;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 2px;
            margin-bottom: 5px;
        }
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
                <h4 class="mb-4">Bookings</h4>
                <hr class="mx-n4 mb-4">

                <div class="row">
                    <div class="col-12" id="booking-data">

                    </div>
                    <div class="col-12 text-center" id="data-loader">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div class="col-12 text-center h5 mt-4 d-none" id="no-data">No Data Found</div>
                </div>
                <div id="list-obj"></div>

            </div>
        </div>
    </div>
</div>


@push('js')
<script>
    var limit = 10;
    var offset = 0;
    var is_data = true;
    var listAjax = '';
    // getList()

    function getList() {
        if (listAjax != '' || !is_data) {
            return true;
        }
        listAjax = $.ajax({
            type: "get",
            url: "{{ route('account.get.booking') }}",
            data: {
                offset: offset,
                limit: limit,
                // category: $('#category').val(),
            },
            dataType: "json",
            headers: {
                // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('#data-loader').removeClass('d-none');
                // document.getElementById("preloader").style.display = "block";
            },
            success: function(res) {
                // document.getElementById("preloader").style.display = "none";
                $('#data-loader').addClass('d-none');
                console.log(res.counts);
                if (res.counts < limit) {
                    is_data = false;
                }

                if(res.counts == 0 && offset == 0){
                    $('#no-data').removeClass('d-none');
                } else{
                    $('#booking-data').append(res.list);
                }

                offset += limit;
                listAjax = '';
                

            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
                // document.getElementById("preloader").style.display = "none";
                $('#data-loader').addClass('d-none');
                alert("There was an error feting data.");
            }
        });
    }

    //Set up Intersection Observer
    const whitepaperobserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                getList();
            }
        });
    }, {
        root: null,
        rootMargin: '0px',
        threshold: 1.0
    });
    whitepaperobserver.observe(document.querySelector('#list-obj'));
</script>
@endpush

@endsection