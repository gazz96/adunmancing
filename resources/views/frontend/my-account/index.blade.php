@extends('frontend.layouts.default')

@section('content')

<!-- Page content -->
<main class="content-wrapper">
    <div class="container py-5 mt-n2 mt-sm-0">
        <div class="row pt-md-2 pt-lg-3 pb-sm-2 pb-md-3 pb-lg-4 pb-xl-5">

            <!-- Sidebar navigation that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
            <aside class="col-lg-3">
                @include('frontend.my-account.navigation')
            </aside>


            <!-- Orders content -->
            <div class="col-lg-9">
                <div class="ps-lg-3 ps-xl-0">

                    <!-- Page title + Sorting selects -->
                    <div class="row align-items-center pb-3 pb-md-4 mb-md-1 mb-lg-2">
                        <div class="col-md-4 col-xl-6 mb-3 mb-md-0">
                            <h1 class="h2 me-3 mb-0">Orders</h1>
                        </div>
                        <div class="col-md-8 col-xl-6">
                            <form action="">
                                <div class="row row-cols-1 row-cols-sm-2 g-3 g-xxl-4 d-flex justify-content-end">
                                    <div class="col">
                                        <select name="status" class="form-select"
                                            data-select='{
                                                "placeholderValue": "Select status",
                                                "choices": [
                                                {
                                                    "value": "",
                                                    "label": "Select status",
                                                    "placeholder": true
                                                },
                                                {
                                                    "value": "pending",
                                                    "label": "<div class=\"d-flex align-items-center text-nowrap\"><span class=\"bg-info rounded-circle p-1 me-2\"></span>Pending</div>"
                                                },
                                                {
                                                    "value": "delivered",
                                                    "label": "<div class=\"d-flex align-items-center text-nowrap\"><span class=\"bg-success rounded-circle p-1 me-2\"></span>Delivered</div>"
                                                },
                                                {
                                                    "value": "canceled",
                                                    "label": "<div class=\"d-flex align-items-center text-nowrap\"><span class=\"bg-danger rounded-circle p-1 me-2\"></span>Canceled</div>"
                                                },
                                                {
                                                    "value": "delayed",
                                                    "label": "<div class=\"d-flex align-items-center text-nowrap\"><span class=\"bg-warning rounded-circle p-1 me-2\"></span>Delayed</div>"
                                                }
                                                ]
                                            }'
                                            data-select-template="true" aria-label="Status sorting" onchange="this.form.submit()"></select>
                                    </div>
                                    {{-- <div class="col">
                                        <select class="form-select" data-select='{"removeItemButton": false}'
                                            aria-label="Timeframe sorting">
                                            <option value="all-time">For all time</option>
                                            <option value="last-year">For last year</option>
                                            <option value="last-3-months">For last 3 months</option>
                                            <option value="last-30-days">For last 30 days</option>
                                            <option value="last-week">For last week</option>
                                        </select>
                                    </div> --}}
                                </div>
                            </form>
                        </div>
                    </div>


                    <!-- Sortable orders table -->
                    <div
                        data-filter-list='{"listClass": "orders-list", "sortClass": "orders-sort", "valueNames": ["date", "total"]}'>
                        <table class="table align-middle fs-sm text-nowrap">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3 ps-0">
                                        <span class="text-body fw-normal">Order <span
                                                class="d-none d-md-inline">#</span></span>
                                    </th>
                                    <th scope="col" class="py-3 d-none d-md-table-cell">
                                        <button type="button" class="btn orders-sort fw-normal text-body p-0"
                                            {{-- data-sort="date" --}}
                                            >Order date</button>
                                    </th>
                                    <th scope="col" class="py-3 d-none d-md-table-cell">
                                        <span class="text-body fw-normal">Status</span>
                                    </th>
                                    <th scope="col" class="py-3 d-none d-md-table-cell">
                                        <button type="button" class="btn orders-sort fw-normal text-body p-0"
                                            {{-- data-sort="total" --}}
                                            >Total</button>
                                    </th>
                                    <th scope="col" class="py-3">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody class="text-body-emphasis orders-list">
                                @foreach($orders as $order)
                                <!-- Item -->
                                <tr>
                                    <td class="fw-medium pt-2 pb-3 py-md-2 ps-0">
                                        <a class="d-inline-block animate-underline text-body-emphasis text-decoration-none py-2"
                                            href="#orderDetails" data-bs-toggle="offcanvas" aria-controls="orderDetails"
                                            aria-label="Show order details">
                                            <span class="animate-target">{{$order->order_number}}</span>
                                        </a>
                                        <ul class="list-unstyled fw-normal text-body m-0 d-md-none">
                                            <li>{{date('d F Y', strtotime($order->created_at)) }}</li>
                                            <li class="d-flex align-items-center">
                                                <span class="bg-info rounded-circle p-1 me-2"></span>
                                                {{ $order->status }}
                                            </li>
                                            @if($order->hasCoupon())
                                                <li class="text-success">Coupon: {{ $order->coupon_code }} (-{{ $order->getCouponDiscountFormatted() }})</li>
                                            @endif
                                            <li class="fw-medium text-body-emphasis">{{ number_format($order->total)}}</li>
                                        </ul>
                                    </td>
                                    <td class="fw-medium py-3 d-none d-md-table-cell">
                                        {{date('d F Y', strtotime($order->created_at)) }}
                                        <span class="date d-none">{{date('Y-m-d', strtotime($order->created_at)) }}</span>
                                    </td>
                                    <td class="fw-medium py-3 d-none d-md-table-cell">
                                        <span class="d-flex align-items-center">
                                            <span class="bg-info rounded-circle p-1 me-2"></span>
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="fw-medium py-3 d-none d-md-table-cell">
                                        @if($order->hasCoupon())
                                            <div class="text-success small mb-1">{{ $order->coupon_code }} (-{{ $order->getCouponDiscountFormatted() }})</div>
                                        @endif
                                        {{ number_format($order->total)}}
                                        <span class="total d-none">{{ number_format($order->total)}}</span>
                                    </td>
                                    <td class="py-3 pe-0">
                                        <span
                                            class="d-flex align-items-center justify-content-end position-relative gap-1 gap-sm-2 ms-n2 ms-sm-0">
                                            {{-- <span><img src="assets/img/shop/electronics/thumbs/20.png" width="64"
                                                    alt="Thumbnail"></span>
                                            <span><img src="assets/img/shop/electronics/thumbs/16.png" width="64"
                                                    alt="Thumbnail"></span>
                                            <span><img src="assets/img/shop/electronics/thumbs/15.png" width="64"
                                                    alt="Thumbnail"></span> --}}
                                            <a class="btn btn-icon btn-ghost btn-secondary stretched-link border-0"
                                                href="#orderDetails-{{$order->id}}" data-bs-toggle="offcanvas"
                                                aria-controls="orderDetails" aria-label="Show order details">
                                                <i class="ci-chevron-right fs-lg"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <!-- Pagination -->
                    {{-- <nav class="pt-3 pb-2 pb-sm-0 mt-2 mt-md-3" aria-label="Page navigation example">
                        <ul class="pagination">
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
                        </ul>
                    </nav> --}}
                </div>
            </div>
        </div>
    </div>
</main>


@endsection


@section('footer_scripts')

    @foreach($orders as $order)
    <!-- Order details offcanvas -->
    <div class="offcanvas offcanvas-end pb-sm-2 px-sm-2" id="orderDetails-{{$order->id}}" tabindex="-1" aria-labelledby="orderDetailsLabel" style="width: 500px">

      <!-- Header -->
      <div class="offcanvas-header align-items-start py-3 pt-lg-4">
        <div>
          <h4 class="offcanvas-title mb-1" id="orderDetailsLabel">Order # {{$order->order_number}}</h4>
          <span class="d-flex align-items-center fs-sm fw-medium text-body-emphasis">
            <span class="bg-info rounded-circle p-1 me-2"></span>
            {{ $order->status }}
          </span>
        </div>
        <button type="button" class="btn-close mt-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="offcanvas-body d-flex flex-column gap-4 pt-2 pb-3">

        <!-- Items -->
        <div class="d-flex flex-column gap-3">
        
          @foreach($order->items as $item)
            @if($item->product)
            <!-- Item -->
            <div class="d-flex align-items-center">
                <a class="flex-shrink-0" href="{{$item->product->permalink}}">
                <img src="{{$item->product->featured_image_url}}" width="110" alt="{{$item->product->name}}">
                </a>
                <div class="w-100 min-w-0 ps-2 ps-sm-3">
                <h5 class="d-flex animate-underline mb-2">
                    <a class="d-block fs-sm fw-medium text-truncate animate-target" href="shop-product-general-electronics.html">{{$item->product->name}}</a>
                </h5>
                <div class="h6 mb-2">{{ number_format($item->price) }}</div>
                <div class="fs-xs">Qty: {{$item->quantity}}</div>
                </div>
            </div>
            @endif
          @endforeach

        </div>


        <!-- Delivery + Payment info -->
        <div class="border-top pt-4">
          <h6>Delivery</h6>
          <ul class="list-unstyled fs-sm mb-4">
            <li class="d-flex justify-content-between mb-1">
              Estimated delivery:
              <span class="text-body-emphasis fw-medium text-end ms-2">{{ $order->courier_package_data[3] ?? ''}} days</span>
            </li>
            <li class="d-flex justify-content-between mb-1">
              Shipping method:
              <span class="text-body-emphasis fw-medium text-end ms-2">{{ strtoupper($order->courier) }}</span>
            </li>
            <li class="d-flex justify-content-between">
              Shipping address:
              <span class="text-body-emphasis fw-medium text-end ms-2">{{$order->address}}, {{$order->postal_code}}</span>
            </li>
          </ul>
          <h6>Payment</h6>
          <ul class="list-unstyled fs-sm mb-4">
            <li class="d-flex justify-content-between mb-1">
              Payment Method:
              <span class="text-body-emphasis fw-medium text-end ms-2">
                @if($order->paymentMethod)
                  {{ $order->paymentMethod->name }}
                @else
                  {{ $order->payment_method ?? 'Not specified' }}
                @endif
              </span>
            </li>
            <li class="d-flex justify-content-between mb-1">
              Payment Status:
              <span class="text-end ms-2">
                @if($order->payment_status === 'pending')
                  <span class="badge bg-warning text-dark">Pending</span>
                @elseif($order->payment_status === 'verification')
                  <span class="badge bg-info">Under Verification</span>
                @elseif($order->payment_status === 'paid')
                  <span class="badge bg-success">Paid</span>
                @elseif($order->payment_status === 'failed')
                  <span class="badge bg-danger">Failed</span>
                @else
                  <span class="badge bg-secondary">Unknown</span>
                @endif
              </span>
            </li>
            @if($order->payment_method === 'bank_transfer' && $order->payment_proof_url)
            <li class="mb-1">
              <span class="d-block mb-2 fw-medium">Payment Proof:</span>
              <div class="d-flex align-items-start">
                <img src="{{ $order->payment_proof_url }}" alt="Payment Proof" 
                     class="img-thumbnail me-2" style="max-width: 150px; max-height: 150px; cursor: pointer;"
                     onclick="showPaymentProofModal('{{ $order->payment_proof_url }}', '{{ $order->order_number }}')">
                <div class="flex-grow-1">
                  <small class="text-muted d-block">Click image to view full size</small>
                  @if($order->payment_notes)
                    <small class="text-muted d-block mt-1">
                      <strong>Notes:</strong> {{ $order->payment_notes }}
                    </small>
                  @endif
                  @if($order->paid_at)
                    <small class="text-success d-block mt-1">
                      <i class="ci-check-circle me-1"></i>Verified on {{ $order->paid_at->format('d M Y H:i') }}
                    </small>
                  @endif
                </div>
              </div>
            </li>
            @elseif($order->payment_method === 'bank_transfer' && $order->payment_status === 'pending')
            <li class="mb-1">
              <div class="alert alert-warning py-2 px-3 mb-2">
                <small>
                  <i class="ci-info-circle me-1"></i>
                  Payment proof is required. Please upload your payment proof to complete this order.
                </small>
              </div>
              @if($order->paymentMethod)
              <div class="bg-light rounded p-2 mb-2">
                <small class="d-block mb-1"><strong>Bank Transfer Details:</strong></small>
                <small class="d-block">Bank: {{ $order->paymentMethod->name }}</small>
                <small class="d-block">Account: {{ $order->paymentMethod->account_number }}</small>
                <small class="d-block">Name: {{ $order->paymentMethod->account_name }}</small>
                <small class="d-block">Amount: Rp {{ number_format($order->total) }}</small>
              </div>
              <a href="{{ route('web.payment', $order->id) }}" class="btn btn-sm btn-primary">
                <i class="ci-upload me-1"></i>Upload Payment Proof
              </a>
              @endif
            </li>
            @endif
            <li class="d-flex justify-content-between">
              Shipping:
              <span class="text-body-emphasis fw-medium text-end ms-2">Rp {{number_format($order->delivery_price)}}</span>
            </li>
          </ul>
        </div>

        <!-- Order Summary -->
        <div class="border-top pt-4">
          <h6>Order Summary</h6>
          <ul class="list-unstyled fs-sm mb-4">
            @if($order->subtotal && $order->subtotal > 0)
            <li class="d-flex justify-content-between mb-1">
              Subtotal:
              <span class="text-body-emphasis fw-medium text-end ms-2">{{ $order->getSubtotalFormatted() }}</span>
            </li>
            @endif
            @if($order->hasCoupon())
            <li class="d-flex justify-content-between mb-1">
              Coupon Discount ({{ $order->coupon_code }}):
              <span class="text-success fw-medium text-end ms-2">-{{ $order->getCouponDiscountFormatted() }}</span>
            </li>
            @endif
            <li class="d-flex justify-content-between mb-1">
              Shipping:
              <span class="text-body-emphasis fw-medium text-end ms-2">Rp {{number_format($order->delivery_price)}}</span>
            </li>
          </ul>
        </div>

        <!-- Total -->
        <div class="d-flex align-items-center justify-content-between fs-sm border-top pt-4">
          Estimated total:
          <span class="h5 text-end ms-2 mb-0">{{ number_format($order->total)}}</span>
        </div>
      </div>

      <!-- Footer -->
      {{-- <div class="offcanvas-header">
        <a class="btn btn-lg btn-secondary w-100" href="#!">Change the delivery time</a>
      </div> --}}
    </div>

    @endforeach

    <!-- Payment Proof Modal -->
    <div class="modal fade" id="paymentProofModal" tabindex="-1" aria-labelledby="paymentProofModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentProofModalLabel">Payment Proof</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="paymentProofImage" src="" alt="Payment Proof" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to show payment proof modal
        function showPaymentProofModal(imageUrl, orderNumber) {
            document.getElementById('paymentProofImage').src = imageUrl;
            document.getElementById('paymentProofModalLabel').textContent = `Payment Proof - Order #${orderNumber}`;
            const modal = new bootstrap.Modal(document.getElementById('paymentProofModal'));
            modal.show();
        }

        // Set active menu based on current URL
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.list-group-item');
            
            // Remove active class from all items
            menuItems.forEach(item => {
                item.classList.remove('active');
                item.classList.remove('pe-none');
            });
            
            // Add active class to current menu item
            menuItems.forEach(item => {
                const href = item.getAttribute('href');
                if (href && currentPath === href) {
                    item.classList.add('active');
                    item.classList.add('pe-none');
                } else if (currentPath === '/my-account' && href && href.includes('/my-account') && !href.includes('personal-info') && !href.includes('addresses')) {
                    // Handle orders page specifically
                    item.classList.add('active');
                    item.classList.add('pe-none');
                }
            });
        });
    </script>

@endsection