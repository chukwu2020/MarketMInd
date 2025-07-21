@php
    use App\Models\WithdrawalCard;
    $cardExists = auth()->check() ? WithdrawalCard::where('user_id', auth()->id())->exists() : false;
@endphp

<aside class="sidebar  text-[#0C3A30] shadow-sidebar" style="background-image: url(assets/images/hero/hero-image-1.svg);" >
    <!-- Close Button (Visible when sidebar is open) -->
    <!-- <button type="button" class="sidebar-close-btn lg:hidden absolute top-4 right-4 z-50" >
        <iconify-icon icon="radix-icons:cross-2" class="text-2xl" style="background-color: #8bc905;"></iconify-icon> 
    </button> -->

<button type="button"
    class="sidebar-close-btn lg:hidden absolute top-4 right-4 z-50"
    style="  border: none;  padding-top:2rem;">
    <iconify-icon icon="radix-icons:cross-2"
        style="font-size: 40px; color: #8bc905;"></iconify-icon>
</button>


    <!-- Logo -->

  <div class="desktop-logo px-4 pt-1 pb-2 hidden lg:block" style="margin-top: 0;">
            <img 
                src="{{ asset('assets/images/mymarketmindmainlogo.png') }}" 
                alt="Market Mind Logo" 
                class="brand-logo logo-img"
            >
        </div>

      

    <!-- Sidebar Menu -->
    <div class="sidebar-menu-area px-1">
        <ul class="sidebar-menu space-y-1 p-1 bg-[#f2fef0] rounded-md">

            <!-- HOME -->
            <li class="menu-title text-xs font-bold uppercase text-[#0C3A30] mt-4 px-3">Home</li>
            <li>
                <a href="{{ route('user_dashboard') }}" class="menu-link {{ request()->routeIs('user_dashboard') ? 'active-link' : '' }}">
                    <iconify-icon icon="solar:home-smile-angle-outline"></iconify-icon>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- APP -->
            <li class="menu-title text-xs font-bold uppercase text-[#0C3A30] mt-4 px-3">App</li>
            <li>
                <a href="{{ route('user.investments') }}" class="menu-link {{ request()->routeIs('user.investments') ? 'active-link' : '' }}">
                    <iconify-icon icon="hugeicons:money-send-square"></iconify-icon>
                    <span>My Investments</span>
                </a>
            </li>
            <li>
                <a href="{{ route('plan.dashboard') }}" class="menu-link {{ request()->routeIs('plan.dashboard') ? 'active-link' : '' }}">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Our Plans</span>
                </a>
            </li>

            <!-- TRANSACTIONS -->
            <li class="menu-title text-xs font-bold uppercase text-[#0C3A30] mt-4 px-3">Transactions</li>

            <!-- Deposits -->
            <li class="dropdown group" style="padding-bottom: 1.1rem;">
                <a href="javascript:void(0)" class="menu-link flex justify-between items-center {{ request()->routeIs('user.deposit*') ? 'active-link' : '' }}">
                    <span class="flex items-center gap-2" style="font-size: 14px;  font-weight: 400;">
                        <iconify-icon icon="hugeicons:bitcoin-circle"></iconify-icon>
                        Deposits
                    </span>
                    
                </a>
                <ul class="sidebar-submenu hidden" style="background-color: #8bc905 !important;">
                    <li><a href="{{ route('user.deposit') }}" class="{{ request()->routeIs('user.deposit') ? 'active-sub-link' : '' }}">➕ Deposit</a></li>
                    <li><a href="{{ route('user.deposit-history') }}" class="{{ request()->routeIs('user.deposit-history') ? 'active-sub-link' : '' }}">Deposit List</a></li>
                </ul>
            </li>

            <!-- Withdrawals -->
            <li class="dropdown group">
                <a href="javascript:void(0)" class="menu-link flex justify-between items-center {{ request()->routeIs('user.withdrawals*') ? 'active-link' : '' }}">
                    <span class="flex items-center gap-2" style="font-size: 14px;  font-weight: 400;" >
                        <iconify-icon icon="hugeicons:money-send-square"></iconify-icon>
                        Withdrawals
                    </span>
                   
                </a>
                <ul class="sidebar-submenu hidden">
                    <li><a href="{{ route('user.withdrawals.list') }}" class="{{ request()->routeIs('user.withdrawals.list') ? 'active-sub-link' : '' }}">💸 Pending/Approved</a></li>
                </ul>
            </li>

            <!-- Card -->
            @auth
                <div class="card-action mt-4 px-3">
                    @if (!$cardExists)
                        <form action="{{ route('withdrawals.generateCard') }}" method="POST">
                            @csrf
                            <button type="submit" class="action-btn">➕ Generate Card</button>
                        </form>
                    @else
                        <a href="{{ route('withdrawals.view-card') }}" class="action-btn">💳 View Your Card</a>
                    @endif
                </div>
            @endauth

            <!-- SETTINGS -->
            <li class="menu-title text-xs font-bold uppercase text-[#0C3A30] gap-2 mt-4 px-3">Settings</li>
            <li>
                <a href="{{ route('profile.show') }}" class="menu-link {{ request()->routeIs('profile.show') ? 'active-link' : '' }}" style="font-size: 16px; " >
                   
                    <span><iconify-icon icon="solar:user-linear" ></iconify-icon>Profile</span>
                </a>
            </li>
            
            <!-- STANDALONE LOGOUT BUTTON -->
            <!-- STANDALONE LOGOUT BUTTON -->
<li class="mt-2">
    <a href="{{ route('signout') }}" 
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
   style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; border-radius: 6px; text-decoration: none;  color: red; margin-top: 10px; transition: all 0.1s ease; font-weight: 600; font-size:18px"
      onmouseover="this.style.backgroundColor='#b91c1c'; this.style.color='black';"
   onmouseout="this.style.backgroundColor='transparent'; this.style.color='red';">
   
    <iconify-icon icon="lucide:power"></iconify-icon>
    <span>Logout</span>
</a>

    <form id="logout-form" method="POST" action="{{ route('signout') }}" class="hidden">
        @csrf
    </form>
</li>

        </ul>
    </div>
</aside>

<style>
    .shadow-sidebar {
        box-shadow: 2px 0 10px rgba(0,0,0,0.05);
    }
    
    .sidebar {
        width: 260px;
        padding: 20px 0;
       
        color: #0C3A30;
        font-family: 'Inter', sans-serif;
        position: fixed;
        left: 0;
        top: 0px;
        height: calc(100vh - 0px);
        z-index: 1101;
        transition: transform 0.3s ease;
        overflow-y: auto;
    }

    @media (max-width: 1023px) {
        .sidebar {
            transform: translateX(-100%);
             top: 78px;
        height: calc(100vh - 78px);
        }
        .sidebar.open {
            transform: translateX(0);
        }
    }

    .menu-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        border-radius: 6px;
        text-decoration: none;
        color: #0C3A30;
        transition: all 0.2s ease;
        position: relative;
    }

    .menu-link:hover,
    .menu-link:focus,
    .active-link {
        background-color: #9EDD05 !important;
        font-weight: 600;
        color: #0C3A30 !important;
    }

    .active-link:after {
        content: '';
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        width: 8px;
        height: 8px;
        background-color: #0C3A30;
        border-radius: 50%;
    }

   

    .sidebar-submenu {
        background-color: transparent;
        padding: 8px 0;
        margin-left: 10px;
        margin-top: 5px;
        border-radius: 6px;
        display: none;
    }

    .sidebar-submenu li a {
        display: block;
        padding: 8px 16px;
        background-color: transparent;
        color: #0C3A30 !important;
        font-size: 16px;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.2s ease;
        background-color: #9EDD05;
    }

    .sidebar-submenu li a:hover,
    .sidebar-submenu li a:focus,
    .active-sub-link {
        background-color: #0C3A30;
        font-weight: 500;
        color: #d0f5b9 !important;
    }

    .card-action .action-btn {
        display: block;
        width: 100%;
        background-color:none;
        color: #0C3A30;
        padding: 10px;
        border-radius: 6px solid #8bc905 ;
        font-weight: 600;
        text-align: center;
        margin-top: 10px;
        border: none;
        cursor: pointer;
    }

    .card-action .action-btn:hover {
        background-color: #8bc905;
        color: #0C3A30 !important;
    }

    .arrow {
        transition: transform 0.2s ease;
    }
    
    .rotate-180 {
        transform: rotate(180deg);
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Toggle dropdowns
        document.querySelectorAll(".menu-link").forEach(link => {
            if (link.closest('.dropdown')) {
                link.addEventListener("click", function(e) {
                    if (this.getAttribute('href') === 'javascript:void(0)') {
                        e.preventDefault();
                        const dropdown = this.closest('.dropdown');
                        const submenu = dropdown.querySelector('.sidebar-submenu');
                        const arrow = dropdown.querySelector('.arrow');
                        
                        submenu.classList.toggle('hidden');
                        arrow.classList.toggle('rotate-180');
                    }
                });
            }
        });

        // Close button functionality
        document.querySelector('.sidebar-close-btn')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.remove('open');
        });
    });
</script>