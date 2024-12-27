@extends('front.layouts.main')
@section('content')
@section('title', 'Businesses')


<section class="container mt-2 mb-5">
  <!-- fore filters -->
<input type="hidden" id="category" value="{{ $catSlug }}" />

  <div class="row">
    <div class="col-lg-2 mt-2 mt-lg-2 col-0">
        <p class="text-center"> for advertisement </p>
    </div>
    <div class="col-lg-8 mt-1 mt-lg-0">
      <!-- Sort Filters
          ============================================= -->
      <div class=" mb-2 pb-2">
        <div class="row align-items-center">
          <div class="col-12 col-md-12">
            <div class="row no-gutters ml-auto">
              <label class="col col-form-label-sm text-right mr-2 mb-0" for="input-sort">Sort By:</label>
              <select class="custom-select custom-select-sm col" id="sort_by" onchange="get_data(0)">
                <option value="1" selected>Popularity</option>
                <option value="3">Newest First</option>
                <!-- <option value="5">Price: Low to High</option>
                <option value="6">Price: High to Low</option> -->
              </select>
            </div>
          </div>
        </div>
      </div><!-- Sort Filters end -->

     
      <div class="" id="business-data"></div>

    <div class="text-center h5 mt-4 d-none" id="data-loader">Loading ...</div>

      <div id="list-obj" ></div>
      <!-- Paginations end -->

    </div>
    <div class="col-lg-2 mt-2 mt-lg-2 col-0">
    <p class="text-center"> for advertisement </p>
    </div>
  </div>
</section>


@push('js')
<script>
  var limit = 10;
  var offset = 0;
  var is_data = true;
  var listAjax = '';
  // getList()

  function getList() {
    if(listAjax != '' || !is_data){
      return true;
    }
    listAjax = $.ajax({
      type: "POST",
      url: "{{ route('get-business') }}",
      data: {
        offset: offset,
        limit: limit,
        category: $('#category').val(),
      },
      dataType: "json",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
        offset += limit;
        listAjax = '';
        $('#business-data').append(res.list);

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