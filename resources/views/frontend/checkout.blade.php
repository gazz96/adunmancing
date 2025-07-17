@extends('frontend.layouts.default')

@section('content')
    <!-- Page content -->
    <main class="content-wrapper">

        <!-- Breadcrumb -->
        <nav class="container pt-1 pt-md-0 my-3 my-md-4" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/shop') }}">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>


        <!-- Checkout form + Order summary -->
        <form action="" method="POST">
            
            <section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
                <h1 class="h3 mb-4">Checkout</h1>
                <div class="row">

                    <!-- Checkout form -->
                    <div class="col-lg-8 col-xl-7 mb-5 mb-lg-0">

                        <!-- Delivery address section -->
                        <h2 class="h5 mb-4">Alamat Pengiriman</h2>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center fs-sm text-dark-emphasis me-3">
                                <i class="ci-map-pin fs-base text-primary me-2"></i>
                                {{ $addresses->where('is_default', 1)->first()->address ?? 'Alamat belum ada' }}
                            </div>
                            {{-- <div class="nav">
                                <a class="nav-link text-decoration-underline text-nowrap p-0" href="#deliveryOptions"
                                    data-bs-toggle="offcanvas" aria-controls="deliveryOptions">Ganti Alamat</a>
                            </div> --}}
                        </div>
                        
                        <!-- Payment method section -->
                        <h2 class="h5 mt-5 mb-0">Courier</h2>
                        
                        <div class="row my-3">

                            <div class="mb-3 col-md-12">
                                <option value="">Ekspedisi</option>
                                <select name="courier" id="iCourier" class="form-control">
                                    <option value="">Pilih</option>
                                    @foreach($couriers as $courier_code => $courier_name)
                                    <option value="{{$courier_code}}">{{ $courier_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 col-md-12">
                                <option value="">Paket</option>
                                <select name="courier_package" id="iCourierPackage" class="form-control"></select>
                            </div>

                        </div>




                    </div>


                    <!-- Order summary (sticky sidebar) -->
                    <aside class="col-lg-4 offset-xl-1" style="margin-top: -115px">
                        <div class="position-sticky top-0" style="padding-top: 115px">
                            <div class="d-flex align-items-center justify-content-between border-bottom pb-4 mb-4">
                                <h2 class="h5 mb-0 me-3">Order summary</h2>
                                <div class="nav">
                                    <a class="nav-link text-decoration-underline p-0" href="checkout-v2-cart.html">Edit</a>
                                </div>
                            </div>
                            <ul class="list-unstyled fs-sm gap-3 mb-0">
                                <li class="d-flex justify-content-between">
                                    Subtotal ({{$carts->count()}} items):
                                    <span class="text-dark-emphasis fw-medium" id="cart-price">{{
                                        number_format($carts->sum(function($row){
                                            return $row->quantity * $row->product->price;
                                        }))
                                    }}</span>
                                </li>
                                {{-- <li class="d-flex justify-content-between">
                                    Saving:
                                    <span class="text-danger fw-medium">-$2.79</span>
                                </li> --}}
                                <li class="d-flex justify-content-between">
                                    Delivery:
                                    <span class="text-dark-emphasis fw-medium" id="delivery-price"></span>
                                </li> 
                            </ul>
                            <div class="border-top pt-4 mt-4">
                                <div class="d-flex justify-content-between mb-4">
                                    <span class="fs-sm">Estimated total:</span>
                                    <span class="h5 mb-0" id="total-price">{{number_format($carts->sum(function($row){
                                            return $row->quantity * $row->product->price;
                                        }))}}</span>
                                </div>
                                {{-- <div class="alert d-flex alert-warning fs-sm rounded-4 mb-4" role="alert">
                                    <i class="ci-info fs-lg pe-1 mt-1 me-2"></i>
                                    <div>There is a weighted product in the cart. The actual amount may differ from the
                                        indicated amount.</div>
                                </div> --}}
                                <div class="mb-4">
                                    <label for="order-note" class="form-label">Order note</label>
                                    <textarea name="note" class="form-control rounded-5" id="order-note" rows="3"></textarea>
                                </div>
                                {{-- <div class="form-check mb-4">
                                    <input type="checkbox" class="form-check-input" id="age">
                                    <label for="age" class="form-check-label">The order has products with age
                                        restrictions. I confirm that <span class="fw-semibold">I am at least 18 years
                                            old.</span></label>
                                </div> --}}
                                <button type="submit" class="btn btn-lg btn-primary w-100 rounded-pill">
                                    Confirm the order
                                    <i class="ci-chevron-right fs-lg ms-1 me-n1"></i>
                                </button>
                            </div>
                        </div>
                    </aside>
                </div>
            </section>
        </form>
    </main>
@endsection


@section('footer_scripts')
    <!-- Delivey options offcanvas -->
    <div class="offcanvas offcanvas-end pb-sm-2 px-sm-2" id="deliveryOptions" tabindex="-1"
        aria-labelledby="deliveryOptionsLabel" style="width: 500px">

        <!-- Header with nav tabs -->
        <div class="offcanvas-header flex-column align-items-start py-3 pt-lg-4">
            <div class="d-flex align-items-center justify-content-between w-100 pb-xl-1 mb-4">
                <h4 class="offcanvas-title" id="deliveryOptionsLabel">Alamat</h4>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <ul class="nav nav-pills nav-justified w-100" role="tablist">
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link active" id="delivery-tab" data-bs-toggle="tab"
                        data-bs-target="#delivery-tab-pane" role="tab" aria-controls="delivery-tab-pane"
                        aria-selected="true">
                        <i class="ci-shopping-bag fs-base ms-n1 me-2"></i>
                        Pengiriman
                    </button>
                </li>
                {{-- <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" id="pickup-tab" data-bs-toggle="tab"
                        data-bs-target="#pickup-tab-pane" role="tab" aria-controls="pickup-tab-pane"
                        aria-selected="false">
                        <i class="ci-box fs-base ms-n1 me-2"></i>
                        Pickup
                    </button>
                </li> --}}
            </ul>
        </div>

        <div class="offcanvas-body tab-content py-2 py-sm-3">

            <!-- Delivery tab -->
            <div class="tab-pane fade show active" id="delivery-tab-pane" role="tabpanel"
                aria-labelledby="delivery-tab">

                <!-- Address options collapse -->
                <div class="collapse delivery-address show" id="deliveryAddressOptions">
                    <div class="mt-n3">
                        @foreach($addresses as $address)
                        <div class="form-check border-bottom py-4 m-0">
                            <input type="radio" class="form-check-input" id="address-{{$address->id}}" name="delivery-address[{{$address->id}}]"
                                @if($address->is_default) checked @endif>
                            
                            <label for="address-{{$address->id}}" class="form-check-label text-dark-emphasis fw-semibold">{{$address->name}} | {{ $address->address }}</label>
                        </div>
                        @endforeach
                        
                    </div>
                </div>

                <!-- Add new address collapse -->
                <div class="collapse delivery-address" id="deliveryAddressAdd">
                    <div class="nav mb-4">
                        <a class="nav-link animate-underline p-0" href=".delivery-address" data-bs-toggle="collapse"
                            aria-expanded="true" aria-controls="deliveryAddressOptions deliveryAddressAdd">
                            <i class="ci-chevron-left fs-lg ms-n1 me-1"></i>
                            <span class="animate-target">Back to my addresses</span>
                        </a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3 mb-lg-4">
                        <h5 class="h6 mb-0 me-3">Add an address to start ordering</h5>
                        <a class="btn btn-sm btn-outline-primary rounded-pill" href="#!">
                            <i class="ci-map-pin fs-base ms-n1 me-1"></i>
                            Find on map
                        </a>
                    </div>
                    <div class="mb-3 mb-lg-4">
                        <label class="form-label">State *</label>
                        <select class="form-select form-select-lg rounded-pill"
                            data-select='{
                "classNames": {
                  "containerInner": ["form-select", "form-select-lg", "rounded-pill"]
                }
              }'
                            aria-label="Large pill select">
                            <option value="">Select state</option>
                            <option value="Arizona">Arizona</option>
                            <option value="California">California</option>
                            <option value="Montana">Montana</option>
                            <option value="Nevada">Nevada</option>
                            <option value="New Mexico">New Mexico</option>
                            <option value="Texas">Texas</option>
                        </select>
                    </div>
                    <div class="mb-3 mb-lg-4">
                        <label for="my-postcode" class="form-label">Postcode *</label>
                        <input type="text" class="form-control form-control-lg rounded-pill" id="my-postcode">
                    </div>
                    <div class="mb-3 mb-lg-4">
                        <label class="form-label">City *</label>
                        <select class="form-select form-select-lg rounded-pill"
                            data-select='{
                "classNames": {
                  "containerInner": ["form-select", "form-select-lg", "rounded-pill"]
                }
              }'
                            aria-label="Large pill select">
                            <option value="">Select city</option>
                            <option value="Austin">Austin</option>
                            <option value="Helena">Helena</option>
                            <option value="Sacramento">Sacramento</option>
                            <option value="Santa Fe">Santa Fe</option>
                            <option value="Las Vegas">Las Vegas</option>
                            <option value="Phoenix">Phoenix</option>
                        </select>
                    </div>
                    <label for="my-address" class="form-label">Street address *</label>
                    <input type="text" class="form-control form-control-lg rounded-pill" id="my-address">
                </div>

                <!-- Add address collapse toggle -->
                <div class="nav">
                    <a class="nav-link hiding-collapse-toggle animate-underline collapsed px-0 mt-4"
                        href=".delivery-address" data-bs-toggle="collapse" aria-expanded="false"
                        aria-controls="deliveryAddressOptions deliveryAddressAdd">
                        <span class="animate-target">Tambah alamat pengiriman</span>
                        <i class="ci-plus fs-base ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Pickup tab -->
            <div class="tab-pane fade" id="pickup-tab-pane" role="tabpanel" aria-labelledby="pickup-tab">

                <!-- Pickup store options collapse -->
                <div class="collapse pickup-options show" id="pickupStoreOptions">
                    <div class="mt-n3">
                        <div class="form-check border-bottom py-4 m-0">
                            <input type="radio" class="form-check-input" id="store-1" name="pickup-store" checked>
                            <div>
                                <div class="d-flex w-100 pb-2 mb-1">
                                    <label for="store-1"
                                        class="form-check-label text-dark-emphasis fw-semibold me-3">Sacramento
                                        Supercenter</label>
                                    <button type="button" class="btn-close fs-sm ms-auto" data-bs-toggle="tooltip"
                                        data-bs-custom-class="tooltip-sm" data-bs-title="Remove"
                                        aria-label="Remove"></button>
                                </div>
                                <div class="fs-xs mb-2">8270 Delta Shores Cir S, Sacramento, CA 95832</div>
                                <div class="fs-xs">Open: <span class="text-dark-emphasis fw-medium">07:00 - 22:00</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-check border-bottom py-4 m-0">
                            <input type="radio" class="form-check-input" id="store-2" name="pickup-store">
                            <div>
                                <div class="d-flex w-100 pb-2 mb-1">
                                    <label for="store-2"
                                        class="form-check-label text-dark-emphasis fw-semibold me-3">West Sacramento
                                        Supercenter</label>
                                    <button type="button" class="btn-close fs-sm ms-auto" data-bs-toggle="tooltip"
                                        data-bs-custom-class="tooltip-sm" data-bs-title="Remove"
                                        aria-label="Remove"></button>
                                </div>
                                <div class="fs-xs mb-2">755 Riverpoint Ct, West Sacramento, CA 95605</div>
                                <div class="fs-xs">Open: <span class="text-dark-emphasis fw-medium">07:00 - 21:00</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-check border-bottom py-4 m-0">
                            <input type="radio" class="form-check-input" id="store-3" name="pickup-store">
                            <div>
                                <div class="d-flex w-100 pb-2 mb-1">
                                    <label for="store-3"
                                        class="form-check-label text-dark-emphasis fw-semibold me-3">Rancho Cordova
                                        Supercenter</label>
                                    <button type="button" class="btn-close fs-sm ms-auto" data-bs-toggle="tooltip"
                                        data-bs-custom-class="tooltip-sm" data-bs-title="Remove"
                                        aria-label="Remove"></button>
                                </div>
                                <div class="fs-xs mb-2">10655 Folsom Blvd, Rancho Cordova, CA 95670</div>
                                <div class="fs-xs">Open: <span class="text-dark-emphasis fw-medium">08:00 - 23:00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add new pickup store collapse -->
                <div class="collapse pickup-options" id="pickupStoreAdd">
                    <div class="nav mb-4">
                        <a class="nav-link animate-underline p-0" href=".pickup-options" data-bs-toggle="collapse"
                            aria-expanded="true" aria-controls="pickupStoreOptions pickupStoreAdd">
                            <i class="ci-chevron-left fs-lg ms-n1 me-1"></i>
                            <span class="animate-target">Back to my stores</span>
                        </a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3 mb-lg-4">
                        <h5 class="h6 mb-0 me-3">Select a suitable store</h5>
                        <a class="btn btn-sm btn-outline-primary rounded-pill" href="#!">
                            <i class="ci-map-pin fs-base ms-n1 me-1"></i>
                            Find on map
                        </a>
                    </div>
                    <div class="mb-3 mb-lg-4">
                        <label class="form-label">State *</label>
                        <select class="form-select form-select-lg rounded-pill"
                            data-select='{
                "classNames": {
                  "containerInner": ["form-select", "form-select-lg", "rounded-pill"]
                }
              }'
                            aria-label="Large pill select">
                            <option value="">Select state</option>
                            <option value="Arizona">Arizona</option>
                            <option value="California" selected>California</option>
                            <option value="Montana">Montana</option>
                            <option value="Nevada">Nevada</option>
                            <option value="New Mexico">New Mexico</option>
                            <option value="Texas">Texas</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">City *</label>
                        <select class="form-select form-select-lg rounded-pill"
                            data-select='{
                "classNames": {
                  "containerInner": ["form-select", "form-select-lg", "rounded-pill"]
                }
              }'
                            aria-label="Large pill select">
                            <option value="">Select city</option>
                            <option value="Austin">Austin</option>
                            <option value="Helena">Helena</option>
                            <option value="Sacramento" selected>Sacramento</option>
                            <option value="Santa Fe">Santa Fe</option>
                            <option value="Las Vegas">Las Vegas</option>
                            <option value="Phoenix">Phoenix</option>
                        </select>
                    </div>
                    <div class="fs-xs fw-medium text-uppercase text-body-secondary">Found stores:</div>
                    <div class="form-check border-bottom py-4 m-0">
                        <input type="radio" class="form-check-input" id="store-4" name="found-store">
                        <div>
                            <label for="store-4"
                                class="form-check-label text-dark-emphasis fw-semibold pb-2 mb-1">Sacramento
                                Supercenter</label>
                            <div class="fs-xs mb-2">8270 Delta Shores Cir S, Sacramento, CA 95832</div>
                            <div class="fs-xs">Open: <span class="text-dark-emphasis fw-medium">07:00 - 22:00</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-check border-bottom py-4 m-0">
                        <input type="radio" class="form-check-input" id="store-5" name="found-store">
                        <div>
                            <label for="store-5" class="form-check-label text-dark-emphasis fw-semibold pb-2 mb-1">West
                                Sacramento Supercenter</label>
                            <div class="fs-xs mb-2">755 Riverpoint Ct, West Sacramento, CA 95605</div>
                            <div class="fs-xs">Open: <span class="text-dark-emphasis fw-medium">07:00 - 21:00</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-check border-bottom py-4 m-0">
                        <input type="radio" class="form-check-input" id="store-6" name="found-store">
                        <div>
                            <label for="store-6" class="form-check-label text-dark-emphasis fw-semibold pb-2 mb-1">Rancho
                                Cordova Supercenter</label>
                            <div class="fs-xs mb-2">10655 Folsom Blvd, Rancho Cordova, CA 95670</div>
                            <div class="fs-xs">Open: <span class="text-dark-emphasis fw-medium">08:00 - 23:00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add address collapse toggle -->
                <div class="nav">
                    <a class="nav-link hiding-collapse-toggle animate-underline collapsed px-0 mt-4"
                        href=".pickup-options" data-bs-toggle="collapse" aria-expanded="false"
                        aria-controls="pickupStoreOptions pickupStoreAdd">
                        <span class="animate-target">Add store address</span>
                        <i class="ci-plus fs-base ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="offcanvas-header">
            <button type="button" class="btn btn-lg btn-primary w-100 rounded-pill">Confirm address</button>
        </div>
    </div>
@endsection


@section('footer_scripts')

@endsection