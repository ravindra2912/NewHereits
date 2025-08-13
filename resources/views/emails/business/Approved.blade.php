<!DOCTYPE html>
@include('emails.header')
<body style="background:#f5f5f5;margin:0;">
  <center>
    <table role="presentation" class="email-container">
      <!-- Header -->
      <tr>
        <td class="header">
          <a href="#"><img src="{{ asset(config('const.site_setting.logo-bg-black')) }}" alt="Hereits"></a>
        </td>
      </tr>

      <!-- Body -->
      <tr>
        <td class="content">
          <h5>Hi {{ $user->first_name }},</h5>
          <p>Good news! 🎉</p>
          <p>Your business “{{ $business->name }}” has been approved and is now active on Hereits.</p>
          <p>You can now log in and start managing your profile, listing your services, and connecting with customers.</p>
          <p>Get started now by logging in:<a href="https://hereits.com">https://hereits.com</a></p>
          <p style="margin-top:20px;">Thanks for joining us!</p>
          <p>– The HereIts Team</p>
        </td>
      </tr>

     
    </table>
  </center>
</body>
@include('emails.footer')