    <!-- Start Footer Area -->
    <div class="footer-area bg-color-0c3a30 pt-120">
        <div class="container">
            <div class="row" data-cues="slideInUp" data-duration="800">
                <div class="col-xl-4 col-lg-9 col-md-6">
                    <div class="footer-weight"> 
                        <h2 class="text-white">Subscribe Newsletter</h2>
                     <form class="footer-form position-relative" id="footerSubscribeForm">
    <div class="input-group">
        <input 
            type="email" 
            class="form-control" 
            placeholder="Enter Your Email"
            id="footerEmail"
            required
            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
            aria-label="Email address for newsletter subscription"
        >
        <button type="submit" class="default-btn">Subscribe <i class="ri-arrow-right-up-line"></i></button>
    </div>
    <div class="invalid-feedback text-white mt-2" id="footerEmailError">
        Please enter a valid email address
    </div>
</form>

<script>
document.getElementById('footerSubscribeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const emailInput = document.getElementById('footerEmail');
    const emailError = document.getElementById('footerEmailError');
    
    // Reset validation state
    emailInput.classList.remove('is-invalid');
    emailError.style.display = 'none';
    
    // Basic validation
    if (!emailInput.value) {
        showError(emailInput, emailError, 'Email is required');
        return;
    }
    
    // Regex pattern validation
    const emailRegex = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/i;
    if (!emailRegex.test(emailInput.value)) {
        showError(emailInput, emailError, 'Please enter a valid email address');
        return;
    }
    
    // If valid, submit form (you would replace this with AJAX call)
    this.submit();
});

function showError(input, errorElement, message) {
    input.classList.add('is-invalid');
    errorElement.textContent = message;
    errorElement.style.display = 'block';
    input.focus();
}
</script>

<style>
/* Add these styles to your CSS */
.invalid-feedback {
    display: none;
    font-size: 0.875rem;
}
.is-invalid {
    border-color: #dc3545 !important;
}
</style>

                        <ul class="social">
                            <li><span>Follow Us:</span></li>
                            <li>
                                <a href="https://www.facebook.com/" target="_blank">
                                    <i class="ri-facebook-fill"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.twitter.com/" target="_blank">
                                    <i class="ri-twitter-x-line"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/" target="_blank">
                                    <i class="ri-instagram-line"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/" target="_blank">
                                    <i class="ri-linkedin-fill"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-4 col-md-6">
                    <div class="footer-weight part-two ps-5">
                        <h3 class="text-white">Quick Links</h3>

                        <ul class="service-link">
                            <li>
                                <a href="/">Terms & Conditions</a>
                            </li>
                            <li>
                                <a href="{{route('our.services')}}">Blog & News</a>
                            </li>
                            <li>
                                <a href="{{route('our.services')}}">Mobile App</a>
                            </li>
                            <li>
                                <a href="{{route('our.services')}}">Why Choose Us</a>
                            </li>
                            <li>
                                <a href="/">Pricing Plan</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="footer-weight part-three ps-5">
                        <h3 class="text-white">Our Services</h3>

                        <ul class="service-link">
                            <li>
                                <a href="{{route('our.services')}}">Mobile Banking</a>
                            </li>
                            <li>
                                <a href="{{route('our.services')}}">Advanced Security</a>
                            </li>
                            <li>
                                <a href="{{route('our.services')}}">Digital Wallet</a>
                            </li>
                            <li>
                                <a href="{{route('our.services')}}">Budgeting Tools</a>
                            </li>
                            <li>
                                <a href="{{route('our.services')}}">Making Transactions</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="footer-weight ps-5">
                        <h3 class="text-white">Get In Touch</h3>

                        <ul class="get-touch">
                            <li>
                                <img src="assets/images/svg/map.svg" alt="image">
                                <span class="text-white"><b>Location:</b></span>
                                <a href="https://www.google.com/maps/search/18+Tanglewood+Lane+Gulfport/@30.4216847,-89.1511032,12z/data=!3m1!4b1?y=ttu" target="_blank">worldwide</a>
                            </li>
                            <li>
                                <img class="phone" src="assets/images/svg/mail.svg" alt="image">
                                <span class="text-white"><b>Email:</b></span>
                                <a href="https://templates.hibootstrap.com/cdn-cgi/l/email-protection#f59d9099999adb969a98"><span class="__cf_email__" data-cfemail="7f171a1313103f1916110b10511c1012">[email&#160;protected]</span></a>
                            </li>
                            <li>
                                <img class="phone" src="assets/images/svg/phone.svg" alt="image">
                                <span class="text-white"><b>Phone:</b></span>
                                <a href="tel:0018085550148">+44 7742 (663) 627</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Area -->

    <!-- Start Copyright Area -->
    <div class="copyright-area bg-color-0c3a30">
        <div class="container">
            <div class="copyright-border">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-4 col-md-6">
                        <p>© <span>MarketMind</span>  Is Proudly Owned By US <a href="/" target="_blank">View More</a></p>
                        
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="copy-image" data-cues="zoomIn" data-duration="700">
                           <a href="/">
                <img
                    src="{{ asset('assets/images/mymarketmindmainlogo.png') }}"
                    alt="Market Mind Logo"
                    class="z-100 logo-img">
            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <ul>
                            <li>
                                <a href="/">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="/">Terms & Conditions</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Copyright Area -->
