@extends('frontend.layouts.default')


@section('content')
    <!-- Page warpper -->
    <main class="content-wrapper">

        <!-- Post content + Sidebar sharing -->
        <section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <!-- Breadcrumb -->
                    <nav class="pt-3 my-3 my-md-4" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('web.blogs') }}">Blog</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
                        </ol>
                    </nav>

                    <!-- Post title -->
                    <h1 class="h3 mb-4">{{ $post->title }}</h1>

                    <!-- Post meta -->
                    <div class="nav align-items-center gap-2 border-bottom pb-4 mt-n1 mb-4">
                        {{-- <a class="nav-link text-body fs-xs text-uppercase p-0" href="#!">Tech news</a>
                        <hr class="vr my-1 mx-1"> --}}
                        <span class="text-body-tertiary fs-xs">
                            {{ date('d F Y', strtotime($post->created_at)) }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">

                <!-- Post content -->
                <div class="col-lg-8 offset-lg-2">

                    <figure class="figure w-100 py-3 py-md-4 mb-3">
                        <div class="ratio" style="--cz-aspect-ratio: calc(599 / 856 * 100%)">
                            <img src="{{ $post->featured_image_url }}" class="rounded-4" alt="{{ $post->title }}">
                        </div>
                        {{-- <figcaption class="figure-caption fs-sm pt-2">Image source Unsplash.com</figcaption> --}}
                    </figure>

                    <div>
                        {!! $post->content !!}
                    </div>


                    <!-- Tags + Sharing -->
                    <div
                        class="d-sm-flex align-items-center justify-content-between py-4 py-md-5 mt-n2 mt-md-n3 mb-2 mb-sm-3 mb-md-0">
                        <div class="d-flex flex-wrap gap-2 mb-4 mb-sm-0 me-sm-4">
                            @foreach ($post->categories as $category)
                                <a class="btn btn-outline-secondary px-3 mt-1 me-1" href="#!">{{ $category->name }}</a>
                            @endforeach
                        </div>

                        <!-- Sharing visible on screens < 992px wide (lg breakpoint) -->
                        <div class="d-flex d-lg-none align-items-center gap-2">
                            <div class="text-body-emphasis fs-sm fw-medium">Share:</div>

                            <!-- X (Twitter) Share -->
                            <a class="btn btn-icon fs-base btn-outline-secondary border-0"
                                href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}"
                                target="_blank" data-bs-toggle="tooltip"
                                data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>'
                                title="X (Twitter)" aria-label="Share on X">
                                <i class="ci-x"></i>
                            </a>

                            <!-- Facebook Share -->
                            <a class="btn btn-icon fs-base btn-outline-secondary border-0"
                                href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                target="_blank" data-bs-toggle="tooltip"
                                data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>'
                                title="Facebook" aria-label="Share on Facebook">
                                <i class="ci-facebook"></i>
                            </a>

                            <!-- Telegram Share -->
                            <a class="btn btn-icon fs-base btn-outline-secondary border-0"
                                href="https://t.me/share/url?url={{ urlencode(url()->current()) }}" target="_blank"
                                data-bs-toggle="tooltip"
                                data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>'
                                title="Telegram" aria-label="Share on Telegram">
                                <i class="ci-telegram"></i>
                            </a>
                        </div>

                    </div>

                    <!-- Post navigation -->
                    {{-- <div class="border-top pt-3 pt-md-4">
                        <div class="nav flex-nowrap align-items-center justify-content-between gap-4 pt-3">
                            <a class="nav-link flex-wrap flex-sm-nowrap justify-content-center position-relative w-50 p-0"
                                href="#!" style="max-width: 330px">
                                <div class="d-flex align-items-center mb-2 mb-sm-0">
                                    <i class="ci-chevron-left fs-xl ms-n3 ms-sm-n1 me-2"></i>
                                    <div class="ratio flex-shrink-0"
                                        style="width: 86px; --cz-aspect-ratio: calc(64 / 86 * 100%)">
                                        <img src="assets/img/blog/post/nav01.jpg" class="rounded-2" alt="Image">
                                    </div>
                                </div>
                                <div
                                    class="h6 fs-sm hover-effect-underline stretched-link text-center text-sm-start mb-0 ps-3">
                                    How modern technology builds communities</div>
                            </a>
                            <a class="nav-link flex-wrap flex-sm-nowrap justify-content-center position-relative w-50 p-0"
                                href="#!" style="max-width: 330px">
                                <div class="d-flex align-items-center order-sm-2 mb-2 mb-sm-0">
                                    <div class="ratio flex-shrink-0"
                                        style="width: 86px; --cz-aspect-ratio: calc(64 / 86 * 100%)">
                                        <img src="assets/img/blog/post/nav02.jpg" class="rounded-2" alt="Image">
                                    </div>
                                    <i class="ci-chevron-right fs-xl me-n3 me-sm-n1 ms-2"></i>
                                </div>
                                <div
                                    class="h6 fs-sm hover-effect-underline stretched-link text-center text-sm-end order-sm-1 mb-0 pe-3">
                                    Transform your home into a smart hub with the latest IoT</div>
                            </a>
                        </div>
                    </div> --}}
                </div>


                <!-- Sharing sticky sidebar visible on screens > 991px wide (lg breakpoint) -->
                <aside class="col-lg-2 d-none d-lg-block" style="margin-top: -115px">
                    <div class="sticky-top" style="padding-top: 115px">
                        <div class="d-flex flex-column align-items-center gap-2">
                            <div class="text-body-emphasis fs-sm fw-medium">Share:</div>
                            <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}"
                                data-bs-toggle="tooltip" data-bs-placement="left"
                                data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>'
                                title="X (Twitter)" aria-label="Follow us on X">
                                <i class="ci-x"></i>
                            </a>
                            <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                data-bs-toggle="tooltip" data-bs-placement="left"
                                data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>'
                                title="Facebook" aria-label="Follow us on Facebook">
                                <i class="ci-facebook"></i>
                            </a>
                            <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="https://t.me/share/url?url={{ urlencode(url()->current()) }}"
                                data-bs-toggle="tooltip" data-bs-placement="left"
                                data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>'
                                title="Telegram" aria-label="Follow us on Telegram">
                                <i class="ci-telegram"></i>
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </section>


        <!-- Related articles that turn into slider on screens < 992px wide (lg breakpoint) -->
        {{-- <section class="container pb-5 mb-1 mb-sm-2 mb-md-3 mb-lg-4 mb-xl-5">
            <h2 class="h3 text-center pb-2 pb-sm-3">Related articles</h2>
            <div class="swiper"
                data-swiper='{
          "slidesPerView": 1,
          "spaceBetween": 24,
          "pagination": {
            "el": ".swiper-pagination",
            "clickable": true
          },
          "breakpoints": {
            "500": {
              "slidesPerView": 2
            },
            "900": {
              "slidesPerView": 3
            }
          }
        }'>
                <div class="swiper-wrapper">

                    <!-- Article -->
                    <article class="swiper-slide">
                        <a class="ratio d-flex hover-effect-scale rounded overflow-hidden" href="#!"
                            style="--cz-aspect-ratio: calc(305 / 416 * 100%)">
                            <img src="assets/img/blog/grid/v1/07.jpg" class="hover-effect-target" alt="Image">
                        </a>
                        <div class="pt-4">
                            <div class="nav align-items-center gap-2 pb-2 mt-n1 mb-1">
                                <a class="nav-link text-body fs-xs text-uppercase p-0" href="#!">IoT</a>
                                <hr class="vr my-1 mx-1">
                                <span class="text-body-tertiary fs-xs">August 23, 2024</span>
                            </div>
                            <h3 class="h5 mb-0">
                                <a class="hover-effect-underline" href="#!">Connecting the dots: How IoT technology
                                    is transforming everyday life</a>
                            </h3>
                        </div>
                    </article>

                </div>

                <!-- Pagination (Bullets) -->
                <div class="swiper-pagination position-static mt-4"></div>
            </div>
        </section> --}}
    </main>
@endsection
