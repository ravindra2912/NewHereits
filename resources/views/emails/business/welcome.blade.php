<!DOCTYPE html>
@include('emails.header')
<body style="background:#f5f5f5;margin:0;">
  <center>
    <table role="presentation" class="email-container">
      <!-- Header -->
      <tr>
        <td class="header">
          <a href="#"><img src="{{ asset('front/img/logo-bg-black.png') }}" alt="Hereits"></a>
        </td>
      </tr>

      <!-- Body -->
      <tr>
        <td class="content">
          <h5>Hi {{ $user->first_name }},</h5>
          <p>Welcome to <a href="https://Hereits.com">Hereits.com</a></p>
          <p>Thank you for registering your business {{ $business->name }} with us.</p>
          <p>We’re excited to have you on board. Currently, your business status is set to pending as our team reviews your submission. You’ll receive a confirmation email once it’s approved and ready to go live.</p>
          <p>Get started now by logging in:<a href="https://hereits.com">https://hereits.com</a></p>
          <p style="margin-top:20px;">Thanks for joining us!</p>
          <p>– The HereIts Team</p>
        </td>
      </tr>

     
    </table>
  </center>
</body>
@include('emails.footer')