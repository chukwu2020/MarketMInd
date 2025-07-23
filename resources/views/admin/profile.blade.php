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
            <li>-</li>
            <li class="font-medium ">View Profile</li>
        </ul>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Profile Card -->
        <div class="col-span-12 lg:col-span-4 bg-[url('assets/images/hero/hero-image-1.svg')] bg-cover bg-center h-full">
             <div class="text-center border-b pb-6 border-gray-300">
                    @php
                    $profilePic = $user->profile->profile_pic ?? null;

                    $initials = collect(explode(' ', $user->name))
                    ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                    ->take(2)
                    ->join('') ?: 'U';
                    @endphp

                    @if ($profilePic && file_exists(public_path('storage/profile_pics/' . $profilePic)))
                    <img src="{{ asset('storage/profile_pics/' . $profilePic) }}"
                        alt="{{ $user->name }}"
                        class="rounded-full object-cover"
                        style="width: 7rem; height: 7rem; border: 2px solid #8bc905;" />
                    @else
                    <div
                        class="mx-auto rounded-full flex items-center justify-center font-semibold text-3xl select-none"
                        style="width: 8rem; height: 8rem; background-color: #9EDD05; color: #0C3A30;">
                        {{ $initials }}
                    </div>
                    @endif
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