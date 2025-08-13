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
          <p>Welcome to <a href="https://Hereits.com">Hereits.com</a></p>
          <p>We're excited to help you book and manage your appointments quickly and effortlessly.</p>
          <p style="margin-top:20px;"> Here’s what you can do: </p>
          <ul>
            <li>Book appointments with top-rated providers</li>
            <li>Track your upcoming bookings</li>
            <li>Get real-time updates</li>
          </ul>

          <p>Get started now by logging in:<a href="https://hereits.com">https://hereits.com</a></p>
          <p style="margin-top:20px;">Thanks for joining us!</p>
          <p>– The HereIts Team</p>
        </td>
      </tr>

     
    </table>
  </center>
</body>
@include('emails.footer')