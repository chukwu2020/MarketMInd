<style>
    .sidebar-submenu li a {
        display: block;
        padding: 8px 16px;
        background-color: #f2fef0;
        color: #0C3A30 !important;
        font-size: 16px;
        text-decoration: none;
        border-radius: 4px;
        transition: all 0.2s ease;
    }

    .sidebar-submenu li a:hover,
    .sidebar-submenu li a:focus,
    .active-sub-link {
        background-color: #9EDD05;
        font-weight: 500;
        color: #0C3A30 !important;
    }
</style>

<aside class="w-64 bg-white text-[#0C3A30] shadow-lg h-screen fixed top-0 left-0 z-50 overflow-y-auto">
    <div class="p-4 border-b border-gray-200">
        <h2 class="text-xl font-bold text-[#0C3A30]">Dashboard</h2>
    </div>

    <nav class="p-4">
        <ul class="space-y-2">
            <!-- Home -->
            <li>
                <a href="" class="block px-4 py-2 rounded hover:bg-[#9EDD05] transition">
                    Home
                </a>
            </li>

            <!-- Deposits Dropdown -->
            <li x-data="{ open: false }">
                <button @click="open = !open"
                        class="w-full flex justify-between items-center px-4 py-2 rounded hover:bg-[#9EDD05] transition">
                    <span>Deposits</span>
                    <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transition-transform"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <ul x-show="open" class="sidebar-submenu ml-4 mt-2 space-y-1" x-cloak>
                    <li><a href="{{ route('user.deposit') }}">Deposit Now</a></li>
                    <li><a href="{{ route('user.pending.deposits') }}">Pending Deposits</a></li>
                    <li><a href="{{ route('user.deposits') }}">Deposit List</a></li>
                </ul>
            </li>

            <!-- Withdrawals Dropdown -->
            <li x-data="{ open: false }">
                <button @click="open = !open"
                        class="w-full flex justify-between items-center px-4 py-2 rounded hover:bg-[#9EDD05] transition">
                    <span>Withdrawals</span>
                    <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transition-transform"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <ul x-show="open" class="sidebar-submenu ml-4 mt-2 space-y-1" x-cloak>
                    <li><a href="{{ route('user.pending.withdrawals') }}">Pending Withdrawals</a></li>
                    <li><a href="{{ route('user.withdrawals') }}">Withdrawal List</a></li>
                </ul>
            </li>

            <!-- Profile -->
            <li>
                <a href="{{ route('user.profile') }}" class="block px-4 py-2 rounded hover:bg-[#9EDD05] transition">
                    Profile
                </a>
            </li>

            <!-- Logout -->
            <li>
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white transition">
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>

<!-- Alpine.js for dropdowns -->
<script src="//unpkg.com/alpinejs" defer></script>
