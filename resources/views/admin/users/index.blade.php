@extends('layout.admin')

@section('content')

<div class="dashboard-main-body">
    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
        <h6 class="font-semibold mb-0 dark:text-white">Users List</h6>
        <ul class="flex items-center gap-[6px]">
            <li class="font-medium">
                <a href="{{route('admin_dashboard')}}" class="flex items-center gap-2 hover:text-primary-600 dark:text-white">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li class="dark:text-white">-</li>
            <li class="font-medium dark:text-white">Users List</li>
        </ul>
    </div>

    <div class="grid grid-cols-12">
        <div class="col-span-12">
            <div class="card h-full p-0 rounded-xl border-0 overflow-hidden">
                <div class="card-header border-b border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-700 py-4 px-6 flex items-center flex-wrap gap-3 justify-between">


                </div>

                <div class="card-body p-6">
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table sm-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Profile</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Join Date</th>
                                    <!-- <th scope="col">Card PIN</th> -->
                                    <th scope="col"> Amount Invested</th>
                                    <th scope="col"> Available balance</th>



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
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td>${{ number_format($user->total_invested, 2) }}</td>


                                    <td>${{ number_format($user->total_income, 2) }}</td>

                                    <td class="text-center">
                                        @if ($user->active == 1)
                                        <span class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 border border-success-600 px-6 py-1.5 rounded font-medium text-sm">Active</span>
                                        @else
                                        <span class="bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 border border-danger-600 px-6 py-1.5 rounded font-medium text-sm">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="flex items-center gap-3 justify-center">
                                            <a href="{{ route('user.edit', $user->id) }}">
                                                <button type="button" class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 hover:bg-success-200 font-medium w-10 h-10 flex justify-center items-center rounded-full">
                                                    <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                </button>
                                            </a>
                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="remove-item-btn bg-danger-100 dark:bg-danger-600/25 hover:bg-danger-200 text-danger-600 dark:text-danger-500 font-medium w-10 h-10 flex justify-center items-center rounded-full">
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

@endsection