@php
use App\Models\WithdrawalCard;
$user = auth()->user();
$cardExists = auth()->check() ? WithdrawalCard::where('user_id', auth()->id())->exists() : false;
@endphp

<header class="main-header">
    <style>
        .main-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #fffaeb;
            z-index: 1100;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            height: 80px;
        }

        body {
            padding-top: 80px;
        }

        .brand-logo {
            max-height: 500px;
            /* increased max-height */
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            height: 100%;
            position: relative;
        }

        .mobile-logo {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        @media (min-width: 1024px) {
            .mobile-logo {
                display: none;
            }
        }

        /* Main logo image styling */
        .logo-img {
            height: 120px;
            /* default base height */
            width: auto;
            max-width: 300px;
            object-fit: contain;
            filter: contrast(150%) brightness(120%) saturate(130%);


            transition: height 0.3s ease;
        }

        /* Tablets - bigger logo for common tablet widths */
        @media (min-width: 700px) and (max-width: 1150px) {
            .logo-img {
                height: 180px;
                /* significantly bigger on tablets */
                max-width: 400px;
            }
        }

        /* Desktops - largest logo */
        @media (min-width: 1151px) {
            .logo-img {
                height: 200px;
                max-width: 500px;
            }
        }

        /* Smaller phones */
        @media (max-width: 699px) {
            .logo-img {
                height: 100px;
                max-width: 220px;
            }
        }

        /* For small screens: center it visually */
        @media (max-width: 767.98px) {
            .mobile-logo {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                display: flex;
                align-items: center;
                justify-content: center;
                height: 120px;
                max-width: 260px;
            }
        }
    </style>

    <!-- {{-- Flash Messages --}}
    @foreach (['success' => 'green', 'error' => 'red'] as $msg => $color)
        @if(session($msg))
            <div class="mx-6 mt-4 px-4 py-2 rounded border border-{{ $color }}-400 bg-{{ $color }}-100 text-{{ $color }}-700 text-sm font-medium">
                {{ session($msg) }}
            </div>
        @endif
    @endforeach -->

    <div class="header-content">
        <!-- Mobile Hamburger -->
        <button class="lg:hidden sidebar-mobile-toggle" style="padding-right:1rem; border: none;">
            <iconify-icon icon="heroicons:bars-3-solid" style="font-size: 40px; color: #8bc905;"></iconify-icon>
        </button>

        <!-- Mobile Logo -->
        <div class="lg:hidden mobile-logo">
            <a href="{{ route('user_dashboard') }}">
                <img
                    src="{{ asset('assets/images/mymarketmindmainlogo.png') }}"
                    alt="Market Mind Logo"
                    class="brand-logo logo-img">
            </a>

        </div>

        <!-- Desktop Hamburger  -->
        <button class="hidden lg:block sidebar-toggle text-[#0c3a30]">
            <iconify-icon icon="heroicons:bars-3-solid" class="text-2xl"></iconify-icon>
        </button>

        <!-- Right Side Controls -->
        <div class="flex items-center gap-3">
            {{-- Profile Dropdown --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="focus:outline-none rounded-full overflow-hidden">
                    <!-- <div class="text-center border-b border-neutral-200 dark:border-neutral-600">
                        @php
                        use Illuminate\Support\Facades\Storage;

                        $profilePic = $user->profile->profile_pic ?? null;
                        $hasProfilePic = $profilePic && Storage::disk('public')->exists($profilePic);

                        $initials = collect(explode(' ', $user->name))
                        ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                        ->take(2)
                        ->join('') ?: 'U';
                        @endphp

                        @if ($hasProfilePic)
                        <img
                            src="{{ Storage::url($profilePic) }}?v={{ filemtime(storage_path('app/public/' . $profilePic)) }}"
                            alt="{{ $user->name }}"
                            class="mx-auto rounded-full object-cover w-11 h-11" />
                        @else
                        <div
                            class="mx-auto w-11 h-11 rounded-full flex items-center justify-center font-semibold text-base select-none"
                            style="background-color: #9EDD05; color: #0C3A30;">
                            {{ $initials }}
                        </div>
                        @endif
                    </div> -->
<div class="text-center border-b border-neutral-200 dark:border-neutral-600">
    @php
    use Illuminate\Support\Facades\Storage;
    
    $profilePic = $user->profile->profile_pic ?? null;
    $hasProfilePic = $profilePic && Storage::disk('public')->exists($profilePic);
    
    $initials = collect(explode(' ', $user->name))
        ->map(fn($word) => strtoupper(substr($word, 0, 1)))
        ->take(2)
        ->join('') ?: 'U';
    @endphp
    
    @if ($hasProfilePic)
        <img
            src="{{ asset('storage/'.$profilePic) }}?v={{ time() }}"
            alt="{{ $user->name }}"
            class="mx-auto rounded-full object-cover w-11 h-11" />
    @else
        <div
            class="mx-auto w-11 h-11 rounded-full flex items-center justify-center font-semibold text-base select-none"
            style="background-color: #9EDD05; color: #0C3A30;">
            {{ $initials }}
        </div>
    @endif
</div>
                </button>

                <div x-show="open" @click.away="open = false" x-transition
                    class="absolute right-0 mt-2 shadow-lg bg-white rounded-lg p-4 z-50 border"
                    style="width: 9rem !important; height: 11rem;">

                    <div style="border-bottom: 1px solid #def1ee; padding-bottom: 0.5rem; margin-bottom: 0.5rem; text-align:center;">
                        <span style="display: block; font-size: 0.875rem; font-weight: 600; color: #0c3a30;">My Account</span>
                    </div>


                    <ul style="font-size: 0.875rem; display: flex; flex-direction: column; gap: 0.5rem;">
                        <li>
                            <a href="{{ route('profile.show') }}"
                                style="display: flex; align-items: center; gap: 0.5rem; color:black; width: 100%; height: 3rem; border-radius: 6px; padding-left: 0.5rem; text-decoration: none;"
                                onmouseover="this.style.backgroundColor='#9EDD05';"
                                onmouseout="this.style.backgroundColor='none';">
                                <iconify-icon icon="solar:user-linear" style="font-size: 1.25rem;"></iconify-icon> Profile
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('signout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; background-color: #ef4444; color: black; width: 100%; height: 2.5rem; border-radius: 6px; text-decoration: none;"
                                onmouseover="this.style.backgroundColor='#b91c1c'; this.style.color='black';"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='red';">
                                <iconify-icon icon="lucide:power" style="font-size: 1.25rem;"></iconify-icon> Logout
                            </a>
                            <form id="logout-form" method="POST" action="{{ route('signout') }}" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    // Mobile sidebar toggle
    document.querySelector('.sidebar-mobile-toggle').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('open');
    });

    // Desktop sidebar toggle
    document.querySelector('.sidebar-toggle')?.addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('open');
    });
</script>

<script>
    (function() {
        const translateTrigger = document.getElementById('translateTrigger');
        const translateElement = document.getElementById('google_translate_element');
        const dropdownIcon = translateTrigger.querySelector('.dropdown-icon');

        // Toggle dropdown visibility
        function toggleDropdown() {
            const isVisible = translateElement.style.display === 'block';
            if (isVisible) {
                translateElement.style.display = 'none';
                translateTrigger.setAttribute('aria-expanded', 'false');
                dropdownIcon.classList.remove('rotate-180');
            } else {
                translateElement.style.display = 'block';
                translateTrigger.setAttribute('aria-expanded', 'true');
                dropdownIcon.classList.add('rotate-180');

                if (!window.googleTranslateLoaded) {
                    const script = document.createElement('script');
                    script.src = '//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
                    document.body.appendChild(script);
                    window.googleTranslateLoaded = true;

                    translateElement.innerHTML = '<div style="color:#333; padding: 8px;">Loading languages...</div>';
                }
            }
        }

        // Click on language selector toggles dropdown
        translateTrigger.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleDropdown();
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!translateTrigger.contains(e.target) && !translateElement.contains(e.target)) {
                translateElement.style.display = 'none';
                translateTrigger.setAttribute('aria-expanded', 'false');
                dropdownIcon.classList.remove('rotate-180');
            }
        });

        // Accessibility: toggle on Enter/Space
        translateTrigger.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleDropdown();
            }
        });
    })();

    // Google Translate Initialization function
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            includedLanguages: 'en,es,fr,de,it,pt,ru,zh-CN,ja,ar,hi',
            autoDisplay: false
        }, 'google_translate_element');

        // Additional style fixes for Google Translate iframe inside dropdown
        const style = document.createElement('style');
        style.textContent = `
        #google_translate_element {
            font-family: Arial, sans-serif;
        }
        .goog-te-menu-frame {
            max-width: 100% !important;
            width: 100% !important;
            box-sizing: border-box;
        }
        .goog-te-menu2 {
            max-width: 100% !important;
            width: 100% !important;
            overflow: auto !important;
        }
    `;
        document.head.appendChild(style);
    }
</script>

<style>
    /* Improved Language Selector Styles */
    .language-selector {
        position: relative;
        cursor: pointer;
        z-index: 1100;
        /* above navbar */
    }

    .translate-trigger {
        display: flex;
        align-items: center;
        gap: 6px;

        padding: 5px 10px;
        border-radius: 4px;
        transition: all 0.2s;
    }

    .translate-trigger:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .dropdown-icon {
        transition: transform 0.3s ease;
    }

    .dropdown-icon.rotate-180 {
        transform: rotate(180deg);
    }

    .top-header-area {
        position: relative;
        z-index: 1000;
    }
</style>