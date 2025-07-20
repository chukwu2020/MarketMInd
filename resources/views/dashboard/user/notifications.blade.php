<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ $subject }} - {{ config('app.name') }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    @media only screen and (max-width: 600px) {
      .email-container {
        width: 100% !important;
      }
      .mobile-padding {
        padding-left: 20px !important;
        padding-right: 20px !important;
      }
    }
  </style>
</head>
<body style="margin:0; padding:0; background-color:#f8faf7; font-family: 'Poppins', Arial, sans-serif; color: #0C3A30;">

  <!-- Preheader Text (Shown in inbox preview) -->
  <div style="display: none; max-height: 0; overflow: hidden;">
    {{ $previewText ?? 'Your MarketMind update is here' }}
  </div>

  <!-- Main Container -->
  <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f8faf7">
    <tr>
      <td align="center" style="padding: 40px 10px;">
        
        <!-- Email Card -->
        <table class="email-container" width="600" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="border-radius:16px; overflow:hidden; box-shadow: 0 8px 24px rgba(0,0,0,0.08);">
          
          <!-- Gradient Header -->
          <tr>
        <td style="background: linear-gradient(135deg, #8bc905 0%, #7bb005 100%); padding: 20px 20px 25px; text-align: center;">

              <table width="100%">
                <tr>
                  <td style="text-align: center;">
                    <!-- Logo with subtle shadow -->
                  

<div style="display: inline-block; background-color: none; border-radius: 12px; padding: 8px 16px; margin-bottom: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
  <img src="https://res.cloudinary.com/dswwq3xks/image/upload/v1752508147/mymarketmindmainlogo_qonmlk.png" alt="Your Company Logo" style="height: 60px; width: auto; display: block; margin: 0 auto;" />
</div>

                  
                    <p style="margin: 8px 0 0; font-size: 16px; color: white; font-weight: 500; letter-spacing: 0.5px;">{{ $subject }}</p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Body Content -->
          <tr>
            <td class="mobile-padding" style="padding: 40px 40px; font-size: 16px; line-height: 1.6; color: #0C3A30;">
              
              <!-- Greeting -->
              <p style="margin-top: 0; font-size: 18px; font-weight: 500;">Hi {{ $userName ?? 'Valued Investor' }},</p>

              <!-- Main Message -->
              <div style="background-color: #f0fdf4; border-left: 4px solid #8bc905; padding: 24px; border-radius: 0 12px 12px 0; margin: 30px 0;">
                <p style="margin: 0; font-size: 16px; line-height: 1.7;">{{ $messageBody }}</p>
              </div>

              <!-- CTA Button -->
              <table width="100%" cellpadding="0" cellspacing="0" style="margin: 40px 0;">
                <tr>
                  <td align="center">{{ route('marketmindinvestments/user.dashboard') }}
                    <a href="" style="background-color: #8bc905; color: white; text-decoration: none; padding: 16px 32px; border-radius: 8px; font-weight: 600; display: inline-block; box-shadow: 0 4px 16px rgba(139, 201, 5, 0.3); transition: all 0.3s ease;">
                      {{ $actionText ?? 'View My Account' }}
                      <span style="margin-left: 8px;">→</span>
                    </a>
                  </td>
                </tr>
              </table>

              <!-- Additional Info -->
              <p style="font-size: 15px; color: #5a6d5a; margin-top: 30px; border-top: 1px dashed #e0f7e9; padding-top: 20px;">
                <strong>Quick Tip:</strong> You can log into your account anytime to check your status or view more details.
              </p>

              <!-- Signature -->
              <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #e0f7e9;">
                <tr>
                  <td>
                    <h4 style="margin: 0; font-size: 16px; font-weight: normal;">
                      To your financial success,<br>
                      <strong style="color: #8bc905; font-size: 18px;">The MarketMind Team</strong>
                    </h4>
              
                  </td>
                  <td width="80" align="right">
                    <div style="width: 60px; height: 60px; background-color: #e0f7e9; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid #8bc905;">
                      <span style="font-size: 24px; color: #8bc905;">💡</span>
                    </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td bgcolor="#f0fdf4" style="padding: 30px; text-align: center; font-size: 13px; color: #5a6d5a;">
              <p style="margin: 0 0 15px;">
                <a href="#" style="color: #8bc905; text-decoration: none; margin: 0 12px; font-weight: 500;">Help Center</a>
                <span style="color: #c1d9c1;">•</span>
                <a href="#" style="color: #8bc905; text-decoration: none; margin: 0 12px; font-weight: 500;">Privacy Policy</a>
                <span style="color: #c1d9c1;">•</span>
                <a href="#" style="color: #8bc905; text-decoration: none; margin: 0 12px; font-weight: 500;">Unsubscribe</a>
              </p>
              <p style="margin: 10px 0 0; font-size: 12px;">
                © {{ date('Y') }} MarketMind. All rights reserved.<br>
               we are worldwide 
              </p>
              <!-- Social Icons -->
              <p style="margin: 20px 0 0;">
                <a href="#" style="display: inline-block; margin: 0 8px;"><img src="https://cdn-icons-png.flaticon.com/512/124/124010.png" width="24" height="24" alt="Facebook" style="border-radius: 50%;"></a>
                <a href="#" style="display: inline-block; margin: 0 8px;"><img src="https://cdn-icons-png.flaticon.com/512/124/124021.png" width="24" height="24" alt="Twitter"></a>
                <a href="#" style="display: inline-block; margin: 0 8px;"><img src="https://cdn-icons-png.flaticon.com/512/174/174857.png" width="24" height="24" alt="LinkedIn"></a>
              </p>
            </td>
          </tr>

        </table>

      </td>
    </tr>
  </table>

</body>
</html>