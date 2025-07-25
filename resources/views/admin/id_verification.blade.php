
@extends('layout.admin')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">ID Verification Requests</h2>


<div class="overflow-x-auto rounded-lg shadow mt-6">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="px-4 py-2 text-left font-semibold">User</th>
                <th class="px-4 py-2 text-left font-semibold">Country</th>
                <th class="px-4 py-2 text-left font-semibold">Status</th>
                <th class="px-4 py-2 text-left font-semibold">Document</th>
                <th class="px-4 py-2 text-left font-semibold">Selfie</th>
                <th class="px-4 py-2 text-left font-semibold">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($verifications as $ver)
                <tr>
                    <td class="px-4 py-2">{{ $ver->user->name }}</td>
                    <td class="px-4 py-2">{{ $ver->country }}</td>
                    <td class="px-4 py-2 capitalize">{{ $ver->status }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ asset('storage/' . $ver->document) }}" target="_blank" class="text-blue-600 hover:underline">
                            View Document
                        </a>
                    </td>
                    <td class="px-4 py-2">
                        @if($ver->selfie)
                            <a href="{{ asset('storage/' . $ver->selfie) }}" target="_blank" class="text-blue-600 hover:underline">
                                View Selfie
                            </a>
                        @else
                            <span class="text-gray-500">None</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        @if($ver->status === 'pending')
                            <div class="flex items-center gap-3">
                                <form action="{{ route('admin.verifications.approve', $ver->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:underline">Approve</button>
                                </form>
                                <form action="{{ route('admin.verifications.reject', $ver->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:underline">Reject</button>
                                </form>
                            </div>
                        @else
                            <span class="text-gray-500">No Action</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection