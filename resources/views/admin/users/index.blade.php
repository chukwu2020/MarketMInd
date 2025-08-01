@extends('layout.admin')

@section('content')

<div class="dashboard-main-body">
    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
        <h6 class="font-semibold mb-0 ">Users List</h6>
        <ul class="flex items-center gap-[6px]">
            <li class="font-medium">
                <a href="{{route('admin_dashboard')}}" class="flex items-center gap-2 hover:text-primary-600 ">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li >-</li>
            <li class="font-medium ">Users List</li>
        </ul>
    </div>

    <div class="grid grid-cols-12">
        <div class="col-span-12">
            <div class="card h-full p-0 rounded-xl border-0 overflow-hidden" style="background: #fff !important;">
                <div class="card-header border-b border-neutral-200 bg-white py-4 px-6 flex items-center flex-wrap gap-3 justify-between">


                </div>

                <div class="card-body p-6">
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table sm-table mb-0">
                            <thead style="background: #fff !important;">
                                <tr style="background-color: #fff !important; color:aliceblue;">
                                    <th scope="col"style="background-color: #0C3A30; color:aliceblue;">Profile</th>
                                    <th scope="col" style="background-color: #0C3A30; color:aliceblue;">Name</th>
                                      <th scope="col" style="background-color: #0C3A30; color:aliceblue;">Phone</th>
                                        <th style="background-color: #0C3A30; color:aliceblue;">Country</th>
                                    <th scope="col"style="background-color: #0C3A30; color:aliceblue;">Email</th>
                                    <th scope="col" style="background-color: #0C3A30; color:aliceblue;">Join Date</th>
                                    <!-- <th scope="col">Card PIN</th> -->
                                    <th scope="col"style="background-color: #0C3A30; color:aliceblue;"> Amount Invested</th>
                                    <th scope="col"style="background-color: #0C3A30; color:aliceblue;"> Available balance</th>



                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>
                                        @php
                                        $profilePic = $user->profile->profile_pic ?? null;
                                        $hasProfilePic = $profilePic && file_exists(public_path('uploads/' . $profilePic));

                                        // Get initials from user name, fallback "U"
                                        $initials = collect(explode(' ', $user->name))
                                        ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                        ->take(2)
                                        ->join('') ?: 'U';
                                        @endphp

                                        @if ($hasProfilePic)
                                        <img src="{{ asset('uploads/' . $profilePic) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover" />
                                        @else
                                        <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold text-sm select-none">
                                            {{ $initials }}
                                        </div>
                                        @endif

                                    </td>

                                    <td>{{ $user->name }}</td>
                                     <td>{{ $user->phone }}</td>
                                      <td>{{ $user->country }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td>${{ number_format($user->total_invested, 2) }}</td>

 

                                    <td>${{ number_format($user->total_income, 2) }}</td>

                                    <td class="text-center">
                                        @if ($user->active == 1)
                                        <span class="bg-success-100 text-success-600border border-success-600 px-6 py-1.5 rounded font-medium text-sm">Active</span>
                                        @else
                                        <span class="bg-danger-100  text-danger-600  border border-danger-600 px-6 py-1.5 rounded font-medium text-sm">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="flex items-center gap-3 justify-center">
                                            <a href="{{ route('user.edit', $user->id) }}">
                                                <button type="button" class="bg-success-100 text-success-600 hover:bg-success-200 font-medium w-10 h-10 flex justify-center items-center rounded-full">
                                                    <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                </button>
                                            </a>
                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="remove-item-btn bg-danger-100  hover:bg-danger-200 text-danger-600font-medium w-10 h-10 flex justify-center items-center rounded-full">
                                                    <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                                </button>
                                            </form>



                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style></style>
@endsection