<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Password Reset OTP - {{ config('app.name') }}</title>
</head>
<body style="margin:0; padding:0; background-color:#f2f2f2; font-family: Helvetica, Arial, sans-serif; color: #0C3A30;">

  <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f2f2f2">
    <tr>
      <td align="center" style="padding: 30px 10px;">
        
        <table width="600" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="border-radius:8px; overflow:hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">

          <!-- Header -->
            <tr>
            <td style="background-color: #8bc905; padding: 30px 20px; text-align: center;">
           <img src="https://res.cloudinary.com/dswwq3xks/image/upload/v1752508147/mymarketmindmainlogo_qonmlk.png" alt="MarketMind" style="height: 80px; width: auto; display: block; margin: 0 auto;">
<p style="margin: 8px 0 0; font-size: 14px; color: #0C3A30;">Smarter Way to Secure Access</p>

            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding: 40px 30px; color: #0C3A30; font-size: 16px; line-height: 1.6;">
              <p style="margin-top: 0; color: #0C3A30;">
                Hi {{ $userName ?? 'there' }},
              </p>

              <p style="color: #0C3A30;">
                We received a request to reset your password. Here’s your confirmation code:
              </p>

              <p style="background-color: #f2f2f2; padding: 15px 20px; border-radius: 4px; font-size: 24px; font-weight: bold; letter-spacing: 2px; display: inline-block; margin: 20px 0; color: #0C3A30;">
                {{ $otp }}
              </p>

              <p style="color: #0C3A30;">
                This code will expire in 10 minutes. Please don’t share this code with anyone, even if they say they work for MarketMind.
              </p>

              <p style="font-size: 14px; color: #0C3A30; margin-top: 30px;">
                If you didn’t request this, you can safely ignore this email.
              </p>

              <h4 style="margin-top: 40px; font-size: 16px; font-weight: normal; color: #0C3A30;">
                Best Regards,<br>
                Thank you!
              </h4>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td bgcolor="#f2f2f2" style="padding: 20px; text-align: center; font-size: 12px; color: #0C3A30;">
              © {{ date('Y') }} MarketMind. All rights reserved.
            </td>
          </tr>

        </table>

      </td>
    </tr>
  </table>

</body>
</html>
