@if ($carts->count() > 0)
    @foreach ($carts as $cart)
        <div class="d-flex align-items-center mb-3">
            <a class="position-relative flex-shrink-0" href="#">
                @if($cart->product->compare_price)
                <span class="badge text-bg-danger position-absolute top-0 start-0">-{{$cart->product->percentage_discount_by_compare_price}}%</span>
                @endif
                <img src="{{ $cart->product->featured_image_url }}"
                    width="110" alt="iPad Pro">
            </a>
            <div class="w-100 min-w-0 ps-2 ps-sm-3">
                <div>
                    {{$cart->attribute_labels}}
                </div>
                <h5 class="d-flex animate-underline mb-2">
                    <a class="d-block fs-sm fw-medium text-truncate animate-target" href="#">{{$cart->product->name}}</a>
                </h5>
                <div class="h6 pb-1 mb-2">{{ $cart->product->price_label }} <del
                        class="text-body-tertiary fs-xs fw-normal">{{ $cart->product->compare_price_label }}</del>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="count-input rounded-2">
                        <button type="button" class="btn btn-icon btn-sm" data-decrement
                            aria-label="Decrement quantity">
                            <i class="ci-minus"></i>
                        </button>
                        <input type="number" class="form-control form-control-sm" value="{{$cart->quantity}}" readonly>
                        <button type="button" class="btn btn-icon btn-sm" data-increment
                            aria-label="Increment quantity">
                            <i class="ci-plus"></i>
                        </button>
                    </div>
                    <button type="button" class="btn-close fs-sm btn-remove_from_cart" data-key="{{$cart->id}}" data-bs-toggle="tooltip"
                        data-bs-custom-class="tooltip-sm" data-bs-title="Remove" aria-label="Remove from cart"></button>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="text-center">
        <svg class="d-block mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" width="60" viewBox="0 0 29.5 30">
            <path class="text-body-tertiary"
                d="M17.8 4c.4 0 .8-.3.8-.8v-2c0-.4-.3-.8-.8-.8-.4 0-.8.3-.8.8v2c0 .4.3.8.8.8zm3.2.6c.4.2.8 0 1-.4l.4-.9c.2-.4 0-.8-.4-1s-.8 0-1 .4l-.4.9c-.2.4 0 .9.4 1zm-7.5-.4c.2.4.6.6 1 .4s.6-.6.4-1l-.4-.9c-.2-.4-.6-.6-1-.4s-.6.6-.4 1l.4.9z"
                fill="currentColor" />
            <path class="text-body-emphasis"
                d="M10.7 24.5c-1.5 0-2.8 1.2-2.8 2.8S9.2 30 10.7 30s2.8-1.2 2.8-2.8-1.2-2.7-2.8-2.7zm0 4c-.7 0-1.2-.6-1.2-1.2s.6-1.2 1.2-1.2 1.2.6 1.2 1.2-.5 1.2-1.2 1.2zm11.1-4c-1.5 0-2.8 1.2-2.8 2.8a2.73 2.73 0 0 0 2.8 2.8 2.73 2.73 0 0 0 2.8-2.8c0-1.6-1.3-2.8-2.8-2.8zm0 4c-.7 0-1.2-.6-1.2-1.2s.6-1.2 1.2-1.2 1.2.6 1.2 1.2-.6 1.2-1.2 1.2zM8.7 18h16c.3 0 .6-.2.7-.5l4-10c.2-.5-.2-1-.7-1H9.3c-.4 0-.8.3-.8.8s.4.7.8.7h18.3l-3.4 8.5H9.3L5.5 1C5.4.7 5.1.5 4.8.5h-4c-.5 0-.8.3-.8.7s.3.8.8.8h3.4l3.7 14.6a3.24 3.24 0 0 0-2.3 3.1C5.5 21.5 7 23 8.7 23h16c.4 0 .8-.3.8-.8s-.3-.8-.8-.8h-16a1.79 1.79 0 0 1-1.8-1.8c0-1 .9-1.6 1.8-1.6z"
                fill="currentColor" />
        </svg>
        <h6 class="mb-2">Your shopping cart is currently empty!</h6>
        <p class="fs-sm mb-4">Explore our wide range of products and add items to your cart to proceed with your
            purchase.</p>
        <a class="btn btn-dark rounded-pill" href="{{ route('web.shop') }}">Continue shopping</a>
    </div>
@endif
