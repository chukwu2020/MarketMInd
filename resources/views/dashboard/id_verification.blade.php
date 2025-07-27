@extends('layout.user')

@section('content')
<div class="min-h-screen" style="background-image: url('assets/images/hero/hero-image-1.svg'); background-size: cover; background-position: center;">
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Glassmorphism Card -->
        <div class="backdrop-blur-lg bg-white/80 shadow-xl rounded-xl overflow-hidden border border-white/20">
            <!-- Header with subtle gradient overlay -->
            <div class="relative bg-gradient-to-r from-blue-700/90 to-blue-900/90 px-8 py-10 text-center">
                <div class="absolute inset-0 opacity-20" style="background-image: url('assets/images/patterns/circuit-board.svg');"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold text-white tracking-tight">Identity Verification</h2>
                    <p class="mt-2 text-blue-100 font-medium">Complete verification to unlock full account access</p>
                    <div class="mt-4 flex justify-center">
                        <div class="h-1 w-16 bg-blue-300 rounded-full opacity-80"></div>
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div class="px-8 py-8">
                <!-- Status Messages -->
                @if(session('success'))
                <div class="mb-6 p-4 rounded-lg bg-emerald-50/90 border border-emerald-200 shadow-sm">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="ml-3 text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-50/90 border border-red-200 shadow-sm">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div class="ml-3">
                            @foreach ($errors->all() as $error)
                            <p class="text-sm font-medium text-red-800">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <form id="verificationForm" action="{{ route('id.verification.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Country Selection -->
                    <div class="space-y-2">
                        <label for="country" class="block text-sm font-medium text-gray-700">Country of Issuance</label>
                        <div class="relative">
                            <select name="country" id="country" class="block w-full pl-3 pr-10 py-2.5 text-base border border-gray-300/80 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 rounded-lg bg-white/90 backdrop-blur-sm transition-all duration-200 appearance-none"  style="border: 2px solid #9EDD05 !important;">
                                <option value="">Select your country</option>
                                @foreach([
                                   'United States', 'Canada', 'United Kingdom', 'Australia', 
    'Germany', 'France', 'Japan', 'China', 'India', 'Brazil',
    'Afghanistan', 'Albania', 'Algeria', 'Andorra', 'Angola',
    'Argentina', 'Armenia', 'Austria', 'Azerbaijan', 'Bahamas',
    'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium',
    'Belize', 'Benin', 'Bhutan', 'Bolivia', 'Bosnia and Herzegovina',
    'Botswana', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambodia',
    'Cameroon', 'Chile', 'Colombia', 'Costa Rica', 'Croatia',
    'Cuba', 'Cyprus', 'Czech Republic', 'Denmark', 'Dominican Republic',
    'Ecuador', 'Egypt', 'El Salvador', 'Estonia', 'Ethiopia',
    'Finland', 'Gabon', 'Gambia', 'Ghana', 'Greece',
    'Guatemala', 'Honduras', 'Hungary', 'Iceland', 'Indonesia',
    'Iran', 'Iraq', 'Ireland', 'Israel', 'Italy',
    'Jamaica', 'Jordan', 'Kenya', 'Kuwait', 'Laos',
    'Latvia', 'Lebanon', 'Liberia', 'Libya', 'Lithuania',
    'Luxembourg', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives',
    'Mali', 'Malta', 'Mexico', 'Monaco', 'Mongolia',
    'Morocco', 'Mozambique', 'Myanmar', 'Namibia', 'Nepal',
    'Netherlands', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria',
    'North Korea', 'Norway', 'Oman', 'Pakistan', 'Panama',
    'Paraguay', 'Peru', 'Philippines', 'Poland', 'Portugal',
    'Qatar', 'Romania', 'Russia', 'Rwanda', 'Saudi Arabia',
    'Senegal', 'Serbia', 'Singapore', 'Slovakia', 'Slovenia',
    'Somalia', 'South Africa', 'South Korea', 'Spain', 'Sri Lanka',
    'Sudan', 'Sweden', 'Switzerland', 'Syria', 'Taiwan',
    'Tanzania', 'Thailand', 'Tunisia', 'Turkey', 'Uganda',
    'Ukraine', 'United Arab Emirates', 'Uruguay', 'Uzbekistan', 'Venezuela',
    'Vietnam', 'Yemen', 'Zambia', 'Zimbabwe'
] as $country)
                                <option value="{{ $country }}">{{ $country }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- File Upload Sections -->
                    <div class="space-y-6">
                        <!-- ID Document Upload -->
                        <div class="space-y-2 mt-8" >
                            <label class="block text-sm font-medium text-gray-700" style="text-align: center;">
                                Government-Issued ID
                                <span class="text-xs font-normal text-gray-500">(Passport, Driver's License, etc.)</span>
                            </label>
                            <div class="mt-1">
                                <div class="relative group">
                                    <input id="document" name="document" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".jpg,.jpeg,.png,.pdf" required>
                                    <div class="flex items-center justify-between px-4 py-3 border border-gray-700/80 rounded-lg bg-white/90 backdrop-blur-sm group-hover:border-blue-400 transition-colors duration-200" style="border: 2px solid #9EDD05 !important;">
                                        <span class="text-sm text-gray-600 truncate">Choose file...</span>
                                        <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-full" style="border: 2px solid #9EDD05 !important ;">Browse</span>
                                    </div>
                                </div>
                               
                            </div>
                        </div>

                        <!-- Selfie Upload -->
                        <div class="space-y-2 mt-8">
                            <label class="block text-sm font-medium text-gray-700" style="text-align:center">
                                Selfie with ID
                                <span class="text-xs font-normal text-gray-500">(Clear photo holding your ID)</span>
                            </label>
                            <div class="mt-1">
                                <div class="relative group">
                                    <input id="selfie" name="selfie" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".jpg,.jpeg,.png" required >
                                    <div class="flex items-center justify-between px-4 py-3 border border-gray-700/80 rounded-lg bg-white/90 backdrop-blur-sm group-hover:border-blue-400 transition-colors duration-200"  style="border: 2px solid #9EDD05 !important;">
                                        <span class="text-sm text-gray-600 truncate">Choose file...</span>
                                        <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-full " style="border: 2px solid #9EDD05 !important ;">Browse</span>
                                    </div>
                                </div>
                           
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" id="submit-btn" class="w-full flex justify-center items-center py-3 px-4 rounded-lg shadow-sm text-base font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500/50 transition-all duration-200 group"  style="background-color: #9EDD05 !important ; color:#065f46 !important;">
                            <span id="submit-text">Verify Identity</span>
                            <span id="submit-spinner" class="hidden ml-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Enhanced file input display
    document.getElementById('document').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Choose file...';
        this.nextElementSibling.querySelector('span:first-child').textContent = fileName;
    });

    document.getElementById('selfie').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Choose file...';
        this.nextElementSibling.querySelector('span:first-child').textContent = fileName;
    });

    // Form submission handling
    document.getElementById('verificationForm').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submit-btn');
        const submitText = document.getElementById('submit-text');
        const submitSpinner = document.getElementById('submit-spinner');
        
        // Show loading state
        submitBtn.disabled = true;
        submitText.textContent = 'Verifying...';
        submitSpinner.classList.remove('hidden');
        
        // Validate required fields
        const documentInput = document.getElementById('document');
        const selfieInput = document.getElementById('selfie');
        const countrySelect = document.getElementById('country');
        
        if (!documentInput.files[0] || !selfieInput.files[0] || !countrySelect.value) {
            e.preventDefault();
            
            // Reset form state
            submitBtn.disabled = false;
            submitText.textContent = 'Verify Identity';
            submitSpinner.classList.add('hidden');
            
            // Show error alert
            const alert = document.createElement('div');
            alert.className = 'mb-6 p-4 rounded-lg bg-red-50/90 border border-red-200 shadow-sm animate-fade-in';
            alert.innerHTML = `
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <p class="ml-3 text-sm font-medium text-red-800">Please complete all required fields</p>
                </div>
            `;
            
            const form = document.querySelector('form');
            form.prepend(alert);
            
            // Remove alert after 5 seconds
            setTimeout(() => {
                alert.classList.add('opacity-0', 'transition-opacity', 'duration-300');
                setTimeout(() => alert.remove(), 300);
            }, 5000);
            
            return false;
        }
    });
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }
    select:focus {
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.25);
    }
</style>
@endsection