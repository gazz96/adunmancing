@extends('frontend.layouts.default')

@push('styles')
<style>
.article-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.article-content h2,
.article-content h3,
.article-content h4,
.article-content h5,
.article-content h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.article-content p {
    margin-bottom: 1.5rem;
    text-align: justify;
}

.article-content blockquote {
    border-left: 4px solid var(--bs-primary);
    padding: 1rem 1.5rem;
    margin: 2rem 0;
    background-color: var(--bs-light);
    font-style: italic;
}

.article-content img {
    border-radius: 0.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    margin: 1.5rem 0;
}

.hover-effect-target:hover {
    transform: scale(1.02);
    transition: transform 0.3s ease;
}

.engagement-buttons .btn:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease;
}
</style>
@endpush

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
                        @if($post->author)
                            <div class="d-flex align-items-center">
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="ci-user fs-sm text-body-secondary"></i>
                                </div>
                                <span class="ms-2 text-body fs-xs">{{ $post->author->name }}</span>
                            </div>
                            <hr class="vr my-1 mx-1">
                        @endif
                        <span class="text-body-tertiary fs-xs">
                            <i class="ci-calendar fs-xs me-1"></i>
                            {{ date('d F Y', strtotime($post->created_at)) }}
                        </span>
                        <hr class="vr my-1 mx-1">
                        <span class="text-body-tertiary fs-xs">
                            <i class="ci-eye fs-xs me-1"></i>
                            {{ number_format($post->views) }} views
                        </span>
                        <hr class="vr my-1 mx-1">
                        <span class="text-body-tertiary fs-xs">
                            <i class="ci-clock fs-xs me-1"></i>
                            {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read
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

                    <div class="article-content">
                        {!! $post->content !!}
                    </div>

                    <!-- Author Bio Section -->
                    @if($post->author)
                    <div class="card bg-body-tertiary border-0 my-5">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 60px; height: 60px;">
                                    <i class="ci-user text-white fs-3"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-2">{{ $post->author->name }}</h5>
                                    <p class="text-body-secondary mb-3">{{ $post->author->email }}</p>
                                    <p class="mb-0">Penulis yang berpengalaman dalam dunia perikanan dan teknologi. Berbagi pengetahuan tentang tips memancing dan peralatan terbaru.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Engagement Section -->
                    <div class="bg-body-secondary rounded-3 p-4 my-5">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="mb-2">Apakah artikel ini membantu?</h5>
                                <p class="text-body-secondary mb-md-0">Berikan rating untuk artikel ini</p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="d-flex justify-content-md-end gap-2 engagement-buttons">
                                    <button class="btn btn-sm btn-success">
                                        <i class="ci-thumbs-up me-1"></i>
                                        Membantu
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="ci-thumbs-down me-1"></i>
                                        Tidak
                                    </button>
                                </div>
                            </div>
                        </div>
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


        <!-- Newsletter Subscription -->
        <section class="container pb-5 mb-2 mb-md-3">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="bg-primary rounded-4 p-4 p-sm-5 text-center">
                        <h3 class="h4 text-white mb-3">Dapatkan Tips Memancing Terbaru</h3>
                        <p class="text-white opacity-75 mb-4">Berlangganan newsletter kami untuk mendapatkan tips, trik, dan informasi peralatan memancing terbaru langsung di inbox Anda.</p>
                        <form class="d-flex flex-column flex-sm-row gap-3 mx-auto" style="max-width: 400px;">
                            <input type="email" class="form-control" placeholder="Email Anda" required>
                            <button type="submit" class="btn btn-light">
                                <i class="ci-mail me-1"></i>
                                Subscribe
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Related articles -->
        <section class="container pb-5 mb-1 mb-sm-2 mb-md-3 mb-lg-4 mb-xl-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="h3 text-center pb-4 mb-4 border-bottom">Artikel Terkait</h2>
                    <div class="row">
                        @php
                            $relatedPosts = \App\Models\Blog::where('id', '!=', $post->id)
                                ->whereIsPublished(1)
                                ->latest()
                                ->take(3)
                                ->get();
                        @endphp
                        
                        @forelse($relatedPosts as $relatedPost)
                        <div class="col-md-4 mb-4">
                            <article class="card h-100 border-0 shadow-sm">
                                <a href="{{ $relatedPost->permalink }}" class="position-relative overflow-hidden rounded-top">
                                    <img src="{{ $relatedPost->featured_image_url ?: 'https://via.placeholder.com/300x200?text=No+Image' }}" 
                                         class="card-img-top hover-effect-target" alt="{{ $relatedPost->title }}"
                                         style="height: 200px; object-fit: cover;">
                                </a>
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        @foreach($relatedPost->categories as $category)
                                            <span class="badge bg-secondary">{{ $category->name }}</span>
                                        @endforeach
                                    </div>
                                    <h5 class="card-title">
                                        <a href="{{ $relatedPost->permalink }}" class="text-decoration-none text-dark hover-effect-underline">
                                            {{ $relatedPost->title }}
                                        </a>
                                    </h5>
                                    <p class="card-text text-body-secondary">{{ $relatedPost->excerpt }}</p>
                                    <div class="d-flex align-items-center gap-3 text-body-tertiary fs-xs">
                                        <span>
                                            <i class="ci-calendar me-1"></i>
                                            {{ $relatedPost->created_at->format('d M Y') }}
                                        </span>
                                        <span>
                                            <i class="ci-eye me-1"></i>
                                            {{ number_format($relatedPost->views) }}
                                        </span>
                                    </div>
                                </div>
                            </article>
                        </div>
                        @empty
                        <div class="col-12 text-center">
                            <p class="text-body-secondary">Tidak ada artikel terkait</p>
                        </div>
                        @endforelse
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('web.blogs') }}" class="btn btn-outline-primary">
                            <i class="ci-arrow-left me-1"></i>
                            Lihat Semua Artikel
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Comments Section -->
        <section class="container pb-5 mb-1 mb-sm-2 mb-md-3 mb-lg-4 mb-xl-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="border-top pt-5">
                        <h3 class="h4 mb-4">Diskusi & Komentar</h3>
                        
                        <!-- Comment Form -->
                        <div class="card bg-body-secondary border-0 mb-4">
                            <div class="card-body p-4">
                                <h5 class="mb-3">Tulis Komentar</h5>
                                <form>
                                    <div class="row mb-3">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control" placeholder="Nama*" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="email" class="form-control" placeholder="Email*" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <textarea class="form-control" rows="4" placeholder="Tulis komentar Anda..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ci-send me-1"></i>
                                        Kirim Komentar
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Sample Comments -->
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="mb-0">3 Komentar</h5>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Urutkan
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Terbaru</a></li>
                                    <li><a class="dropdown-item" href="#">Terlama</a></li>
                                    <li><a class="dropdown-item" href="#">Terpopuler</a></li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Comment Item -->
                        <div class="d-flex gap-3 pb-4 mb-4 border-bottom">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                                <i class="ci-user text-white"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <h6 class="mb-0">Andi Setiawan</h6>
                                    <span class="text-body-tertiary fs-xs">2 hari yang lalu</span>
                                </div>
                                <p class="mb-2">Artikel yang sangat bermanfaat! Saya sudah mencoba tips yang disebutkan dan hasilnya memuaskan. Terima kasih sudah berbagi.</p>
                                <div class="d-flex gap-3">
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="ci-thumbs-up me-1"></i>
                                        5
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="ci-message-circle me-1"></i>
                                        Balas
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- More sample comments can be added here -->
                        <div class="text-center">
                            <button class="btn btn-outline-secondary">
                                Muat Komentar Lainnya
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
