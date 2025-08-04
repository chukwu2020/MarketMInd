@extends('layout.user')

@section('content')
<style>
    /* Your existing styles ... */
    .atm-card {
        position: relative;
        width: 100%;
        max-width: 420px;
        height: 250px;
        border-radius: 1.5rem;
        color: #fff !important;
        overflow: hidden;
        background: linear-gradient(135deg, #1D4ED8, #A3E635, #4ADE80);
        background-size: 400% 400%;
        animation: gradientMove 10s ease infinite;
        font-family: 'Segoe UI', sans-serif;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.35);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 1.5rem 2rem;
        margin: 0 auto;
        transition: transform 0.5s ease;
    }

    @keyframes gradientMove {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
.card-flip.flipped {
    transform: rotateY(180deg);
    background-color: none !important;
}


.toggle-btn iconify-icon {
    color: black !important;
}

    .card-brand {
        font-size: 1.5rem;
        font-weight: bold;
        letter-spacing: 1.5px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        flex: 1;
    }

    .card-logo-wrapper {
        margin-left: 15px;
        display: flex;
        align-items: center;
    }

    .card-logo {
        height: 50px;
        width: auto;
        max-width: 120px;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .card-logo:hover {
        transform: scale(1.05);
    }

    .card-number {
        font-size: 1.7rem;
        font-weight: 500;
        text-align: center;
        letter-spacing: 2px;
        margin: 1rem 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        width: 100%;
    }

    .card-footer-item {
        display: flex;
        flex-direction: column;
        text-align: left;
        position: relative;
    }

    .card-label {
        font-size: 0.75rem;
        opacity: 0.85;
        margin-bottom: 0.25rem;
    }

    .card-value {
        font-size: 1rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        user-select: text;
    }

    .info-text {
        margin-top: 2.5rem;
        font-size: 15px;
        font-weight: 400;
        color: #0C3A30;
        max-width: 420px;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }

    .atm-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 1.5rem;
        box-shadow: inset 0 0 20px rgba(255, 255, 255, 0.1);
        pointer-events: none;
    }

    .card-wrapper {
        perspective: 1000px;
        max-width: 420px;
        height: 250px; /* match the card height */
        margin: 0 auto 2rem; /* adds space below the card */
        position: relative;
    }

    .card-flip {
        width: 100%;
        height: 100%;
        position: relative;
        transform-style: preserve-3d;
        transition: transform 0.8s ease;
    }


    .card-front, .card-back {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
    }

    .card-back {
        transform: rotateY(180deg);
    }

    /* Copy buttons styling */
    .btn-copy {
        background-color: #8bc905;
        color: #0C3A30;
        border: none;
        padding: 6px 12px;
        margin: 0 5px;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }
    .btn-copy:hover {
        background-color: #0C3A30;
        color: #8bc905 !important;
    }

    .copy-feedback {
        font-size: 0.9rem;
        color: #0C3A30;
        margin-top: 0.5rem;
        display: none;
    }

    .card-balance {
        font-size: 1.1rem;
        font-weight: 600;
        color: #0C3A30;
        margin: 1rem auto 2rem;
        max-width: 420px;
        text-align: center;
    }

    /* Toggle eye button */
    .toggle-btn {
        background: none;
        border: none;
        color: #fff;
        cursor: pointer;
        position: absolute;
        right: 0;
        top: 0;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .toggle-btn svg {
        width: 20px;
        height: 20px;
    }

    @media (max-width: 640px) {
        .atm-card {
            height: 220px;
            padding: 1.25rem;
        }

        .card-brand { font-size: 1.3rem; margin-top: 2rem; }
        .card-logo { height: 40px; max-width: 100px; margin-top: 2rem; }
        .card-number { font-size: 1.1rem; margin: 0.75rem 0; }
        .card-value { font-size: 0.9rem; }
    }

    @media (max-width: 480px) {
        .atm-card { height: 200px; padding: 1rem; }
        .card-brand { font-size: 1.2rem; margin-top: 1.5rem; }
        .card-logo { height: 35px; max-width: 90px; margin-top: 1.5rem; }
        .card-number { font-size: 1rem; margin-top: 1.5rem; }
    }
</style>

<div class="min-h-screen">
    <div class="container mx-auto px-4 py-10 text-center" style="padding-bottom: 100px; background-image: url('assets/images/hero/hero-image-1.svg'); min-height: 100vh; background-repeat: no-repeat; background-size: cover;">
        <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
            <h6 class="font-semibold mb-0" style="color: #0C3A30;">MY Virtual Card</h6>
            <ul class="flex items-center gap-[6px]">
                <li class="font-medium">
                    <a href="{{ route('user_dashboard') }}" class="flex items-center gap-2 hover:text-primary-600"
                       onmouseover="this.style.color='#9EDD05';"
                       onmouseout="this.style.color='#0C3A30';">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="font-medium">Card</li>
            </ul>
        </div>

        @if ($card)
            @php
                $expiry = now()->addYears(4)->format('m/Y');
                $cvv = str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);
            @endphp

            <div class="relative z-10">
                <div class="card-wrapper" id="cardWrapper">
                    <div class="card-flip" id="cardFlip">
                        <!-- Front of card -->
                        <div class="card-front">
                            <div class="atm-card">
                                <div class="card-header" style="margin-top: -3.5rem;">
                                    <div class="card-brand" style="color:#fff !important;">MARKETMIND</div>
                                    <div class="card-logo-wrapper">
                                        <img src="{{ asset('assets/images/mymarketmindmainlogo.png') }}"
                                             alt="MarketMind Logo"
                                             class="card-logo" style="width: 120px; height:auto;" />
                                    </div>
                                </div>

                                <div class="card-number" style="margin-top: -1.3rem; color:#fff !important;">
                                    {{ chunk_split($card->card_number, 4, ' ') }}
                                </div>

                                <div class="card-footer">
                                    <div class="card-footer-item" style="color:#fff !important;">
                                        <span class="card-label" style="color:#fff !important;">Card Holder</span>
                                        <span class="card-value" style="color:#fff !important; font-size: 18px;">{{ $card->name_on_card }}</span>
                                    </div>

                                    <div class="card-footer-item" style="color:#fff !important;">
                                        <span class="card-label" style="color:#fff !important;">PIN</span>
                                        <span id="pinValue" class="card-value" style="font-size: 18px; padding-right:5px; color:#fff !important; user-select:none;">••••</span>
                                        <button type="button" class="toggle-btn" onclick="toggleVisibility('pin')">
                                            <iconify-icon id="pinToggleIcon" icon="mdi:eye-off-outline"></iconify-icon>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Back of card -->
                        <div class="card-back">
                            <div class="atm-card" style="background: linear-gradient(135deg, #0C3A30, #1E3A8A); padding-top: 2rem;">

                                {{-- Magnetic Strip --}}
                                <div style="
                                    height: 40px;
                                    width: 100%;
                                    background-color: #111;
                                    margin-bottom: 2rem;
                                    border-radius: 6px;
                                "></div>

                                {{-- Signature Strip + CVV and Expiry --}}
                                <div class="card-footer" style="margin-bottom:3rem;">
                                    <div class="card-footer-item" style="color:#fff !important;">
                                        <span class="card-label" style="color:#fff !important;">Expires</span>
                                        <span class="card-value" style="background:#fff; color:#111; padding:5px 10px; border-radius:4px;">
                                            {{ $expiry }}
                                        </span>
                                    </div>
                                    <div class="card-footer-item" style="color:#fff !important;">
                                        <span class="card-label" style="color:#fff !important;">CVV</span>
                                        <span id="cvvValue" class="card-value" style="background:#fff; color:#111; padding:5px 10px; border-radius:4px; user-select:none;">•••</span>
                                        <button type="button" class="toggle-btn" onclick="toggleVisibility('cvv')" style="color:#111;">
                                            <iconify-icon id="cvvToggleIcon" icon="mdi:eye-off-outline"></iconify-icon>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
   
       
                    </div>
                    <div class="flex justify-center mt-2">
    <button id="flipCardBtn" >
        <iconify-icon icon="mdi:rotate-3d-variant" style="font-size: 24px; color: white;"></iconify-icon>
    </button>
</div>
                          </div>
            




            </div>

            {{-- Card Worth Balance Display --}}
            <div class="card-balance">
              Card Worth For Online Purchases: ${{ number_format(Auth::user()->available_balance, 2) }}

            </div>

            {{-- Copy Buttons --}}
            <div class="flex justify-center gap-4 mt-4">
                <button class="btn-copy" onclick="copyToClipboard('{{ $card->card_number }}', 'copyNumberFeedback')">
                    Copy Card Number
                </button>
                <button class="btn-copy" onclick="copyToClipboard('{{ $card->pin }}', 'copyPinFeedback')">
                    Copy PIN
                </button>
            </div>

            <div class="copy-feedback text-center" id="copyNumberFeedback">Card number copied!</div>
            <div class="copy-feedback text-center" id="copyPinFeedback">PIN copied!</div>

            <p class="info-text text-sm mt-6">
                Your Virtual Card is worth an amount and can be used for online purchases and payments.
                Withdrawals are deducted from your available balance, funded by this card.
            </p>

        @else
            <p class="text-gray-600 mt-12">No card has been generated yet.</p>
        @endif
    </div>
</div>

<script>
    const pinActual = "{{ $card->pin ?? '' }}";
    const cvvActual = "{{ $cvv ?? '' }}";

    let pinVisible = false;
    let cvvVisible = false;

    function toggleVisibility(type) {
        if(type === 'pin') {
            pinVisible = !pinVisible;
            const pinSpan = document.getElementById('pinValue');
            const icon = document.getElementById('pinToggleIcon');
            if(pinVisible) {
                pinSpan.textContent = pinActual;
                icon.setAttribute('icon', 'mdi:eye-outline');
            } else {
                pinSpan.textContent = '••••';
                icon.setAttribute('icon', 'mdi:eye-off-outline');
            }
        } else if(type === 'cvv') {
            cvvVisible = !cvvVisible;
            const cvvSpan = document.getElementById('cvvValue');
            const icon = document.getElementById('cvvToggleIcon');
            if(cvvVisible) {
                cvvSpan.textContent = cvvActual;
                icon.setAttribute('icon', 'mdi:eye-outline');
            } else {
                cvvSpan.textContent = '•••';
                icon.setAttribute('icon', 'mdi:eye-off-outline');
            }
        }
    }

    function copyToClipboard(text, feedbackId) {
        navigator.clipboard.writeText(text).then(() => {
            const feedback = document.getElementById(feedbackId);
            feedback.style.display = 'block';
            setTimeout(() => {
                feedback.style.display = 'none';
            }, 1500);
        });
    }



    // flip 
    document.getElementById('flipCardBtn').addEventListener('click', () => {
    const flipCard = document.getElementById('cardFlip');
    flipCard.classList.toggle('flipped');
});

</script>

@endsection
