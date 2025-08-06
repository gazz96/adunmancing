@extends('frontend.layouts.default')

@section('content')
    <!-- Page content -->
    <main class="content-wrapper">

        <!-- Breadcrumb -->
        <nav class="container pt-1 pt-md-0 my-3 my-md-4" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/shop') }}">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cart</li>
            </ol>
        </nav>

        <!-- Cart section -->
        <section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
            <h1 class="h3 mb-4">Shopping Cart</h1>

            @if($carts && $carts->count() > 0)
                <div class="row">
                    <!-- Cart items -->
                    <div class="col-lg-8">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($carts as $cart)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('storage/' . $cart->product->featured_image) }}" 
                                                         alt="{{ $cart->product->name }}" 
                                                         class="me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                    <div>
                                                        <h6 class="mb-1">{{ $cart->product->name }}</h6>
                                                        <small class="text-muted">Weight: {{ $cart->product->weight }}g</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Rp {{ number_format($cart->product->price) }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <input type="number" class="form-control me-2" 
                                                           style="width: 80px;" 
                                                           value="{{ $cart->quantity }}" 
                                                           min="1"
                                                           onchange="updateCart({{ $cart->product_id }}, this.value)">
                                                </div>
                                            </td>
                                            <td>Rp {{ number_format($cart->product->price * $cart->quantity) }}</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-danger btn-sm" 
                                                        onclick="removeFromCart({{ $cart->product_id }})">
                                                    <i class="ci-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Cart summary -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Cart Summary</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span>Rp {{ number_format($carts->sum(function($cart) { return $cart->product->price * $cart->quantity; })) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span>Items:</span>
                                    <span>{{ $carts->sum('quantity') }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Total:</strong>
                                    <strong>Rp {{ number_format($carts->sum(function($cart) { return $cart->product->price * $cart->quantity; })) }}</strong>
                                </div>
                                <a href="{{ route('web.checkout') }}" class="btn btn-primary w-100">
                                    Proceed to Checkout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty cart -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="ci-shopping-cart" style="font-size: 4rem; color: #dee2e6;"></i>
                    </div>
                    <h4 class="mb-3">Your cart is empty</h4>
                    <p class="text-muted mb-4">Looks like you haven't added any items to your cart yet.</p>
                    <a href="{{ route('web.shop') }}" class="btn btn-primary">
                        Continue Shopping
                    </a>
                </div>
            @endif
        </section>
    </main>
@endsection

@section('footer_scripts')
    <script>
        function updateCart(productId, quantity) {
            if (quantity < 1) {
                quantity = 1;
            }
            
            fetch('{{ route("cart.update") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: parseInt(quantity)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to update cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update cart');
            });
        }

        function removeFromCart(productId) {
            if (confirm('Are you sure you want to remove this item from cart?')) {
                fetch('{{ route("cart.remove") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to remove item from cart');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to remove item from cart');
                });
            }
        }
    </script>
@endsection