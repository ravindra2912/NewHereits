<!DOCTYPE html>
<html lang="en">

<head>
  <title>Hereits</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="theme-color" content="#ebf9ff">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ config('const.site_setting.fevicon') }}">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

  <!--Toastr -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
  <!-- custome css -->
  <link rel="stylesheet" href="{{ asset('admin/dist/css/style.css') }}">

  <meta name="robots" content="noindex, nofollow">

</head>

<body class="hold-transition">
  <div class="wrapper">

    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center mt-5 pt-5">
          <div class=" text-center">
            <input type="hidden" name="payment_session_id" value="{{ $payment_session_id }}" />
            <input type="hidden" name="mode" value="{{ env('CASHFREE_MODE') }}" />
            <form id="paymentResponceForm" action="{{ route('business.payment.responce') }}" method="post" enctype="multipart/form-data" class="formaction" data-action="redirect" data-tost="false"> @csrf
              <input type="hidden" name="redirectUrl" value="{{$data->redirectUrl}}" />
              <input type="hidden" name="order" value="{{$data->orderid}}" />
              <input type="hidden" name="type" value="{{$data->type}}" />
            </form>
            <p class="h3 mb-2">Payment...</p>
            <button class="btn btn-success mr-3 rezorpay-btn d-none" id="renderBtn">Payment</button>
            <a href="{{$data->redirectUrl}}" class="btn btn-danger d-none">Cancel</a>
            <p class="text-danger h5 mt-3">
              ⚠ Please do not refresh or close this page while your payment is processing.
            </p>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- jQuery -->
  <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset('admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <!-- <script src="{{ asset('admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script> -->
  <!-- AdminLTE App -->
  <script src="{{ asset('admin/dist/js/adminlte.js') }}"></script>

  <!--Toastr -->
  <script src="{{asset('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js')}}"></script>

  <script src="{{ asset('ajax/ajax.js') }}"></script>

  <script src="{{ asset('rezorpay/jquery.min.js') }}"></script>
  <!-- <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="{{ asset('rezorpay/rezorpay.js') }}"></script> -->

  <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>

  <script>
    const cashfree = Cashfree({
      mode: document.querySelector('input[name="mode"]').value
    });

    document.getElementById("renderBtn").addEventListener("click", async () => {
      const paymentSessionId = document.querySelector('input[name="payment_session_id"]').value;
      const checkoutOptions = {
        paymentSessionId: paymentSessionId,
        redirectTarget: "_modal",
      };

      cashfree.checkout(checkoutOptions).then((result) => {
        if (result.error) {
          console.log("User closed popup or error occurred", result.error);
          $('#paymentResponceForm').submit();
        }
        if (result.redirect) {
          console.log("Redirection in progress");
        }
        if (result.paymentDetails) {
          console.log("Payment completed:", result);
          $('#paymentResponceForm').submit();
        }
      });
    });

    $('#renderBtn').click();
  </script>

</body>

</html>