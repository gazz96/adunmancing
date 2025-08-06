@extends('frontend.layouts.default')

@section('content')
    <!-- Page content -->
    <main class="content-wrapper">

        <!-- 1. Hero Image Slider -->
        <section class="bg-body-tertiary position-relative overflow-hidden" style="margin-top: -110px; padding-top: 110px">
            <div class="container-fluid px-0">
                <div class="swiper hero-slider" data-swiper='{
                    "loop": true,
                    "autoplay": {
                        "delay": 5000,
                        "disableOnInteraction": false
                    },
                    "pagination": {
                        "el": ".hero-pagination",
                        "clickable": true
                    },
                    "navigation": {
                        "prevEl": ".hero-prev",
                        "nextEl": ".hero-next"
                    }
                }'>
                    <div class="swiper-wrapper">
                        @foreach ($sliders as $slider)
                        <div class="swiper-slide">
                            <div class="position-relative min-vh-100 d-flex align-items-center">
                                <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
                                <div class="ratio ratio-21x9 position-absolute top-0 start-0 w-100 h-100">
                                    <img src="{{ $slider->featured_image_url }}" class="object-fit-cover" alt="{{ $slider->name }}">
                                </div>
                                <div class="container position-relative z-1 text-white text-center py-5">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-8">
                                            <h1 class="display-3 fw-bold mb-4">{{ $slider->name }}</h1>
                                            <p class="fs-5 mb-4">{{ $slider->excerpt ?? 'Temukan peralatan memancing terbaik untuk pengalaman memancing yang sempurna' }}</p>
                                            <div class="d-flex justify-content-center gap-3">
                                                <a href="{{ route('frontend.product-detail', $slider) }}" class="btn btn-primary btn-lg rounded-pill px-4">
                                                    <i class="ci-eye me-2"></i>Lihat Produk
                                                </a>
                                                <a href="{{ route('web.shop') }}" class="btn btn-outline-light btn-lg rounded-pill px-4">
                                                    Belanja Sekarang
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Navigation -->
                    <button type="button" class="hero-prev btn btn-icon btn-light rounded-circle position-absolute top-50 start-0 translate-middle-y ms-3 z-2">
                        <i class="ci-chevron-left fs-lg"></i>
                    </button>
                    <button type="button" class="hero-next btn btn-icon btn-light rounded-circle position-absolute top-50 end-0 translate-middle-y me-3 z-2">
                        <i class="ci-chevron-right fs-lg"></i>
                    </button>
                    
                    <!-- Pagination -->
                    <div class="hero-pagination position-absolute bottom-0 start-50 translate-middle-x mb-4 z-2"></div>
                </div>
            </div>
        </section>

        <!-- 2. YouTube Playlist Section -->
        <section class="container py-5 my-2 my-sm-3 my-lg-4">
            <div class="text-center mb-5">
                <h2 class="h1 mb-3">Video Tutorial Memancing</h2>
                <p class="fs-5 text-muted mb-4">Pelajari teknik memancing terbaik dari para ahli</p>
                <a href="https://www.youtube.com/@adunmancing" target="_blank" class="btn btn-danger btn-lg rounded-pill">
                    <i class="ci-play fs-base me-2"></i>Subscribe Channel Kami
                </a>
            </div>
            
            <div class="row g-4">
                <!-- Featured Video -->
                <div class="col-lg-8">
                    <div class="position-relative rounded-4 overflow-hidden bg-dark">
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" 
                                    title="Video Tutorial Memancing" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                    <div class="pt-3">
                        <h3 class="h4 mb-2">Teknik Memancing di Laut Dalam</h3>
                        <p class="text-muted">Pelajari teknik memancing di laut dalam untuk hasil tangkapan yang maksimal</p>
                    </div>
                </div>
                
                <!-- Video Playlist -->
                <div class="col-lg-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h4 class="h5 mb-0">Video Terbaru</h4>
                        <a href="https://www.youtube.com/@adunmancing" target="_blank" class="text-decoration-none">
                            Lihat Semua <i class="ci-chevron-right fs-sm"></i>
                        </a>
                    </div>
                    
                    <!-- Video Items -->
                    @for($i = 1; $i <= 4; $i++)
                    <div class="d-flex gap-3 mb-3 p-3 bg-body-tertiary rounded-3 hover-effect-lift">
                        <div class="position-relative flex-shrink-0">
                            <div class="ratio ratio-16x9" style="width: 120px">
                                <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" 
                                     class="rounded-2 object-fit-cover" 
                                     alt="Video {{ $i }}">
                            </div>
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <div class="btn btn-sm btn-light rounded-circle">
                                    <i class="ci-play fs-xs"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Tutorial Memancing Ikan {{ $i == 1 ? 'Kakap' : ($i == 2 ? 'Bawal' : ($i == 3 ? 'Tenggiri' : 'Kerapu')) }}</h6>
                            <p class="fs-sm text-muted mb-2">Tips dan trik memancing untuk pemula</p>
                            <div class="fs-xs text-muted">
                                <i class="ci-eye fs-xs me-1"></i>12.5K views
                                <span class="mx-2">•</span>
                                {{ $i }} hari yang lalu
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </section>

        <!-- 3. New Products Section -->
        <section class="container py-5 my-2 my-sm-3 my-lg-4">
            <div class="d-flex align-items-center justify-content-between border-bottom pb-3 pb-md-4 mb-4">
                <div>
                    <h2 class="h1 mb-2">Produk Terbaru 2024</h2>
                    <p class="text-muted mb-0">Peralatan memancing terkini dengan teknologi terdepan</p>
                </div>
                <div class="nav ms-3">
                    <a class="nav-link animate-underline px-0 py-2" href="{{ route('web.shop') }}">
                        <span class="animate-target">Lihat Semua</span>
                        <i class="ci-chevron-right fs-base ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="position-relative">
                <!-- Navigation buttons -->
                <button type="button" class="new-prev btn btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-start position-absolute top-50 start-0 z-2 translate-middle mt-n5 d-none d-sm-inline-flex">
                    <i class="ci-chevron-left fs-lg animate-target"></i>
                </button>
                <button type="button" class="new-next btn btn-icon btn-outline-secondary bg-body rounded-circle animate-slide-end position-absolute top-50 start-100 z-2 translate-middle mt-n5 d-none d-sm-inline-flex">
                    <i class="ci-chevron-right fs-lg animate-target"></i>
                </button>

                <!-- Products Slider -->
                <div class="swiper pt-3 pt-sm-4" data-swiper='{
                    "slidesPerView": 2,
                    "spaceBetween": 24,
                    "loop": true,
                    "navigation": {
                        "prevEl": ".new-prev",
                        "nextEl": ".new-next"
                    },
                    "breakpoints": {
                        "768": {"slidesPerView": 3},
                        "992": {"slidesPerView": 4},
                        "1200": {"slidesPerView": 5}
                    }
                }'>
                    <div class="swiper-wrapper">
                        @foreach($newProducts as $product)
                        <div class="swiper-slide">
                            <div class="card product-card border-0 bg-transparent">
                                <div class="position-relative">
                                    <a href="{{ $product->permalink }}" class="ratio ratio-1x1 d-block">
                                        @if($product->compare_price)
                                        <div class="position-absolute top-0 start-0 z-2 mt-2 ms-2">
                                            <span class="badge bg-danger">-{{ $product->percentage_discount_by_compare_price }}%</span>
                                        </div>
                                        @endif
                                        <img src="{{ $product->featured_image_url }}" class="card-img-top object-fit-cover rounded-3" alt="{{ $product->name }}">
                                    </a>
                                    <div class="position-absolute top-0 end-0 z-2 mt-2 me-2">
                                        <button type="button" class="btn btn-icon btn-sm btn-light rounded-circle" title="Add to wishlist">
                                            <i class="ci-heart fs-sm"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body px-0 pb-0 pt-3">
                                    <h5 class="card-title fs-sm fw-medium mb-2">
                                        <a href="{{ $product->permalink }}" class="text-decoration-none text-dark">{{ $product->name }}</a>
                                    </h5>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                            <i class="ci-star-filled fs-xs"></i>
                                            @endfor
                                        </div>
                                        <span class="fs-xs text-muted">(4.8)</span>
                                    </div>
                                    <div class="h6 mb-2">
                                        {{ $product->price_label }}
                                        @if($product->compare_price)
                                        <span class="text-muted text-decoration-line-through fs-sm ms-1">{{ $product->compare_price_label }}</span>
                                        @endif
                                    </div>
                                    <div class="d-grid">
                                        @if($product->attributes->count())
                                        <a href="{{ $product->permalink }}" class="btn btn-outline-primary btn-sm rounded-pill">Lihat Detail</a>
                                        @else
                                        <button type="button" class="btn btn-primary btn-sm rounded-pill btn-single_add_to_cart" data-key="{{ $product->id }}">
                                            <i class="ci-shopping-cart fs-sm me-1"></i>Add to Cart
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Mobile navigation -->
                <div class="d-flex justify-content-center gap-2 mt-4 d-sm-none">
                    <button type="button" class="new-prev btn btn-icon btn-outline-secondary rounded-circle">
                        <i class="ci-chevron-left fs-lg"></i>
                    </button>
                    <button type="button" class="new-next btn btn-icon btn-outline-secondary rounded-circle">
                        <i class="ci-chevron-right fs-lg"></i>
                    </button>
                </div>
            </div>
        </section>

        <!-- 4. Product Categories -->
        <section class="bg-body-tertiary py-5 my-2 my-sm-3 my-lg-4">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="h1 mb-3">Kategori Produk</h2>
                    <p class="fs-5 text-muted">Temukan peralatan memancing sesuai kebutuhan Anda</p>
                </div>
                
                <div class="row g-4">
                    @foreach ($productCategories as $category)
                    <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="{{ route('web.shop', ['category_id' => $category->id]) }}" class="text-decoration-none">
                            <div class="card border-0 bg-white h-100 hover-effect-lift text-center p-3">
                                <div class="mb-3">
                                    <div class="bg-primary bg-opacity-10 rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <img src="{{ asset('storage/' . $category->icon) }}" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;" alt="{{ $category->name }}">
                                    </div>
                                </div>
                                <h5 class="card-title h6 mb-2">{{ $category->name }}</h5>
                                <p class="fs-sm text-muted mb-0">{{ $category->products_count ?? '0' }} Produk</p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- 5. Our Products (Featured Products by Category) -->
        <section class="container py-5 my-2 my-sm-3 my-lg-4">
            <div class="d-flex align-items-center justify-content-between border-bottom pb-3 pb-md-4 mb-4">
                <div>
                    <h2 class="h1 mb-2">Produk Unggulan Kami</h2>
                    <p class="text-muted mb-0">Koleksi terbaik pilihan para pemancing profesional</p>
                </div>
            </div>

            <!-- Category Tabs -->
            <nav class="mb-4">
                <ul class="nav nav-pills justify-content-center flex-wrap">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#all-products">Semua Produk</button>
                    </li>
                    @foreach($productCategories->take(4) as $category)
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#category-{{ $category->id }}">{{ $category->name }}</button>
                    </li>
                    @endforeach
                </ul>
            </nav>

            <!-- Products Content -->
            <div class="tab-content">
                <div class="tab-pane fade show active" id="all-products">
                    <div class="row g-4">
                        @foreach($makanProducts->take(8) as $product)
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card product-card border-0 bg-transparent">
                                <div class="position-relative">
                                    <a href="{{ $product->permalink }}" class="ratio ratio-4x3 d-block">
                                        @if($product->compare_price)
                                        <div class="position-absolute top-0 start-0 z-2 mt-2 ms-2">
                                            <span class="badge bg-danger">-{{ $product->percentage_discount_by_compare_price }}%</span>
                                        </div>
                                        @endif
                                        <img src="{{ $product->featured_image_url }}" class="card-img-top object-fit-cover rounded-3" alt="{{ $product->name }}">
                                    </a>
                                    <div class="position-absolute top-0 end-0 z-2 mt-2 me-2">
                                        <button type="button" class="btn btn-icon btn-sm btn-light rounded-circle" title="Add to wishlist">
                                            <i class="ci-heart fs-sm"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body px-0 pb-0 pt-3">
                                    <h5 class="card-title fs-sm fw-medium mb-2">
                                        <a href="{{ $product->permalink }}" class="text-decoration-none text-dark">{{ $product->name }}</a>
                                    </h5>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                            <i class="ci-star-filled fs-xs"></i>
                                            @endfor
                                        </div>
                                        <span class="fs-xs text-muted">(4.8)</span>
                                    </div>
                                    <div class="h6 mb-2">
                                        {{ $product->price_label }}
                                        @if($product->compare_price)
                                        <span class="text-muted text-decoration-line-through fs-sm ms-1">{{ $product->compare_price_label }}</span>
                                        @endif
                                    </div>
                                    <div class="d-grid">
                                        @if($product->attributes->count())
                                        <a href="{{ $product->permalink }}" class="btn btn-outline-primary btn-sm rounded-pill">Lihat Detail</a>
                                        @else
                                        <button type="button" class="btn btn-primary btn-sm rounded-pill btn-single_add_to_cart" data-key="{{ $product->id }}">
                                            <i class="ci-shopping-cart fs-sm me-1"></i>Add to Cart
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                @foreach($productCategories->take(4) as $category)
                <div class="tab-pane fade" id="category-{{ $category->id }}">
                    <div class="row g-4">
                        @foreach($makanProducts->take(4) as $product)
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card product-card border-0 bg-transparent">
                                <div class="position-relative">
                                    <a href="{{ $product->permalink }}" class="ratio ratio-4x3 d-block">
                                        <img src="{{ $product->featured_image_url }}" class="card-img-top object-fit-cover rounded-3" alt="{{ $product->name }}">
                                    </a>
                                </div>
                                <div class="card-body px-0 pb-0 pt-3">
                                    <h5 class="card-title fs-sm fw-medium mb-2">
                                        <a href="{{ $product->permalink }}" class="text-decoration-none text-dark">{{ $product->name }}</a>
                                    </h5>
                                    <div class="h6 mb-2">{{ $product->price_label }}</div>
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-primary btn-sm rounded-pill btn-single_add_to_cart" data-key="{{ $product->id }}">
                                            <i class="ci-shopping-cart fs-sm me-1"></i>Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <!-- 6. Coupons and Discounts -->
        <section class="bg-primary py-5 my-2 my-sm-3 my-lg-4" data-bs-theme="dark">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="text-center text-lg-start mb-4 mb-lg-0">
                            <div class="fs-sm text-light opacity-75 mb-2">PENAWARAN SPESIAL HARI INI</div>
                            <h2 class="display-4 fw-bold text-white mb-3">Diskon Hingga 50%</h2>
                            <p class="fs-5 text-light opacity-75 mb-4">Dapatkan peralatan memancing berkualitas dengan harga terbaik. Penawaran terbatas!</p>
                            
                            <!-- Coupon Code -->
                            <div class="d-inline-flex align-items-center bg-white bg-opacity-10 rounded-pill p-2 mb-4">
                                <span class="text-light me-3 ps-3">Kode Kupon:</span>
                                <div class="bg-white rounded-pill px-3 py-2">
                                    <code class="text-primary fw-bold">MANCING50</code>
                                </div>
                                <button class="btn btn-sm btn-light rounded-pill ms-2" onclick="copyToClipboard('MANCING50')">
                                    <i class="ci-copy fs-sm"></i> Copy
                                </button>
                            </div>
                            
                            <div class="d-flex justify-content-center justify-content-lg-start gap-3">
                                <a href="{{ route('web.shop') }}" class="btn btn-light btn-lg rounded-pill px-4">
                                    <i class="ci-shopping-bag me-2"></i>Belanja Sekarang
                                </a>
                                <button class="btn btn-outline-light btn-lg rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#couponModal">
                                    <i class="ci-percent me-2"></i>Lihat Semua Kupon
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="text-center">
                            <!-- Discount Badge -->
                            <div class="position-relative d-inline-block">
                                <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center animate-bounce" style="width: 200px; height: 200px;">
                                    <div class="text-center">
                                        <div class="display-3 fw-bold text-dark">50%</div>
                                        <div class="fw-bold text-dark">OFF</div>
                                    </div>
                                </div>
                                <div class="position-absolute top-0 end-0 translate-middle">
                                    <span class="badge bg-danger rounded-pill">HOT!</span>
                                </div>
                            </div>
                            
                            <!-- Countdown Timer -->
                            <div class="mt-4">
                                <div class="text-light opacity-75 mb-2">Berakhir dalam:</div>
                                <div class="d-flex justify-content-center gap-2">
                                    <div class="bg-white bg-opacity-10 rounded text-center p-2" style="min-width: 50px;">
                                        <div class="fw-bold text-white" id="countdown-hours">24</div>
                                        <small class="text-light opacity-75">Jam</small>
                                    </div>
                                    <div class="bg-white bg-opacity-10 rounded text-center p-2" style="min-width: 50px;">
                                        <div class="fw-bold text-white" id="countdown-minutes">59</div>
                                        <small class="text-light opacity-75">Menit</small>
                                    </div>
                                    <div class="bg-white bg-opacity-10 rounded text-center p-2" style="min-width: 50px;">
                                        <div class="fw-bold text-white" id="countdown-seconds">59</div>
                                        <small class="text-light opacity-75">Detik</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 7. About Us (Tentang Adunmancing) -->
        <section class="container py-5 my-2 my-sm-3 my-lg-4">
            <div class="row align-items-center g-4 g-lg-5">
                <div class="col-lg-6">
                    <div class="pe-lg-4">
                        <div class="text-primary fw-semibold mb-3">TENTANG KAMI</div>
                        <h2 class="display-5 fw-bold mb-4">Adunmancing - Partner Terpercaya Untuk Petualangan Memancing Anda</h2>
                        <p class="fs-5 text-muted mb-4">Sejak tahun 2015, kami telah melayani ribuan pemancing di seluruh Indonesia dengan menyediakan peralatan memancing berkualitas tinggi dan pelayanan terbaik.</p>
                        
                        <div class="row g-4 mb-4">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="ci-check-circle text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Kualitas Terjamin</h6>
                                        <small class="text-muted">Produk berkualitas internasional</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="ci-delivery text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Pengiriman Cepat</h6>
                                        <small class="text-muted">Ke seluruh Indonesia</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="ci-support text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Konsultasi Gratis</h6>
                                        <small class="text-muted">24/7 customer support</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="ci-award text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Garansi Resmi</h6>
                                        <small class="text-muted">Setiap pembelian</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-3">
                            <a href="{{ route('web.shop') }}" class="btn btn-primary btn-lg rounded-pill">
                                Mulai Belanja
                            </a>
                            <a href="#" class="btn btn-outline-primary btn-lg rounded-pill">
                                Pelajari Lebih Lanjut
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="position-relative">
                        <img src="{{ asset('assets/img/about-fishing.jpg') }}" class="rounded-4 img-fluid" alt="About Adunmancing" onerror="this.src='https://via.placeholder.com/600x400/0066cc/ffffff?text=Adunmancing'">
                        
                        <!-- Stats Cards -->
                        <div class="position-absolute bottom-0 start-0 translate-middle-x mb-n3">
                            <div class="card border-0 shadow-lg">
                                <div class="card-body text-center p-4">
                                    <h3 class="h2 text-primary mb-1">10K+</h3>
                                    <p class="fs-sm text-muted mb-0">Pelanggan Puas</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="position-absolute top-0 end-0 translate-middle-x mt-3">
                            <div class="card border-0 shadow-lg">
                                <div class="card-body text-center p-3">
                                    <h4 class="text-primary mb-1">5000+</h4>
                                    <p class="fs-sm text-muted mb-0">Produk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 8. Newsletter -->
        <section class="bg-dark py-5 my-2 my-sm-3 my-lg-4" data-bs-theme="dark">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <div class="mb-4">
                            <i class="ci-mail fs-1 text-primary mb-3"></i>
                            <h2 class="display-6 fw-bold text-white mb-3">Dapatkan Update Terbaru</h2>
                            <p class="fs-5 text-light opacity-75 mb-4">Berlangganan newsletter kami untuk mendapatkan tips memancing, promo eksklusif, dan informasi produk terbaru</p>
                        </div>
                        
                        <!-- Newsletter Form -->
                        <form class="newsletter-form mb-4" id="newsletterForm">
                            <div class="input-group input-group-lg">
                                <input type="email" class="form-control form-control-lg border-0" placeholder="Masukkan email Anda" required>
                                <button type="submit" class="btn btn-primary btn-lg px-4">
                                    <i class="ci-send me-2"></i>Berlangganan
                                </button>
                            </div>
                            <div class="form-text text-light opacity-50 mt-2">
                                *Kami tidak akan spam email Anda. Anda bisa unsubscribe kapan saja.
                            </div>
                        </form>
                        
                        <!-- Benefits -->
                        <div class="row g-4 justify-content-center">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <i class="ci-percent text-primary fs-2 mb-2"></i>
                                    <h6 class="text-white mb-1">Promo Eksklusif</h6>
                                    <small class="text-light opacity-75">Diskon khusus subscriber</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <i class="ci-bell text-primary fs-2 mb-2"></i>
                                    <h6 class="text-white mb-1">Update Produk</h6>
                                    <small class="text-light opacity-75">Info produk terbaru</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <i class="ci-book text-primary fs-2 mb-2"></i>
                                    <h6 class="text-white mb-1">Tips Memancing</h6>
                                    <small class="text-light opacity-75">Panduan dari para ahli</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Coupon Modal -->
    <div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="couponModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="couponModalLabel">Kupon Tersedia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Coupon 1 -->
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="card-title mb-0">Diskon 50%</h6>
                                        <span class="badge bg-primary">MANCING50</span>
                                    </div>
                                    <p class="card-text fs-sm">Untuk pembelian minimal Rp 500.000</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Berlaku s/d 31 Des 2024</small>
                                        <button class="btn btn-sm btn-outline-primary" onclick="copyToClipboard('MANCING50')">Copy</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Coupon 2 -->
                        <div class="col-md-6">
                            <div class="card border-success">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="card-title mb-0">Gratis Ongkir</h6>
                                        <span class="badge bg-success">FREEONGKIR</span>
                                    </div>
                                    <p class="card-text fs-sm">Untuk semua pembelian</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Berlaku s/d 31 Des 2024</small>
                                        <button class="btn btn-sm btn-outline-success" onclick="copyToClipboard('FREEONGKIR')">Copy</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Coupon 3 -->
                        <div class="col-md-6">
                            <div class="card border-warning">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="card-title mb-0">Cashback 25%</h6>
                                        <span class="badge bg-warning text-dark">CASHBACK25</span>
                                    </div>
                                    <p class="card-text fs-sm">Untuk member baru</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Berlaku s/d 31 Des 2024</small>
                                        <button class="btn btn-sm btn-outline-warning" onclick="copyToClipboard('CASHBACK25')">Copy</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Coupon 4 -->
                        <div class="col-md-6">
                            <div class="card border-info">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="card-title mb-0">Buy 2 Get 1</h6>
                                        <span class="badge bg-info">BUY2GET1</span>
                                    </div>
                                    <p class="card-text fs-sm">Khusus produk umpan</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Berlaku s/d 31 Des 2024</small>
                                        <button class="btn btn-sm btn-outline-info" onclick="copyToClipboard('BUY2GET1')">Copy</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
<script>
$(document).ready(function() {
    // Countdown Timer
    function updateCountdown() {
        const now = new Date().getTime();
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        tomorrow.setHours(0, 0, 0, 0);
        
        const distance = tomorrow - now;
        
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        document.getElementById("countdown-hours").innerText = hours.toString().padStart(2, '0');
        document.getElementById("countdown-minutes").innerText = minutes.toString().padStart(2, '0');
        document.getElementById("countdown-seconds").innerText = seconds.toString().padStart(2, '0');
        
        if (distance < 0) {
            document.getElementById("countdown-hours").innerText = "00";
            document.getElementById("countdown-minutes").innerText = "00";
            document.getElementById("countdown-seconds").innerText = "00";
        }
    }
    
    // Update countdown every second
    updateCountdown();
    setInterval(updateCountdown, 1000);
    
    // Newsletter Form
    $('#newsletterForm').on('submit', function(e) {
        e.preventDefault();
        const email = $(this).find('input[type="email"]').val();
        
        // Here you would typically send the email to your backend
        // For now, we'll just show a success message
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Terima kasih telah berlangganan newsletter kami!',
            confirmButtonText: 'OK'
        });
        
        $(this).find('input[type="email"]').val('');
    });
});

// Copy to clipboard function
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Kode kupon berhasil disalin: ' + text,
            timer: 2000,
            showConfirmButton: false
        });
    });
}
</script>
@endsection