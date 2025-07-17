@extends('frontend.layouts.default')


@section('content')
    <!-- Page content -->
    <main class="content-wrapper">
        <div class="container py-5 mt-n2 mt-sm-0">
            <div class="row pt-md-2 pt-lg-3 pb-sm-2 pb-md-3 pb-lg-4 pb-xl-5">


                <div class="col-lg-3">
                    @include('frontend.my-account.navigation')
                </div>


                <!-- Addresses content -->
                <div class="col-lg-9">
                    <div class="ps-lg-3 ps-xl-0">

                        <!-- Page title -->
                        <h1 class="h2 mb-1 mb-sm-2">Addresses</h1>

                        @forelse($addresses as $address)
                            <!-- Primary shipping address -->
                            <div class="border-bottom py-4">
                                <div class="nav flex-nowrap align-items-center justify-content-between pb-1 mb-3">
                                    <div class="d-flex align-items-center gap-3 me-4">
                                        <h2 class="h6 mb-0">{{ $address->name }}</h2>
                                        @if ($address->is_default)
                                            <span class="badge text-bg-info rounded-pill">Primary</span>
                                        @endif
                                    </div>
                                    <a class="nav-link hiding-collapse-toggle text-decoration-underline p-0 collapsed"
                                        href=".primary-address-{{$address->id}}" data-bs-toggle="collapse" aria-expanded="false"
                                        aria-controls="primaryAddressPreview primaryAddressEdit">Edit</a>
                                </div>
                                <div class="collapse primary-address show" id="primaryAddressPreview">
                                    <ul class="list-unstyled fs-sm m-0">
                                        <li>{{ $address->province_name }}, {{ $address->city_name }},
                                            {{ $address->postal_code }}</li>
                                        <li>{{ $address->address }}</li>
                                    </ul>
                                </div>
                                <div class="collapse primary-address-{{$address->id}}" id="primaryAddressEdit">
                                    <form class="row g-3 g-sm-4 needs-validation" novalidate method="POST"
                                        action="{{ route('web.my-account.save-addresses') }}">
                                        <input type="hidden" name="id" value="{{ $address->id }}">
                                        <input type="hidden" name="province_id" value="{{ $address->province_id }}">
                                        <input type="hidden" name="province_name" value="{{ $address->province_name }}">
                                        <input type="hidden" name="city_name" value="{{ $address->city_name }}">
                                        
                                        <div class="col-sm-10">
                                            <label for="iName" class="form-label">Name</label>
                                            <input name="name" type="text" class="form-control" id="iName"
                                                value="{{ $address->name }}" required>
                                            @error('name')
                                                <span class="d-block invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="position-relative">
                                                <label for="ipsa-zip" class="form-label">Receipt Name</label>
                                                <input name="recipient_name" type="text" class="form-control" id="ipsa-zip"
                                                    value="{{ $address->recipient_name }}" required>
                                                @error('phone_number')
                                                        <div class="d-block invalid-feedback">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="position-relative">
                                                <label for="iPhoneNumber" class="form-label">Phone Number</label>
                                                <input name="phone_number" type="text" class="form-control" id="iPhoneNumber" value="{{ $address->phone_number }}" required>
                                                    @error('phone_number')
                                                        <div class="d-block invalid-feedback">{{$message}}</div>
                                                    @enderror
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-sm-6">
                                            <div class="position-relative">
                                                <label class="form-label">City</label>
                                                <select name="city_id" class="form-select iCityId"
                                                    data-select='{"searchEnabled": true}' id="iCityId"
                                                    aria-label="Select city" required>
                                                    @foreach ($cities as $city)
                                                        <option value="{{ $city->city_id }}"
                                                            data-option='{{ json_encode($city) }}'
                                                            {{ $city->city_id == $address->city_id ? 'selected' : '' }}>
                                                            {{ $city->province }} - {{ $city->city_name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Please select your city!</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="position-relative">
                                                <label for="psa-zip" class="form-label">ZIP code</label>
                                                <input name="postal_code" type="text" class="form-control" id="psa-zip"
                                                    value="{{ $address->postal_code }}" required>
                                                <div class="invalid-feedback">Please enter your ZIP code!</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-10">
                                            <div class="position-relative">
                                                <label for="psa-address" class="form-label">Address</label>
                                                <input name="address" type="text" class="form-control" id="psa-address"
                                                    value="{{ $address->address }}" required>
                                                <div class="invalid-feedback">Please enter your address!</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check mb-0">
                                                <input name="is_default" type="checkbox" class="form-check-input"
                                                    id="set-primary-1" value="1" @if($address->is_default) checked @endif>
                                                <label for="set-primary-1" class="form-check-label">Set as primary
                                                    address</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex gap-3 pt-2 pt-sm-0">
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                <button type="button" class="btn btn-secondary" data-bs-toggle="collapse"
                                                    data-bs-target=".primary-address-{{$address->id}}" aria-expanded="true"
                                                    aria-controls="primaryAddressPreview primaryAddressEdit">Close</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        @empty
                        @endforelse


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


@section('footer_scripts')
    <!-- Add new address modal -->
    <div class="modal fade" id="newAddressModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="newAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newAddressModalLabel">Add new address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 g-sm-4 needs-validation" novalidate method="POST"
                        action="{{ route('web.my-account.save-addresses') }}">
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="province_id" value="">
                        <input type="hidden" name="province_name" value="">
                        <input type="hidden" name="city_name" value="">
                        <div class="col-sm-10">
                            <label for="iName" class="form-label">Name</label>
                            <input name="name" type="text" class="form-control" id="iName"
                                value="" required>
                            @error('name')
                                <span class="d-block invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <div class="position-relative">
                                <label for="ipsa-recipient_name" class="form-label">Receipt Name</label>
                                <input name="recipient_name" type="text" class="form-control" id="ipsa-recipient_name"
                                    value="" required>
                                @error('phone_number')
                                        <div class="d-block invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="position-relative">
                                <label for="iPhoneNumber" class="form-label">Phone Number</label>
                                <input name="phone_number" type="text" class="form-control" id="iPhoneNumber" value="" required>
                                    @error('phone_number')
                                        <div class="d-block invalid-feedback">{{$message}}</div>
                                    @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="position-relative">
                                <label class="form-label">City</label>
                                <select name="city_id" class="form-select iCityId" data-select='{"searchEnabled":true}' aria-label="Select city" required>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->city_id }}" data-option='{{ json_encode($city) }}'>
                                            {{ $city->province }} - {{ $city->city_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select your city!</div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="position-relative">
                                <label for="ipsa-zip" class="form-label">ZIP code</label>
                                <input name="postal_code" type="text" class="form-control" id="ipsa-zip"
                                    value="" required>
                                <div class="invalid-feedback">Please enter your ZIP code!</div>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <div class="position-relative">
                                <label for="ipsa-address" class="form-label">Address</label>
                                <input name="address" type="text" class="form-control" id="ipsa-address"
                                    value="" required>
                                <div class="invalid-feedback">Please enter your address!</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check mb-0">
                                <input name="is_default" type="checkbox" class="form-check-input" id="iset-primary-1"
                                    value="1" checked>
                                <label for="iset-primary-1" class="form-check-label">Set as primary address</label>
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
        </div>
    </div>


    <script>
        let cities = []
        async function initPage() {
            //const response = await App.Models.Shipping.getRegencies();
            // cities = response?.rajaongkir?.results ?? []
            //await renderCityOptions(cities)
        }


        $(document).on('change', '.iCityId', async function(e) {
            e.preventDefault();
            let cityIdToFind = $(this).val();
            const city = $(this).find('option:selected').data('option');
            console.log('city', city);
            let form = $(this).closest('form');
            form.find('[name=city_id]').val(city.city_id);
            form.find('[name=province_id]').val(city.province_id);
            form.find('[name=province_name]').val(city.province);
            form.find('[name=city_name]').val(city.city_name)

        })

        initPage();
    </script>
@endsection
