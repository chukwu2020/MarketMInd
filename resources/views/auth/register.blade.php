@extends('layout.app')

@section('content')
<style>
    /* CSS to reduce header gap */
    .page-banner-area {
        margin-top: -1rem;
        padding-top: 4rem !important;
    }

    @media (max-width: 768px) {
        .page-banner-area {
            margin-top: -1.5rem;
        }
    }
</style>
<!-- Start Compact Page Banner Area -->
<div class="page-banner-area position-relative" style="background-image: url(assets/images/hero/hero-image-2.svg); ">
    <div class="container">
        <div class="page-banner-content">
            <h1 style="font-size: 24px; margin: 0;">My Account</h1>
            <ul style="margin: 5px 0 0; padding: 0;">
                <li style="display: inline;"><a href="/">Home</a></li>
                <li style="display: inline;"> / My Account</li>
            </ul>
        </div>
    </div>
</div>
<!-- End Compact Page Banner Area -->

<!-- Start My Account Page -->
<div class="my-account-page ptb-80 overflow-hidden">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-10 col-md-12" data-cues="slideInLeft" data-duration="800">
                <!-- <form action="{{ route('user.create') }}" method="POST" class="login-form bg-color-fffaeb radius-30"> -->
                <form id="registerForm" action="{{ route('user.create') }}" method="POST" class="login-form bg-color-fffaeb radius-30">

                    @csrf
                    <h3>Create An Account</h3>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" value="{{ old('name') }}" name="name" placeholder="Name">
                            <span class="text-danger">@error('name') {{ $message }} @enderror</span>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="">Username</label>
                            <input type="text" class="form-control" value="{{ old('username') }}" name="username" placeholder="Username">
                            <span class="text-danger">@error('username') {{ $message }} @enderror</span>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="">Email</label>
                            <input type="email" class="form-control" value="{{ old('email') }}" name="email" placeholder="Email">
                            <span class="text-danger">@error('email') {{ $message }} @enderror</span>
                        </div>


                        <div class="mb-3 col-md-6">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone" class="form-control" inputmode="tel" placeholder="Phone number" value="{{ old('phone') }}">
                            <span class="text-danger">@error('phone') {{ $message }} @enderror</span>
                        </div>
                        <div class="mb-3 col-md-6 position-relative">
                            <label for="">Password</label>
                            <input type="password" id="regPassword" class="form-control pe-5" name="password" placeholder="Password (e.g. Ch@#%)" value="{{ old('password') }}">
                            <span class="password-toggle" onclick="toggleRegPassword()">
                                <i class="ri-eye-line" id="regToggleIcon"></i> <!-- eye without slash = visible -->
                            </span>


                            <span class="text-danger">@error('password') {{ $message }} @enderror</span>
                        </div>


                        <div class="mb-3 col-md-6 position-relative">
                            <label for="">Confirm Password</label>
                            <input type="password" id="regConfirmPassword" class="form-control pe-5" name="confirm_password" placeholder="Password (e.g. Ch@#%)" value="{{ old('confirm_password') }}">
                            <span class="password-toggle" onclick="toggleRegConfirmPassword()">
                                <i class="ri-eye-line" id="regConfirmToggleIcon"></i> <!-- eye without slash = visible -->
                            </span>


                            <span class="text-danger">@error('confirm_password') {{ $message }} @enderror</span>
                        </div>





                        <div class="mb-3 col-md-6">
                            <label for="">Country</label>
                            <select name="country" id="country" class="form-control pe-5" required>
                                <option style="justify-content:space-between;" value="country" {{ old('country') == 'selectcountry' ? 'selected' : '' }}>Select country     ▼  </option>
 
                                <option value="Afghanistan">Afghanistan</option>
                                <option value="Albania">Albania</option>
                                <option value="Algeria">Algeria</option>
                                <option value="Andorra">Andorra</option>
                                <option value="Angola">Angola</option>
                                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                <option value="Argentina">Argentina</option>
                                <option value="Armenia">Armenia</option>
                                <option value="Australia">Australia</option>
                                <option value="Austria">Austria</option>
                                <option value="Azerbaijan">Azerbaijan</option>
                                <option value="Bahamas">Bahamas</option>
                                <option value="Bahrain">Bahrain</option>
                                <option value="Bangladesh">Bangladesh</option>
                                <option value="Barbados">Barbados</option>
                                <option value="Belarus">Belarus</option>
                                <option value="Belgium">Belgium</option>
                                <option value="Belize">Belize</option>
                                <option value="Benin">Benin</option>
                                <option value="Bhutan">Bhutan</option>
                                <option value="Bolivia">Bolivia</option>
                                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                <option value="Botswana">Botswana</option>
                                <option value="Brazil">Brazil</option>
                                <option value="Brunei">Brunei</option>
                                <option value="Bulgaria">Bulgaria</option>
                                <option value="Burkina Faso">Burkina Faso</option>
                                <option value="Burundi">Burundi</option>
                                <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                                <option value="Cabo Verde">Cabo Verde</option>
                                <option value="Cambodia">Cambodia</option>
                                <option value="Cameroon">Cameroon</option>
                                <option value="Canada">Canada</option>
                                <option value="Central African Republic">Central African Republic</option>
                                <option value="Chad">Chad</option>
                                <option value="Chile">Chile</option>
                                <option value="China">China</option>
                                <option value="Colombia">Colombia</option>
                                <option value="Comoros">Comoros</option>
                                <option value="Congo">Congo</option>
                                <option value="Costa Rica">Costa Rica</option>
                                <option value="Croatia">Croatia</option>
                                <option value="Cuba">Cuba</option>
                                <option value="Cyprus">Cyprus</option>
                                <option value="Czech Republic">Czech Republic</option>
                                <option value="Democratic Republic of the Congo">Democratic Republic of the Congo</option>
                                <option value="Denmark">Denmark</option>
                                <option value="Djibouti">Djibouti</option>
                                <option value="Dominica">Dominica</option>
                                <option value="Dominican Republic">Dominican Republic</option>
                                <option value="Ecuador">Ecuador</option>
                                <option value="Egypt">Egypt</option>
                                <option value="El Salvador">El Salvador</option>
                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                <option value="Eritrea">Eritrea</option>
                                <option value="Estonia">Estonia</option>
                                <option value="Eswatini">Eswatini</option>
                                <option value="Ethiopia">Ethiopia</option>
                                <option value="Fiji">Fiji</option>
                                <option value="Finland">Finland</option>
                                <option value="France">France</option>
                                <option value="Gabon">Gabon</option>
                                <option value="Gambia">Gambia</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Germany">Germany</option>
                                <option value="Ghana">Ghana</option>
                                <option value="Greece">Greece</option>
                                <option value="Grenada">Grenada</option>
                                <option value="Guatemala">Guatemala</option>
                                <option value="Guinea">Guinea</option>
                                <option value="Guinea-Bissau">Guinea-Bissau</option>
                                <option value="Guyana">Guyana</option>
                                <option value="Haiti">Haiti</option>
                                <option value="Holy See">Holy See</option>
                                <option value="Honduras">Honduras</option>
                                <option value="Hungary">Hungary</option>
                                <option value="Iceland">Iceland</option>
                                <option value="India">India</option>
                                <option value="Indonesia">Indonesia</option>
                                <option value="Iran">Iran</option>
                                <option value="Iraq">Iraq</option>
                                <option value="Ireland">Ireland</option>
                                <option value="Israel">Israel</option>
                                <option value="Italy">Italy</option>
                                <option value="Jamaica">Jamaica</option>
                                <option value="Japan">Japan</option>
                                <option value="Jordan">Jordan</option>
                                <option value="Kazakhstan">Kazakhstan</option>
                                <option value="Kenya">Kenya</option>
                                <option value="Kiribati">Kiribati</option>
                                <option value="Kuwait">Kuwait</option>
                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                <option value="Laos">Laos</option>
                                <option value="Latvia">Latvia</option>
                                <option value="Lebanon">Lebanon</option>
                                <option value="Lesotho">Lesotho</option>
                                <option value="Liberia">Liberia</option>
                                <option value="Libya">Libya</option>
                                <option value="Liechtenstein">Liechtenstein</option>
                                <option value="Lithuania">Lithuania</option>
                                <option value="Luxembourg">Luxembourg</option>
                                <option value="Madagascar">Madagascar</option>
                                <option value="Malawi">Malawi</option>
                                <option value="Malaysia">Malaysia</option>
                                <option value="Maldives">Maldives</option>
                                <option value="Mali">Mali</option>
                                <option value="Malta">Malta</option>
                                <option value="Marshall Islands">Marshall Islands</option>
                                <option value="Mauritania">Mauritania</option>
                                <option value="Mauritius">Mauritius</option>
                                <option value="Mexico">Mexico</option>
                                <option value="Micronesia">Micronesia</option>
                                <option value="Moldova">Moldova</option>
                                <option value="Monaco">Monaco</option>
                                <option value="Mongolia">Mongolia</option>
                                <option value="Montenegro">Montenegro</option>
                                <option value="Morocco">Morocco</option>
                                <option value="Mozambique">Mozambique</option>
                                <option value="Myanmar">Myanmar</option>
                                <option value="Namibia">Namibia</option>
                                <option value="Nauru">Nauru</option>
                                <option value="Nepal">Nepal</option>
                                <option value="Netherlands">Netherlands</option>
                                <option value="New Zealand">New Zealand</option>
                                <option value="Nicaragua">Nicaragua</option>
                                <option value="Niger">Niger</option>
                                <option value="Nigeria">Nigeria</option>
                                <option value="North Korea">North Korea</option>
                                <option value="North Macedonia">North Macedonia</option>
                                <option value="Norway">Norway</option>
                                <option value="Oman">Oman</option>
                                <option value="Pakistan">Pakistan</option>
                                <option value="Palau">Palau</option>
                                <option value="Palestine State">Palestine State</option>
                                <option value="Panama">Panama</option>
                                <option value="Papua New Guinea">Papua New Guinea</option>
                                <option value="Paraguay">Paraguay</option>
                                <option value="Peru">Peru</option>
                                <option value="Philippines">Philippines</option>
                                <option value="Poland">Poland</option>
                                <option value="Portugal">Portugal</option>
                                <option value="Qatar">Qatar</option>
                                <option value="Romania">Romania</option>
                                <option value="Russia">Russia</option>
                                <option value="Rwanda">Rwanda</option>
                                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                <option value="Saint Lucia">Saint Lucia</option>
                                <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                <option value="Samoa">Samoa</option>
                                <option value="San Marino">San Marino</option>
                                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                <option value="Saudi Arabia">Saudi Arabia</option>
                                <option value="Senegal">Senegal</option>
                                <option value="Serbia">Serbia</option>
                                <option value="Seychelles">Seychelles</option>
                                <option value="Sierra Leone">Sierra Leone</option>
                                <option value="Singapore">Singapore</option>
                                <option value="Slovakia">Slovakia</option>
                                <option value="Slovenia">Slovenia</option>
                                <option value="Solomon Islands">Solomon Islands</option>
                                <option value="Somalia">Somalia</option>
                                <option value="South Africa">South Africa</option>
                                <option value="South Korea">South Korea</option>
                                <option value="South Sudan">South Sudan</option>
                                <option value="Spain">Spain</option>
                                <option value="Sri Lanka">Sri Lanka</option>
                                <option value="Sudan">Sudan</option>
                                <option value="Suriname">Suriname</option>
                                <option value="Sweden">Sweden</option>
                                <option value="Switzerland">Switzerland</option>
                                <option value="Syria">Syria</option>
                                <option value="Tajikistan">Tajikistan</option>
                                <option value="Tanzania">Tanzania</option>
                                <option value="Thailand">Thailand</option>
                                <option value="Timor-Leste">Timor-Leste</option>
                                <option value="Togo">Togo</option>
                                <option value="Tonga">Tonga</option>
                                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                <option value="Tunisia">Tunisia</option>
                                <option value="Turkey">Turkey</option>
                                <option value="Turkmenistan">Turkmenistan</option>
                                <option value="Tuvalu">Tuvalu</option>
                                <option value="Uganda">Uganda</option>
                                <option value="Ukraine">Ukraine</option>
                                <option value="United Arab Emirates">United Arab Emirates</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="United States">United States</option>
                                <option value="Uruguay">Uruguay</option>
                                <option value="Uzbekistan">Uzbekistan</option>
                                <option value="Vanuatu">Vanuatu</option>
                                <option value="Venezuela">Venezuela</option>
                                <option value="Vietnam">Vietnam</option>
                                <option value="Yemen">Yemen</option>
                                <option value="Zambia">Zambia</option>
                                <option value="Zimbabwe">Zimbabwe</option>
                            
                            </select>
                        
                        </div>
                        <!-- arrown dwn -->
                        <style>
                            .arrow-down {
                                color: #555;
                                font-size: 0.9rem;
                            }
                        </style>

                        <div class="mb-3 col-md-6">
                            <label for="">Referral Id</label>
                            <input type="text" class="form-control" value="{{ old('referral_id') }}" name="referral_id" placeholder="Referral ID (optional)">

                        </div>
                    </div>
<button id="registerBtn" type="submit" class="default-btn w-100 text-center bg-[#8bc905] text-white relative">
    <span class="btn-text">Register Now</span>
    <span class="btn-loader hidden absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 50 50">
            <circle cx="25" cy="25" r="20" stroke="#fff" stroke-width="5" fill="none" stroke-linecap="round">
                <animateTransform
                    attributeName="transform"
                    type="rotate"
                    dur="1s"
                    from="0 25 25"
                    to="360 25 25"
                    repeatCount="indefinite" />
            </circle>
        </svg>
    </span>
</button>




                    <p class="text-center">Already Have An Account? <a href="{{ route('login') }}">Login</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End My Account Page -->
<style>
    .password-toggle {
        position: absolute;
        right: 15px;
        top: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        cursor: pointer;
        color: #6c757d;
        z-index: 10;
    }

    .password-toggle:hover {
        color: #0c3a30;
    }

    .form-control.pe-5 {
        padding-right: 2.5rem !important;
    }
</style>

<script>
    function toggleRegPassword() {
        const passwordInput = document.getElementById('regPassword');
        const toggleIcon = document.getElementById('regToggleIcon');

        if (passwordInput.type === 'text') {
            // Hide password (change to password)
            passwordInput.type = 'password';
            // Show eye-off (slashed eye) icon meaning hidden
            toggleIcon.classList.remove('ri-eye-line');
            toggleIcon.classList.add('ri-eye-off-line');
        } else {
            // Show password (change to text)
            passwordInput.type = 'text';
            // Show eye (unslashed eye) icon meaning visible
            toggleIcon.classList.remove('ri-eye-off-line');
            toggleIcon.classList.add('ri-eye-line');
        }
    }

    function toggleRegConfirmPassword() {
        const passwordInput = document.getElementById('regConfirmPassword');
        const toggleIcon = document.getElementById('regConfirmToggleIcon');

        if (passwordInput.type === 'text') {
            // Hide password
            passwordInput.type = 'password';
            toggleIcon.classList.remove('ri-eye-line');
            toggleIcon.classList.add('ri-eye-off-line');
        } else {
            // Show password
            passwordInput.type = 'text';
            toggleIcon.classList.remove('ri-eye-off-line');
            toggleIcon.classList.add('ri-eye-line');
        }
    }
</script>


<style>
    .loader {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-left-color: #8bc905;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-left: 10px;
        vertical-align: middle;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>

<!-- delaying loading  -->
<style>
    #registerBtn {
    position: relative;
    padding: 10px 20px;
    background-color: #8bc905 !important;
    color: white !important;
    border: none;
    border-radius: 5px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
#registerBtn:hover {
    background-color: #76ad03;
}
#registerBtn:disabled {
    background-color: #ccc !important;
    cursor: not-allowed;
}
.hidden {
    display: none !important;
}

</style>

<script>
    document.getElementById('registerForm').addEventListener('submit', function () {
        const btn = document.getElementById('registerBtn');
        const btnText = btn.querySelector('.btn-text');
        const btnLoader = btn.querySelector('.btn-loader');

        // Disable button
        btn.disabled = true;

        // Hide text, show loader
        btnText.style.display = 'none';
        btnLoader.classList.remove('hidden'); // shows the loader
    });
</script>



@endsection