<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email Verification - {{ config('app.name') }}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f8faf7; font-family: Arial, sans-serif; color: #0C3A30;">

  <div style="display: none; max-height: 0; overflow: hidden;">
    Verify your MarketMind account with this one-time code
  </div>

  <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#f8faf7" style="padding: 40px 10px;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" bgcolor="#ffffff" style="border-radius: 16px; overflow: hidden; box-shadow: 0 8px 24px rgba(0,0,0,0.08);">
          
          <!-- Header -->
          <tr>
            <td style="background: #8bc905; padding: 40px 20px; text-align: center;">
              <div style="display: inline-block; background-color: #ffffff; border-radius: 16px; padding: 14px 24px; margin-bottom: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.1);">
                <img src="https://res.cloudinary.com/dswwq3xks/image/upload/v1752508147/mymarketmindmainlogo_qonmlk.png" alt="MarketMind" style="height: 80px; width: auto; display: block; margin: 0 auto;">
              </div>
              <p style="margin: 8px 0 0; font-size: 16px; color: #ffffff; font-weight: 500;">Secure Account Verification</p>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding: 40px; font-size: 16px; line-height: 1.7; color: #0C3A30;">
              <p style="margin-top: 0; font-size: 18px; font-weight: 500;">Hello{{ isset($userName) ? ' ' . $userName : ' there' }},</p>

              <p>We're securing your account access. Please use this verification code:</p>

              <div style="text-align: center; margin: 40px 0;">
                <div style="display: inline-block; padding: 20px 30px; background-color: #f0fdf4; border-radius: 12px; border: 2px dashed #8bc905;">
                  <span style="font-size: 28px; font-weight: 700; letter-spacing: 4px; color: #0C3A30;">
                    {{ $otp }}
                  </span>
                </div>
                <p style="font-size: 14px; color: #5a6d5a; margin-top: 10px;">(Valid for 30 minutes)</p>
              </div>

              <div style="text-align: center; margin: 40px 0;">
                <a href="{{ $verificationUrl }}" style="display: inline-block; background-color: #8bc905; color: #ffffff; text-decoration: none; padding: 16px 32px; border-radius: 8px; font-weight: 600;">
                  Verify My Email →
                </a>
              </div>

              <div style="background-color: #f0fdf4; border-radius: 8px; padding: 16px; margin: 30px 0;">
                <p style="margin: 0 0 8px; font-size: 14px; color: #5a6d5a;"><strong>Alternative:</strong> If the button doesn't work, copy this link:</p>
                <p style="word-break: break-all; font-size: 14px; color: #0C3A30; background-color: #ffffff; padding: 10px; border-radius: 4px; margin: 0;">
                  {{ $verificationUrl }}
                </p>
              </div>

              <p style="font-size: 14px; color: #5a6d5a; border-top: 1px dashed #e0f7e9; padding-top: 20px;">
                <strong>Security tip:</strong> Never share this code with anyone. MarketMind will never ask you for your verification code.
              </p>

              <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 40px; border-top: 1px solid #e0f7e9; padding-top: 20px;">
                <tr>
                  <td>
                    <p style="margin: 0; font-size: 16px;">
                      Stay secure,<br>
                      <strong style="color: #8bc905; font-size: 18px;">The MarketMind Team</strong>
                    </p>
                  </td>
                  <td width="80" align="right">
                    <div style="width: 60px; height: 60px; background-color: #e0f7e9; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid #8bc905;">
                      <span style="font-size: 24px; color: #8bc905;">🔒</span>
                    </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="background-color: #f0fdf4; text-align: center; padding: 30px; font-size: 13px; color: #5a6d5a;">
              <p style="margin: 0 0 15px;">
                <a href="#" style="color: #8bc905; text-decoration: none; margin: 0 12px;">Help Center</a>
                <span style="color: #c1d9c1;">•</span>
                <a href="#" style="color: #8bc905; text-decoration: none; margin: 0 12px;">Privacy Policy</a>
              </p>
              <p style="margin: 10px 0 0; font-size: 12px;">
                © {{ date('Y') }} MarketMind. All rights reserved.<br>
                123 Security Lane, Financial District
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>
