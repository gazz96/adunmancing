@extends('frontend.layouts.default')


@section('content')
    <!-- Page content -->
    <main class="content-wrapper">
        <div class="container py-5 mt-n2 mt-sm-0">
            <div class="row pt-md-2 pt-lg-3 pb-sm-2 pb-md-3 pb-lg-4 pb-xl-5">


                <!-- Sidebar navigation that turns into offcanvas on screens < 992px wide (lg breakpoint) -->
                <aside class="col-lg-3">
                    <div class="offcanvas-lg offcanvas-start pe-lg-0 pe-xl-4" id="accountSidebar">

                        <!-- Header -->
                        <div class="offcanvas-header d-lg-block py-3 p-lg-0">
                            <div class="d-flex align-items-center">
                                <div class="h5 d-flex justify-content-center align-items-center flex-shrink-0 text-primary bg-primary-subtle lh-1 rounded-circle mb-0"
                                    style="width: 3rem; height: 3rem">S</div>
                                <div class="min-w-0 ps-3">
                                    <h5 class="h6 mb-1">Susan Gardner</h5>
                                    <div class="nav flex-nowrap text-nowrap min-w-0">
                                        <a class="nav-link animate-underline text-body p-0" href="#bonusesModal"
                                            data-bs-toggle="modal">
                                            <svg class="text-warning flex-shrink-0 me-2" xmlns="http://www.w3.org/2000/svg"
                                                width="16" height="16" fill="currentColor">
                                                <path
                                                    d="M1.333 9.667H7.5V16h-5c-.64 0-1.167-.527-1.167-1.167V9.667zm13.334 0v5.167c0 .64-.527 1.167-1.167 1.167h-5V9.667h6.167zM0 5.833V7.5c0 .64.527 1.167 1.167 1.167h.167H7.5v-1-3H1.167C.527 4.667 0 5.193 0 5.833zm14.833-1.166H8.5v3 1h6.167.167C15.473 8.667 16 8.14 16 7.5V5.833c0-.64-.527-1.167-1.167-1.167z" />
                                                <path
                                                    d="M8 5.363a.5.5 0 0 1-.495-.573C7.752 3.123 9.054-.03 12.219-.03c1.807.001 2.447.977 2.447 1.813 0 1.486-2.069 3.58-6.667 3.58zM12.219.971c-2.388 0-3.295 2.27-3.595 3.377 1.884-.088 3.072-.565 3.756-.971.949-.563 1.287-1.193 1.287-1.595 0-.599-.747-.811-1.447-.811z" />
                                                <path
                                                    d="M8.001 5.363c-4.598 0-6.667-2.094-6.667-3.58 0-.836.641-1.812 2.448-1.812 3.165 0 4.467 3.153 4.713 4.819a.5.5 0 0 1-.495.573zM3.782.971c-.7 0-1.448.213-1.448.812 0 .851 1.489 2.403 5.042 2.566C7.076 3.241 6.169.971 3.782.971z" />
                                            </svg>
                                            <span class="animate-target me-1">100 bonuses</span>
                                            <span class="text-body fw-normal text-truncate">available</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn-close d-lg-none" data-bs-dismiss="offcanvas"
                                data-bs-target="#accountSidebar" aria-label="Close"></button>
                        </div>

                        <!-- Body (Navigation) -->
                        <div class="offcanvas-body d-block pt-2 pt-lg-4 pb-lg-0">
                            <nav class="list-group list-group-borderless">
                                <a class="list-group-item list-group-item-action d-flex align-items-center"
                                    href="account-orders.html">
                                    <i class="ci-shopping-bag fs-base opacity-75 me-2"></i>
                                    Orders
                                    <span class="badge bg-primary rounded-pill ms-auto">1</span>
                                </a>
                                <a class="list-group-item list-group-item-action d-flex align-items-center"
                                    href="account-wishlist.html">
                                    <i class="ci-heart fs-base opacity-75 me-2"></i>
                                    Wishlist
                                </a>
                                <a class="list-group-item list-group-item-action d-flex align-items-center"
                                    href="account-payment.html">
                                    <i class="ci-credit-card fs-base opacity-75 me-2"></i>
                                    Payment methods
                                </a>
                                <a class="list-group-item list-group-item-action d-flex align-items-center"
                                    href="account-reviews.html">
                                    <i class="ci-star fs-base opacity-75 me-2"></i>
                                    My reviews
                                </a>
                            </nav>
                            <h6 class="pt-4 ps-2 ms-1">Manage account</h6>
                            <nav class="list-group list-group-borderless">
                                <a class="list-group-item list-group-item-action d-flex align-items-center"
                                    href="account-info.html">
                                    <i class="ci-user fs-base opacity-75 me-2"></i>
                                    Personal info
                                </a>
                                <a class="list-group-item list-group-item-action d-flex align-items-center pe-none active"
                                    href="account-addresses.html">
                                    <i class="ci-map-pin fs-base opacity-75 me-2"></i>
                                    Addresses
                                </a>
                                <a class="list-group-item list-group-item-action d-flex align-items-center"
                                    href="account-notifications.html">
                                    <i class="ci-bell fs-base opacity-75 mt-1 me-2"></i>
                                    Notifications
                                </a>
                            </nav>
                            <h6 class="pt-4 ps-2 ms-1">Customer service</h6>
                            <nav class="list-group list-group-borderless">
                                <a class="list-group-item list-group-item-action d-flex align-items-center"
                                    href="help-topics-v1.html">
                                    <i class="ci-help-circle fs-base opacity-75 me-2"></i>
                                    Help center
                                </a>
                                <a class="list-group-item list-group-item-action d-flex align-items-center"
                                    href="terms-and-conditions.html">
                                    <i class="ci-info fs-base opacity-75 me-2"></i>
                                    Terms and conditions
                                </a>
                            </nav>
                            <nav class="list-group list-group-borderless pt-3">
                                <a class="list-group-item list-group-item-action d-flex align-items-center"
                                    href="account-signin.html">
                                    <i class="ci-log-out fs-base opacity-75 me-2"></i>
                                    Log out
                                </a>
                            </nav>
                        </div>
                    </div>
                </aside>


                <!-- Addresses content -->
                <div class="col-lg-9">
                    <div class="ps-lg-3 ps-xl-0">

                        <!-- Page title -->
                        <h1 class="h2 mb-1 mb-sm-2">Addresses</h1>

                        <!-- Primary shipping address -->
                        <div class="border-bottom py-4">
                            <div class="nav flex-nowrap align-items-center justify-content-between pb-1 mb-3">
                                <div class="d-flex align-items-center gap-3 me-4">
                                    <h2 class="h6 mb-0">Shipping address</h2>
                                    <span class="badge text-bg-info rounded-pill">Primary</span>
                                </div>
                                <a class="nav-link hiding-collapse-toggle text-decoration-underline p-0 collapsed"
                                    href=".primary-address" data-bs-toggle="collapse" aria-expanded="false"
                                    aria-controls="primaryAddressPreview primaryAddressEdit">Edit</a>
                            </div>
                            <div class="collapse primary-address show" id="primaryAddressPreview">
                                <ul class="list-unstyled fs-sm m-0">
                                    <li>New York 11741, USA</li>
                                    <li>396 Lillian Bolavandy, Holbrook</li>
                                </ul>
                            </div>
                            <div class="collapse primary-address" id="primaryAddressEdit">
                                <form class="row g-3 g-sm-4 needs-validation" novalidate>
                                    <div class="col-sm-6">
                                        <div class="position-relative">
                                            <label class="form-label">Country</label>
                                            <select class="form-select" data-select='{"searchEnabled": true}'
                                                aria-label="Select country" required>
                                                <option value="">Select country...</option>
                                                <optgroup label="Africa">
                                                    <option value="Nigeria">Nigeria</option>
                                                    <option value="South Africa">South Africa</option>
                                                    <option value="Kenya">Kenya</option>
                                                    <option value="Egypt">Egypt</option>
                                                    <option value="Ethiopia">Ethiopia</option>
                                                </optgroup>
                                                <optgroup label="Asia">
                                                    <option value="China">China</option>
                                                    <option value="India">India</option>
                                                    <option value="Japan">Japan</option>
                                                    <option value="South Korea">South Korea</option>
                                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                                </optgroup>
                                                <optgroup label="Europe">
                                                    <option value="Germany">Germany</option>
                                                    <option value="France">France</option>
                                                    <option value="United Kingdom">United Kingdom</option>
                                                    <option value="Italy">Italy</option>
                                                    <option value="Spain">Spain</option>
                                                </optgroup>
                                                <optgroup label="North America">
                                                    <option value="United States" selected>United States</option>
                                                    <option value="Canada">Canada</option>
                                                    <option value="Mexico">Mexico</option>
                                                    <option value="Jamaica">Jamaica</option>
                                                    <option value="Costa Rica">Costa Rica</option>
                                                </optgroup>
                                                <optgroup label="South America">
                                                    <option value="Brazil">Brazil</option>
                                                    <option value="Argentina">Argentina</option>
                                                    <option value="Colombia">Colombia</option>
                                                    <option value="Chile">Chile</option>
                                                    <option value="Peru">Peru</option>
                                                </optgroup>
                                                <optgroup label="Oceania">
                                                    <option value="Australia">Australia</option>
                                                    <option value="New Zealand">New Zealand</option>
                                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                                    <option value="Fiji">Fiji</option>
                                                    <option value="Solomon Islands">Solomon Islands</option>
                                                </optgroup>
                                            </select>
                                            <div class="invalid-feedback">Please select your country!</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="position-relative">
                                            <label class="form-label">City</label>
                                            <select class="form-select" data-select='{"searchEnabled": true}'
                                                aria-label="Select city" required>
                                                <option value="">Select city...</option>
                                                <option value="Austin">Austin</option>
                                                <option value="Charlotte">Charlotte</option>
                                                <option value="Chicago">Chicago</option>
                                                <option value="Columbus">Columbus</option>
                                                <option value="Dallas">Dallas</option>
                                                <option value="Houston">Houston</option>
                                                <option value="Jacksonville">Jacksonville</option>
                                                <option value="Los Angeles">Los Angeles</option>
                                                <option value="New York" selected>New York</option>
                                                <option value="Orlando">Orlando</option>
                                                <option value="Philadelphia">Philadelphia</option>
                                                <option value="Phoenix">Phoenix</option>
                                                <option value="San Antonio">San Antonio</option>
                                                <option value="San Diego">San Diego</option>
                                                <option value="San Jose">San Jose</option>
                                            </select>
                                            <div class="invalid-feedback">Please select your city!</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="position-relative">
                                            <label for="psa-zip" class="form-label">ZIP code</label>
                                            <input type="text" class="form-control" id="psa-zip" value="11741"
                                                required>
                                            <div class="invalid-feedback">Please enter your ZIP code!</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="position-relative">
                                            <label for="psa-address" class="form-label">Address</label>
                                            <input type="text" class="form-control" id="psa-address"
                                                value="396 Lillian Bolavandy, Holbrook" required>
                                            <div class="invalid-feedback">Please enter your address!</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check mb-0">
                                            <input type="checkbox" class="form-check-input" id="set-primary-1" checked>
                                            <label for="set-primary-1" class="form-check-label">Set as primary
                                                address</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex gap-3 pt-2 pt-sm-0">
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                            <button type="button" class="btn btn-secondary" data-bs-toggle="collapse"
                                                data-bs-target=".primary-address" aria-expanded="true"
                                                aria-controls="primaryAddressPreview primaryAddressEdit">Close</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <!-- Add address button -->
                        <div class="nav pt-4">
                            <a class="nav-link animate-underline fs-base px-0" href="#newAddressModal"
                                data-bs-toggle="modal">
                                <i class="ci-plus fs-lg ms-n1 me-2"></i>
                                <span class="animate-target">Add address</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
