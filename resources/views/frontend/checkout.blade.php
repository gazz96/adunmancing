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
        <form action="{{ route('web.do-checkout') }}" method="POST">
            @csrf
            
            <section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
                <h1 class="h3 mb-4">Checkout</h1>
                <div class="row">

                    <!-- Checkout form -->
                    <div class="col-lg-8 col-xl-7 mb-5 mb-lg-0">

                        <!-- Delivery address section -->
                        <h2 class="h5 mb-4">Alamat Pengiriman <span class="text-danger">*</span></h2>
                        
                        @if($addresses && $addresses->count() > 0)
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="d-flex align-items-center fs-sm text-dark-emphasis me-3">
                                    <i class="ci-map-pin fs-base text-primary me-2"></i>
                                    <span id="selected-address">{{ $addresses->where('is_default', 1)->first()->checkout_display ?? 'Pilih alamat pengiriman' }}</span>
                                </div>
                                <div class="nav">
                                    <a class="nav-link text-decoration-underline text-nowrap p-0" href="#deliveryOptions"
                                        data-bs-toggle="offcanvas" aria-controls="deliveryOptions">Pilih/Ganti Alamat</a>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning mb-4">
                                <i class="ci-info-circle fs-base me-2"></i>
                                Anda belum memiliki alamat pengiriman. Silakan tambah alamat terlebih dahulu.
                            </div>
                            <div class="mb-4">
                                <a class="btn btn-outline-primary" href="#deliveryOptions" data-bs-toggle="offcanvas" aria-controls="deliveryOptions">
                                    <i class="ci-plus fs-base me-2"></i>Tambah Alamat Pengiriman
                                </a>
                            </div>
                        @endif

                        <!-- Address validation -->
                        <input type="hidden" id="selected_address_id" name="address_id" value="{{ $addresses && $addresses->where('is_default', 1)->first() ? $addresses->where('is_default', 1)->first()->id : '' }}">
                        <!-- Shipping package validation -->
                        <input type="hidden" id="selected_shipping_package" name="shipping_package" value="">
                        <input type="hidden" id="selected_shipping_cost" name="shipping_cost" value="0">
                        
                        <!-- Guest address form (shown when user is not logged in) -->
                        @guest
                        <div class="border rounded-4 p-4 mb-4">
                            <h6 class="mb-3">Atau isi alamat pengiriman:</h6>
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="name">Nama Alamat *</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Rumah, Kantor, dll" required>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="recipient_name">Nama Penerima *</label>
                                    <input type="text" class="form-control" id="recipient_name" name="recipient_name" required>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="phone_number">No. Telepon *</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="postal_code">Kode Pos *</label>
                                    <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="province_name">Provinsi *</label>
                                    <input type="text" class="form-control" id="province_name" name="province_name" required>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label" for="city_name">Kota/Kabupaten *</label>
                                    <input type="text" class="form-control" id="city_name" name="city_name" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label" for="address">Alamat Lengkap *</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW" required></textarea>
                                </div>
                                <input type="hidden" name="destination_type" value="subdistrict">
                            </div>
                        </div>
                        @endguest
                        
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

                        <!-- Payment method section -->
                        <h2 class="h5 mt-5 mb-4">Metode Pembayaran <span class="text-danger">*</span></h2>
                        <div class="border rounded-4 p-4 mb-4">
                            @if($paymentMethods && $paymentMethods->count() > 0)
                                @foreach($paymentMethods as $method)
                                    <div class="form-check mb-3">
                                        <input type="radio" class="form-check-input" id="payment_{{ $method->id }}" 
                                               name="payment_method_id" value="{{ $method->id }}" required>
                                        <label class="form-check-label w-100" for="payment_{{ $method->id }}">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    @if($method->logo_url)
                                                        <img src="{{ $method->logo_url }}" alt="{{ $method->name }}" 
                                                             class="me-3" style="height: 30px;">
                                                    @endif
                                                    <div>
                                                        <div class="fw-semibold">{{ $method->name }}</div>
                                                        @if($method->type === 'bank_transfer')
                                                            <small class="text-muted">
                                                                {{ $method->account_number }} - {{ $method->account_name }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @if($method->instructions)
                                                <small class="text-muted d-block mt-1">{{ $method->instructions }}</small>
                                            @endif
                                        </label>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-warning">
                                    <i class="ci-info-circle me-2"></i>
                                    Tidak ada metode pembayaran yang tersedia saat ini.
                                </div>
                            @endif
                        </div>

                    </div>


                    <!-- Order summary (sticky sidebar) -->
                    <aside class="col-lg-4 offset-xl-1" style="margin-top: -115px">
                        <div class="position-sticky top-0" style="padding-top: 115px">
                            <div class="d-flex align-items-center justify-content-between border-bottom pb-4 mb-4">
                                <h2 class="h5 mb-0 me-3">Order summary</h2>
                                {{-- <div class="nav">
                                    <a class="nav-link text-decoration-underline p-0" href="checkout-v2-cart.html">Edit</a>
                                </div> --}}
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
                                <button type="submit" class="btn btn-lg btn-primary w-100 rounded-pill" id="checkout-btn">
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
                {{-- <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link active" id="delivery-tab" data-bs-toggle="tab"
                        data-bs-target="#delivery-tab-pane" role="tab" aria-controls="delivery-tab-pane"
                        aria-selected="true">
                        <i class="ci-shopping-bag fs-base ms-n1 me-2"></i>
                        Pengiriman
                    </button>
                </li> --}}
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
                            <input type="radio" class="form-check-input" id="address-{{$address->id}}" name="delivery-address" value="{{$address->id}}"
                                @if($address->is_default) checked @endif>
                            
                            <label for="address-{{$address->id}}" class="form-check-label text-dark-emphasis fw-semibold">{{ $address->shipping_label }}</label>
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
                        <h5 class="h6 mb-0 me-3">Tambah Alamat Baru</h5>
                    </div>
                    
                    <form id="addAddressForm">
                        @csrf
                        <div class="mb-3">
                            <label for="address_name" class="form-label">Nama Alamat *</label>
                            <input type="text" class="form-control form-control-lg rounded-pill" id="address_name" name="name" placeholder="Rumah, Kantor, dll" required>
                        </div>
                        <div class="mb-3">
                            <label for="address_recipient_name" class="form-label">Nama Penerima *</label>
                            <input type="text" class="form-control form-control-lg rounded-pill" id="address_recipient_name" name="recipient_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="address_phone_number" class="form-label">No. Telepon *</label>
                            <input type="text" class="form-control form-control-lg rounded-pill" id="address_phone_number" name="phone_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="address_province_id" class="form-label">Provinsi *</label>
                            <select class="form-select form-select-lg rounded-pill" id="address_province_id" name="province_id" required>
                                <option value="">Pilih Provinsi</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province['id'] }}">{{ $province['name'] }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" id="address_province_name" name="province_name">
                        </div>
                        <div class="mb-3">
                            <label for="address_city_id" class="form-label">Kota/Kabupaten *</label>
                            <select class="form-select form-select-lg rounded-pill" id="address_city_id" name="city_id" required disabled>
                                <option value="">Pilih Kota/Kabupaten</option>
                            </select>
                            <input type="hidden" id="address_city_name" name="city_name">
                        </div>
                        <div class="mb-3">
                            <label for="address_postal_code" class="form-label">Kode Pos *</label>
                            <input type="text" class="form-control form-control-lg rounded-pill" id="address_postal_code" name="postal_code" required>
                        </div>
                        <div class="mb-4">
                            <label for="address_full" class="form-label">Alamat Lengkap *</label>
                            <textarea class="form-control form-control-lg rounded-4" id="address_full" name="address" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW" required></textarea>
                        </div>
                        <input type="hidden" name="destination_type" value="subdistrict">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="set_as_default" name="is_default" value="1">
                            <label class="form-check-label" for="set_as_default">
                                Jadikan sebagai alamat utama
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill" id="saveAddressBtn">
                            <span class="btn-text">Simpan Alamat</span>
                            <span class="btn-loading d-none">
                                <span class="spinner-border spinner-border-sm me-2"></span>
                                Menyimpan...
                            </span>
                        </button>
                    </form>
                </div>

                <!-- Shipping Package Selection -->
                <div class="mt-4" id="shippingPackageSection" style="display: none;">
                    <h6 class="mb-3">Pilih Paket Pengiriman</h6>
                    <div id="shippingPackageOptions">
                        <!-- Package options will be loaded here dynamically -->
                        <div class="d-flex justify-content-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading shipping options...</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add address collapse toggle -->
                <div class="nav">
                    <a class="nav-link hiding-collapse-toggle animate-underline collapsed px-0"
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
            <button type="button" class="btn btn-lg btn-primary w-100 rounded-pill" id="confirmAddressBtn">Jadikan alamat utama</button>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const checkoutForm = document.querySelector('form');
    const checkoutBtn = document.getElementById('checkout-btn');
    
    // Address validation for authenticated users
    @auth
    function validateAddress() {
        const selectedAddressId = document.getElementById('selected_address_id').value;
        if (!selectedAddressId) {
            Swal.fire({
                icon: 'warning',
                title: 'Alamat Belum Dipilih',
                text: 'Silakan pilih alamat pengiriman terlebih dahulu.',
                confirmButtonText: 'OK'
            });
            return false;
        }
        return true;
    }
    
    // Shipping package validation
    function validateShippingPackage() {
        const selectedPackage = document.getElementById('selected_shipping_package').value;
        if (!selectedPackage) {
            Swal.fire({
                icon: 'warning',
                title: 'Paket Pengiriman Belum Dipilih',
                text: 'Silakan pilih paket pengiriman terlebih dahulu.',
                confirmButtonText: 'OK'
            });
            return false;
        }
        return true;
    }
    @endauth
    
    // Address validation for guest users
    @guest
    function validateGuestAddress() {
        const name = document.getElementById('name').value.trim();
        const recipientName = document.getElementById('recipient_name').value.trim();
        const phoneNumber = document.getElementById('phone_number').value.trim();
        const address = document.getElementById('address').value.trim();
        const cityName = document.getElementById('city_name').value.trim();
        const provinceName = document.getElementById('province_name').value.trim();
        const postalCode = document.getElementById('postal_code').value.trim();
        
        if (!name || !recipientName || !phoneNumber || !address || !cityName || !provinceName || !postalCode) {
            Swal.fire({
                icon: 'warning',
                title: 'Data Alamat Belum Lengkap',
                text: 'Mohon lengkapi semua data alamat pengiriman yang wajib diisi.',
                confirmButtonText: 'OK'
            });
            return false;
        }
        return true;
    }
    @endguest
    
    // Courier validation
    function validateCourier() {
        const courier = document.getElementById('iCourier').value;
        const courierPackage = document.getElementById('iCourierPackage').value;
        
        if (!courier) {
            Swal.fire({
                icon: 'warning',
                title: 'Kurir Belum Dipilih',
                text: 'Silakan pilih kurir pengiriman terlebih dahulu.',
                confirmButtonText: 'OK'
            });
            return false;
        }
        
        if (!courierPackage) {
            Swal.fire({
                icon: 'warning',
                title: 'Paket Kurir Belum Dipilih',
                text: 'Silakan pilih paket pengiriman terlebih dahulu.',
                confirmButtonText: 'OK'
            });
            return false;
        }
        
        return true;
    }
    
    // Form submission validation
    checkoutForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let isValid = true;
        
        // Validate address
        @auth
        isValid = validateAddress();
        @endauth
        
        @guest
        isValid = validateGuestAddress();
        @endguest
        
        // Validate shipping package
        @auth
        if (isValid) {
            isValid = validateShippingPackage();
        }
        @endauth
        
        // Validate courier
        if (isValid) {
            isValid = validateCourier();
        }
        
        if (isValid) {
            // Show loading state
            checkoutBtn.disabled = true;
            checkoutBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
            
            // Submit form
            this.submit();
        }
    });
    
    // jQuery handler untuk perubahan alamat yang dipilih
    $(document).on('change', 'input[name="delivery-address"]', function() {
        var addressId = $(this).val(); // Gunakan value karena sudah berisi ID
        var addressLabel = $(`label[for="${$(this).attr('id')}"]`).text();
        
        console.log('jQuery: Address selection changed to:', addressId, addressLabel);
        
        // Update hidden field
        $('#selected_address_id').val(addressId);
        
        // Update displayed address text di dalam offcanvas
        $('#selected-address').text(addressLabel);
        
        // Juga update tampilan di checkout utama dengan format yang sama
        var formattedAddress = addressLabel; // Label sudah berformat "Nama | Alamat"
        $('#selected-address').text(formattedAddress);
        
        console.log('jQuery: Updated selected address ID:', addressId);
        console.log('jQuery: Updated main address display to:', formattedAddress);
        
        // Tambahkan efek highlight untuk menunjukkan alamat berubah
        $('#selected-address').parent().addClass('border-primary bg-light').removeClass('text-dark-emphasis').addClass('text-primary');
        
        setTimeout(function() {
            $('#selected-address').parent().removeClass('border-primary bg-light text-primary').addClass('text-dark-emphasis');
        }, 2000);
    });
    
    
    
    // jQuery event handler untuk perubahan provinsi
    $(document).on('change', '#address_province_id', function() {
        console.log('jQuery: Province changed');
        var provinceId = $(this).val();
        var provinceName = $(this).find('option:selected').text();
        var $citySelect = $('#address_city_id');
        
        console.log('jQuery: Province changed to:', provinceId, provinceName);
        
        // Simpan nama provinsi ke hidden field
        $('#address_province_name').val(provinceName);
        
        // Reset dropdown kota
        $citySelect.empty().append('<option value="">Pilih Kota/Kabupaten</option>').prop('disabled', true);
        $('#address_city_name').val('');
        
        if (provinceId && provinceId !== '') {
            console.log('jQuery: Hit route untuk mendapatkan data kota, province_id:', provinceId);
            
            // Tampilkan loading state
            $citySelect.append('<option value="">Loading kota...</option>');
            
            // Hit route web.shipping.regencies menggunakan jQuery AJAX
            $.ajax({
                url: '{{ route("web.shipping.regencies") }}',
                type: 'GET',
                data: {
                    province_id: provinceId
                },
                dataType: 'json',
                timeout: 15000,
                beforeSend: function() {
                    console.log('jQuery: Sending AJAX request to get cities...');
                },
                success: function(response) {
                    console.log('jQuery: ✓ Response dari route regencies:', response);
                    
                    // Hapus loading option
                    $citySelect.empty().append('<option value="">Pilih Kota/Kabupaten</option>');
                    
                    // Response sudah berupa array kota langsung
                    if ($.isArray(response) && response.length > 0) {
                        console.log('jQuery: Memproses', response.length, 'kota...');
                        
                        $.each(response, function(index, city) {
                            var cityId = city.id || city.city_id;
                            var cityName = city.name || city.city_name;
                            var cityType = city.type || '';
                            var displayName = cityType ? cityType + ' ' + cityName : cityName;
                            
                            $citySelect.append('<option value="' + cityId + '">' + displayName + '</option>');
                        });
                        
                        // Enable dropdown kota
                        $citySelect.prop('disabled', false);
                        console.log('jQuery: ✓ Berhasil memuat', response.length, 'kota untuk provinsi', provinceName);
                        
                    } else {
                        console.log('jQuery: ✗ Tidak ada data kota dalam response');
                        $citySelect.append('<option value="">Tidak ada data kota</option>');
                        
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Tidak Ada Data',
                                text: 'Tidak ada kota yang ditemukan untuk provinsi ' + provinceName
                            });
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.log('jQuery: ✗ Error saat hit route regencies:');
                    console.log('- Status:', status);
                    console.log('- Error:', error);
                    console.log('- Response Text:', xhr.responseText);
                    console.log('- Status Code:', xhr.status);
                    
                    // Hapus loading dan tampilkan error
                    $citySelect.empty().append('<option value="">Error memuat kota</option>');
                    
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Gagal memuat data kota: ' + error
                        });
                    }
                },
                complete: function() {
                    console.log('jQuery: AJAX request selesai');
                }
            });
            
        } else {
            console.log('jQuery: Tidak ada provinsi dipilih, dropdown kota tetap disabled');
        }
    });
    
    // jQuery event handler untuk perubahan kota
    $(document).on('change', '#address_city_id', function() {
        var cityId = $(this).val();
        var cityName = $(this).find('option:selected').text();
        
        console.log('jQuery: City changed to:', cityId, cityName);
        
        // Simpan nama kota ke hidden field
        $('#address_city_name').val(cityName);
    });
    
    // jQuery event handler untuk tombol "Jadikan alamat utama"
    $(document).on('click', '#confirmAddressBtn', function() {
        var selectedAddressId = $('#selected_address_id').val();
        var selectedAddressRadio = $('input[name="delivery-address"]:checked');
        
        console.log('jQuery: Confirm address button clicked, selected ID:', selectedAddressId);
        
        if (!selectedAddressId) {
            Swal.fire({
                icon: 'warning',
                title: 'Alamat Belum Dipilih',
                text: 'Silakan pilih alamat terlebih dahulu.'
            });
            return;
        }
        
        var button = $(this);
        var originalText = button.text();
        
        // Show loading state
        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Memproses...');
        
        // AJAX request untuk set alamat sebagai utama
        $.ajax({
            url: '/addresses/set-default',
            type: 'POST',
            data: {
                address_id: selectedAddressId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(response) {
                console.log('jQuery: ✓ Address set as default:', response);
                
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Alamat berhasil dijadikan alamat utama.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    
                    // Update UI - set alamat yang baru jadi utama sebagai checked
                    // Tidak perlu menghapus checked dari yang lain, biarkan user bisa pilih ulang
                    $(`#address-${selectedAddressId}`).prop('checked', true);
                    
                    // Update tampilan alamat terpilih di dalam offcanvas
                    var selectedLabel = $(`label[for="address-${selectedAddressId}"]`).text();
                    $('#selected-address').text(selectedLabel);
                    
                    // Update tampilan alamat utama di halaman checkout utama
                    updateMainAddressDisplay(response.address);
                    
                    // Close offcanvas
                    setTimeout(function() {
                        $('#deliveryOptions').offcanvas('hide');
                    }, 1500);
                    
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message || 'Gagal mengubah alamat utama.'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log('jQuery: ✗ Error setting default address:', error);
                console.log('Response:', xhr.responseText);
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan: ' + error
                });
            },
            complete: function() {
                // Reset button state
                button.prop('disabled', false).text(originalText);
            }
        });
    });
    
    // Bootstrap collapse event handlers untuk mengelola visibility tombol
    $('.delivery-address').on('show.bs.collapse', function(e) {
        var targetId = $(e.target).attr('id');
        console.log('jQuery: Collapse showing:', targetId);
        
        if (targetId === 'deliveryAddressAdd') {
            console.log('jQuery: Form tambah alamat akan terbuka, sembunyikan tombol');
            $('#confirmAddressBtn').hide();
        } else if (targetId === 'deliveryAddressOptions') {
            console.log('jQuery: List alamat akan terbuka, tampilkan tombol');
            $('#confirmAddressBtn').show();
        }
    });
    
    $('.delivery-address').on('shown.bs.collapse', function(e) {
        var targetId = $(e.target).attr('id');
        console.log('jQuery: Collapse shown:', targetId);
        
        if (targetId === 'deliveryAddressAdd') {
            $('#confirmAddressBtn').hide();
        } else if (targetId === 'deliveryAddressOptions') {
            $('#confirmAddressBtn').show();
        }
    });
    
    $('.delivery-address').on('hide.bs.collapse', function(e) {
        var targetId = $(e.target).attr('id');
        console.log('jQuery: Collapse hiding:', targetId);
    });
    
    $('.delivery-address').on('hidden.bs.collapse', function(e) {
        var targetId = $(e.target).attr('id');
        console.log('jQuery: Collapse hidden:', targetId);
        
        if (targetId === 'deliveryAddressAdd') {
            console.log('jQuery: Form tambah alamat tertutup, tampilkan tombol');
            $('#confirmAddressBtn').show();
        }
    });
    
    // jQuery handler untuk offcanvas saat dibuka
    $('#deliveryOptions').on('shown.bs.offcanvas', function () {
        console.log('jQuery: Offcanvas delivery options terbuka');
        
        // Pastikan tombol confirm dalam keadaan yang benar
        setTimeout(function() {
            if ($('#deliveryAddressAdd').hasClass('show')) {
                $('#confirmAddressBtn').hide();
                console.log('jQuery: Form tambah alamat aktif, sembunyikan tombol confirm');
            } else {
                $('#confirmAddressBtn').show();
                console.log('jQuery: Default/list alamat aktif, tampilkan tombol confirm');
            }
        }, 300);
    });
    
    // jQuery handler untuk offcanvas saat ditutup - reset state
    $('#deliveryOptions').on('hidden.bs.offcanvas', function () {
        console.log('jQuery: Offcanvas delivery options tertutup');
        // Reset tombol ke state default
        $('#confirmAddressBtn').show();
    });
    
    // Address management functions
    $('#addAddressForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validate province and city selection
        const provinceId = $('#address_province_id').val();
        const cityId = $('#address_city_id').val();
        
        if (!provinceId) {
            Swal.fire({
                icon: 'warning',
                title: 'Provinsi Belum Dipilih',
                text: 'Silakan pilih provinsi terlebih dahulu.'
            });
            return;
        }
        
        if (!cityId) {
            Swal.fire({
                icon: 'warning',
                title: 'Kota/Kabupaten Belum Dipilih',
                text: 'Silakan pilih kota/kabupaten terlebih dahulu.'
            });
            return;
        }
        
        const form = $(this);
        const submitBtn = $('#saveAddressBtn');
        const btnText = submitBtn.find('.btn-text');
        const btnLoading = submitBtn.find('.btn-loading');
        
        // Show loading state
        btnText.addClass('d-none');
        btnLoading.removeClass('d-none');
        submitBtn.prop('disabled', true);
        
        // Prepare form data
        const formData = new FormData(this);
        
        $.ajax({
            url: '{{ route("user.addresses.store") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Alamat berhasil disimpan.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    
                    // Add new address to the list
                    addAddressToList(response.address);
                    
                    // Reset form
                    form[0].reset();
                    
                    // Go back to address list
                    $('.delivery-address').collapse('toggle');
                    
                    // Tampilkan kembali tombol confirm setelah sukses simpan
                    setTimeout(function() {
                        $('#confirmAddressBtn').show();
                        console.log('jQuery: Alamat berhasil disimpan, tampilkan tombol confirm');
                    }, 500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message || 'Terjadi kesalahan saat menyimpan alamat.'
                    });
                }
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan saat menyimpan alamat.';
                
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    errorMessage = Object.values(errors).flat().join('\n');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMessage
                });
            },
            complete: function() {
                // Reset loading state
                btnText.removeClass('d-none');
                btnLoading.addClass('d-none');
                submitBtn.prop('disabled', false);
            }
        });
    });
    
    function addAddressToList(address) {
        const addressListContainer = $('#deliveryAddressOptions .mt-n3');
        const isChecked = address.is_default ? 'checked' : '';
        
        const addressHtml = `
            <div class="form-check border-bottom py-4 m-0">
                <input type="radio" class="form-check-input" id="address-${address.id}" 
                       name="delivery-address[${address.id}]" ${isChecked}>
                <label for="address-${address.id}" class="form-check-label text-dark-emphasis fw-semibold">
                    ${address.name} | ${address.address}, ${address.city_name}, ${address.province_name} ${address.postal_code}
                </label>
            </div>
        `;
        
        addressListContainer.append(addressHtml);
        
        // Update selected address if it's default
        if (address.is_default) {
            updateMainAddressDisplay(address);
        }
    }
    
    // Fungsi untuk update tampilan alamat utama di checkout
    function updateMainAddressDisplay(address) {
        console.log('jQuery: Updating main address display:', address);
        
        // Gunakan custom attribute dari model jika tersedia
        var addressText = '';
        
        if (address.checkout_display) {
            // Gunakan format checkout_display dari model
            addressText = address.checkout_display.replace(/\n/g, ', ');
        } else if (address.shipping_label) {
            // Fallback ke shipping_label
            addressText = address.shipping_label;
        } else {
            // Fallback ke format manual
            addressText = `${address.name || ''} | ${address.address || ''}`;
            if (address.city_name) {
                addressText += `, ${address.city_name}`;
            }
            if (address.province_name) {
                addressText += `, ${address.province_name}`;
            }
            if (address.postal_code) {
                addressText += ` ${address.postal_code}`;
            }
        }
        
        // Update alamat yang ditampilkan di checkout utama
        $('#selected-address').text(addressText);
        
        // Juga update hidden field untuk memastikan consistency
        $('#selected_address_id').val(address.id);
        
        console.log('jQuery: ✓ Main address display updated to:', addressText);
        
        // Tambahkan efek highlight untuk menunjukkan perubahan
        $('#selected-address').parent().addClass('border-success bg-light').removeClass('text-dark-emphasis').addClass('text-success');
        
        // Hapus highlight setelah 3 detik
        setTimeout(function() {
            $('#selected-address').parent().removeClass('border-success bg-light text-success').addClass('text-dark-emphasis');
        }, 3000);
    }
    
    // Shipping Package Functions
    function loadShippingPackages(courier = null) {
        console.log('Loading shipping packages for courier:', courier);
        
        // Show shipping package section
        $('#shippingPackageSection').show();
        
        // Show loading spinner
        $('#shippingPackageOptions').html(`
            <div class="d-flex justify-content-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading shipping options...</span>
                </div>
            </div>
        `);
        
        $.ajax({
            url: '{{ route("web.shipping.cost") }}',
            type: 'POST',
            data: {
                courier: courier || 'jne',
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(response) {
                console.log('Shipping packages response:', response);
                
                if (response.success && response.data && response.data.data) {
                    displayShippingPackages(response.data.data);
                } else {
                    showShippingError('Tidak ada paket pengiriman yang tersedia');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading shipping packages:', error);
                showShippingError('Gagal memuat paket pengiriman');
            }
        });
    }
    
    function displayShippingPackages(packages) {
        let html = '';
        
        if (!packages || packages.length === 0) {
            html = '<div class="text-center py-4 text-muted">Tidak ada paket pengiriman tersedia</div>';
        } else {
            packages.forEach((pkg, index) => {
                const isChecked = index === 0 ? 'checked' : ''; // Auto select first package
                const cost = parseInt(pkg.cost);
                const formattedCost = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(cost);
                
                html += `
                    <div class="form-check border-bottom py-3 m-0">
                        <input type="radio" class="form-check-input shipping-package-radio" 
                               id="package-${index}" 
                               name="shipping-package" 
                               value="${pkg.code}-${pkg.service}"
                               data-courier="${pkg.code}"
                               data-service="${pkg.service}" 
                               data-cost="${cost}"
                               data-etd="${pkg.etd}"
                               ${isChecked}>
                        <div class="w-100">
                            <label for="package-${index}" class="form-check-label text-dark-emphasis fw-semibold d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-bold">${pkg.name} - ${pkg.service}</div>
                                    <div class="text-muted small">${pkg.description}</div>
                                    <div class="text-success small">Estimasi: ${pkg.etd}</div>
                                </div>
                                <div class="text-primary fw-bold">${formattedCost}</div>
                            </label>
                        </div>
                    </div>
                `;
            });
            
            // Auto-select first package if available
            if (packages.length > 0) {
                const firstPackage = packages[0];
                updateSelectedShippingPackage(
                    `${firstPackage.code}-${firstPackage.service}`,
                    firstPackage.cost
                );
            }
        }
        
        $('#shippingPackageOptions').html(html);
        
        // Add event listener for package selection
        $('.shipping-package-radio').on('change', function() {
            const packageValue = $(this).val();
            const cost = $(this).data('cost');
            updateSelectedShippingPackage(packageValue, cost);
        });
    }
    
    function updateSelectedShippingPackage(packageValue, cost) {
        $('#selected_shipping_package').val(packageValue);
        $('#selected_shipping_cost').val(cost);
        
        console.log('Selected shipping package:', packageValue, 'Cost:', cost);
        
        // Update checkout summary if needed
        updateShippingSummary(cost);
    }
    
    function updateShippingSummary(shippingCost) {
        // Find and update shipping cost in checkout summary
        const shippingElement = $('.checkout-summary .shipping-cost');
        if (shippingElement.length) {
            const formattedCost = new Intl.NumberFormat('id-ID', {
                style: 'currency', 
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(shippingCost);
            shippingElement.text(formattedCost);
        }
        
        // Recalculate total if needed
        calculateCheckoutTotal();
    }
    
    function calculateCheckoutTotal() {
        // This function should calculate the total including shipping
        // Implementation depends on your checkout summary structure
        console.log('Calculating checkout total with shipping cost');
    }
    
    function showShippingError(message) {
        $('#shippingPackageOptions').html(`
            <div class="text-center py-4 text-danger">
                <i class="ci-warning fs-2 mb-2"></i>
                <div>${message}</div>
            </div>
        `);
    }
    
    // Event handler for address change - reload shipping packages
    $(document).on('change', 'input[name="delivery-address"]', function() {
        const addressId = $(this).val();
        console.log('Address changed, loading shipping packages for address:', addressId);
        
        // Update selected address ID
        $('#selected_address_id').val(addressId);
        
        // Load shipping packages for the selected address
        loadShippingPackages();
    });
    
    // Load shipping packages when page loads if address is already selected
    $(document).ready(function() {
        const selectedAddressId = $('#selected_address_id').val();
        if (selectedAddressId) {
            console.log('Auto-loading shipping packages for default address:', selectedAddressId);
            loadShippingPackages();
        }
    });

  
});
</script>
@endsection


