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
                        @if($sliders && $sliders->count() > 0)
                            @foreach ($sliders as $slider)
                            <div class="swiper-slide">
                                <div class="position-relative min-vh-100 d-flex align-items-center">
                                    <div class="ratio ratio-21x9 position-absolute top-0 start-0 w-100 h-100">
                                        <img src="{{ $slider->featured_image_url }}" class="object-fit-cover" alt="{{ $slider->name }}">
                                    </div>
                                    <!-- Gradient overlay for better text readability -->
                                    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0.7) 100%);"></div>
                                    <div class="container position-relative z-1 text-white text-center py-5">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-8">
                                                <h1 class="display-3 fw-bold mb-4 text-white">{{ $slider->name }}</h1>
                                                <p class="fs-5 mb-4 text-white opacity-90">{{ $slider->excerpt ?? 'Temukan peralatan memancing terbaik untuk pengalaman memancing yang sempurna' }}</p>
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
                        @else
                            <!-- Default hero section when no sliders -->
                            <div class="swiper-slide">
                                <div class="position-relative min-vh-100 d-flex align-items-center">
                                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                                    <div class="container position-relative z-1 text-white text-center py-5">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-8">
                                                <h1 class="display-3 fw-bold mb-4">Selamat Datang di Adun Mancing</h1>
                                                <p class="fs-5 mb-4">Temukan peralatan memancing terbaik untuk pengalaman memancing yang sempurna</p>
                                                <div class="d-flex justify-content-center gap-3">
                                                    <a href="{{ route('web.shop') }}" class="btn btn-primary btn-lg rounded-pill px-4">
                                                        <i class="ci-shopping-bag me-2"></i>Belanja Sekarang
                                                    </a>
                                                    <a href="#products" class="btn btn-outline-light btn-lg rounded-pill px-4">
                                                        Lihat Produk
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Navigation -->
                    <button type="button" class="hero-prev btn btn-icon btn-light rounded-circle position-absolute top-50 start-0 translate-middle-y ms-3 z-2">
                        <i class="ci-chevron-left fs-lg"></i>
                    </button>
                    <button type="button" class="hero-next btn btn-icon btn-light rounded-circle position-absolute top-50 end-0 translate-middle-y me-3 z-2">
                        <i class="ci-chevron-right fs-lg"></i>
                    </button>
                    
                    <!-- Pagination -->
                    <div class="hero-pagination position-absolute bottom-0 start-50 translate-middle-x mb-4 z-2 d-flex justify-content-center"></div>
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
                    @php
                        $featuredVideo = $youtubeVideos ? $youtubeVideos->where('is_featured', true)->first() : null;
                        if (!$featuredVideo && $youtubeVideos && $youtubeVideos->count() > 0) {
                            $featuredVideo = $youtubeVideos->first();
                        }
                    @endphp
                    <div class="position-relative rounded-4 overflow-hidden bg-dark">
                        <div class="ratio ratio-16x9">
                            @if($featuredVideo)
                            <iframe src="{{ $featuredVideo->embed_url }}" 
                                    title="{{ $featuredVideo->title }}" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen>
                            </iframe>
                            @else
                            <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" 
                                    title="Video Tutorial Memancing" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen>
                            </iframe>
                            @endif
                        </div>
                    </div>
                    <div class="pt-3">
                        <h3 class="h4 mb-2">{{ $featuredVideo ? $featuredVideo->title : 'Teknik Memancing di Laut Dalam' }}</h3>
                        <p class="text-muted">{{ $featuredVideo && $featuredVideo->description ? $featuredVideo->description : 'Pelajari teknik memancing di laut dalam untuk hasil tangkapan yang maksimal' }}</p>
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
                    @if($youtubeVideos && $youtubeVideos->count() > 0)
                        @foreach($youtubeVideos->take(4) as $video)
                        <div class="d-flex gap-2 mb-2 p-2 bg-body-tertiary rounded-2 hover-effect-lift">
                            <div class="position-relative flex-shrink-0">
                                <div class="ratio ratio-16x9" style="width: 100px">
                                    <img src="{{ $video->thumbnail_url }}" 
                                         class="rounded-1 object-fit-cover" 
                                         alt="{{ $video->title }}">
                                </div>
                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <a href="{{ $video->youtube_url }}" target="_blank" class="btn btn-sm btn-light rounded-circle p-1">
                                        <i class="ci-play" style="font-size: 12px;"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fs-sm">{{ Str::limit($video->title, 40) }}</h6>
                                <div class="fs-xs text-muted">
                                    {{ $video->views_formatted }} views • {{ $video->published_date_formatted }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <!-- Default videos when no data -->
                        @php
                        $defaultVideos = [
                            ['title' => 'Tutorial Memancing Ikan Kakap', 'views' => '12.5K', 'days' => '1'],
                            ['title' => 'Tutorial Memancing Ikan Bawal', 'views' => '8.2K', 'days' => '2'],
                            ['title' => 'Tutorial Memancing Ikan Tenggiri', 'views' => '15.7K', 'days' => '3'],
                            ['title' => 'Tutorial Memancing Ikan Kerapu', 'views' => '9.4K', 'days' => '4']
                        ];
                        @endphp
                        @foreach($defaultVideos as $video)
                        <div class="d-flex gap-2 mb-2 p-2 bg-body-tertiary rounded-2 hover-effect-lift">
                            <div class="position-relative flex-shrink-0">
                                <div class="ratio ratio-16x9" style="width: 100px">
                                    <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" 
                                         class="rounded-1 object-fit-cover" 
                                         alt="{{ $video['title'] }}">
                                </div>
                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <div class="btn btn-sm btn-light rounded-circle p-1">
                                        <i class="ci-play" style="font-size: 12px;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fs-sm">{{ $video['title'] }}</h6>
                                <div class="fs-xs text-muted">
                                    {{ $video['views'] }} views • {{ $video['days'] }} hari yang lalu
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>

        <!-- 3. New Products Section -->
        <section class="container py-5 my-2 my-sm-3 my-lg-4" id="products">
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

            @if($newProducts && $newProducts->count() > 0)
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
            @else
            <!-- Placeholder when no products -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="ci-package" style="font-size: 4rem; color: #dee2e6;"></i>
                </div>
                <h4 class="mb-3">Produk Akan Segera Hadir</h4>
                <p class="text-muted mb-4">Kami sedang menyiapkan koleksi produk terbaik untuk Anda</p>
                <a href="{{ route('web.shop') }}" class="btn btn-primary rounded-pill">
                    Kunjungi Toko
                </a>
            </div>
            @endif
        </section>

        <!-- 4. Product Categories -->
        <section class="bg-body-tertiary py-5 my-2 my-sm-3 my-lg-4">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="h1 mb-3">Kategori Produk</h2>
                    <p class="fs-5 text-muted">Temukan peralatan memancing sesuai kebutuhan Anda</p>
                </div>
                
                @if($productCategories && $productCategories->count() > 0)
                <div class="row g-4">
                    @foreach ($productCategories as $category)
                    <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="{{ route('web.shop', ['category_id' => $category->id]) }}" class="text-decoration-none">
                            <div class="card border-0 bg-white h-100 hover-effect-lift text-center p-3">
                                <div class="mb-3">
                                    <div class="bg-primary bg-opacity-10 rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <img src="{{ $category->image_url_with_placeholder }}" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;" alt="{{ $category->name }}">
                                    </div>
                                </div>
                                <h5 class="card-title h6 mb-2">{{ $category->name }}</h5>
                                <p class="fs-sm text-muted mb-0">{{ $category->products_count ?? '0' }} Produk</p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                @else
                <!-- Default categories when no data -->
                <div class="row g-4">
                    @php
                    $defaultCategories = [
                        ['name' => 'Pancing', 'icon' => 'ci-package', 'count' => '25+'],
                        ['name' => 'Kail', 'icon' => 'ci-package', 'count' => '50+'],
                        ['name' => 'Senar', 'icon' => 'ci-package', 'count' => '30+'],
                        ['name' => 'Reel', 'icon' => 'ci-package', 'count' => '20+'],
                        ['name' => 'Umpan', 'icon' => 'ci-package', 'count' => '15+'],
                        ['name' => 'Aksesoris', 'icon' => 'ci-package', 'count' => '40+'],
                    ];
                    @endphp
                    @foreach($defaultCategories as $category)
                    <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="{{ route('web.shop') }}" class="text-decoration-none">
                            <div class="card border-0 bg-white h-100 hover-effect-lift text-center p-3">
                                <div class="mb-3">
                                    <div class="bg-primary bg-opacity-10 rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                        <i class="{{ $category['icon'] }} fs-2 text-primary"></i>
                                    </div>
                                </div>
                                <h5 class="card-title h6 mb-2">{{ $category['name'] }}</h5>
                                <p class="fs-sm text-muted mb-0">{{ $category['count'] }} Produk</p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif
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
                    @if($productCategories && $productCategories->count() > 0)
                        @foreach($productCategories->take(4) as $category)
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#category-{{ $category->id }}">{{ $category->name }}</button>
                        </li>
                        @endforeach
                    @endif
                </ul>
            </nav>

            <!-- Products Content -->
            <div class="tab-content">
                <div class="tab-pane fade show active" id="all-products">
                    @if($makanProducts && $makanProducts->count() > 0)
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
                    @else
                    <!-- Placeholder when no products -->
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="ci-package" style="font-size: 4rem; color: #dee2e6;"></i>
                        </div>
                        <h4 class="mb-3">Produk Akan Segera Hadir</h4>
                        <p class="text-muted mb-4">Kami sedang menyiapkan koleksi produk terbaik untuk Anda</p>
                        <a href="{{ route('web.shop') }}" class="btn btn-primary rounded-pill">
                            Kunjungi Toko
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- 6. Coupons and Discounts -->
        <section class="bg-primary py-5 my-2 my-sm-3 my-lg-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="text-white">
                            <h2 class="h1 text-white mb-3">Promo & Diskon Spesial</h2>
                            <p class="fs-5 mb-4">Dapatkan penawaran terbaik untuk semua peralatan memancing berkualitas tinggi</p>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="bg-white bg-opacity-20 rounded-pill px-4 py-2">
                                    <span class="text-white fw-bold">DISKON 20%</span>
                                </div>
                                <div class="bg-white bg-opacity-20 rounded-pill px-4 py-2">
                                    <span class="text-white fw-bold">GRATIS ONGKIR</span>
                                </div>
                                <div class="bg-white bg-opacity-20 rounded-pill px-4 py-2">
                                    <span class="text-white fw-bold">CASHBACK 50K</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="bg-white bg-opacity-10 rounded-4 p-4">
                            <h5 class="text-white mb-3">Kupon Promo</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="bg-white rounded-3 p-3 text-center">
                                        <div class="h4 text-primary mb-1">FISHING20</div>
                                        <small class="text-muted">Diskon 20% untuk semua produk</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-white rounded-3 p-3 text-center">
                                        <div class="h4 text-success mb-1">NEWBIE50</div>
                                        <small class="text-muted">Potongan 50K untuk pemula</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 7. About Us (Tentang Kami) -->
        <section class="container py-5 my-2 my-sm-3 my-lg-4">
            <div class="row align-items-center g-4 g-md-5">
                <div class="col-lg-6">
                    <div class="pe-lg-4">
                        <h2 class="h1 mb-4">Tentang Adun Mancing</h2>
                        <p class="fs-lg text-muted mb-4">Kami adalah toko perlengkapan memancing terpercaya yang telah melayani para pemancing Indonesia sejak bertahun-tahun. Dengan komitmen memberikan produk berkualitas tinggi dan pelayanan terbaik.</p>
                        
                        <div class="row g-4 mb-4">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="ci-check text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Produk Berkualitas</h6>
                                        <p class="fs-sm text-muted mb-0">Dipilih langsung dari supplier terpercaya</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="ci-delivery text-success"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Pengiriman Cepat</h6>
                                        <p class="fs-sm text-muted mb-0">Ke seluruh Indonesia</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="ci-headphones text-info"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Customer Service 24/7</h6>
                                        <p class="fs-sm text-muted mb-0">Tim support kami siap membantu</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="ci-security-check text-warning"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Garansi Resmi</h6>
                                        <p class="fs-sm text-muted mb-0">Semua produk bergaransi</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ route('web.shop') }}" class="btn btn-primary btn-lg rounded-pill">
                            <i class="ci-shopping-bag me-2"></i>Mulai Belanja
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" class="rounded-4 img-fluid" alt="Tentang Adun Mancing">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <button type="button" class="btn btn-primary btn-lg rounded-circle" style="width: 80px; height: 80px;">
                                <i class="ci-play fs-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 8. Newsletter Section -->
        <section class="bg-body-tertiary py-5 my-2 my-sm-3 my-lg-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="pe-lg-4">
                            <h2 class="h1 mb-3">Dapatkan Tips Memancing Terbaru</h2>
                            <p class="fs-5 text-muted">Berlangganan newsletter kami dan dapatkan tips, trik, dan promo eksklusif langsung ke email Anda</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <form class="d-flex gap-2">
                            <div class="flex-grow-1">
                                <input type="email" class="form-control form-control-lg rounded-pill" placeholder="Masukkan email Anda" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-4 flex-shrink-0">
                                Subscribe
                            </button>
                        </form>
                        <p class="text-muted fs-sm mt-2 mb-0">
                            <i class="ci-security-check me-1"></i>
                            Kami tidak akan mengirim spam. Unsubscribe kapan saja.
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection

@section('footer_scripts')
<script>
    // Initialize Swiper for hero slider
    document.addEventListener('DOMContentLoaded', function() {
        // Hero slider initialization is handled by data-swiper attribute
        // New products slider initialization is handled by data-swiper attribute
        
        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });
</script>
@endsection