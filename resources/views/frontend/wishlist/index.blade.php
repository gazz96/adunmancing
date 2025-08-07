@extends('frontend.layouts.default')

@section('content')
<main class="content-wrapper">
    <div class="container">
        
        <!-- Breadcrumb -->
        <nav class="position-relative pt-3 mt-3 mt-md-4 mb-4" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col">
                <h1 class="h2 mb-2">My Wishlist</h1>
                <p class="text-muted mb-0">{{ $wishlists->total() }} item{{ $wishlists->total() != 1 ? 's' : '' }} dalam wishlist Anda</p>
            </div>
        </div>

        @if($wishlists->count() > 0)
            <!-- Wishlist Items -->
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
                @foreach($wishlists as $wishlist)
                    <div class="col" id="wishlist-item-{{ $wishlist->product_id }}">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="position-relative">
                                <a href="{{ $wishlist->product->permalink }}" class="d-block">
                                    @if($wishlist->product->compare_price && $wishlist->product->percentage_discount_by_compare_price > 0)
                                        <div class="position-absolute top-0 start-0 z-2 mt-2 ms-2">
                                            <span class="badge bg-danger">-{{ $wishlist->product->percentage_discount_by_compare_price }}%</span>
                                        </div>
                                    @endif
                                    <button type="button" 
                                            class="btn btn-icon btn-sm btn-secondary position-absolute top-0 end-0 z-2 mt-2 me-2 remove-from-wishlist" 
                                            data-product-id="{{ $wishlist->product_id }}"
                                            title="Remove from wishlist">
                                        <i class="ci-close"></i>
                                    </button>
                                    <div class="ratio ratio-1x1">
                                        @if($wishlist->product->featured_image_url)
                                            <img src="{{ $wishlist->product->featured_image_url }}" 
                                                 class="card-img-top object-fit-cover" 
                                                 alt="{{ $wishlist->product->name }}"
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
                                    <a href="{{ $wishlist->product->permalink }}" 
                                       class="text-decoration-none text-dark">
                                        {{ Str::limit($wishlist->product->name, 50) }}
                                    </a>
                                </h5>
                                <div class="mb-3">
                                    <span class="h6 text-primary">Rp {{ $wishlist->product->price_label }}</span>
                                    @if($wishlist->product->compare_price)
                                        <del class="fs-sm text-muted ms-2">Rp {{ $wishlist->product->compare_price_label }}</del>
                                    @endif
                                </div>
                                <div class="mt-auto d-flex gap-2">
                                    <button type="button" 
                                            class="btn btn-primary btn-sm w-100 add-to-cart-btn" 
                                            data-product-id="{{ $wishlist->product_id }}">
                                        <i class="ci-shopping-cart me-1"></i>
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($wishlists->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $wishlists->links() }}
                </div>
            @endif

        @else
            <!-- Empty Wishlist -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="ci-heart text-muted" style="font-size: 4rem;"></i>
                </div>
                <h3 class="h4 mb-3">Wishlist Anda Kosong</h3>
                <p class="text-muted mb-4">Mulai jelajahi produk-produk menarik dan tambahkan ke wishlist Anda!</p>
                <a href="{{ route('frontend.shop') }}" class="btn btn-primary">
                    <i class="ci-arrow-left me-2"></i>
                    Belanja Sekarang
                </a>
            </div>
        @endif

    </div>
</main>
@endsection

@section('footer_scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Remove from wishlist
    document.querySelectorAll('.remove-from-wishlist').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const productId = this.dataset.productId;
            
            fetch('{{ route("wishlist.remove") }}', {
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
                    // Remove the item from DOM
                    const item = document.getElementById(`wishlist-item-${productId}`);
                    if (item) {
                        item.style.transition = 'opacity 0.3s ease';
                        item.style.opacity = '0';
                        setTimeout(() => {
                            item.remove();
                            
                            // Check if no more items
                            const remainingItems = document.querySelectorAll('[id^="wishlist-item-"]');
                            if (remainingItems.length === 0) {
                                location.reload(); // Reload to show empty state
                            }
                        }, 300);
                    }
                    
                    // Show success message
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus dari wishlist');
            });
        });
    });

    // Add to cart from wishlist
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            
            fetch('{{ route("cart.add") }}', {
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
                    alert(data.message);
                } else {
                    alert(data.error || 'Terjadi kesalahan saat menambah ke cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menambah ke cart');
            });
        });
    });
});
</script>
@endsection