@extends('layout.admin')
@section('content')

<div class="dashboard-main-body">
    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
        <h6 class="font-semibold mb-0 ">Add Plan</h6>
        <ul class="flex items-center gap-[6px]">
            <li class="font-medium">
                <a href="{{route('admin_dashboard')}}" class="flex items-center gap-2 hover:text-primary-600 ">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="font-medium ">Add Plan</li>
        </ul>
    </div>

    <div class="card h-full rounded-xl overflow-hidden border-0">
        <div class="card-body p-10">
            <form action="{{ route('plans.store') }}" method="POST">
                @csrf
                <div class="grid md:grid-cols-2 gap-x-5">
                    <div class="mb-5">
                        <label for="firebaseSecretKey" class="text-sm font-semibold mb-2 block text-neutral-900 ">Plan Name</label>
                        <input type="text" class="form-control rounded-lg" name="name" placeholder="Plan Name" value="{{ old('name') }}">
                        <span class="text-danger">@error ('name') {{ $message }} @enderror</span>
                    </div>

                    <div class="mb-5">
                        <label for="firebaseSecretKey" class="text-sm font-semibold mb-2 block text-neutral-900 ">Duration (days)</label>
                        <input type="number" class="form-control rounded-lg" name="duration" placeholder="Duration" value="{{ old('duration') }}">
                        <span class="text-red">@error ('duration') {{ $message }} @enderror</span>
                    </div>

                    <div class="mb-5">
                        <label for="firebasePublicVapidKey" class="text-sm font-semibold mb-2 block text-neutral-900 ">Minimum Amount</label>
                        <input type="number" name="minimum_amount" class="form-control rounded-lg" placeholder="Minimum Amount" value="{{ old('minimum_amount') }}">
                        <span class="text-red">@error ('minimum_amount') {{ $message }} @enderror</span>
                    </div>
                    <div class="mb-5">
                        <label for="firebasePublicVapidKey" class="text-sm font-semibold mb-2 block text-neutral-900 ">Maximum Amount</label>
                        <input type="number" name="maximum_amount" class="form-control rounded-lg" placeholder="Maximum Amount" value="{{ old('maximum_amount') }}">
                        <span class="text-red">@error ('maximum_amount') {{ $message }} @enderror</span>
                    </div>
                    <div class="mb-2">
                        <label for="firebaseAuthDomain" class="text-sm font-semibold mb-2 block text-neutral-900 ">Interest Rate (%)</label>
                        <input type="number" name="interest_rate" class="form-control rounded-lg" placeholder="Interest Rate" value="{{ old('interest_rate') }}">
                        <span class="text-red">@error ('interest_rate') {{ $message }} @enderror</span>
                    </div>
                    <div class="form-group mb-2">
                        <label for="firebaseProjectID" class="text-sm font-semibold mb-2 block text-neutral-900 ">Status</label>
                        <select name="status" class="form-control rounded-lg">
                            <option selected disabled>Select Status</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <span class="text-red">@error ('status') {{ $message }} @enderror</span>
                    </div>

                    <div class="flex items-center justify-center gap-3 mt-6 col-span-2">
                        <button type="reset" class="border border-danger-600 hover:bg-danger-200 text-danger-600 text-base px-10 py-[11px] rounded-lg">
                            Reset
                        </button>
                        <button type="submit" class="btn btn-primary border border-primary-600 text-base px-6 py-3 rounded-lg">
                            Save Plan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection