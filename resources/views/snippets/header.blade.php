<!-- Navbar - Your Original Navigation -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm " id="navbar">
    <div class="container-fluid side-padding d-flex justify-content-between align-items-center">


        <div class="logo-wrapper d-flex align-items-center justify-content-center">
            <a href="/">
                <img
                    src="{{ asset('assets/images/mymarketmindmainlogo.png') }}"
                    alt="Market Mind Logo"
                    class="z-100 logo-img">
            </a>
        </div>
        <style>
            /* Force navbar height */
            #navbar {
                height: 80px;
                overflow: hidden;
            }

            /* Container inside navbar stays centered */
            #navbar .container-fluid {
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            /* Logo wrapper centers the image in the available height */
            .logo-wrapper {
                height: 100%;
                display: flex;
                align-items: center;
            }

            /* Bold logo image styling */
            .logo-img {
                height: 140px;
                width: 150px;
                object-fit: contain;
                filter: contrast(130%) brightness(110%) saturate(120%);
            }

            /* Adjust mobile layout spacing */
            @media (max-width: 767.98px) {
                .logo-wrapper {
                    margin-right: auto;
                }

                .navbar-toggler {
                    margin-left: 12px;
                }
            }
        </style>



        <button class="navbar-toggler border-0 bg-transparent p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu">
            <div class="hamburger" id="hamburger">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
           <ul class="navbar-nav mb-2 mb-lg-0 d-flex gap-3 align-items-center">
    <li class="nav-item">
        <a class="navLinks {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
    </li>
    <li class="nav-item">
        <a class="navLinks {{ Route::is('plans.header') ? 'active' : '' }}" href="{{ route('plans.header') }}">Plans</a>
    </li>
    <li class="nav-item">
        <a class="navLinks {{ Route::is('about.us') ? 'active' : '' }}" href="{{ route('about.us') }}">About Us</a>
    </li>
    <li class="nav-item">
        <a class="navLinks {{ Route::is('our.services') ? 'active' : '' }}" href="{{ route('our.services') }}">Services</a>
    </li>
    <li class="nav-item">
        <a class="navLinks {{ Route::is('contact.us') ? 'active' : '' }}" href="{{ route('contact.us') }}">Contact</a>
    </li>
</ul>

        </div>

        <div class="others-options d-none d-lg-flex align-items-center gap-2">
            <a href="{{ route('login') }}" class="search-btn login text-decoration-none"><i class="ri-account-circle-line"></i> Log in</a>
            <a href="{{ route('signup') }}" class="default-btn">Sign Up <i class="ri-arrow-right-up-line"></i></a>
        </div>
    </div>
</nav>

<!-- Offcanvas Mobile Menu -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu" >
    <div class="offcanvas-header border-bottom" style="max-height: 65px;">
        <a href="/" class="navbar-brand d-flex align-items-center gap-2">
            <img src="{{ asset('assets/images/mymarketmindmainlogo.png') }}" alt="Logo" style="height: auto; width:90px;">
            
        </a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav mb-4">
        <li class="nav-item">
    <a class="nav-link mobile-nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
</li>
<li class="nav-item">
    <a class="nav-link mobile-nav-link {{ Route::is('plans.header') ? 'active' : '' }}" href="{{ route('plans.header') }}">Plans</a>
</li>
<li class="nav-item">
    <a class="nav-link mobile-nav-link {{ Route::is('about.us') ? 'active' : '' }}" href="{{ route('about.us') }}">About Us</a>
</li>
<li class="nav-item">
    <a class="nav-link mobile-nav-link {{ Route::is('our.services') ? 'active' : '' }}" href="{{ route('our.services') }}">Services</a>
</li>
<li class="nav-item">
    <a class="nav-link mobile-nav-link {{ Route::is('contact.us') ? 'active' : '' }}" href="{{ route('contact.us') }}">Contact</a>
</li>

        </ul>
        <div class="mobile-auth-buttons d-flex flex-column gap-2 mt-auto">
            <a href="{{ route('login') }}" class="btn btn-outline-primary"><i class="ri-account-circle-line me-2"></i> Log in</a>
            <a href="{{ route('signup') }}" class="btn btn-primary">Sign Up <i class="ri-arrow-right-up-line ms-1"></i></a>
        </div>
    </div>
</div>

<!-- Google Translate Script with Dropdown Behavior -->




<!-- Your Original Styles with Language Selector Improvements -->
<style>
    /* Desktop nav links */
    .navLinks {
        padding: 15px;
        color: #333;
        text-decoration: none;
        transition: 0.3s ease;
    }

    .navLinks:hover,
    .navLinks.active {
        background: #9edd05;
        color: #fff;
        border-radius: 4px;
    }

    /* Mobile nav links */
    .mobile-nav-link {
        padding: 12px 16px;
        color: #333;
        font-weight: 500;
        border-radius: 6px;
        margin-bottom: 4px;
        transition: all 0.2s;
    }

    .mobile-nav-link:hover {
        background: rgba(158, 221, 5, 0.1);
        color: #0c3a30;
    }

    .mobile-nav-link.active {
        background: #9edd05;
        color: #fff;
        border-radius: 6px;
    }

    /* Auth buttons */
    .default-btn {
        background: #9edd05;
        color: #fff;
        padding: 6px 15px;
        border-radius: 5px;
        text-decoration: none;
        transition: 0.3s;
    }

    .default-btn:hover {
        background: #7cc300;
    }

    .btn-outline-primary {
        border-color: #9edd05;
        color: #9edd05;
    }

    .btn-outline-primary:hover {
        background: #9edd05;
        color: #fff;
    }

    .btn-primary {
        background: #9edd05;
        border-color: #9edd05;
    }

    .btn-primary:hover {
        background: #7cc300;
        border-color: #7cc300;
    }

    .mobile-auth-buttons .btn {
        padding: 10px 16px;
        font-weight: 500;
    }

    /* Hamburger icon */
    .hamburger {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 24px;
        height: 18px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-right: 1.5rem;
    }

    .hamburger .line {
        height: 2px;
        width: 100%;
        background: #333;
        transition: all 0.3s ease;
    }

    .hamburger.active .line:nth-child(1) {
        transform: translateY(8px) rotate(45deg);
    }

    .hamburger.active .line:nth-child(2) {
        opacity: 0;
    }

    .hamburger.active .line:nth-child(3) {
        transform: translateY(-8px) rotate(-45deg);
    }

    /* Offcanvas sidebar */
    .offcanvas-end {
        width: 280px;
    }
</style>
