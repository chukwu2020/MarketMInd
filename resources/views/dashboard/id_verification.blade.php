@extends('layout.user')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
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

            @if($errors->any())
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

            <form id="verificationForm" action="{{ route('id.upload') }}" method="POST" enctype="multipart/form-data" class="px-6 py-8 space-y-6">
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

                <!-- ID Document Upload with Preview -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload ID Document Front and Back</label>
                    <div class="mt-1 flex flex-col items-center">
                        <div id="id-preview-container" class="hidden mb-4 w-full max-w-xs">
                            <div class="relative">
                                <img id="id-preview" class="w-full h-auto border border-gray-300 rounded-md">
                                <button type="button" onclick="clearIdPreview()" class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 transform translate-x-1/2 -translate-y-1/2">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            <p id="id-file-name" class="text-sm text-gray-500 mt-1 text-center"></p>
                        </div>
                        <label class="w-full flex flex-col items-center px-4 py-6 bg-white text-blue-600 rounded-lg border-2 border-dashed border-blue-300 cursor-pointer hover:bg-blue-50 transition-colors duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <span class="mt-2 text-base font-medium">Select ID Document</span>
                            <span class="text-sm text-gray-500">JPG, PNG, or PDF (Max 5MB)</span>
                            <input id="id-upload" type="file" name="document" class="hidden" accept=".jpg,.jpeg,.png,.pdf" required>
                        </label>
                    </div>
                </div>

                <!-- Selfie Capture with Preview -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Take a Selfie</label>
                    <div class="mt-1 flex flex-col items-center">
                        <div id="selfie-preview-container" class="hidden mb-4 w-full max-w-xs">
                            <div class="relative">
                                <img id="selfie-preview" class="w-full h-auto border border-gray-300 rounded-md">
                                <button type="button" onclick="clearSelfiePreview()" class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 transform translate-x-1/2 -translate-y-1/2">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div id="selfie-capture-container" class="w-full">
                            <div id="selfie-instructions" class="text-center mb-4">
                                <p class="text-sm text-gray-500">Please ensure your face is clearly visible</p>
                            </div>
                            <div class="relative bg-gray-100 rounded-lg overflow-hidden">
                                <video id="video" class="w-full hidden" autoplay playsinline></video>
                                <canvas id="canvas" class="hidden"></canvas>
                                <div id="selfie-placeholder" class="flex flex-col items-center justify-center py-8 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <p class="mt-2 text-gray-600">Click to take a selfie</p>
                                </div>
                            </div>
                            <div id="camera-controls" class="mt-4 flex justify-center space-x-4 hidden">
                                <button type="button" id="capture-btn" class="px-4 py-2 rounded-md transition" style="background-color: #9EDD05 !important; color:#0C3A30 !important;">Capture</button>
                                <button type="button" id="retake-btn" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition hidden">Retake</button>
                            </div>
                            <input type="hidden" name="selfie" id="selfie-data">
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" id="submit-btn" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150" style="background-color: #9EDD05 !important; color:#0C3A30 !important;">
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

    // ID Document Upload with Preview
    const idUpload = document.getElementById('id-upload');
    const idPreviewContainer = document.getElementById('id-preview-container');
    const idPreview = document.getElementById('id-preview');
    const idFileName = document.getElementById('id-file-name');

    idUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                idPreview.src = event.target.result;
                idPreviewContainer.classList.remove('hidden');
                idFileName.textContent = file.name;
            };
            if (file.type.match('image.*')) {
                reader.readAsDataURL(file);
            } else {
                // For PDFs, show a placeholder
                idPreview.src = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%239CA3AF'%3E%3Cpath d='M8 3v10a4 4 0 01-4 4H2V5a2 2 0 012-2h4zm2 0h4a2 2 0 012 2v10a2 2 0 01-2 2h-4V3zm6 0h4a2 2 0 012 2v10a4 4 0 01-4 4h-2V3z'/%3E%3C/svg%3E";
                idPreviewContainer.classList.remove('hidden');
                idFileName.textContent = file.name;
            }
        }
    });

    function clearIdPreview() {
        idUpload.value = '';
        idPreviewContainer.classList.add('hidden');
        idPreview.src = '';
        idFileName.textContent = '';
    }

    // Selfie Capture with Preview
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const selfiePlaceholder = document.getElementById('selfie-placeholder');
    const captureBtn = document.getElementById('capture-btn');
    const retakeBtn = document.getElementById('retake-btn');
    const cameraControls = document.getElementById('camera-controls');
    const selfieData = document.getElementById('selfie-data');
    const selfiePreviewContainer = document.getElementById('selfie-preview-container');
    const selfiePreview = document.getElementById('selfie-preview');
    let stream = null;

    selfiePlaceholder.addEventListener('click', async function() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ 
                video: { 
                    width: 640, 
                    height: 480,
                    facingMode: 'user' 
                }, 
                audio: false 
            });
            video.srcObject = stream;
            video.classList.remove('hidden');
            selfiePlaceholder.classList.add('hidden');
            cameraControls.classList.remove('hidden');
            captureBtn.classList.remove('hidden');
        } catch (err) {
            console.error("Error accessing camera:", err);
            alert("Could not access the camera. Please ensure you've granted camera permissions.");
        }
    });

    captureBtn.addEventListener('click', function() {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
        
        // Stop video stream
        stream.getTracks().forEach(track => track.stop());
        
        // Show preview and hide video
        video.classList.add('hidden');
        selfiePreview.src = canvas.toDataURL('image/jpeg');
        selfiePreviewContainer.classList.remove('hidden');
        
        // Convert canvas to base64 and set as hidden input value
        selfieData.value = canvas.toDataURL('image/jpeg', 0.8);
        
        // Show retake button and hide capture button
        captureBtn.classList.add('hidden');
        retakeBtn.classList.remove('hidden');
    });

    retakeBtn.addEventListener('click', function() {
        // Clear preview
        selfiePreviewContainer.classList.add('hidden');
        selfiePreview.src = '';
        selfieData.value = '';
        
        // Restart camera
        selfiePlaceholder.click();
    });

    function clearSelfiePreview() {
        selfiePreviewContainer.classList.add('hidden');
        selfiePreview.src = '';
        selfieData.value = '';
        selfiePlaceholder.classList.remove('hidden');
        cameraControls.classList.add('hidden');
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
    }

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
        if (!idUpload.files[0] || !selfieData.value) {
            e.preventDefault();
            alert('Please complete all required fields before submitting');
            submitBtn.disabled = false;
            submitText.textContent = 'Submit Verification';
            submitSpinner.classList.add('hidden');
            return false;
        }
        
        return true;
    });
</script>
@endsection