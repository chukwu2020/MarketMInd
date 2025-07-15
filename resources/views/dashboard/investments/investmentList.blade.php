@extends('layout.user')

@section('content')


<div class=" container mx-auto px-4 py-10" style="background-image: url(assets/images/hero/hero-image-1.svg); margin-bottom:2rem " >



     <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
        <h5 class="font-semibold mb-0  " style="color: #0C3A30; padding-right:0.8rem;">Withdrawn </h5>
        <ul class="flex items-center gap-[6px]">
            <li class="font-medium">
                <a href="{{ route('user_dashboard') }}" class="flex items-center gap-2 hover:text-primary-600 dark:text-white" onmouseover="this.style.backgroundColor='transparent'; this.style.color='#9EDD05';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#0C3A30';">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li class="dark:text-white">-</li>
            <li class="font-medium dark:text-white">Investments</li>
        </ul>
    </div>
   
<div class="mb-6"  >
    {{-- Return Link --}}
    <div class="flex justify-end">
        <a href="{{ route('user.investments') }}" class="inline-flex items-center gap-1 text-sm hover:underline" style="color: #0C3A30;">
            <iconify-icon icon="solar:arrow-left-linear" class="text-lg"></iconify-icon>
            Return Back 
        </a>
    </div>
</div>

@if($withdrawnInvestments->isEmpty())
    <p class="text-center" style="color: #0C3A30;">No withdrawn investments yet.</p>
@else
    <div class="space-y-6" style="background-image: url(assets/images/hero/hero-image-1.svg); "  >
        @foreach($withdrawnInvestments as $investment)
            <div class="border border-gray-200 rounded-2xl shadow p-6" style="border-top: 4px solid #9EDD05;"style="background-image: url(assets/images/hero/hero-image-1.svg); " >
                <h3 class="text-xl font-semibold mb-2 text-center" style="color: #0C3A30;">
                    {{ $investment->plan->name ?? 'N/A' }}
                </h3>
                <p class="text-center text-sm mb-4" style="color: #0C3A30;">
                    {{ $investment->updated_at->format('d M, Y') }}
                </p>

                {{-- Table Format Inside Card --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border border-gray-200">
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <th class="px-4 py-2 font-medium" style="color: #0C3A30;">Amount</th>
                                <td class="px-4 py-2 font-medium" style="color: #0C3A30;">${{ number_format($investment->amount_invested) }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <th class="px-4 py-2 font-medium" style="color: #0C3A30;">Profit</th>
                                <td class="px-4 py-2 font-medium text-emerald-600">${{ number_format($investment->total_profit, 2) }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <th class="px-4 py-2 font-medium" style="color: #0C3A30;">Total</th>
                                <td class="px-4 py-2 font-semibold" style="color: #0C3A30;">${{ number_format($investment->amount_invested + $investment->total_profit, 2) }}</td>
                            </tr>
                            <tr>
                                <th class="px-4 py-2 font-medium" style="color: #0C3A30;">Status</th>
                                <td class="px-4 py-2 font-semibold" style="color: #0C3A30;">{{ $investment->status }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>


@endif
</div>
@endsection
