@extends('layout.user')

@section('content')

<div class="max-w-2xl mx-auto mt-10 bg-white shadow-lg p-6 rounded-xl"  style="background-image: url(assets/images/hero/hero-image-1.svg); background-repeat: repeat; background-size: cover; background-position: center; max-height:100vh;" >
    <h2 class="text-xl font-bold mb-4"> 🛡️ Verify Your Identity</h2>

    @if(session('success'))
        <div class="p-3 bg-green-100 text-green-800 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form action="{{ route('user.kyc.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block mb-2 font-medium">Upload Government ID / Passport</label>
            <input type="file" name="id_document" required class="w-full border p-2 rounded">
            @error('id_document') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-medium">Upload Sefie Of Yourself</label>
            <input type="file" name="utility_bill" required class="w-full border p-2 rounded">
            @error('sefie') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-center mt-6">
    <div class="flex justify-center mt-6">
 <div class="flex justify-center mt-6">
    <button
        type="submit"
        id="kycSubmitBtn"
        class="px-6 py-3 rounded font-semibold shadow-lg flex items-center justify-center gap-2 transition-all duration-300"
        style="background-color: #9EDD05; color: #0C3A30;"
        onclick="handleKycSubmit(this)"
    >
        <span>Submit KYC</span>
        <svg id="spinner" class="w-5 h-5 animate-spin hidden text-[#0C3A30]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 018 8h-4l3 3 3-3h-4a8 8 0 01-8 8v-4l-3 3 3 3v-4a8 8 0 01-8-8z"/>
        </svg>
    </button>
</div>

<script>
    function handleKycSubmit(btn) {
        btn.disabled = true;
        btn.style.backgroundColor = '#cccccc'; // new grayish bg
        btn.querySelector('span').innerText = 'Submitting...';
        btn.querySelector('#spinner').classList.remove('hidden');
        btn.form.submit();
    }
</script>

</div>

</div>

    </form>
</div>
</div>

@endsection
