@extends('business.layouts.main')
@section('content')
@section('title', 'Business credit')

@push('style')
<style>
  /* .pricingTable {
    margin: 40px auto;
  } */

  .pricingTable-firstTable {
    list-style: none;
    padding-left: 2em;
    padding-right: 2em;
    text-align: center;
  }

  .pricingTable-firstTable_table {
    vertical-align: middle;
    /* width: 31%; */
    background-color: #ffffff;
    display: inline-block;
    padding: 0px 30px 40px;
    text-align: center;
    max-width: 320px;
    transition: all 0.3s ease;
    border-radius: 5px;
    border: 1px solid #ebedec;
  }

  @media screen and (max-width: 767px) {
    .pricingTable-firstTable_table {
      display: block;
      width: 90%;
      margin: 0 auto 20px;
      max-width: 90%;
      padding: 10px 20px;
    }

    .pricingTable-firstTable_table>* {
      display: inline-block;
      vertical-align: middle;
    }

    .pricingTable-firstTable_table:after {
      display: table;
      content: '';
      clear: both;
    }
  }

  @media screen and (max-width: 480px) {
    .pricingTable-firstTable_table>* {
      display: block;
      float: none;
    }
  }

  .pricingTable-firstTable_table:hover {
    transform: scale(1.08);
  }

  @media screen and (max-width: 767px) {
    .pricingTable-firstTable_table:hover {
      transform: none;
    }
  }

  .pricingTable-firstTable_table:not(:last-of-type) {
    margin-right: calc((100% - 31% * 3) / 2);
  }

  @media screen and (max-width: 767px) {
    .pricingTable-firstTable_table:not(:last-of-type) {
      margin-right: auto;
    }
  }

  .pricingTable-firstTable_table:nth-of-type(2) {
    position: relative;
  }

  @media screen and (max-width: 767px) {
    .pricingTable-firstTable_table:nth-of-type(2) h1 {
      padding-top: 8%;
    }
  }

  @media screen and (max-width: 988px) {
    .pricingTable-firstTable_table:nth-of-type(2):before {
      font-size: 0.6em;
    }
  }

  @media screen and (max-width: 767px) {
    .pricingTable-firstTable_table:nth-of-type(2):before {
      left: 10px;
      width: 45px;
      height: 45px;
      top: -10px;
      padding-top: 13px;
    }
  }

  @media screen and (max-width: 480px) {
    .pricingTable-firstTable_table:nth-of-type(2):before {
      font-size: 0.8em;
    }
  }

  .pricingTable-firstTable_table:nth-of-type(2):hover:before {
    transform: rotate(360deg);
  }

  .pricingTable-firstTable_table__header {
    font-size: 1.6em;
    padding: 40px 0px;
    border-bottom: 2px solid #ebedec;
    letter-spacing: 0.03em;
  }

  @media screen and (max-width: 1068px) {
    .pricingTable-firstTable_table__header {
      font-size: 1.45em;
    }
  }

  @media screen and (max-width: 767px) {
    .pricingTable-firstTable_table__header {
      padding: 0px;
      border-bottom: none;
      float: left;
      width: 33%;
      padding-top: 3%;
      padding-bottom: 2%;
    }
  }

  @media screen and (max-width: 610px) {
    .pricingTable-firstTable_table__header {
      font-size: 1.3em;
    }
  }

  @media screen and (max-width: 480px) {
    .pricingTable-firstTable_table__header {
      float: none;
      width: 100%;
      font-size: 1.8em;
      margin-bottom: 5px;
    }
  }

  .pricingTable-firstTable_table__pricing {
    font-size: 3em;
    padding: 30px 0px;
    border-bottom: 2px solid #ebedec;
    line-height: 0.7;
  }

  @media screen and (max-width: 1068px) {
    .pricingTable-firstTable_table__pricing {
      font-size: 2.8em;
    }
  }

  @media screen and (max-width: 767px) {
    .pricingTable-firstTable_table__pricing {
      border-bottom: none;
      padding: 0;
      float: left;
      clear: left;
      width: 33%;
    }
  }

  @media screen and (max-width: 610px) {
    .pricingTable-firstTable_table__pricing {
      font-size: 2.4em;
    }
  }

  @media screen and (max-width: 480px) {
    .pricingTable-firstTable_table__pricing {
      float: none;
      width: 100%;
      font-size: 3em;
      margin-bottom: 10px;
    }
  }

  .pricingTable-firstTable_table__pricing span:first-of-type {
    font-size: 0.35em;
    vertical-align: top;
    letter-spacing: 0.15em;
  }

  @media screen and (max-width: 1068px) {
    .pricingTable-firstTable_table__pricing span:first-of-type {
      font-size: 0.3em;
    }
  }

  .pricingTable-firstTable_table__pricing span:last-of-type {
    vertical-align: bottom;
    font-size: 0.30em;
    letter-spacing: 0.04em;
    padding-left: 0.2em;
  }

  @media screen and (max-width: 1068px) {
    .pricingTable-firstTable_table__pricing span:last-of-type {
      font-size: 0.25em;
    }
  }

  .pricingTable-firstTable_table__options {
    list-style: none;
    padding: 15px;
    font-size: 0.9em;
    border-bottom: 2px solid #ebedec;
  }

  @media screen and (max-width: 1068px) {
    .pricingTable-firstTable_table__options {
      font-size: 0.85em;
    }
  }

  @media screen and (max-width: 767px) {
    .pricingTable-firstTable_table__options {
      border-bottom: none;
      padding: 0;
      margin-right: 10%;
    }
  }

  @media screen and (max-width: 610px) {
    .pricingTable-firstTable_table__options {
      font-size: 0.7em;
      margin-right: 8%;
    }
  }

  @media screen and (max-width: 480px) {
    .pricingTable-firstTable_table__options {
      font-size: 1.3em;
      margin-bottom: 10px;
    }
  }

  .pricingTable-firstTable_table__options>li {
    padding: 8px 0px;
  }

  @media screen and (max-width: 767px) {
    .pricingTable-firstTable_table__options>li {
      text-align: left;
    }
  }

  @media screen and (max-width: 610px) {
    .pricingTable-firstTable_table__options>li {
      padding: 5px 0;
    }
  }

  @media screen and (max-width: 480px) {
    .pricingTable-firstTable_table__options>li {
      text-align: center;
    }
  }

  .pricingTable-firstTable_table__options>li:before {
    content: '✓';
    display: inline-flex;
    margin-right: 15px;
    color: white;
    background-color: #74ce6a;
    border-radius: 50%;
    width: 15px;
    height: 15px;
    font-size: 0.8em;
    padding: 2px;
    align-items: center;
    justify-content: center;
  }

  @media screen and (max-width: 1068px) {
    .pricingTable-firstTable_table__options>li:before {
      width: 14px;
      height: 14px;
      padding: 1.5px;
    }
  }

  @media screen and (max-width: 767px) {
    .pricingTable-firstTable_table__options>li:before {
      width: 12px;
      height: 12px;
    }
  }

  .pricingTable-firstTable_table__getstart {
    color: white;
    border: 0;
    background-color: #71ce73;
    margin-top: 30px;
    border-radius: 5px;
    cursor: pointer;
    padding: 15px;
    box-shadow: 0px 3px 0px 0px rgba(102, 172, 100, 1);
    letter-spacing: 0.07em;
    transition: all 0.4s ease;
  }

  @media screen and (max-width: 1068px) {
    .pricingTable-firstTable_table__getstart {
      font-size: 0.95em;
    }
  }

  @media screen and (max-width: 767px) {
    .pricingTable-firstTable_table__getstart {
      margin-top: 0;
    }
  }

  @media screen and (max-width: 610px) {
    .pricingTable-firstTable_table__getstart {
      font-size: 0.9em;
      padding: 10px;
    }
  }

  @media screen and (max-width: 480px) {
    .pricingTable-firstTable_table__getstart {
      font-size: 1em;
      width: 50%;
      margin: 10px auto;
    }
  }

  .pricingTable-firstTable_table__getstart:hover {
    transform: translateY(-10px);
    box-shadow: 0px 40px 29px -19px rgba(102, 172, 100, 0.9);
  }

  @media screen and (max-width: 767px) {
    .pricingTable-firstTable_table__getstart:hover {
      transform: none;
      box-shadow: none;
    }
  }

  .pricingTable-firstTable_table__getstart:active {
    box-shadow: inset 0 0 10px 1px rgba(102, 165, 100, 1), 0px 40px 29px -19px rgba(102, 172, 100, 0.95);
    transform: scale(0.95) translateY(-9px);
  }

  @media screen and (max-width: 767px) {
    .pricingTable-firstTable_table__getstart:active {
      transform: scale(0.95) translateY(0);
      box-shadow: none;
    }
  }

  body {
    font-family: 'Montserrat', sans-serif;
    font-size: 100%;
    background-color: #f0f4f7;
    color: #717787;
  }

  @media screen and (max-width: 960px) {
    body {
      font-size: 80%;
    }
  }

  @media screen and (max-width: 776px) {
    body {
      font-size: 70%;
    }
  }

  @media screen and (max-width: 496px) {
    body {
      font-size: 50%;
    }
  }

  @media screen and (max-width: 320px) {
    body {
      font-size: 40%;
    }
  }

  * {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
  }
</style>
@endpush

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Business credit</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Setting</a></li>
          <li class="breadcrumb-item active">Business credit</li>
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
            Business credit
          </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="pricingTable row">
            <div class="col-12 mb-12">
              Available credit: <span class="text-success">{{ $business->credit }}</span>
            </div>
            <form action="{{ route('business.setting.business.credit.buy')}}" data-action="redirect" data-tost="false" class="formaction col-md-6">
              @csrf
              <ul class="pricingTable-firstTable ">
                <li class="pricingTable-firstTable_table">
                  <h1 class="pricingTable-firstTable_table__header">Credit

                  </h1>
                  <p class="pricingTable-firstTable_table__pricing">
                    <input type="number" name="credit" class="form-control" min="1" placeholder="Enter Your credit" />
                    <label class="h5 mb-3 calculation"> 0 * {{ $price }} Rs</label></br><span>Rs.</span><span class="total">0</span><span></span>
                  </p>
                  <ul class="pricingTable-firstTable_table__options">
                    <li>Get booking</li>
                  </ul>
                  <button type="submit" class="pricingTable-firstTable_table__getstart btn-block">Buy</button>

                </li>
              </ul>
            </form>
            <div class="col-md-12">
              <h4>History</h4>
              <hr>
              <table class="table table-bordered table-striped">
                <tr>
                  <th>Price</th>
                  <th>Credits</th>
                  <th>Status</th>
                  <th>Date</th>
                </tr>
                @foreach ($business->businessCredits as $data)
                <tr>
                  <td>Rs. {{ $data->transaction->amount }}</td>
                  <td>{{ $data->credit }}</td>
                  <td>{{ ucfirst( str_replace('_', ' ', $data->status)) }}</td>
                  <td>{{ get_date($data->created_at) }}</td>
                </tr>
                @endforeach
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- /.col-->
    </div>
</section>
<!-- /.content -->

@push('js')
<script>
  function responce(res) {
    window.location.reload();
  }

  $('input[name="credit"]').on('keyup change', function() {
    var price = '{{ $price }}';
    var credit = $(this).val();

    $('.calculation').html(credit + ' * ' + price + ' Rs');
    $('.total').html((credit * price).toFixed(2));
  })
</script>

@endpush
@endsection