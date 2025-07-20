@php

$user = auth()->user();

@endphp

<div class="navbar-header fixed top-0 left-0 right-0 z-50 w-full bg-white shadow-md">



    <div class="flex items-center justify-between">
        <div class="col-auto">
            <div class="flex flex-wrap items-center gap-[16px]">
                <!-- <button type="button" class="sidebar-toggle">
                    <iconify-icon icon="heroicons:bars-3-solid" class="icon non-active"></iconify-icon>
                    <iconify-icon icon="iconoir:arrow-right" class="icon active"></iconify-icon>
                </button> -->
                <button type="button" class="sidebar-mobile-toggle">
                    <iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
                </button>

                    <h1 class="text-lg font-semibold text-neutral-900">
                    Welcome <span class="wave-hand">👋</span> {{ auth()->user()->name ?? 'Guest' }}
                </h1>

                <!-- <span class="max-w-[244px] w-full p-6 h-3 bg-red-600 text-white flex items-center justify-center rounded-[50px]">tesdgxt</span> -->

            </div>
        </div>
        <div class="col-auto">
            <div class="flex flex-wrap items-center gap-3">



        <button data-dropdown-toggle="dropdownProfile" class="rounded-full overflow-hidden w-10 h-10 focus:outline-none border-2 border-transparent hover:border-primary-500 transition">
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
        <img src="{{ asset('storage/' . $profilePic) }}"
            alt="{{ $user->name }}"
            class="mx-auto rounded-full object-cover w-10 h-10" />
    @else
        <div class="w-10 h-10 rounded-full flex items-center justify-center font-semibold text-sm select-none bg-[#9EDD05] text-[#0C3A30]">
            {{ $initials }}
        </div>
    @endif
</button>

                <div id="dropdownProfile" class="z-10 hidden bg-white dark:bg-neutral-700 rounded-lg shadow-lg dropdown-menu-sm p-3">
                    <div class="py-3 px-4 rounded-lg bg-primary-50 dark:bg-primary-600/25 mb-4 flex items-center justify-between gap-2">







                        <div class="max-h-[400px] overflow-y-auto scroll-sm pe-2">
                            <ul class="flex flex-col">
                                <li">
                                    <a class="text-black px-0 py-2 hover:text-primary-600 flex items-center gap-4" href="{{route('admin.profile')}}">
                                        <iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon> My Profile</a>
                                    </li>


                                    <li>
                                        <a class="text-black px-0 py-2 hover:text-danger-600 flex items-center gap-4" href="{{ route('signout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon> Log Out</a>
                                    </li>
                                    <form action="{{ route('signout') }}" method="post" class="d-none" id="logout-form">@csrf</form>
                            </ul>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    </div>