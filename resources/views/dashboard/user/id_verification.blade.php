@component('mail::layout')
@slot('header')
    @component('mail::header', ['url' => config('app.url')])
        <img src="https://res.cloudinary.com/dswwq3xks/image/upload/v1752508147/mymarketmindmainlogo_qonmlk.png" alt="MarketMind Logo" style="height: 60px;">
        
    @endcomponent
@endslot

<!-- Email Body -->
<div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 24px rgba(0,0,0,0.08);">
    <!-- Gradient Header -->
    <div style="background: linear-gradient(135deg, #8bc905 0%, #7bb005 100%); padding: 20px 20px 25px; text-align: center;">
        <p style="margin: 8px 0 0; font-size: 16px; color: white; font-weight: 500; letter-spacing: 0.5px;">ID Verification Received</p>
    </div>

    <!-- Content -->
    <div style="padding: 40px; font-size: 16px; line-height: 1.6; color: #0C3A30;">
        <p style="margin-top: 0; font-size: 18px; font-weight: 500;">Hi {{ $userName }},</p>

        <div style="background-color: #f0fdf4; border-left: 4px solid #8bc905; padding: 24px; border-radius: 0 12px 12px 0; margin: 30px 0;">
            <p style="margin: 0 0 16px; font-size: 16px; line-height: 1.7;">
                Thank you for submitting your ID verification documents. We've successfully received your submission and our team will review it shortly.
            </p>
            <p style="margin: 0; font-size: 16px; line-height: 1.7;">
                <strong>Country:</strong> {{ $verification->country }}<br>
                <strong>Submitted On:</strong> {{ $verification->created_at->format('F j, Y \a\t g:i a') }}
            </p>
        </div>

        @component('mail::button', ['url' => $actionUrl, 'color' => 'success'])
            View Verification Status
        @endcomponent

        <p style="font-size: 15px; color: #5a6d5a; margin-top: 30px; border-top: 1px dashed #e0f7e9; padding-top: 20px;">
            <strong>Note:</strong> The verification process typically takes 1-2 business days. You'll receive another notification once your verification is complete.
        </p>

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
    </div>

    <!-- Footer -->
    <div style="background-color: #f0fdf4; padding: 30px; text-align: center; font-size: 13px; color: #5a6d5a;">
        <p style="margin: 0 0 15px;">
            <a href="{{ config('app.url') }}/help" style="color: #8bc905; text-decoration: none; margin: 0 12px; font-weight: 500;">Help Center</a>
            <span style="color: #c1d9c1;">•</span>
            <a href="{{ config('app.url') }}/privacy" style="color: #8bc905; text-decoration: none; margin: 0 12px; font-weight: 500;">Privacy Policy</a>
            <span style="color: #c1d9c1;">•</span>
            <a href="{{ config('app.url') }}/unsubscribe" style="color: #8bc905; text-decoration: none; margin: 0 12px; font-weight: 500;">Unsubscribe</a>
        </p>
        <p style="margin: 10px 0 0; font-size: 12px;">
            © {{ date('Y') }} MarketMind. All rights reserved.<br>
            We are worldwide
        </p>
    </div>
</div>


@endcomponent