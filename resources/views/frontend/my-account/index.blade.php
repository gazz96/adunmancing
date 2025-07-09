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
                            <div class="row row-cols-1 row-cols-sm-2 g-3 g-xxl-4">
                                <div class="col">
                                    <select class="form-select"
                                        data-select='{
                        "placeholderValue": "Select status",
                        "choices": [
                          {
                            "value": "",
                            "label": "Select status",
                            "placeholder": true
                          },
                          {
                            "value": "inprogress",
                            "label": "<div class=\"d-flex align-items-center text-nowrap\"><span class=\"bg-info rounded-circle p-1 me-2\"></span>In progress</div>"
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
                                        data-select-template="true" aria-label="Status sorting"></select>
                                </div>
                                <div class="col">
                                    <select class="form-select" data-select='{"removeItemButton": false}'
                                        aria-label="Timeframe sorting">
                                        <option value="all-time">For all time</option>
                                        <option value="last-year">For last year</option>
                                        <option value="last-3-months">For last 3 months</option>
                                        <option value="last-30-days">For last 30 days</option>
                                        <option value="last-week">For last week</option>
                                    </select>
                                </div>
                            </div>
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
                                            data-sort="date">Order date</button>
                                    </th>
                                    <th scope="col" class="py-3 d-none d-md-table-cell">
                                        <span class="text-body fw-normal">Status</span>
                                    </th>
                                    <th scope="col" class="py-3 d-none d-md-table-cell">
                                        <button type="button" class="btn orders-sort fw-normal text-body p-0"
                                            data-sort="total">Total</button>
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
                                            <li class="fw-medium text-body-emphasis">{{ number_format($order->total_amount)}}</li>
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
                                        {{ number_format($order->total_amount)}}
                                        <span class="total d-none">{{ number_format($order->total_amount)}}</span>
                                    </td>
                                    <td class="py-3 pe-0">
                                        {{-- <span
                                            class="d-flex align-items-center justify-content-end position-relative gap-1 gap-sm-2 ms-n2 ms-sm-0">
                                            <span><img src="assets/img/shop/electronics/thumbs/20.png" width="64"
                                                    alt="Thumbnail"></span>
                                            <span><img src="assets/img/shop/electronics/thumbs/16.png" width="64"
                                                    alt="Thumbnail"></span>
                                            <span><img src="assets/img/shop/electronics/thumbs/15.png" width="64"
                                                    alt="Thumbnail"></span>
                                            <a class="btn btn-icon btn-ghost btn-secondary stretched-link border-0"
                                                href="#orderDetails" data-bs-toggle="offcanvas"
                                                aria-controls="orderDetails" aria-label="Show order details">
                                                <i class="ci-chevron-right fs-lg"></i>
                                            </a>
                                        </span> --}}
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