<!DOCTYPE html>
<html lang="en" data-bs-theme="light" data-pwa="true">

<head>
    <meta charset="utf-8">

    <!-- Viewport -->
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">

    <!-- SEO Meta Tags -->
    <title>{{ $option->getByKey('site_name') }} | Furniture Store</title>
    <meta name="description" content="{{ $option->getByKey('site_description') }}">
    <meta name="keywords"
        content="online shop, e-commerce, online store, market, multipurpose, product landing, cart, checkout, ui kit, light and dark mode, bootstrap, html5, css3, javascript, gallery, slider, mobile, pwa">
    <meta name="author" content="Bagas Topati">

    <!-- Webmanifest + Favicon / App icons -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/png" href="assets/app-icons/icon-32x32.png" sizes="32x32">
    <link rel="apple-touch-icon" href="assets/app-icons/icon-180x180.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Theme switcher (color modes) -->
    <script src="assets/js/theme-switcher.js"></script>

    <!-- Preloaded local web font (Inter) -->
    <link rel="preload" href="assets/fonts/inter-variable-latin.woff2" as="font" type="font/woff2" crossorigin>

    <!-- Font icons -->
    <link rel="preload" href="{{ url('assets/icons/cartzilla-icons.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ url('assets/icons/cartzilla-icons.min.css') }}">

    <!-- Vendor styles -->
    <link rel="stylesheet" href="{{ url('assets/vendor/choices.js/public/assets/styles/choices.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendor/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendor/simplebar/dist/simplebar.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendor/glightbox/dist/css/glightbox.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendor/sweet-alert/sweet-alert.min.css') }}">

    <!-- Bootstrap + Theme styles -->
    <link rel="stylesheet" href="{{ url('assets/css/theme.min.css') }}" id="theme-styles">
</head>


<!-- Body -->

<body>

    <!-- Shopping cart offcanvas (Empty state) -->
    <div class="offcanvas offcanvas-end pb-sm-2 px-sm-2" id="shoppingCart" tabindex="-1"
        aria-labelledby="shoppingCartLabel" style="width: 500px">
        <div class="offcanvas-header py-3 pt-lg-4">
            <h4 class="offcanvas-title" id="shoppingCartLabel">Shopping cart</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">

            @include('frontend.cart.list')

            
        </div>
        <div class="offcanvas-header flex-column align-items-start">
            
            <div class="d-flex w-100 gap-3">
                <a class="btn btn-lg btn-dark w-100" href="{{ route('web.checkout')}}">Checkout</a>
            </div>
        </div>
    </div>


    <!-- Topbar -->
    <div class="container position-relative d-flex justify-content-between z-1 py-3">
        <div class="nav animate-underline">
            <span class="text-secondary-emphasis fs-xs me-1">Contact us <span
                    class="d-none d-sm-inline">24/7</span></span>
            <a class="nav-link animate-target fs-xs fw-semibold p-0"
                href="tel:{{ $option->getByKey('contact') }}">{{ $option->getByKey('contact') }}</a>
        </div>
        {{-- <a class="text-secondary-emphasis fs-xs text-decoration-none d-none d-md-inline" href="#!">🔥 The Biggest
            Sale Ever 50% Off</a> --}}
        <ul class="nav gap-4">
            {{-- <li class="animate-underline">
          <a class="nav-link animate-target fs-xs p-0" href="#!">Wishlist</a>
        </li> --}}

            @if (Auth::check())
                <li class="animate-underline">
                    <a class="nav-link animate-target fs-xs p-0" href="{{ route('web.my-account') }}">Account</a>
                </li>
            @else
                <li class="animate-underline">
                    <a class="nav-link animate-target fs-xs p-0"
                        href="{{ route('web.auth.login') }}">Login/Register</a>
                </li>
            @endif
        </ul>
    </div>


    <!-- Navigation bar (Page header) -->
    <header class="navbar-sticky sticky-top container z-fixed px-2" data-sticky-element>
        <div class="navbar navbar-expand-lg flex-nowrap bg-body rounded-pill shadow ps-0 mx-1">
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark rounded-pill z-0 d-none d-block-dark">
            </div>

            <!-- Mobile offcanvas menu toggler (Hamburger) -->
            <button type="button" class="navbar-toggler ms-3" data-bs-toggle="offcanvas"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar brand (Logo) -->
            <a class="navbar-brand position-relative z-1 ms-4 ms-sm-5 ms-lg-4 me-2 me-sm-0 me-lg-3"
                href="{{ url('/') }}">{{ $option->getByKey('site_name') }}</a>

            <!-- Main navigation that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
            <nav class="offcanvas offcanvas-start" id="navbarNav" tabindex="-1" aria-labelledby="navbarNavLabel">
                <div class="offcanvas-header py-3">
                    <h5 class="offcanvas-title" id="navbarNavLabel">Browse Cartzilla</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body pt-3 pb-4 py-lg-0 mx-lg-auto">
                    <ul class="navbar-nav position-relative">

                        @if ($mainMenus->items->count() > 0)
                            @foreach ($mainMenus->items()->orderBy('order', 'ASC')->get() as $menu)
                                <li class="nav-item me-lg-n2 me-xl-0">
                                    <a class="nav-link fs-sm" href="{{ $menu->url }}">{{ $menu->label }}</a>
                                </li>
                            @endforeach
                        @endif



                        {{-- <li class="nav-item dropdown me-lg-n1 me-xl-0">
                            <a class="nav-link dropdown-toggle fs-sm active" aria-current="page" href="#"
                                role="button" data-bs-toggle="dropdown" data-bs-trigger="hover"
                                aria-expanded="false">Home</a>
                            <ul class="dropdown-menu" style="--cz-dropdown-spacer: 1rem">
                                <li class="hover-effect-opacity px-2 mx-n2">
                                    <a class="dropdown-item d-block mb-0" href="home-electronics.html">
                                        <span class="fw-medium">Electronics Store</span>
                                        <span class="d-block fs-xs text-body-secondary">Megamenu + Hero slider</span>
                                        <div class="d-none d-lg-block hover-effect-target position-absolute top-0 start-100 bg-body border border-light-subtle rounded rounded-start-0 transition-none invisible opacity-0 pt-2 px-2 ms-n2"
                                            style="width: 212px; height: calc(100% + 2px); margin-top: -1px">
                                            <img class="position-relative z-2 d-none-dark"
                                                src="assets/img/mega-menu/demo-preview/electronics-light.jpg"
                                                alt="Electronics Store">
                                            <img class="position-relative z-2 d-none d-block-dark"
                                                src="assets/img/mega-menu/demo-preview/electronics-dark.jpg"
                                                alt="Electronics Store">
                                            <span
                                                class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none-dark"
                                                style="box-shadow: .875rem .5rem 2rem -.5rem #676f7b; opacity: .1"></span>
                                            <span
                                                class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none d-block-dark"
                                                style="box-shadow: .875rem .5rem 1.875rem -.5rem #080b12; opacity: .25"></span>
                                        </div>
                                    </a>
                                </li>
                                <li class="hover-effect-opacity px-2 mx-n2">
                                    <a class="dropdown-item d-block mb-0" href="home-fashion-v1.html">
                                        <span class="fw-medium">Fashion Store v.1</span>
                                        <span class="d-block fs-xs text-body-secondary">Hero promo slider</span>
                                        <div class="d-none d-lg-block hover-effect-target position-absolute top-0 start-100 bg-body border border-light-subtle rounded rounded-start-0 transition-none invisible opacity-0 pt-2 px-2 ms-n2"
                                            style="width: 212px; height: calc(100% + 2px); margin-top: -1px">
                                            <img class="position-relative z-2 d-none-dark"
                                                src="assets/img/mega-menu/demo-preview/fashion-1-light.jpg"
                                                alt="Fashion Store v.1">
                                            <img class="position-relative z-2 d-none d-block-dark"
                                                src="assets/img/mega-menu/demo-preview/fashion-1-dark.jpg"
                                                alt="Fashion Store v.1">
                                            <span
                                                class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none-dark"
                                                style="box-shadow: .875rem .5rem 2rem -.5rem #676f7b; opacity: .1"></span>
                                            <span
                                                class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none d-block-dark"
                                                style="box-shadow: .875rem .5rem 1.875rem -.5rem #080b12; opacity: .25"></span>
                                        </div>
                                    </a>
                                </li>
                                <li class="hover-effect-opacity px-2 mx-n2">
                                    <a class="dropdown-item d-block mb-0" href="home-fashion-v2.html">
                                        <span class="fw-medium">Fashion Store v.2</span>
                                        <span class="d-block fs-xs text-body-secondary">Hero banner with
                                            hotspots</span>
                                        <div class="d-none d-lg-block hover-effect-target position-absolute top-0 start-100 bg-body border border-light-subtle rounded rounded-start-0 transition-none invisible opacity-0 pt-2 px-2 ms-n2"
                                            style="width: 212px; height: calc(100% + 2px); margin-top: -1px">
                                            <img class="position-relative z-2 d-none-dark"
                                                src="assets/img/mega-menu/demo-preview/fashion-2-light.jpg"
                                                alt="Fashion Store v.2">
                                            <img class="position-relative z-2 d-none d-block-dark"
                                                src="assets/img/mega-menu/demo-preview/fashion-2-dark.jpg"
                                                alt="Fashion Store v.2">
                                            <span
                                                class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none-dark"
                                                style="box-shadow: .875rem .5rem 2rem -.5rem #676f7b; opacity: .1"></span>
                                            <span
                                                class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none d-block-dark"
                                                style="box-shadow: .875rem .5rem 1.875rem -.5rem #080b12; opacity: .25"></span>
                                        </div>
                                    </a>
                                </li>
                                <li class="hover-effect-opacity px-2 mx-n2">
                                    <a class="dropdown-item d-block mb-0" href="home-furniture.html">
                                        <span class="fw-medium">Furniture Store</span>
                                        <span class="d-block fs-xs text-body-secondary">Fancy product carousel</span>
                                        <div class="d-none d-lg-block hover-effect-target position-absolute top-0 start-100 bg-body border border-light-subtle rounded rounded-start-0 transition-none invisible opacity-0 pt-2 px-2 ms-n2"
                                            style="width: 212px; height: calc(100% + 2px); margin-top: -1px">
                                            <img class="position-relative z-2 d-none-dark"
                                                src="assets/img/mega-menu/demo-preview/furniture-light.jpg"
                                                alt="Furniture Store">
                                            <img class="position-relative z-2 d-none d-block-dark"
                                                src="assets/img/mega-menu/demo-preview/furniture-dark.jpg"
                                                alt="Furniture Store">
                                            <span
                                                class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none-dark"
                                                style="box-shadow: .875rem .5rem 2rem -.5rem #676f7b; opacity: .1"></span>
                                            <span
                                                class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none d-block-dark"
                                                style="box-shadow: .875rem .5rem 1.875rem -.5rem #080b12; opacity: .25"></span>
                                        </div>
                                    </a>
                                </li>
                                <li class="hover-effect-opacity px-2 mx-n2">
                                    <a class="dropdown-item d-block mb-0" href="home-grocery.html">
                                        <span class="fw-medium">Grocery Store</span>
                                        <span class="d-block fs-xs text-body-secondary">Hero slider + Category
                                            cards</span>
                                        <div class="d-none d-lg-block hover-effect-target position-absolute top-0 start-100 bg-body border border-light-subtle rounded rounded-start-0 transition-none invisible opacity-0 pt-2 px-2 ms-n2"
                                            style="width: 212px; height: calc(100% + 2px); margin-top: -1px">
                                            <img class="position-relative z-2 d-none-dark"
                                                src="assets/img/mega-menu/demo-preview/grocery-light.jpg"
                                                alt="Grocery Store">
                                            <img class="position-relative z-2 d-none d-block-dark"
                                                src="assets/img/mega-menu/demo-preview/grocery-dark.jpg"
                                                alt="Grocery Store">
                                            <span
                                                class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none-dark"
                                                style="box-shadow: .875rem .5rem 2rem -.5rem #676f7b; opacity: .1"></span>
                                            <span
                                                class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none d-block-dark"
                                                style="box-shadow: .875rem .5rem 1.875rem -.5rem #080b12; opacity: .25"></span>
                                        </div>
                                    </a>
                                </li>
                                <li class="hover-effect-opacity px-2 mx-n2">
                                    <a class="dropdown-item d-block mb-0" href="home-marketplace.html">
                                        <span class="fw-medium">Marketplace</span>
                                        <span class="d-block fs-xs text-body-secondary">Multi-vendor, digital
                                            goods</span>
                                        <div class="d-none d-lg-block hover-effect-target position-absolute top-0 start-100 bg-body border border-light-subtle rounded rounded-start-0 transition-none invisible opacity-0 pt-2 px-2 ms-n2"
                                            style="width: 212px; height: calc(100% + 2px); margin-top: -1px">
                                            <img class="position-relative z-2 d-none-dark"
                                                src="assets/img/mega-menu/demo-preview/marketplace-light.jpg"
                                                alt="Marketplace">
                                            <img class="position-relative z-2 d-none d-block-dark"
                                                src="assets/img/mega-menu/demo-preview/marketplace-dark.jpg"
                                                alt="Marketplace">
                                            <span
                                                class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none-dark"
                                                style="box-shadow: .875rem .5rem 2rem -.5rem #676f7b; opacity: .1"></span>
                                            <span
                                                class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none d-block-dark"
                                                style="box-shadow: .875rem .5rem 1.875rem -.5rem #080b12; opacity: .25"></span>
                                        </div>
                                    </a>
                                </li>
                                <li class="hover-effect-opacity px-2 mx-n2">
                                    <a class="dropdown-item d-block mb-0" href="home-single-store.html">
                                        <span class="fw-medium">Single Product Store</span>
                                        <span class="d-block fs-xs text-body-secondary">Single product / mono
                                            brand</span>
                                        <div class="d-none d-lg-block hover-effect-target position-absolute top-0 start-100 bg-body border border-light-subtle rounded rounded-start-0 transition-none invisible opacity-0 pt-2 px-2 ms-n2"
                                            style="width: 212px; height: calc(100% + 2px); margin-top: -1px">
                                            <img class="position-relative z-2 d-none-dark"
                                                src="assets/img/mega-menu/demo-preview/single-store-light.jpg"
                                                alt="Single Product Store">
                                            <img class="position-relative z-2 d-none d-block-dark"
                                                src="assets/img/mega-menu/demo-preview/single-store-dark.jpg"
                                                alt="Single Product Store">
                                            <span
                                                class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none-dark"
                                                style="box-shadow: .875rem .5rem 2rem -.5rem #676f7b; opacity: .1"></span>
                                            <span
                                                class="position-absolute top-0 start-0 w-100 h-100 rounded rounded-start-0 d-none d-block-dark"
                                                style="box-shadow: .875rem .5rem 1.875rem -.5rem #080b12; opacity: .25"></span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}
                    </ul>
                </div>
            </nav>

            <!-- Button group -->
            <div class="d-flex gap-sm-1 position-relative z-1">

                <!-- Theme switcher (light/dark/auto) -->
                <div class="dropdown">
                    <button type="button"
                        class="theme-switcher btn btn-icon btn-outline-secondary fs-lg border-0 rounded-circle animate-scale"
                        data-bs-toggle="dropdown" data-bs-display="dynamic" aria-expanded="false"
                        aria-label="Toggle theme (light)">
                        <span class="theme-icon-active d-flex animate-target">
                            <i class="ci-sun"></i>
                        </span>
                    </button>
                    <ul class="dropdown-menu start-50 translate-middle-x"
                        style="--cz-dropdown-min-width: 9rem; --cz-dropdown-spacer: 1rem">
                        <li>
                            <button type="button" class="dropdown-item active" data-bs-theme-value="light"
                                aria-pressed="true">
                                <span class="theme-icon d-flex fs-base me-2">
                                    <i class="ci-sun"></i>
                                </span>
                                <span class="theme-label">Light</span>
                                <i class="item-active-indicator ci-check ms-auto"></i>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item" data-bs-theme-value="dark"
                                aria-pressed="false">
                                <span class="theme-icon d-flex fs-base me-2">
                                    <i class="ci-moon"></i>
                                </span>
                                <span class="theme-label">Dark</span>
                                <i class="item-active-indicator ci-check ms-auto"></i>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item" data-bs-theme-value="auto"
                                aria-pressed="false">
                                <span class="theme-icon d-flex fs-base me-2">
                                    <i class="ci-auto"></i>
                                </span>
                                <span class="theme-label">Auto</span>
                                <i class="item-active-indicator ci-check ms-auto"></i>
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Cart button -->
                <button type="button"
                    class="btn btn-icon fs-lg btn-outline-secondary border-0 rounded-circle animate-scale me-2"
                    data-bs-toggle="offcanvas" data-bs-target="#shoppingCart" aria-controls="shoppingCart"
                    aria-label="Shopping cart">
                    <i class="ci-shopping-cart animate-target"></i>
                </button>

                <!-- Search -->
                <div class="dropdown">
                    <button type="button" class="btn btn-icon fs-lg btn-secondary rounded-circle animate-scale"
                        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-label="Toggle search bar">
                        <i class="ci-search animate-target"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end p-3"
                        style="--cz-dropdown-min-width: 20rem; --cz-dropdown-spacer: 1rem">
                        <form class="position-relative">
                            <input type="search" class="form-control rounded-pill" placeholder="Search..."
                                data-autofocus="dropdown">
                            <button type="submit"
                                class="btn btn-icon btn-sm fs-lg btn-secondary rounded-circle position-absolute top-0 end-0 mt-1 me-1"
                                aria-label="Search">
                                <i class="ci-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>


    @yield('content')

    <!-- Page footer -->
    <footer class="footer bg-dark pb-4 py-lg-5" data-bs-theme="dark">
        <div class="container pt-5 pt-lg-4 mt-sm-2 mt-md-3">
            <div class="row pb-5">

                <!-- Subscription + Social account links -->
                <div class="col-md col-xl-8 order-md-2">
                    <div class="text-center px-sm-4 mx-auto" style="max-width: 568px">
                        <h3 class="pb-1 mb-2">Stay in touch with us</h3>
                        <p class="fs-sm text-body pb-2 pb-sm-3">Receive the latest updates about our products &amp;
                            promotions</p>
                        <form class="needs-validation position-relative" novalidate>
                            <input type="email" class="form-control form-control-lg rounded-pill text-start"
                                placeholder="You email" aria-label="Your email address" required>
                            <div class="invalid-tooltip bg-transparent p-0">Please enter you email address!</div>
                            <button type="submit"
                                class="btn btn-icon fs-xl btn-dark rounded-circle position-absolute top-0 end-0 mt-1 me-1"
                                aria-label="Submit your email address" data-bs-theme="light">
                                <i class="ci-arrow-up-right"></i>
                            </button>
                        </form>
                        <div class="d-flex justify-content-center gap-2 pt-4 pt-md-5 mt-1 mt-md-0">
                            <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!"
                                data-bs-toggle="tooltip"
                                data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-white p-0"></div></div>'
                                title="YouTube" aria-label="Follow us on YouTube">
                                <i class="ci-youtube"></i>
                            </a>
                            <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!"
                                data-bs-toggle="tooltip"
                                data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-white p-0"></div></div>'
                                title="Facebook" aria-label="Follow us on Facebook">
                                <i class="ci-facebook"></i>
                            </a>
                            <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!"
                                data-bs-toggle="tooltip"
                                data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-white p-0"></div></div>'
                                title="Instagram" aria-label="Follow us on Instagram">
                                <i class="ci-instagram"></i>
                            </a>
                            <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!"
                                data-bs-toggle="tooltip"
                                data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-white p-0"></div></div>'
                                title="Telegram" aria-label="Follow us on Telegram">
                                <i class="ci-telegram"></i>
                            </a>
                            <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!"
                                data-bs-toggle="tooltip"
                                data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-white p-0"></div></div>'
                                title="Pinterest" aria-label="Follow us on Pinterest">
                                <i class="ci-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Category links -->
                <div class="col-md-auto col-xl-2 text-center order-md-1 pt-4 pt-md-0">
                    <ul class="nav d-inline-flex flex-md-column justify-content-center align-items-center gap-md-2">
                        <li class="animate-underline my-1 mx-2 m-md-0">
                            <a class="nav-link d-inline-flex fw-normal p-0 animate-target" href="#!">Bedroom</a>
                        </li>
                        <li class="animate-underline my-1 mx-2 m-md-0">
                            <a class="nav-link d-inline-flex fw-normal p-0 animate-target" href="#!">Living
                                room</a>
                        </li>
                        <li class="animate-underline my-1 mx-2 m-md-0">
                            <a class="nav-link d-inline-flex fw-normal p-0 animate-target" href="#!">Bathroom</a>
                        </li>
                        <li class="animate-underline my-1 mx-2 m-md-0">
                            <a class="nav-link d-inline-flex fw-normal p-0 animate-target"
                                href="#!">Decoration</a>
                        </li>
                        <li class="animate-underline my-1 mx-2 m-md-0">
                            <a class="nav-link d-inline-flex fw-normal p-0 animate-target" href="#!">Kitchen</a>
                        </li>
                        <li class="animate-underline my-1 mx-2 m-md-0">
                            <a class="nav-link d-inline-flex fw-normal p-0 animate-target" href="#!">Sale</a>
                        </li>
                    </ul>
                </div>

                <!-- Customer links -->
                <div class="col-md-auto col-xl-2 text-center order-md-3 pt-3 pt-md-0">
                    <ul class="nav d-inline-flex flex-md-column justify-content-center align-items-center gap-md-2">
                        <li class="animate-underline my-1 mx-2 m-md-0">
                            <a class="nav-link d-inline-flex fw-normal p-0 animate-target" href="#!">Shipping
                                options</a>
                        </li>
                        <li class="animate-underline my-1 mx-2 m-md-0">
                            <a class="nav-link d-inline-flex fw-normal p-0 animate-target" href="#!">Tracking a
                                package</a>
                        </li>
                        <li class="animate-underline my-1 mx-2 m-md-0">
                            <a class="nav-link d-inline-flex fw-normal p-0 animate-target" href="#!">Help
                                center</a>
                        </li>
                        <li class="animate-underline my-1 mx-2 m-md-0">
                            <a class="nav-link d-inline-flex fw-normal p-0 animate-target" href="#!">Contact
                                us</a>
                        </li>
                        <li class="animate-underline my-1 mx-2 m-md-0">
                            <a class="nav-link d-inline-flex fw-normal p-0 animate-target" href="#!">Product
                                returns</a>
                        </li>
                        <li class="animate-underline my-1 mx-2 m-md-0">
                            <a class="nav-link d-inline-flex fw-normal p-0 animate-target"
                                href="#!">Locations</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <p class="fs-xs text-body text-center pt-lg-4 mt-n2 mt-md-0 mb-0">
                &copy; All rights reserved. Made by <span class="animate-underline"><a
                        class="animate-target text-white text-decoration-none" href="https://createx.studio/"
                        target="_blank" rel="noreferrer">Createx Studio</a></span>
            </p>
        </div>
    </footer>


    <!-- Back to top button -->
    <div class="floating-buttons position-fixed top-50 end-0 z-sticky me-3 me-xl-4 pb-4">
        <a class="btn-scroll-top btn btn-sm bg-body border-0 rounded-pill shadow animate-slide-end" href="#top">
            Top
            <i class="ci-arrow-right fs-base ms-1 me-n1 animate-target"></i>
            <span class="position-absolute top-0 start-0 w-100 h-100 border rounded-pill z-0"></span>
            <svg class="position-absolute top-0 start-0 w-100 h-100 z-1" viewBox="0 0 62 32" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <rect x=".75" y=".75" width="60.5" height="30.5" rx="15.25" stroke="currentColor"
                    stroke-width="1.5" stroke-miterlimit="10" />
            </svg>
        </a>
    </div>


    <!-- Vendor scripts -->
    <script src="{{ url('assets/js/jquery.min.js')}}"></script>
    <script src="{{ url('assets/vendor/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script src="{{ url('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ url('assets/vendor/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ url('assets/vendor/glightbox/dist/js/glightbox.min.js') }}"></script>
    <script src="{{ url('assets/vendor/sweet-alert/sweet-alert.min.js') }}"></script>



    <!-- Bootstrap + Theme scripts -->
    <script src="{{ url('assets/js/theme.min.js') }}"></script>

    <script>

            const App = {
                Models: {
                    Shipping: {
                        getProvinces: async(data = {}) => {
                            return $.ajax({
                                url: "{{ route('web.shipping.provinces') }}",
                                data: data
                            })
                        },
                        getRegencies: async(data) => {
                            return $.ajax({
                                url: "{{ route('web.shipping.regencies') }}",
                                data: data
                            })
                        }
                    }
                }
            }

            const removeCart = async(key) => {
                return await $.ajax({
                    url: "{{route('cart.remove')}}",
                    method: 'POST',
                    data:{
                        key: key
                    }
                })
            }

            const addToCart = async (data) => {
                let form = $('#form-add_to_cart');
                return await $.ajax({
                    url: "{{ route('cart.add') }}",
                    method: 'POST',
                    data: data
                })
            }

            const refreshCart = async () => {
                try {
                    const response = await $.ajax({
                        url: "{{ route('cart.index') }}"
                    });
                    
                    let shoppingCartBody = $('#shoppingCart').find('.offcanvas-body')// Update cart UI with the new data
                    shoppingCartBody.html(response);
                    
                } catch (error) {
                    console.error('Error fetching cart:', error);
                }
            };

            // Add to cart form submission
            $('#form-add_to_cart').on('submit', async function(e) {
                e.preventDefault();
                await addToCart($(this).serialize());
                await refreshCart();
            });

            $(document).on('click', '.btn-remove_from_cart', async function(e){
                e.preventDefault();
                await removeCart($(this).data('key'));
                await refreshCart();
            })

            $(document).on('click', '.btn-single_add_to_cart', async function(e){
                e.preventDefault();
                await addToCart({
                    product_id: $(this).data('key')
                })
                await refreshCart();
            })
    </script>

    @yield('footer_scripts')
</body>

</html>
