<!DOCTYPE html>
<html lang="en" data-bs-theme="light" data-pwa="true">

<head>
    <meta charset="utf-8">

    <!-- Viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">

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
    {{-- <script src="assets/js/theme-switcher.js"></script> --}}

    <!-- Preloaded local web font (Inter) -->
    <link rel="preload" href="assets/fonts/inter-variable-latin.woff2" as="font" type="font/woff2" crossorigin>

    <!-- Font icons -->
    <link rel="preload" href="{{ url('assets/icons/cartzilla-icons.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ url('assets/icons/cartzilla-icons.min.css') }}">

    <!-- Vendor styles -->
    <link rel="stylesheet" href="{{ url('assets/vendor/choices.js/public/assets/styles/choices.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendor/flatpickr/dist/flatpickr.min.css') }}">
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
                        href="{{ route('login') }}">Login/Register</a>
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
                href="{{ url('/') }}">
                
                @if($logo = $option->getByKey('site_logo'))
                
               <img src="{{ url('storage/' . $logo) }}" alt="{{$option->getByKey('site_name')}}" width="40">

                @else 
                     {{ $option->getByKey('site_name') }}
                @endif
            
            </a>

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
                    {{-- <button type="button"
                        class="theme-switcher btn btn-icon btn-outline-secondary fs-lg border-0 rounded-circle animate-scale"
                        data-bs-toggle="dropdown" data-bs-display="dynamic" aria-expanded="false"
                        aria-label="Toggle theme (light)">
                        <span class="theme-icon-active d-flex animate-target">
                            <i class="ci-sun"></i>
                        </span>
                    </button> --}}
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
                    id="btnShoppingCart"
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
                        <form class="position-relative" action="{{route('web.blogs')}}">
                            <input name="s" type="search" class="form-control rounded-pill" placeholder="Search..."
                                data-autofocus="dropdown" value="{{request('s')}}">
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
    <footer class="footer bg-dark pb-4" data-bs-theme="dark">

      <div class="container py-4 py-md-5">
        <div class="row pt-3 pb-4 py-md-1 py-lg-3">

          <!-- Promo text + Social account links -->
          <div class="col-lg-3 text-center text-lg-start pb-sm-2 pb-md-0 mb-4 mb-md-5 mb-lg-0">
            <h4 class="pb-2 mb-1">
              <a class="text-dark-emphasis text-decoration-none" href="index.html">{{$option->getByKey('site_name')}}</a>
            </h4>
            <p class="fs-sm text-body mx-auto" style="max-width: 480px">{{$option->getByKey('site_description')}}</p>
            <div class="d-flex justify-content-center justify-content-lg-start gap-2 pt-2 pt-md-3">
              <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!" data-bs-toggle="tooltip" data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-white p-0"></div></div>' title="Instagram" aria-label="Follow us on Instagram">
                <i class="ci-instagram"></i>
              </a>
              <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!" data-bs-toggle="tooltip" data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-white p-0"></div></div>' title="Facebook" aria-label="Follow us on Facebook">
                <i class="ci-facebook"></i>
              </a>
              <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!" data-bs-toggle="tooltip" data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-white p-0"></div></div>' title="Telegram" aria-label="Follow us on Telegram">
                <i class="ci-telegram"></i>
              </a>
              <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!" data-bs-toggle="tooltip" data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-white p-0"></div></div>' title="WhatsApp" aria-label="Follow us on WhatsApp">
                <i class="ci-whatsapp"></i>
              </a>
            </div>
          </div>

          <!-- Columns with links that are turned into accordion on screens < 500px wide (sm breakpoint) -->
          <div class="col-lg-8 offset-lg-1">
            <div class="accordion" id="footerLinks">
              <div class="row">
                <div class="accordion-item col-sm-3 border-0">
                  <h6 class="accordion-header" id="categoriesHeading">
                    <span class="text-dark-emphasis d-none d-sm-block">Categories</span>
                    <button type="button" class="accordion-button collapsed py-3 d-sm-none" data-bs-toggle="collapse" data-bs-target="#categoriesLinks" aria-expanded="false" aria-controls="categoriesLinks">Categories</button>
                  </h6>
                  <div class="accordion-collapse collapse d-sm-block" id="categoriesLinks" aria-labelledby="categoriesHeading" data-bs-parent="#footerLinks">
                    <ul class="nav flex-column gap-2 pt-sm-3 pb-3 pb-sm-0 mt-n1 mb-1 mb-sm-0">
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Weekly sale</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Special price</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Easter is coming</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Italian dinner</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Fresh fruits</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Exotic fruits</a>
                      </li>
                    </ul>
                  </div>
                  <hr class="d-sm-none my-0">
                </div>
                <div class="accordion-item col-sm-3 border-0">
                  <h6 class="accordion-header" id="companyHeading">
                    <span class="text-dark-emphasis d-none d-sm-block">Company</span>
                    <button type="button" class="accordion-button collapsed py-3 d-sm-none" data-bs-toggle="collapse" data-bs-target="#companyLinks" aria-expanded="false" aria-controls="companyLinks">Company</button>
                  </h6>
                  <div class="accordion-collapse collapse d-sm-block" id="companyLinks" aria-labelledby="companyHeading" data-bs-parent="#footerLinks">
                    <ul class="nav flex-column gap-2 pt-sm-3 pb-3 pb-sm-0 mt-n1 mb-1 mb-sm-0">
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Blog and news</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">About us</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">FAQ page</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Contact us</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Careers</a>
                      </li>
                    </ul>
                  </div>
                  <hr class="d-sm-none my-0">
                </div>
                <div class="accordion-item col-sm-3 border-0">
                  <h6 class="accordion-header" id="accountHeading">
                    <span class="text-dark-emphasis d-none d-sm-block">Account</span>
                    <button type="button" class="accordion-button collapsed py-3 d-sm-none" data-bs-toggle="collapse" data-bs-target="#accountLinks" aria-expanded="false" aria-controls="accountLinks">Account</button>
                  </h6>
                  <div class="accordion-collapse collapse d-sm-block" id="accountLinks" aria-labelledby="accountHeading" data-bs-parent="#footerLinks">
                    <ul class="nav flex-column gap-2 pt-sm-3 pb-3 pb-sm-0 mt-n1 mb-1 mb-sm-0">
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Your account</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Shipping &amp; policies</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Refunds &amp; replacements</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Order tracking</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Delivery info</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Taxes &amp; fees</a>
                      </li>
                    </ul>
                  </div>
                  <hr class="d-sm-none my-0">
                </div>
                <div class="accordion-item col-sm-3 border-0">
                  <h6 class="accordion-header" id="customerHeading">
                    <span class="text-dark-emphasis d-none d-sm-block">Customer service</span>
                    <button type="button" class="accordion-button collapsed py-3 d-sm-none" data-bs-toggle="collapse" data-bs-target="#customerLinks" aria-expanded="false" aria-controls="customerLinks">Customer service</button>
                  </h6>
                  <div class="accordion-collapse collapse d-sm-block" id="customerLinks" aria-labelledby="customerHeading" data-bs-parent="#footerLinks">
                    <ul class="nav flex-column gap-2 pt-sm-3 pb-3 pb-sm-0 mt-n1 mb-1 mb-sm-0">
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Payment methods</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Money back guarantee</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Refunds &amp; replacements</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Order tracking</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Delivery info</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Shipping</a>
                      </li>
                    </ul>
                  </div>
                  <hr class="d-sm-none my-0">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Copyright -->
      <p class="container fs-xs text-body text-center text-lg-start pb-md-3 mb-0">
       {!! $option->getByKey('site_copyright') !!}
      </p>
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
    <script src="{{ url('assets/vendor/flatpickr/dist/flatpickr.min.js') }}"></script>
    <script src="{{ url('assets/vendor/cleave.js/dist/cleave.min.js') }} "></script>
    <script src="{{ url('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ url('assets/vendor/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ url('assets/vendor/glightbox/dist/js/glightbox.min.js') }}"></script>
    <script src="{{ url('assets/vendor/sweet-alert/sweet-alert.min.js') }}"></script>
    <script src="{{ url('assets/js/currency.min.js')}}  "></script>



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
                        },
                        getCost: async(data) => {
                            return $.ajax({
                                method: 'POST',
                                url: "{{ route('web.shipping.cost') }}",
                                data: data
                            })
                        },
                    }
                },
                Helper: {
                    sumPrices: function(...prices) {
                        let total = currency(0, {
                            separator:',',
                            decimal: '.',
                            precision: 0,
                            symbol: ''
                        });

                        prices.forEach(function (price) {
                            total = total.add(currency(price, {
                                separator: ',',
                                decimal: '.',
                                precision: 0,
                                symbol: ''
                            }));
                        });

                        return total.format(); // default: Rp10.000
                    }
                }
            }

            const removeCart = async(key) => {
                return await $.ajax({
                    url: "{{route('cart.remove')}}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data:{
                        product_id: key
                    }
                })
            }

            const updateCartQuantity = async(productId, quantity) => {
                return await $.ajax({
                    url: "{{route('cart.update')}}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        product_id: productId,
                        quantity: quantity
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

                await Swal.fire({
                    icon: 'success',
                    title: 'Information',
                    text: 'Product added to cart'
                })
            });

            $(document).on('click', '.btn-remove_from_cart', async function(e){
                e.preventDefault();
                const productId = $(this).data('product-id') || $(this).data('key');
                
                // Show confirmation dialog
                const result = await Swal.fire({
                    title: 'Remove Item?',
                    text: 'Are you sure you want to remove this item from cart?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, remove it!'
                });
                
                if (result.isConfirmed) {
                    // Show loading on button
                    const originalContent = $(this).html();
                    $(this).prop('disabled', true).html('<div class="spinner-border spinner-border-sm" role="status"></div>');
                    
                    try {
                        // Show loading skeleton
                        showCartLoading();
                        
                        await removeCart(productId);
                        await refreshCart();

                        // Show success toast
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                        Toast.fire({
                            icon: 'success',
                            title: 'Item removed from cart'
                        });
                        
                    } catch (error) {
                        console.error('Error removing from cart:', error);
                        await refreshCart(); // Refresh to restore original state
                        
                        await Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to remove item from cart'
                        });
                        
                        // Restore button
                        $(this).prop('disabled', false).html(originalContent);
                    }
                }

            })

            // Function to show cart loading skeleton
            const showCartLoading = () => {
                const cartBody = $('#shoppingCart').find('.offcanvas-body');
                cartBody.html(`
                    <div class="cart-loading-skeleton">
                        <div class="d-flex align-items-center mb-3">
                            <div class="skeleton-image me-3"></div>
                            <div class="flex-grow-1">
                                <div class="skeleton-line mb-2"></div>
                                <div class="skeleton-line-small mb-2"></div>
                                <div class="d-flex justify-content-between">
                                    <div class="skeleton-counter"></div>
                                    <div class="skeleton-remove"></div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="skeleton-image me-3"></div>
                            <div class="flex-grow-1">
                                <div class="skeleton-line mb-2"></div>
                                <div class="skeleton-line-small mb-2"></div>
                                <div class="d-flex justify-content-between">
                                    <div class="skeleton-counter"></div>
                                    <div class="skeleton-remove"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                        .cart-loading-skeleton {
                            animation: pulse 1.5s ease-in-out infinite;
                        }
                        .skeleton-image {
                            width: 110px;
                            height: 70px;
                            background: #f0f0f0;
                            border-radius: 8px;
                        }
                        .skeleton-line {
                            height: 16px;
                            background: #f0f0f0;
                            border-radius: 4px;
                            width: 70%;
                        }
                        .skeleton-line-small {
                            height: 12px;
                            background: #f0f0f0;
                            border-radius: 4px;
                            width: 50%;
                        }
                        .skeleton-counter {
                            height: 32px;
                            width: 120px;
                            background: #f0f0f0;
                            border-radius: 4px;
                        }
                        .skeleton-remove {
                            height: 24px;
                            width: 24px;
                            background: #f0f0f0;
                            border-radius: 50%;
                        }
                        @keyframes pulse {
                            0%, 100% { opacity: 1; }
                            50% { opacity: 0.5; }
                        }
                    </style>
                `);
            };

            // Cart increment button handler
            $(document).on('click', '.btn-cart-increment', async function(e) {
                e.preventDefault();
                const cartKey = $(this).data('key');
                const productId = $(this).data('product-id');
                const qtyInput = $(`#cart-qty-${cartKey}`);
                const currentQty = parseInt(qtyInput.val()) || 0;
                const newQty = currentQty + 1;
                
                // Disable button and show loading state
                $(this).prop('disabled', true).html('<div class="spinner-border spinner-border-sm" role="status"></div>');
                
                try {
                    // Show loading skeleton
                    showCartLoading();
                    
                    await updateCartQuantity(productId, newQty);
                    await refreshCart();
                    
                    // Show success message briefly
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Quantity updated'
                    });
                    
                } catch (error) {
                    console.error('Error incrementing cart:', error);
                    await refreshCart(); // Refresh to restore original state
                    await Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update cart'
                    });
                }
            });

            // Cart decrement button handler
            $(document).on('click', '.btn-cart-decrement', async function(e) {
                e.preventDefault();
                const cartKey = $(this).data('key');
                const productId = $(this).data('product-id');
                const qtyInput = $(`#cart-qty-${cartKey}`);
                const currentQty = parseInt(qtyInput.val()) || 0;
                const newQty = Math.max(1, currentQty - 1); // Minimum quantity is 1
                
                // Don't process if already at minimum
                if (currentQty <= 1) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    Toast.fire({
                        icon: 'warning',
                        title: 'Minimum quantity is 1'
                    });
                    return;
                }
                
                // Disable button and show loading state
                $(this).prop('disabled', true).html('<div class="spinner-border spinner-border-sm" role="status"></div>');
                
                try {
                    // Show loading skeleton
                    showCartLoading();
                    
                    await updateCartQuantity(productId, newQty);
                    await refreshCart();
                    
                    // Show success message briefly
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Quantity updated'
                    });
                    
                } catch (error) {
                    console.error('Error decrementing cart:', error);
                    await refreshCart(); // Refresh to restore original state
                    await Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update cart'
                    });
                }
            });

            // $('#btnShoppingCart').on('click', function () {
            //     console.log('Opening shopping cart');
            //     var myOffcanvas = new bootstrap.Offcanvas($('#shoppingCart')[0]);
            //     myOffcanvas.show();
            // });

            $(document).on('click', '.btn-single_add_to_cart', async function(e){
                e.preventDefault();
                
                // Show loading on button
                const originalContent = $(this).html();
                $(this).prop('disabled', true).html('<div class="spinner-border spinner-border-sm me-2" role="status"></div>Adding...');
                
                try {
                    await addToCart({
                        product_id: $(this).data('key')
                    })
                    await refreshCart();

                    // Show success toast
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Product added to cart'
                    });

                }catch (error) {
                    console.error('Error adding to cart:', error.status);
                    if(error.status == 401) {
                        const result = await Swal.fire({
                            icon: 'error',
                            title: 'Login Required',
                            text: 'You must login to add product to cart',
                            showCancelButton: true,
                            confirmButtonText: 'Login Now',
                            cancelButtonText: 'Cancel'
                        })

                        if(result.isConfirmed) {
                            window.location.href = "{{ route('login') }}";
                        }
                        return;
                    }else {
                        const result = await Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to add product to cart'
                        })
                        return;
                    }
                } finally {
                    // Restore button state
                    $(this).prop('disabled', false).html(originalContent);
                }
            })
    </script>

    <script>

        let courierElement = $('#iCourier');

        async function renderCosts(costs) {
            let html = `<option value=''>Pilih</option>`;
            $('#iCourierPackage').html('');

            (costs ?? []).map((cost, index) => {
                html += `<option value="${cost.code}|${cost.service}|${cost.cost}|${cost.etd}">Harga ${cost.cost} | ETD ${cost.etd}</option>`;
                
            })

            $('#iCourierPackage').html(html)
        }

        $(document).on('change', '#iCourier', async function(e){

            $('#delivery-price').val(0);
            const value = $(this).val();
            const costs = await App.Models.Shipping.getCost({
                courier: value
            });

            $('#delivery-price').html('');
            $('#iCourierPackage').html('<option value="">Pilih</option>');

            let cartPrice = $('#cart-price').html();
            var parts = value.split('|');
            var price = App.Helper.sumPrices(parts[2]); // index ke-2 = harga
            let total = App.Helper.sumPrices(price, cartPrice);

            $('#total-price').html(total);

            await renderCosts(costs.data.data);
        })

        $(document).on('change', '#iCourierPackage', async function(e){
            var value = $(this).val(); // ambil value terpilih
            console.log('value', value);
            if (value) {
                let cartPrice = $('#cart-price').html();
                var parts = value.split('|');
                var price = App.Helper.sumPrices(parts[2]); // index ke-2 = harga
                let total = App.Helper.sumPrices(price, cartPrice);

                $('#delivery-price').html(price);
                $('#total-price').html(total);
            } else {
                $('#delivery-price').html('');
            } 

           
        })



    </script>

    <script>
        // Dynamic menu active state for my-account pages
        document.addEventListener('DOMContentLoaded', function() {
            // Only run on my-account pages
            if (window.location.pathname.includes('/my-account')) {
                const currentPath = window.location.pathname;
                const menuItems = document.querySelectorAll('[data-menu]');
                
                // Remove active class from all menu items
                menuItems.forEach(item => {
                    item.classList.remove('active', 'pe-none');
                });
                
                // Set active menu based on current path
                let activeMenuItem = null;
                
                if (currentPath === '/my-account/personal-info') {
                    activeMenuItem = document.querySelector('[data-menu="personal-info"]');
                } else if (currentPath === '/my-account/addresses') {
                    activeMenuItem = document.querySelector('[data-menu="addresses"]');
                } else if (currentPath === '/my-account' || currentPath === '/my-account/') {
                    activeMenuItem = document.querySelector('[data-menu="orders"]');
                }
                
                // Add active class to the determined menu item
                if (activeMenuItem) {
                    activeMenuItem.classList.add('active', 'pe-none');
                }
            }
        });
    </script>

    @yield('footer_scripts')
</body>

</html>
