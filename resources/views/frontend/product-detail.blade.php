@extends('frontend.layouts.default')

@section('content')
    <!-- Page content -->
    <main class="content-wrapper">
        <div class="container">

            <!-- Breadcrumb -->
            <nav class="position-relative pt-3 mt-3 mt-md-4 mb-4" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('shop') }}">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
                </ol>
            </nav>


            <!-- Product gallery and details -->
            <section class="row pb-4 pb-md-5 mb-2 mb-md-0 mb-xl-3">

                <!-- Gallery -->
                <div class="col-md-7 col-xl-8 pb-4 pb-md-0 mb-2 mb-sm-3 mb-md-0">
                    @if($product->featured_image || $product->images->count() > 0)
                        <div class="row row-cols-2 g-3 g-sm-4 g-md-3 g-lg-4">
                            @if($product->featured_image)
                            <div class="col">
                                <a class="hover-effect-scale hover-effect-opacity position-relative d-flex rounded-4 overflow-hidden"
                                    href="{{ $product->featured_image_url }}" data-glightbox
                                    data-gallery="product-gallery">
                                    <i class="ci-zoom-in hover-effect-target fs-3 text-white position-absolute top-50 start-50 translate-middle opacity-0 z-2"></i>
                                    <div class="ratio ratio-1x1 hover-effect-target">
                                        <img src="{{ $product->featured_image_url}}" alt="{{ $product->name}}" class="w-100 h-100 object-fit-cover">
                                    </div>
                                </a>
                            </div>
                            @endif
                            @foreach($product->images as $image)
                            <div class="col">
                                <a class="hover-effect-scale hover-effect-opacity position-relative d-flex rounded-4 overflow-hidden"
                                    href="{{ $image->image_url }}" data-glightbox
                                    data-gallery="product-gallery">
                                    <i class="ci-zoom-in hover-effect-target fs-3 text-white position-absolute top-50 start-50 translate-middle opacity-0 z-2"></i>
                                    <div class="ratio ratio-1x1 hover-effect-target">
                                        <img src="{{ $image->image_url}}" alt="Product Image" class="w-100 h-100 object-fit-cover">
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <!-- No images placeholder -->
                        <div class="d-flex align-items-center justify-content-center bg-light rounded-4" style="min-height: 400px;">
                            <div class="text-center">
                                <i class="ci-image fs-1 text-muted mb-3"></i>
                                <h5 class="text-muted">Tidak ada gambar produk</h5>
                                <p class="text-muted mb-0">Gambar produk belum tersedia</p>
                            </div>
                        </div>
                    @endif
                </div>


                <!-- Product details and options -->
                <div class="col-md-5 col-xl-4">
                    <div class="d-none d-md-block" style="margin-top: -90px"></div>
                    <div class="sticky-md-top ps-md-2 ps-xl-4">
                        <div class="d-none d-md-block" style="padding-top: 90px"></div>
                        <div class="fs-xs text-body-secondary mb-3">P{{$product->id}}</div>
                        <h1 class="fs-xl fw-medium">{{ $product->name }}</h1>
                        <div class="h4 fw-bold mb-4">
                            Rp {{ $product->price_label }}
                            @if($product->compare_price)
                                <del class="fs-sm fw-normal text-body-tertiary ms-2">Rp {{ $product->compare_price_label }}</del>
                            @endif
                        </div>

                        <!-- Product Variations -->
                        <form action="{{ route('cart.add') }}" method="POST" id="form-add_to_cart">
                            @csrf
                            
                            @if($product->hasVariations())
                                @foreach($product->variations as $slug => $variation)
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold pb-1 mb-2">
                                            {{ $variation['attribute']->name }}
                                            @if($variation['attribute']->is_required)
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>

                                        @if($variation['attribute']->type == 'color')
                                            <!-- Color options -->
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($variation['selected_values'] as $value)
                                                    <input type="radio" 
                                                           class="btn-check attribute-option" 
                                                           name="attributes[{{ $variation['attribute']->id }}]" 
                                                           id="attr_{{ $variation['attribute']->id }}_{{ $value->id }}"
                                                           value="{{ $value->id }}"
                                                           data-price-adjustment="{{ $value->price_adjustment }}"
                                                           {{ $variation['attribute']->is_required ? 'required' : '' }}>
                                                    <label for="attr_{{ $variation['attribute']->id }}_{{ $value->id }}" 
                                                           class="btn btn-outline-secondary"
                                                           style="@if($value->color_code) background-color: {{ $value->color_code }}; border-color: {{ $value->color_code }}; @endif">
                                                        {{ $value->display_value }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        
                                        @elseif($variation['attribute']->type == 'size' || $variation['attribute']->type == 'radio')
                                            <!-- Size/Radio options -->
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($variation['selected_values'] as $value)
                                                    <input type="radio" 
                                                           class="btn-check attribute-option" 
                                                           name="attributes[{{ $variation['attribute']->id }}]" 
                                                           id="attr_{{ $variation['attribute']->id }}_{{ $value->id }}"
                                                           value="{{ $value->id }}"
                                                           data-price-adjustment="{{ $value->price_adjustment }}"
                                                           {{ $variation['attribute']->is_required ? 'required' : '' }}>
                                                    <label for="attr_{{ $variation['attribute']->id }}_{{ $value->id }}" 
                                                           class="btn btn-outline-secondary">
                                                        {{ $value->display_value }}
                                                        @if($value->price_adjustment > 0)
                                                            <span class="badge bg-success ms-1">+Rp {{ number_format($value->price_adjustment, 0, ',', '.') }}</span>
                                                        @elseif($value->price_adjustment < 0)
                                                            <span class="badge bg-danger ms-1">-Rp {{ number_format(abs($value->price_adjustment), 0, ',', '.') }}</span>
                                                        @endif
                                                    </label>
                                                @endforeach
                                            </div>

                                        @else
                                            <!-- Select dropdown -->
                                            <select name="attributes[{{ $variation['attribute']->id }}]" 
                                                    class="form-select form-select-lg rounded-pill attribute-option"
                                                    {{ $variation['attribute']->is_required ? 'required' : '' }}>
                                                <option value="">Pilih {{ $variation['attribute']->name }}</option>
                                                @foreach($variation['selected_values'] as $value)
                                                    <option value="{{ $value->id }}" data-price-adjustment="{{ $value->price_adjustment }}">
                                                        {{ $value->display_value }}
                                                        @if($value->price_adjustment > 0)
                                                            (+Rp {{ number_format($value->price_adjustment, 0, ',', '.') }})
                                                        @elseif($value->price_adjustment < 0)
                                                            (-Rp {{ number_format(abs($value->price_adjustment), 0, ',', '.') }})
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                @endforeach
                            @endif

                            <!-- Add to cart + Wishlist buttons -->
                            <div class="d-flex gap-3 pb-4 mb-2 mb-lg-3">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="btn btn-lg btn-dark w-100 rounded-pill btn-add_to_cart">Add to cart</button>
                                <button type="button" 
                                        class="btn btn-icon btn-lg btn-secondary rounded-circle animate-pulse wishlist-toggle"
                                        data-product-id="{{ $product->id }}"
                                        aria-label="Add to Wishlist">
                                    <i class="ci-heart fs-lg animate-target"></i>
                                </button>
                            </div>

                        </form>

                     

                        <!-- Product Details -->
                        <div class="bg-body-tertiary rounded p-3 mb-3">
                            <h6 class="fs-sm mb-2">Detail Produk</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="d-flex">
                                        <span class="fs-xs text-muted me-2">Berat:</span>
                                        @if($product->weight)
                                            <span class="fs-xs fw-medium">{{ number_format($product->weight, 0, ',', '.') }}g</span>
                                        @else
                                            <span class="fs-xs text-danger">Belum diatur</span>
                                        @endif
                                    </div>
                                </div>
                                @if($product->dimension)
                                <div class="col-6">
                                    <div class="d-flex">
                                        <span class="fs-xs text-muted me-2">Dimensi:</span>
                                        <span class="fs-xs fw-medium">{{ $product->dimension }}</span>
                                    </div>
                                </div>
                                @endif
                                <div class="col-6">
                                    <div class="d-flex">
                                        <span class="fs-xs text-muted me-2">Status:</span>
                                        <span class="fs-xs fw-medium text-success">{{ $product->stock_status_label }}</span>
                                    </div>
                                </div>
                                @if($product->manage_stock && $product->stock_quantity)
                                <div class="col-6">
                                    <div class="d-flex">
                                        <span class="fs-xs text-muted me-2">Stok:</span>
                                        <span class="fs-xs fw-medium">{{ $product->stock_quantity }} unit</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            @if(!$product->weight)
                                <div class="alert alert-warning alert-sm mt-2 mb-0">
                                    <small><i class="ci-alert-triangle me-1"></i> Berat produk belum diatur. Ongkos kirim mungkin tidak akurat.</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>


            <!-- Sticky product preview + Add to cart CTA -->
            <section class="sticky-product-banner sticky-top" data-sticky-element>
                <div class="sticky-product-banner-inner pt-5">
                    <div class="navbar flex-nowrap align-items-center bg-body pt-4 pb-2">
                        <div class="d-flex align-items-center min-w-0 ms-lg-2 me-3">
                            <div class="ratio ratio-1x1 flex-shrink-0 d-flex align-items-center justify-content-center bg-light rounded" style="width: 50px">
                                @if($product->featured_image)
                                    <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}" class="rounded">
                                @else
                                    <i class="ci-image text-muted"></i>
                                @endif
                            </div>
                            <h4 class="h6 fw-medium d-none d-lg-block ps-3 mb-0">{{ $product->name }}</h4>
                            <div class="w-100 min-w-0 d-lg-none ps-2">
                                <h4 class="fs-sm fw-medium text-truncate mb-1">{{ $product->name }}</h4>
                                <div class="h6 mb-0">
                                    Rp {{ $product->price_label }}
                                    @if($product->compare_price)
                                        <del class="fs-xs fw-normal text-body-tertiary ms-2">Rp {{ $product->compare_price_label }}</del>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="h4 d-none d-lg-block mb-0 ms-auto me-4">
                            Rp {{ $product->price_label }}
                            @if($product->compare_price)
                                <del class="fs-sm fw-normal text-body-tertiary ms-2">Rp {{ $product->compare_price_label }}</del>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-icon btn-secondary rounded-circle animate-pulse wishlist-toggle"
                                data-product-id="{{ $product->id }}"
                                aria-label="Add to Wishlist">
                                <i class="ci-heart fs-base animate-target"></i>
                            </button>
                            <button type="button"
                                class="btn btn-dark rounded-pill ms-auto d-none d-md-inline-flex px-4 sticky-add-to-cart"
                                data-product-id="{{ $product->id }}">Add to cart</button>
                            <button type="button"
                                class="btn btn-icon btn-dark rounded-circle animate-slide-end ms-auto d-md-none sticky-add-to-cart"
                                data-product-id="{{ $product->id }}"
                                aria-label="Add to Cart">
                                <i class="ci-shopping-cart fs-base animate-target"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </section>


            <!-- Product description -->
            <section class="row pb-5 mb-2 mb-sm-3 mb-lg-4 mb-xl-5">
                <div class="col-md-7 col-xl-8 mb-xxl-3">
                    <div>{!! $product->description !!}</div>
                    {{-- <ul class="list-unstyled pb-md-2 pb-lg-3">
                        <li class="mt-1"><span class="h6 mb-0">Backrest height:</span> 46 cm</li>
                        <li class="mt-1"><span class="h6 mb-0">Width:</span> 64 cm</li>
                        <li class="mt-1"><span class="h6 mb-0">Depth:</span> 78 cm</li>
                        <li class="mt-1"><span class="h6 mb-0">Height under furniture:</span> 22 cm</li>
                        <li class="mt-1"><span class="h6 mb-0">Seat width:</span> 56 cm</li>
                        <li class="mt-1"><span class="h6 mb-0">Armrest height:</span> 63 cm</li>
                    </ul> --}}

                    <div class="accordion accordion-alt-icon" id="productAccordion">
                        @if($product->warranty_information)
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingProductWarranty">
                                <button type="button" class="accordion-button animate-underline fs-xl collapsed"
                                    data-bs-toggle="collapse" data-bs-target="#productWarranty" aria-expanded="false"
                                    aria-controls="productWarranty">
                                    <span class="animate-target me-2">Informasi Garansi</span>
                                </button>
                            </h3>
                            <div class="accordion-collapse collapse" id="productWarranty"
                                aria-labelledby="headingProductWarranty" data-bs-parent="#productAccordion">
                                <div class="accordion-body fs-base">{{ $product->warranty_information }}</div>
                            </div>
                        </div>
                        @endif
                        
                        @if($product->delivery_shipping)
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="headingProductDelivery">
                                <button type="button" class="accordion-button animate-underline fs-xl collapsed"
                                    data-bs-toggle="collapse" data-bs-target="#productDelivery" aria-expanded="false"
                                    aria-controls="productDelivery">
                                    <span class="animate-target me-2">Pengiriman & Distribusi</span>
                                </button>
                            </h3>
                            <div class="accordion-collapse collapse" id="productDelivery"
                                aria-labelledby="headingProductDelivery" data-bs-parent="#productAccordion">
                                <div class="accordion-body fs-base">{{ $product->delivery_shipping }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </section>


            <!-- Popular products -->
            <section class="pb-5 mb-1 mb-sm-3 mb-lg-4 mb-xl-5">
                <h2 class="h3 pb-2 pb-sm-3">Popular products</h2>
                
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                    @forelse($popularProducts->take(8) as $popularProduct)
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="position-relative">
                                    <a href="{{ $popularProduct->permalink }}" class="d-block">
                                        @if($popularProduct->compare_price && $popularProduct->percentage_discount_by_compare_price > 0)
                                            <div class="position-absolute top-0 start-0 z-2 mt-2 ms-2">
                                                <span class="badge bg-danger">-{{ $popularProduct->percentage_discount_by_compare_price }}%</span>
                                            </div>
                                        @endif
                                        <div class="ratio ratio-1x1">
                                            @if($popularProduct->featured_image_url)
                                                <img src="{{ $popularProduct->featured_image_url }}" 
                                                     class="card-img-top object-fit-cover" 
                                                     alt="{{ $popularProduct->name }}"
                                                     style="border-radius: 0.5rem 0.5rem 0 0;">
                                            @else
                                                <div class="d-flex align-items-center justify-content-center bg-light" 
                                                     style="border-radius: 0.5rem 0.5rem 0 0;">
                                                    <div class="text-center">
                                                        <i class="ci-image text-muted mb-2" style="font-size: 2rem;"></i>
                                                        <small class="text-muted d-block">No Image</small>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fs-sm mb-2">
                                        <a href="{{ $popularProduct->permalink }}" 
                                           class="text-decoration-none text-dark">
                                            {{ Str::limit($popularProduct->name, 50) }}
                                        </a>
                                    </h5>
                                    <div class="mb-3">
                                        <span class="h6 text-primary">Rp {{ $popularProduct->price_label }}</span>
                                        @if($popularProduct->compare_price)
                                            <del class="fs-sm text-muted ms-2">Rp {{ $popularProduct->compare_price_label }}</del>
                                        @endif
                                    </div>
                                    <div class="mt-auto d-flex gap-2">
                                        <button type="button" 
                                                class="btn btn-primary btn-sm w-100 add-to-cart-btn" 
                                                data-product-id="{{ $popularProduct->id }}">
                                            <i class="ci-shopping-cart me-1"></i>
                                            Add to Cart
                                        </button>
                                        <button type="button"
                                                class="btn btn-outline-secondary btn-sm"
                                                aria-label="Add to wishlist">
                                            <i class="ci-heart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="ci-package text-muted mb-3" style="font-size: 3rem;"></i>
                                <p class="text-muted mb-0">Tidak ada produk populer saat ini.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </section>


            <!-- Blog articles -->
            <section class="pb-5 mb-2 mb-sm-3 mb-lg-4 mb-xl-5">
                <h2 class="h3 pb-2 pb-sm-3">From the blog</h2>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-xxl-3">
                    @forelse($blogPosts as $blogPost)
                    <!-- Article -->
                    <article class="col">
                        <a class="ratio d-flex hover-effect-scale rounded-4 overflow-hidden" 
                           href="{{ route('web.blog-post', $blogPost->slug) }}"
                           style="--cz-aspect-ratio: calc(200 / 280 * 100%)">
                            @if($blogPost->featured_image_url)
                                <img src="{{ $blogPost->featured_image_url }}" 
                                     class="hover-effect-target w-100 h-100 object-fit-cover" 
                                     alt="{{ $blogPost->title }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light hover-effect-target">
                                    <div class="text-center">
                                        <i class="ci-file-text text-muted mb-2" style="font-size: 2rem;"></i>
                                        <small class="text-muted d-block">Article</small>
                                    </div>
                                </div>
                            @endif
                        </a>
                        <div class="pt-4">
                            @if($blogPost->categories->first())
                            <div class="nav pb-2 mb-1">
                                <span class="nav-link text-body fs-xs text-uppercase p-0">{{ $blogPost->categories->first()->name ?? 'Blog' }}</span>
                            </div>
                            @endif
                            <h3 class="h6 mb-2">
                                <a class="hover-effect-underline text-decoration-none" 
                                   href="{{ route('web.blog-post', $blogPost->slug) }}">
                                    {{ Str::limit($blogPost->title, 50) }}
                                </a>
                            </h3>
                            
                            <!-- Excerpt - 20 words -->
                            <p class="fs-sm text-muted mb-3">
                                {{ $blogPost->excerpt }}
                            </p>
                            
                            {{-- <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2 fs-xs text-muted">
                                    <span>{{ $blogPost->author ?? 'Admin' }}</span>
                                    <span>•</span>
                                    <span>{{ $blogPost->created_at->format('M j, Y') }}</span>
                                </div>
                                <a href="{{ route('web.blog-post', $blogPost->slug) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <small>Baca</small>
                                </a>
                            </div> --}}
                        </div>
                    </article>
                    @empty
                    <div class="col-12">
                        <div class="text-center py-4">
                            <p class="text-muted">Tidak ada artikel blog saat ini.</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </section>


            <!-- Reviews -->
            <section class="pb-5 mb-2 mb-sm-3 mb-lg-4 mb-xl-5">

                <!-- Heading + Add review button -->
                <div class="d-sm-flex align-items-center justify-content-between border-bottom pb-2 pb-sm-3">
                    <div class="mb-3 me-sm-3">
                        <h2 class="h3 pb-2 mb-1">Review Produk</h2>
                        <div class="d-flex align-items-center fs-sm">
                            @if($totalReviews > 0)
                                <div class="d-flex gap-1 me-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= floor($averageRating + 0.5))
                                            <i class="ci-star-filled text-body-emphasis"></i>
                                        @else
                                            <i class="ci-star text-body-tertiary opacity-75"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="me-2">{{ number_format($averageRating, 1) }}</span>
                                <span>Berdasarkan {{ $totalReviews }} review{{ $totalReviews > 1 ? 's' : '' }}</span>
                            @else
                                <span>Belum ada review</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($canUserReview)
                        <button type="button" class="btn btn-lg btn-outline-dark rounded-pill mb-3" data-bs-toggle="modal"
                            data-bs-target="#reviewForm">Tulis Review</button>
                    @elseif($userReviewReason == 'already_reviewed')
                        <span class="badge bg-secondary mb-3">Anda sudah memberikan review</span>
                    @elseif($userReviewReason == 'not_logged_in')
                        <a href="{{ route('login') }}" class="btn btn-lg btn-outline-dark rounded-pill mb-3">Login untuk Review</a>
                    @endif
                </div>

                <!-- Reviews List -->
                @forelse($reviews as $review)
                    <div class="border-bottom py-4">
                        <div class="row py-sm-2">
                            <div class="col-md-4 col-lg-3 mb-3 mb-md-0">
                                <div class="d-flex h6 mb-2">
                                    {{ $review->user->name ?? 'Customer' }}
                                    @if($review->is_verified_purchase)
                                        <i class="ci-check-circle text-success mt-1 ms-2" data-bs-toggle="tooltip"
                                            data-bs-custom-class="tooltip-sm" title="Verified Purchase"></i>
                                    @endif
                                </div>
                                <div class="fs-sm mb-2 mb-md-3">{{ $review->created_at_formatted }}</div>
                                <div class="d-flex gap-1 fs-sm">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <i class="ci-star-filled text-body-emphasis"></i>
                                        @else
                                            <i class="ci-star text-body-tertiary opacity-75"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-9">
                                <p class="mb-md-4">{{ $review->review }}</p>
                                
                                @if($review->admin_reply)
                                    <div class="bg-light p-3 rounded mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <strong class="text-primary">Admin Response:</strong>
                                        </div>
                                        <p class="mb-0 fs-sm">{{ $review->admin_reply }}</p>
                                    </div>
                                @endif
                                
                                @if($review->is_verified_purchase)
                                    <div class="d-flex justify-content-end">
                                        <div class="badge bg-success-subtle text-success">
                                            <i class="ci-check fs-sm me-1"></i>
                                            Verified Purchase
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="ci-chat fs-1 text-muted"></i>
                        </div>
                        <h4 class="h5 text-muted mb-2">Belum ada review</h4>
                        <p class="text-muted mb-0">Jadilah yang pertama memberikan review untuk produk ini!</p>
                    </div>
                @endforelse

                <!-- Show More Reviews Button (only if there are more than 5 reviews) -->
                @if($reviews->count() > 5)
                    <div class="text-center pt-3">
                        <button class="btn btn-outline-primary" onclick="loadMoreReviews()">
                            Tampilkan Review Lainnya
                        </button>
                    </div>
                @endif
            </section>


            <!-- Viewed products -->
            <section class="pb-5 mb-2 mb-sm-3 mb-md-4 mb-lg-5">
                <h2 class="h3 pb-2 pb-sm-3">Viewed products</h2>
                
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                    @forelse($viewedProducts->take(8) as $viewedProduct)
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="position-relative">
                                    <a href="{{ $viewedProduct->permalink }}" class="d-block">
                                        @if($viewedProduct->compare_price && $viewedProduct->percentage_discount_by_compare_price > 0)
                                            <div class="position-absolute top-0 start-0 z-2 mt-2 ms-2">
                                                <span class="badge bg-danger">-{{ $viewedProduct->percentage_discount_by_compare_price }}%</span>
                                            </div>
                                        @endif
                                        <div class="ratio ratio-1x1">
                                            @if($viewedProduct->featured_image_url)
                                                <img src="{{ $viewedProduct->featured_image_url }}" 
                                                     class="card-img-top object-fit-cover" 
                                                     alt="{{ $viewedProduct->name }}"
                                                     style="border-radius: 0.5rem 0.5rem 0 0;">
                                            @else
                                                <div class="d-flex align-items-center justify-content-center bg-light" 
                                                     style="border-radius: 0.5rem 0.5rem 0 0;">
                                                    <div class="text-center">
                                                        <i class="ci-image text-muted mb-2" style="font-size: 2rem;"></i>
                                                        <small class="text-muted d-block">No Image</small>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fs-sm mb-2">
                                        <a href="{{ $viewedProduct->permalink }}" 
                                           class="text-decoration-none text-dark">
                                            {{ Str::limit($viewedProduct->name, 50) }}
                                        </a>
                                    </h5>
                                    <div class="mb-3">
                                        <span class="h6 text-primary">Rp {{ $viewedProduct->price_label }}</span>
                                        @if($viewedProduct->compare_price)
                                            <del class="fs-sm text-muted ms-2">Rp {{ $viewedProduct->compare_price_label }}</del>
                                        @endif
                                    </div>
                                    <div class="mt-auto d-flex gap-2">
                                        <button type="button" 
                                                class="btn btn-primary btn-sm w-100 add-to-cart-btn" 
                                                data-product-id="{{ $viewedProduct->id }}">
                                            <i class="ci-shopping-cart me-1"></i>
                                            Add to Cart
                                        </button>
                                        <button type="button"
                                                class="btn btn-outline-secondary btn-sm"
                                                aria-label="Add to wishlist">
                                            <i class="ci-heart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="ci-clock text-muted mb-3" style="font-size: 3rem;"></i>
                                <p class="text-muted mb-0">Tidak ada produk yang pernah dilihat.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </main>
@endsection

<!-- Review Form Modal -->
@if($canUserReview)
<div class="modal fade" id="reviewForm" tabindex="-1" aria-labelledby="reviewFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewFormLabel">Tulis Review untuk {{ $product->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="reviewFormSubmit">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <!-- Rating -->
                    <div class="mb-3">
                        <label class="form-label">Rating <span class="text-danger">*</span></label>
                        <div class="d-flex gap-1 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="ci-star text-body-tertiary star-rating" 
                                   data-rating="{{ $i }}" 
                                   style="font-size: 1.5rem; cursor: pointer;"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="selectedRating" required>
                        <div class="invalid-feedback" id="ratingError"></div>
                    </div>

                    <!-- Review Text -->
                    <div class="mb-3">
                        <label for="reviewText" class="form-label">Review Anda <span class="text-danger">*</span></label>
                        <textarea class="form-control" 
                                  id="reviewText" 
                                  name="review" 
                                  rows="4" 
                                  placeholder="Ceritakan pengalaman Anda dengan produk ini..."
                                  maxlength="1000"
                                  required></textarea>
                        <div class="form-text">
                            <span id="reviewCharCount">0</span>/1000 karakter
                        </div>
                        <div class="invalid-feedback" id="reviewError"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitReviewBtn">
                        <span class="btn-text">Kirim Review</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@section('footer_scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const basePrice = {{ $product->price }};
    const priceElements = document.querySelectorAll('.product-price');
    const stickyPriceElements = document.querySelectorAll('.h4');
    const attributeOptions = document.querySelectorAll('.attribute-option');

    function updatePrice() {
        let totalAdjustment = 0;
        
        // Calculate total price adjustment from selected attributes
        attributeOptions.forEach(function(option) {
            if ((option.type === 'radio' && option.checked) || 
                (option.tagName === 'SELECT' && option.value)) {
                
                const adjustment = parseFloat(option.dataset.priceAdjustment || 0);
                if (option.tagName === 'SELECT') {
                    const selectedOption = option.options[option.selectedIndex];
                    if (selectedOption && selectedOption.dataset.priceAdjustment) {
                        totalAdjustment += parseFloat(selectedOption.dataset.priceAdjustment);
                    }
                } else {
                    totalAdjustment += adjustment;
                }
            }
        });

        const finalPrice = basePrice + totalAdjustment;
        const formattedPrice = new Intl.NumberFormat('id-ID').format(finalPrice);
        
        // Update all price displays
        const priceDisplay = `Rp ${formattedPrice}`;
        
        // Update main price  
        const mainPriceElement = document.querySelector('.h4.fw-bold.mb-4');
        if (mainPriceElement) {
            const originalHTML = mainPriceElement.innerHTML;
            const newHTML = originalHTML.replace(/Rp\s[\d,\.]+/g, priceDisplay);
            mainPriceElement.innerHTML = newHTML;
        }
        
        // Update sticky price
        const stickyPriceElement = document.querySelector('.d-none.d-lg-block.mb-0.ms-auto.me-4');
        if (stickyPriceElement) {
            const originalHTML = stickyPriceElement.innerHTML;
            const newHTML = originalHTML.replace(/Rp\s[\d,\.]+/g, priceDisplay);
            stickyPriceElement.innerHTML = newHTML;
        }

        // Update mobile sticky price
        const mobileStickyPrice = document.querySelector('.h6.mb-0');
        if (mobileStickyPrice) {
            const originalHTML = mobileStickyPrice.innerHTML;
            const newHTML = originalHTML.replace(/Rp\s[\d,\.]+/g, priceDisplay);
            mobileStickyPrice.innerHTML = newHTML;
        }
    }

    // Add event listeners to all attribute options
    attributeOptions.forEach(function(option) {
        option.addEventListener('change', updatePrice);
    });

    // Review Form JavaScript
    @if($canUserReview)
    // Star rating functionality
    const starRatings = document.querySelectorAll('.star-rating');
    const selectedRatingInput = document.getElementById('selectedRating');
    
    starRatings.forEach(function(star, index) {
        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            selectedRatingInput.value = rating;
            
            // Update star display
            starRatings.forEach(function(s, i) {
                if (i < rating) {
                    s.classList.remove('text-body-tertiary');
                    s.classList.add('text-body-emphasis', 'ci-star-filled');
                } else {
                    s.classList.add('text-body-tertiary');
                    s.classList.remove('text-body-emphasis', 'ci-star-filled');
                }
            });
        });
        
        // Hover effects
        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            starRatings.forEach(function(s, i) {
                if (i < rating) {
                    s.classList.add('text-warning');
                } else {
                    s.classList.remove('text-warning');
                }
            });
        });
    });
    
    // Reset hover effects
    document.querySelector('.d-flex.gap-1.mb-2').addEventListener('mouseleave', function() {
        starRatings.forEach(function(s) {
            s.classList.remove('text-warning');
        });
    });

    // Character count for review
    const reviewTextarea = document.getElementById('reviewText');
    const charCountSpan = document.getElementById('reviewCharCount');
    
    reviewTextarea.addEventListener('input', function() {
        const count = this.value.length;
        charCountSpan.textContent = count;
        
        if (count > 1000) {
            charCountSpan.classList.add('text-danger');
        } else {
            charCountSpan.classList.remove('text-danger');
        }
    });

    // Review form submission
    const reviewForm = document.getElementById('reviewFormSubmit');
    const submitBtn = document.getElementById('submitReviewBtn');
    
    reviewForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Reset errors
        document.getElementById('ratingError').textContent = '';
        document.getElementById('reviewError').textContent = '';
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        // Validate form
        const rating = selectedRatingInput.value;
        const review = reviewTextarea.value.trim();
        let hasError = false;
        
        if (!rating) {
            document.getElementById('ratingError').textContent = 'Rating harus dipilih';
            selectedRatingInput.classList.add('is-invalid');
            hasError = true;
        }
        
        if (!review) {
            document.getElementById('reviewError').textContent = 'Review harus diisi';
            reviewTextarea.classList.add('is-invalid');
            hasError = true;
        } else if (review.length > 1000) {
            document.getElementById('reviewError').textContent = 'Review maksimal 1000 karakter';
            reviewTextarea.classList.add('is-invalid');
            hasError = true;
        }
        
        if (hasError) {
            return;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.querySelector('.btn-text').textContent = 'Mengirim...';
        submitBtn.querySelector('.spinner-border').classList.remove('d-none');
        
        // Prepare form data
        const formData = new FormData(this);
        
        // Submit review
        fetch('{{ route("reviews.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Review berhasil ditambahkan! Terima kasih atas feedback Anda.',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('reviewForm'));
                modal.hide();
                
                // Reload page to show new review
                window.location.reload();
            } else {
                // Show error message
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: data.message || 'Terjadi kesalahan saat mengirim review',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Terjadi kesalahan saat mengirim review',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        })
        .finally(() => {
            // Reset button state
            submitBtn.disabled = false;
            submitBtn.querySelector('.btn-text').textContent = 'Kirim Review';
            submitBtn.querySelector('.spinner-border').classList.add('d-none');
        });
    });
    @endif

    // Wishlist functionality
    document.querySelectorAll('.wishlist-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            
            fetch('{{ route("wishlist.toggle") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update button appearance
                    const icon = this.querySelector('i');
                    if (data.is_wishlist) {
                        icon.classList.remove('ci-heart');
                        icon.classList.add('ci-heart-filled', 'text-danger');
                        this.classList.remove('btn-secondary');
                        this.classList.add('btn-danger');
                    } else {
                        icon.classList.remove('ci-heart-filled', 'text-danger');
                        icon.classList.add('ci-heart');
                        this.classList.remove('btn-danger');
                        this.classList.add('btn-secondary');
                    }
                    
                    // Show success message
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                } else if (data.error) {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: data.error,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Terjadi kesalahan saat menambah ke wishlist',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
        });
    });

    // Update wishlist buttons for product cards
    document.querySelectorAll('.btn-outline-secondary[aria-label="Add to wishlist"]').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.closest('.col').querySelector('.add-to-cart-btn')?.dataset.productId;
            if (!productId) return;
            
            fetch('{{ route("wishlist.toggle") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const icon = this.querySelector('i');
                    if (data.is_wishlist) {
                        icon.classList.remove('ci-heart');
                        icon.classList.add('ci-heart-filled', 'text-danger');
                    } else {
                        icon.classList.remove('ci-heart-filled', 'text-danger');
                        icon.classList.add('ci-heart');
                    }
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                } else if (data.error) {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: data.error,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Terjadi kesalahan',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
        });
    });

    // Add to cart form is handled by global handlers in layouts/default.blade.php

    // Handle product card add to cart buttons
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            if (!productId) return;
            
            const originalText = this.textContent;
            this.disabled = true;
            this.textContent = 'Adding...';
            
            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Produk berhasil ditambahkan ke keranjang!',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                    
                    // Update cart badge
                    if (window.updateCartBadge) {
                        window.updateCartBadge();
                    }
                } else {
                    alert(data.error || 'Terjadi kesalahan');
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Terjadi kesalahan',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            })
            .finally(() => {
                this.disabled = false;
                this.textContent = originalText;
            });
        });
    });
});
</script>
@endsection