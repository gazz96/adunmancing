@extends('frontend.layouts.default')


@section('content')
    <!-- Posts list + Sidebar -->
    <section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5 mt-5">
        <div class="row">

            <!-- Posts list -->
            <div class="col-lg-8">
                <div class="d-flex flex-column gap-4 mt-n3">
                    @foreach($posts as $post)
                    <!-- Article -->
                    <article class="row align-items-start align-items-md-center gx-0 gy-4 pt-3">
                        <div class="col-sm-5 pe-sm-4">
                            <a class="ratio d-flex hover-effect-scale rounded overflow-hidden flex-md-shrink-0"
                                href="{{$post->permalink}}" style="--cz-aspect-ratio: calc(226 / 306 * 100%)">
                                <img src="{{$post->featured_image_url}}" class="hover-effect-target" alt="Read: {{$post->title}}">
                            </a>
                        </div>
                        <div class="col-sm-7">
                            <div class="nav align-items-center gap-2 pb-2 mt-n1 mb-1">
                                {{-- <a class="nav-link text-body fs-xs text-uppercase p-0" href="#!">Tech tips</a>
                                <hr class="vr my-1 mx-1"> --}}
                                <span class="text-body-tertiary fs-xs">{{date('d F Y', strtotime($post->created_at))}}</span>
                            </div>
                            <h3 class="h5 mb-2 mb-md-3">
                                <a class="hover-effect-underline" href="{{$post->permalink}}">{{$post->title}}</a>
                            </h3>
                            <p class="mb-0">{{$post->excerpt}}</p>
                        </div>
                    </article>
                    @endforeach
                </div>
    
                <!-- Pagination -->
                <div>
                    {{$posts->links()}}
                </div>
                {{-- <nav aria-label="Blog pages">
                    <ul class="pagination pagination-lg">
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">
                                1
                                <span class="visually-hidden">(current)</span>
                            </span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">4</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">5</a>
                        </li>
                    </ul>
                </nav> --}}
            </div>


            <!-- Sticky sidebar that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
            <aside class="col-lg-4 col-xl-3 offset-xl-1" style="margin-top: -115px">
                <div class="offcanvas-lg offcanvas-end sticky-lg-top ps-lg-4 ps-xl-0" id="blogSidebar">
                    <div class="d-none d-lg-block" style="height: 115px"></div>
                    <div class="offcanvas-header py-3">
                        <h5 class="offcanvas-title">Sidebar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                            data-bs-target="#blogSidebar" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-block pt-2 py-lg-0">
                        <h4 class="h6 mb-4">Blog categories</h4>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach($categories as $category)
                            <a class="btn btn-outline-secondary px-3" href="?category_id={{$category->id}}">{{$category->name}}</a>
                            @endforeach
                        </div>
                        <h4 class="h6 pt-5 mb-0">Trending posts</h4>
                        @foreach($trendingPosts as $trendingPost)
                        <article class="hover-effect-scale position-relative d-flex align-items-center border-bottom py-4">
                            <div class="w-100 pe-3">
                                <h3 class="h6 lh-base fs-sm mb-0">
                                    <a class="hover-effect-underline stretched-link" href="{{$trendingPost->permalink}}">{{$trendingPost->title}}</a>
                                </h3>
                            </div>
                            <div class="ratio w-100" style="max-width: 86px; --cz-aspect-ratio: calc(64 / 86 * 100%)">
                                <img src="{{ $trendingPost->featured_image_url }}" class="rounded-2" alt="{{$trendingPost->title}}">
                            </div>
                        </article>
                        @endforeach
                        {{-- <h4 class="h6 pt-4">Follow us</h4>
                        <div class="d-flex gap-2 pb-2">
                            <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!"
                                data-bs-toggle="tooltip"
                                data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>'
                                title="Instagram" aria-label="Follow us on Instagram">
                                <i class="ci-instagram"></i>
                            </a>
                            <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!"
                                data-bs-toggle="tooltip"
                                data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>'
                                title="X (Twitter)" aria-label="Follow us on X">
                                <i class="ci-x"></i>
                            </a>
                            <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!"
                                data-bs-toggle="tooltip"
                                data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>'
                                title="Facebook" aria-label="Follow us on Facebook">
                                <i class="ci-facebook"></i>
                            </a>
                            <a class="btn btn-icon fs-base btn-outline-secondary border-0" href="#!"
                                data-bs-toggle="tooltip"
                                data-bs-template='<div class="tooltip fs-xs mb-n2" role="tooltip"><div class="tooltip-inner bg-transparent text-body p-0"></div></div>'
                                title="Telegram" aria-label="Follow us on Telegram">
                                <i class="ci-telegram"></i>
                            </a>
                        </div> --}}
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
