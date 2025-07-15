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
          <p>We regret to inform you that your business account “{{ $business->name }}” on Hereits has been suspended due to a violation of our terms of service or activity that goes against our platform policies.</p>
          <p>If you believe this was a mistake or would like to appeal the decision, please reply to this email or contact us at <a href="mailto:support@hereits.com">support@hereits.com</a>.</p>
          <p>We value all our users and are happy to work with you to resolve any misunderstandings.</p>
          <p style="margin-top: 10px;">Thank you for your understanding.</p>
          <p>– The HereIts Team</p>
        </td>
      </tr>

     
    </table>
  </center>
</body>
@include('emails.footer')