<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
     <div class="lg:hidden mobile-logo">
            <img 
                src="{{ asset('assets/images/mymarketmindmainlogo.png') }}" 
                alt="Market Mind Logo" 
                class="brand-logo logo-img" style="width:180px; height:170px; justify-content:center; "
            >
        </div>

    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li class="">
                <a href="{{ route('admin_dashboard') }}">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:ai-brain-03" class="menu-icon"></iconify-icon>
                    <span>Wallet</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('create_wallet') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Add Wallet</a>
                    </li>
                    <li>
                        <a href="{{ route('wallet.index') }}"><i class="ri-circle-fill circle-icon text-warning-600 w-auto"></i> Wallet List</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Plans</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('create_plan') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Add Plan</a>
                    </li>
                    <li>
                        <a href="{{ route('plan.list') }}"><i class="ri-circle-fill circle-icon text-warning-600 w-auto"></i> Plan List</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                    <span>Users</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('user.index') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Users List</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:bitcoin-circle" class="menu-icon"></iconify-icon>
                    <span>Deposits
                        @if(isset($pendingDepositsCount) && $pendingDepositsCount > 0)
                            <span class="ml-1 inline-block bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full" style="background-color: red !important;">
                                {{ $pendingDepositsCount }}
                            </span>
                        @endif
                    </span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('admin.deposits.pending') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Pending deposits</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.deposits.approved') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Approved deposits</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:money-send-square" class="menu-icon"></iconify-icon>
                    <span>Withdrawals
                        @if(isset($pendingWithdrawalsCount) && $pendingWithdrawalsCount > 0)
                            <span class="ml-1 inline-block bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full" style="background-color: red !important;">
                                {{ $pendingWithdrawalsCount }}
                            </span>
                        @endif
                    </span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('withdrawals.pending')}}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Pending withdrawals</a>
                    </li>
                    <li>
                        <a href="{{route('admin.withdrawals.approved')}}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Approved withdrawals</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="icon-park-outline:setting-two" class="menu-icon"></iconify-icon>
                    <span>Settings</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        @if(Route::has('admin.profile'))
                            <a href="{{ route('admin.profile') }}">
                                <i class="ri-circle-fill circle-icon text-info-600 w-auto"></i>
                                Profile
                            </a>
                        @else
                            <a href="#" onclick="alert('Profile page not available')">
                                <i class="ri-circle-fill circle-icon text-info-600 w-auto"></i>
                                Profile
                            </a>
                        @endif
                    </li>
             <li>
                                        <a class="text-black px-0 py-2 hover:text-danger-600 flex items-center gap-4" href="{{ route('signout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon> Log Out</a>
                                    </li>
                                    <form action="{{ route('signout') }}" method="post" class="d-none" id="logout-form">@csrf</form>

                </ul>
            </li>
        </ul>
    </div>
</aside>
