@extends('layout.admin')
@section('content')


<div class="dashboard-main-body">

    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
        <h6 class="font-semibold mb-0 ">Approved Deposit</h6>
        <ul class="flex items-center gap-[6px]">
            <li class="font-medium">
                <a href="{{route('admin_dashboard')}}" class="flex items-center gap-2 hover:text-primary-600 ">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li >-</li>
            <li class="font-medium "> deposits</li>
        </ul>
    </div>

    <div class="grid grid-cols-1 2xl:grid-cols-12 gap-6">

        <!-- ================== Third Row Cards Start ======================= -->
        <div class="col-span-12 ">
            <div class="card border-0 h-full">
                <div class="card-header">
                    <div class="flex items-center flex-wrap gap-2 justify-between">
                        <h6 class="font-bold text-lg mb-0">approved deposit</h6>
                    </div>
                </div>
                <div class="card-body p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-[900px] w-full table bordered-table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Plan</th>
                                    <th>Proof</th>
                                    <th style="background-color: #0C3A30; color:aliceblue;">Country</th>
                                    <th>Amount Deposited ($)</th>
                                    <th>Payment Method</th>
                                    <th>Date Approved</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deposits as $deposit)
                                <tr>
                                    <td>
                                        <span class="text-neutral-600">{{ $loop->iteration }}</span>
                                    </td>
                                    <td>
                                        <span class="text-neutral-600">{{ $deposit->user->name }}</span>
                                    </td>
                                    <td>
                                        <span class="text-neutral-600">
                                            {{ $deposit->user->email }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-neutral-600">
                                            {{ $deposit->plan->name }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($deposit->proof)
                                        @php
                                        $proofUrl = file_exists(public_path('storage/' . $deposit->proof))
                                        ? asset('storage/' . $deposit->proof)
                                        : asset('uploads/' . $deposit->proof);
                                        @endphp

                                        <img
                                            src="{{ $proofUrl }}"
                                            alt="Proof"
                                            style="width: 60px; height: 60px; cursor: pointer;"
                                            onclick="openModal('{{ $proofUrl }}')">
                                        @else
                                        <span class="text-gray-400">No proof</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-neutral-600">
                                            {{ $deposit->user->country }}
                                        </span>
                                    </td>
                                    <td><span class="text-neutral-600">${{ number_format($deposit->amount_deposited, 2) }}</span></td>

                                    <td class="text-neutral-600">({{ $deposit->wallet->crypto_name }}) <br> {{ $deposit->wallet->wallet_address }}</td>

                                    <td>
                                        <span class="text-neutral-600">{{ $deposit->updated_at->format('d M, Y') }}</span>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- ================== Third Row Cards End ======================= -->

    </div>

</div>
<!-- Modal viewer -->
<div id="imageModal"
    class="fixed inset-0 bg-black bg-opacity-80 z-50 hidden items-center justify-center p-4"
    onclick="closeModal()">
    <img id="modalImage"
        class="max-w-full max-h-full rounded-lg shadow-lg object-contain"
        onclick="event.stopPropagation();">
</div>

<script>
    function openModal(imageUrl) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageUrl;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
<style></style>
@endsection


<!--  -->