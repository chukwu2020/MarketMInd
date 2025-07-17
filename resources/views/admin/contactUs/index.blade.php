@extends('layout.admin')

@section('content')

 <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
        <h6 class="font-semibold mb-0 dark:text-white">User Messages</h6>
        <ul class="flex items-center gap-[6px]">
            <li class="font-medium">
                <a href="{{route('admin_dashboard')}}" class="flex items-center gap-2 hover:text-primary-600 dark:text-white">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li class="dark:text-white">-</li>
            <li class="font-medium dark:text-white">message</li>
        </ul>
    </div>

<div class="p-4 max-w-full">
    <h2 class="text-2xl font-bold mb-6">All Messages</h2>

    <!-- Desktop & Tablet: Table -->
    <div class="hidden md:block overflow-x-auto border rounded bg-white shadow">
        <table class="min-w-full border-collapse border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left border border-gray-300">Name</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Email</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Phone</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Subject</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Message</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Sent</th>
                    <th class="px-4 py-2 text-left border border-gray-300">Actions</th> <!-- New -->
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                    <tr class="border-t border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-2 border border-gray-300">{{ $msg->name }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $msg->email }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $msg->phone }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $msg->subject }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $msg->message }}</td>
                        <td class="px-4 py-2 border border-gray-300 text-sm text-gray-500">{{ $msg->created_at->diffForHumans() }}</td>
                        <td class="px-4 py-2 border border-gray-300">
                            <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500">No messages yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile: Stacked cards -->
    <div class="block md:hidden space-y-4">
        @forelse($messages as $msg)
            <div class="bg-white border border-gray-300 rounded-lg p-4 shadow">
                <p><strong>Name:</strong> {{ $msg->name }}</p>
                <p><strong>Email:</strong> {{ $msg->email }}</p>
                <p><strong>Phone:</strong> {{ $msg->phone }}</p>
                <p><strong>Subject:</strong> {{ $msg->subject }}</p>
                <p><strong>Message:</strong> {{ $msg->message }}</p>
                <p class="text-sm text-gray-500"><strong>Sent:</strong> {{ $msg->created_at->diffForHumans() }}</p>

                <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" class="mt-3" onsubmit="return confirm('Are you sure you want to delete this message?');">
                    @csrf
                    @method('DELETE')
                    <button  type="submit"  class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 rounded-lg font-semibold shadow-md transition">Delete</button>
                </form>
            </div>
        @empty
            <p class="text-center text-gray-500">No messages yet.</p>
        @endforelse
    </div>
</div>
@endsection
