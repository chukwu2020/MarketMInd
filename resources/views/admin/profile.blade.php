@extends('layout.admin')

@section('content')
<div class="dashboard-main-body">
    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
        <h6 class="font-semibold mb-0 text-[#0C3A30]">My Profile</h6>
        <ul class="flex items-center gap-[6px]">
            <li class="font-medium">
                <a href="{{ route('admin_dashboard') }}" class="flex items-center gap-2 hover-text">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li >-</li>
            <li class="font-medium ">View Profile</li>
        </ul>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Profile Card -->
        <div class="col-span-12 lg:col-span-4 bg-[url('assets/images/hero/hero-image-1.svg')] bg-cover bg-center h-full">
            <div class="user-grid-card relative rounded-2xl overflow-hidden bg-whiteh-full bg-opacity-80">
                <div class="pb-6 px-6 pt-[20px]">
                    <div class="text-center border-b border-neutral-200 py-6">

                        @php
                        $profilePic = $user->profile->profile_pic ?? null;

                        $hasProfilePic = $profilePic && file_exists(storage_path('app/public/profile_pictures/' . $profilePic));


                        // Get initials from user name, fallback "U"
                        $initials = collect(explode(' ', $user->name))
                        ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                        ->take(2)
                        ->join('') ?: 'U';
                        @endphp

                        @if ($hasProfilePic)
                        <img loading="lazy"
                            src="{{ asset('storage/profile_pictures/' . $profilePic) }}"
                            alt="{{ $user->name }}"
                            class="mx-auto rounded-full object-cover"
                            style="width: 7rem; height: 7rem;" />
                        @else
                        <div class="mx-auto  rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold text-3xl select-none" style="background-color: #9EDD05; color:#0C3A30; width:8rem; height: 8rem;
border-radius:50%">
                            {{ $initials }}
                        </div>
                        @endif

                        <h6 class="mb-0 mt-4 text-[#0C3A30]">{{ $user->name }}</h6>
                        <span class="text-secondary-light mb-4">{{ $user->email }}</span>
                    </div>


                    <div class="mt-6">
                        <h6 class="text-xl mb-4 text-[#0C3A30]">Personal Info</h6>
                        <ul>
                            <li class="flex items-center gap-1 mb-3">
                                <span class="w-[30%] font-semibold text-neutral-600">Full Name</span>
                                <span class="w-[70%] text-secondary-light font-medium">: {{ $user->name }}</span>
                            </li>
                            <li class="flex items-center gap-1 mb-3">
                                <span class="w-[30%] font-semibold text-neutral-600 ">Email</span>
                                <span class="w-[70%] text-secondary-light font-medium">: {{ $user->email }}</span>
                            </li>
                            <li class="flex items-center gap-1 mb-3">
                                <span class="w-[30%] font-semibold text-neutral-600 ">Phone</span>
                                <span class="w-[70%] text-secondary-light font-medium">: {{ $user->phone }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Profile Form -->
        <div class="col-span-12 lg:col-span-8">
            <div class="card h-full border-0">
                <div class="card-body p-6">
                    <ul class="tab-style-gradient flex flex-wrap text-sm font-medium text-center mb-5" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                        <li role="presentation" class="mr-2">
                            <button class="py-2.5 px-4 font-semibold text-base inline-flex items-center gap-3 border-t-4 rounded-t-lg"
                                id="edit-profile-tab" data-tabs-target="#edit-profile" type="button" role="tab" aria-controls="edit-profile" aria-selected="true">
                                Edit Profile
                            </button>
                        </li>
                    </ul>

                    <div id="default-tab-content">
                        <div id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">
                            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- Profile Image -->
                                <h6 class="text-base text-neutral-600 mb-4">Profile Image</h6>
                                <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6">
                                    <div class="col-span-12 sm:col-span-6 mb-5">
                                        <input type="file" name="profile_pic" id="profile_pic" class="form-control rounded-lg custom-input" />
                                    </div>
                                </div>

                                <!-- Name / Email / Phone / Address -->
                                <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6">
                                    <div class="col-span-12 sm:col-span-6 mb-5">
                                        <label for="name" class="block font-semibold text-neutral-600  text-sm mb-2">
                                            Full Name <span class="text-danger-600">*</span>
                                        </label>
                                        <input type="text" name="name" id="name" placeholder="Enter Full Name"
                                            value="{{ old('name', $user->name ?? '') }}"
                                            class="form-control rounded-lg custom-input" />
                                    </div>

                                    <div class="col-span-12 sm:col-span-6 mb-5">
                                        <label for="email" class="block font-semibold text-neutral-600  text-sm mb-2">
                                            Email <span class="text-danger-600">*</span>
                                        </label>
                                        <input type="email" name="email" id="email" readonly placeholder="Enter email address"
                                            value="{{ old('email', $user->email ?? '') }}"
                                            class="form-control rounded-lg custom-input bg-gray-100 cursor-not-allowed" />
                                    </div>

                                    <div class="col-span-12 sm:col-span-6 mb-5">
                                        <label for="phone" class="block font-semibold text-neutral-600  text-sm mb-2">
                                            Phone
                                        </label>
                                        <input type="text" name="phone" id="phone" placeholder="Enter phone number"
                                            value="{{ old('phone', $user->phone ?? '') }}"
                                            class="form-control rounded-lg custom-input" />
                                    </div>

                                    <div class="col-span-12 sm:col-span-6 mb-5">
                                        <label for="address" class="block font-semibold text-neutral-600  text-sm mb-2">
                                            Address
                                        </label>
                                        <input type="text" name="address" id="address" placeholder="Enter your address"
                                            value="{{ old('address', $user->profile->address ?? '') }}"
                                            class="form-control rounded-lg custom-input" />
                                    </div>
                                </div>



                                <!-- Submit -->
                                <button type="submit"
                                    class="btn btn-sm rounded-full mt-5 px-10 py-3 font-semibold text-white"
                                    style="background-color: blue;">
                                    Update Profile
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection