@extends('layout.user')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden" style="background-image: url(assets/images/hero/hero-image-1.svg);" >
            <!-- Header with techy background -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-8 text-center">
                <h2 class="text-3xl font-bold text-white">Identity Verification</h2>
                <p class="mt-2 text-blue-100">Complete your verification to access all features</p>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mx-6 mt-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->any()))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mx-6 mt-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            @foreach ($errors->all() as $error)
                                <p class="text-sm text-red-700">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <form id="verificationForm" action="{{ route('id.verification.store') }}" method="POST" enctype="multipart/form-data" class="px-6 py-8 space-y-6">
                @csrf

                <!-- Continent and Country Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="continent" class="block text-sm font-medium text-gray-700 mb-1">Select Continent</label>
                        <select name="continent" id="continent" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">-- Select Continent --</option>
                            <option value="Africa">Africa</option>
                            <option value="Asia">Asia</option>
                            <option value="Europe">Europe</option>
                            <option value="North America">North America</option>
                            <option value="South America">South America</option>
                            <option value="Oceania">Oceania</option>
                        </select>
                    </div>
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country of Issuance</label>
                        <select name="country" id="country" class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500" required disabled>
                            <option value="">-- Select Country --</option>
                        </select>
                    </div>
                </div>

                <!-- ID Document Upload -->
                <div>
                    <label class="block text-sm font-medium mt-5 text-gray-700 mb-2">Upload ID  (Passport, Driver's License, etc.)</label>
                    <div class="mt-1">
                        <input id="document" name="document" type="file" class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100" 
                            accept=".jpg,.jpeg,.png,.pdf" 
                            required>
                       
                    </div>
                </div>

                <!-- Selfie Upload -->
                <div>
                    <label class="block text-sm font-medium mt-8 text-gray-700 mb-2">Upload a clear selfie holding your ID</label>
                    <div class="mt-1">
                        <input id="selfie" name="selfie" type="file" class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100" 
                            accept=".jpg,.jpeg,.png" 
                            required>
                    
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" id="submit-btn" class="w-full flex  mt-6 justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150" style="background-color: #9EDD05 !important; color:#0C3A30 !important;">
                        <span id="submit-text">Submit Verification</span>
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

<script>
    // Country selection based on continent
    const continentSelect = document.getElementById('continent');
    const countrySelect = document.getElementById('country');
    
    const countriesByContinent = {
        'Africa': ['Algeria', 'Angola', 'Benin', 'Botswana', 'Burkina Faso', 'Burundi', 'Cabo Verde', 'Cameroon', 'Central African Republic', 'Chad', 'Comoros', 'Congo', 'Djibouti', 'Egypt', 'Equatorial Guinea', 'Eritrea', 'Eswatini', 'Ethiopia', 'Gabon', 'Gambia', 'Ghana', 'Guinea', 'Guinea-Bissau', 'Ivory Coast', 'Kenya', 'Lesotho', 'Liberia', 'Libya', 'Madagascar', 'Malawi', 'Mali', 'Mauritania', 'Mauritius', 'Morocco', 'Mozambique', 'Namibia', 'Niger', 'Nigeria', 'Rwanda', 'Sao Tome and Principe', 'Senegal', 'Seychelles', 'Sierra Leone', 'Somalia', 'South Africa', 'South Sudan', 'Sudan', 'Tanzania', 'Togo', 'Tunisia', 'Uganda', 'Zambia', 'Zimbabwe'],
        'Asia': ['Afghanistan', 'Armenia', 'Azerbaijan', 'Bahrain', 'Bangladesh', 'Bhutan', 'Brunei', 'Cambodia', 'China', 'Cyprus', 'Georgia', 'India', 'Indonesia', 'Iran', 'Iraq', 'Israel', 'Japan', 'Jordan', 'Kazakhstan', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Lebanon', 'Malaysia', 'Maldives', 'Mongolia', 'Myanmar', 'Nepal', 'North Korea', 'Oman', 'Pakistan', 'Palestine', 'Philippines', 'Qatar', 'Russia', 'Saudi Arabia', 'Singapore', 'South Korea', 'Sri Lanka', 'Syria', 'Taiwan', 'Tajikistan', 'Thailand', 'Timor-Leste', 'Turkey', 'Turkmenistan', 'United Arab Emirates', 'Uzbekistan', 'Vietnam', 'Yemen'],
        'Europe': ['Albania', 'Andorra', 'Austria', 'Belarus', 'Belgium', 'Bosnia and Herzegovina', 'Bulgaria', 'Croatia', 'Czech Republic', 'Denmark', 'Estonia', 'Finland', 'France', 'Germany', 'Greece', 'Hungary', 'Iceland', 'Ireland', 'Italy', 'Kosovo', 'Latvia', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Malta', 'Moldova', 'Monaco', 'Montenegro', 'Netherlands', 'North Macedonia', 'Norway', 'Poland', 'Portugal', 'Romania', 'San Marino', 'Serbia', 'Slovakia', 'Slovenia', 'Spain', 'Sweden', 'Switzerland', 'Ukraine', 'United Kingdom', 'Vatican City'],
        'North America': ['Antigua and Barbuda', 'Bahamas', 'Barbados', 'Belize', 'Canada', 'Costa Rica', 'Cuba', 'Dominica', 'Dominican Republic', 'El Salvador', 'Grenada', 'Guatemala', 'Haiti', 'Honduras', 'Jamaica', 'Mexico', 'Nicaragua', 'Panama', 'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Vincent and the Grenadines', 'Trinidad and Tobago', 'United States'],
        'South America': ['Argentina', 'Bolivia', 'Brazil', 'Chile', 'Colombia', 'Ecuador', 'Guyana', 'Paraguay', 'Peru', 'Suriname', 'Uruguay', 'Venezuela'],
        'Oceania': ['Australia', 'Fiji', 'Kiribati', 'Marshall Islands', 'Micronesia', 'Nauru', 'New Zealand', 'Palau', 'Papua New Guinea', 'Samoa', 'Solomon Islands', 'Tonga', 'Tuvalu', 'Vanuatu']
    };

    continentSelect.addEventListener('change', function() {
        const continent = this.value;
        countrySelect.innerHTML = '<option value="">-- Select Country --</option>';
        
        if (continent) {
            countrySelect.disabled = false;
            countriesByContinent[continent].forEach(country => {
                const option = document.createElement('option');
                option.value = country;
                option.textContent = country;
                countrySelect.appendChild(option);
            });
        } else {
            countrySelect.disabled = true;
        }
    });

    // Form submission handling
    document.getElementById('verificationForm').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submit-btn');
        const submitText = document.getElementById('submit-text');
        const submitSpinner = document.getElementById('submit-spinner');
        
        // Disable button and show spinner
        submitBtn.disabled = true;
        submitText.textContent = 'Processing...';
        submitSpinner.classList.remove('hidden');
        
        // Validate required fields
        const documentInput = document.getElementById('document');
        const selfieInput = document.getElementById('selfie');
        
        if (!documentInput.files[0] || !selfieInput.files[0]) {
            e.preventDefault();
            alert('Please complete all required fields before submitting');
            submitBtn.disabled = false;
            submitText.textContent = 'Submit Verification';
            submitSpinner.classList.add('hidden');
            return false;
        }
        
        return true;
    });




    document.getElementById('verificationForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submit-btn');
    const submitText = document.getElementById('submit-text');
    const submitSpinner = document.getElementById('submit-spinner');
    
    // Disable button and show spinner
    submitBtn.disabled = true;
    submitText.textContent = 'Processing...';
    submitSpinner.classList.remove('hidden');

    // Disable all form fields to prevent resubmission
    const formElements = this.elements;
    for (let i = 0; i < formElements.length; i++) {
        formElements[i].disabled = true;
    }

    // Validate required fields (run this before disabling everything ideally)
    const documentInput = document.getElementById('document');
    const selfieInput = document.getElementById('selfie');

    if (!documentInput.files[0] || !selfieInput.files[0]) {
        e.preventDefault();
        alert('Please complete all required fields before submitting');

        // Re-enable form
        for (let i = 0; i < formElements.length; i++) {
            formElements[i].disabled = false;
        }

        submitBtn.disabled = false;
        submitText.textContent = 'Submit Verification';
        submitSpinner.classList.add('hidden');
        return false;
    }

    return true;
});

</script>
@endsection