<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Email Verification - {{ config('app.name') }}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f2f2f2; font-family: Helvetica, Arial, sans-serif; color: #0C3A30;">

  <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#f2f2f2" style="padding: 30px 0;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">

          <!-- Header -->
          <tr>
            <td style="background-color: #8bc905; padding: 30px 20px; text-align: center;">
              <img src="https://res.cloudinary.com/dswwq3xks/image/upload/v1752508147/mymarketmindmainlogo_qonmlk.png" alt="MarketMind" style="height: 80px; width: auto; display: block; margin: 0 auto;">
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding: 40px 30px; font-size: 16px; line-height: 1.6; color: #0C3A30;">
              <p style="margin: 0 0 15px 0;">
                Hello{{ isset($userName) ? ' ' . $userName : '' }},
              </p>

              <p style="margin: 0 0 15px 0;">
                You recently requested to verify your email address. Please use the OTP below:
              </p>

              <div style="text-align: center; margin: 30px 0;">
                <span style="display: inline-block; padding: 15px 25px; background-color: #f2f2f2; border-radius: 8px; font-size: 28px; font-weight: bold; letter-spacing: 4px; color: #0C3A30;">
                  {{ $otp }}
                </span>
              </div>

              <p style="margin: 0 0 15px 0;">
                Or click the button below to verify your email:
              </p>

              <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $verificationUrl }}" style="display: inline-block; background-color: #0C3A30; color: #ffffff; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold;">
                  Verify Email
                </a>
              </div>

              <p style="margin: 0 0 10px 0; font-size: 14px;">
                If the button above doesn't work, copy and paste this link into your browser:
              </p>

              <p style="margin: 0 0 20px 0; word-break: break-all; font-size: 14px;">
                {{ $verificationUrl }}
              </p>

              <p style="margin: 0 0 20px 0; font-size: 14px;">
                This code will expire in 30 minutes. If you didn't request this, you can safely ignore this message.
              </p>

              <p style="margin-top: 40px; font-size: 14px;">
                Regards,<br>
                The MarketMind Team
              </p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="background-color: #f2f2f2; text-align: center; padding: 20px; font-size: 12px; color: #0C3A30;">
              &copy; {{ date('Y') }} MarketMind. All rights reserved.
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>
