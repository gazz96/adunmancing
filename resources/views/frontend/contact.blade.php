@extends('frontend.layouts.default')

@section('content')
    <!-- Page content -->
    <main class="content-wrapper">


        <!-- Page title -->
        <section class="position-relative bg-body-tertiary py-4">
            {{-- <img src="assets/img/contact/title-bg.png"
                class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover rtl-flip" alt="Background image"> --}}
            <div class="container position-relative z-2 py-4 py-md-5 my-lg-3 my-xl-4 my-xxl-5">
                <div class="row pt-lg-2 pb-2 pb-sm-3 pb-lg-4">
                    <div class="col-9 col-md-8 col-lg-6">
                        <h1 class="display-4 mb-lg-4">Hubungi Kami</h1>
                        <p class="mb-0">Jangan ragu untuk menghubungi kami, kami akan dengan senang hati membantu Anda!</p>
                    </div>
                </div>
            </div>
        </section>


        <!-- Contact details -->
        <section class="container pt-5 mt-2 mt-sm-3 mt-lg-4 mt-xl-5 mb-n3">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4 pt-lg-2 pt-xl-0">

                <!-- Location -->
                <div class="col">
                    <div class="d-flex align-items-center">
                        <i class="ci-map-pin fs-lg text-dark-emphasis"></i>
                        <h3 class="h6 ps-2 ms-1 mb-0">Lokasi Toko</h3>
                    </div>
                    <hr class="text-dark-emphasis opacity-50 my-3 my-md-4">
                    <ul class="list-unstyled">
                        <li>Indonesia</li>
                        <li>PT Adun Mancing Megautama</li>
                    </ul>
                </div>

                <!-- Phones -->
                <div class="col">
                    <div class="d-flex align-items-center">
                        <i class="ci-phone-outgoing fs-lg text-dark-emphasis"></i>
                        <h3 class="h6 ps-2 ms-1 mb-0">Hubungi Langsung</h3>
                    </div>
                    <hr class="text-dark-emphasis opacity-50 my-3 my-md-4">
                    <ul class="list-unstyled">
                        <li>Customer Service: (321) 578 393 4937</li>
                        <li>WhatsApp: 0878-1234-1234</li>
                    </ul>
                </div>

                <!-- Emails -->
                <div class="col">
                    <div class="d-flex align-items-center">
                        <i class="ci-mail fs-lg text-dark-emphasis"></i>
                        <h3 class="h6 ps-2 ms-1 mb-0">Kirim Pesan</h3>
                    </div>
                    <hr class="text-dark-emphasis opacity-50 my-3 my-md-4">
                    <ul class="list-unstyled">
                        <li>Customer: info@adunmancing.com</li>
                        <li>Support: support@adunmancing.com</li>
                    </ul>
                </div>

                <!-- Working hours -->
                <div class="col">
                    <div class="d-flex align-items-center">
                        <i class="ci-clock fs-lg text-dark-emphasis"></i>
                        <h3 class="h6 ps-2 ms-1 mb-0">Jam Operasional</h3>
                    </div>
                    <hr class="text-dark-emphasis opacity-50 my-3 my-md-4">
                    <ul class="list-unstyled">
                        <li>Senin - Jumat: 9:00 - 17:00</li>
                        <li>Sabtu - Minggu: 10:00 - 15:00</li>
                    </ul>
                </div>
            </div>
        </section>


        <!-- Support / Help center -->
        <section class="container py-5 my-2 my-sm-3 my-lg-4 my-xl-5">
            <div class="d-sm-flex align-items-center justify-content-between py-xxl-3">
                <div class="mb-4 mb-sm-0 me-sm-4">
                    <h2 class="h3">Mencari bantuan?</h2>
                    <p class="mb-0">Kami mungkin sudah memiliki jawaban yang Anda cari. Lihat FAQ kami di bawah ini atau hubungi customer service kami.</p>
                </div>
                <a class="btn btn-lg btn-outline-dark" href="#faq">Lihat FAQ</a>
            </div>
        </section>


        <!-- Map -->
        <section class="position-relative bg-body-tertiary">
            <a class="position-absolute top-50 start-50 translate-middle z-2 mt-lg-n4"
                href="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30908.594922615324!2d-73.07331970206108!3d40.788157341303005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89e8483b8bffed93%3A0x53467ceb834b7397!2s396%20Lillian%20Blvd%2C%20Holbrook%2C%20NY%2011741%2C%20USA!5e0!3m2!1sen!2s!4v1706086459668!5m2!1sen!2"
                style="width: 50px" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover"
                data-bs-content="Click to view the map" data-glightbox="width: 100vw; height: 100vh;" data-gallery="map"
                aria-label="Toggle map">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 42.5 54.6">
                    <path
                        d="M42.5 19.2C42.5 8.1 33.2-.7 22 0 12.4.7 4.7 8.5 4.2 18c-.2 2.7.3 5.3 1.1 7.7h0s3.4 10.4 17.4 25c.4.4 1 .4 1.4 0 13.6-13.3 17.4-25 17.4-25h0c.6-2 1-4.2 1-6.5z"
                        fill="#ffffff" />
                    <g fill="#222934">
                        <path
                            d="M20.4 31.8c-4.5 0-8.1-3.6-8.1-8.1s3.6-8.1 8.1-8.1 8.1 3.6 8.1 8.1-3.7 8.1-8.1 8.1zm0-14.2a6.06 6.06 0 0 0-6.1 6.1 6.06 6.06 0 0 0 6.1 6.1c3.3 0 6.1-2.7 6.1-6.1s-2.8-6.1-6.1-6.1z" />
                        <circle cx="20.4" cy="23.7" r="3" />
                        <path
                            d="M20.4 54.5c-.6 0-1.1-.2-1.4-.6C5 39.3 1.5 29 1.4 28.5a21.92 21.92 0 0 1-1.2-8c.6-10.1 8.6-18.3 18.7-19C24.6 1.1 30 3 34.1 6.9c4.1 3.8 6.4 9.2 6.4 14.8 0 2.4-.4 4.7-1.2 6.9-.1.5-4 12-17.6 25.3-.3.4-.8.6-1.3.6zm-17-26.2c.8 2 4.9 11.6 17 24.2 13.2-13 17-24.5 17.1-24.6.7-2 1.1-4.1 1.1-6.3 0-5-2.1-9.9-5.8-13.3-3.7-3.5-8.6-5.2-13.7-4.8-9.1.6-16.4 8-16.9 17.1-.1 2.5.2 5 1.1 7.3l.1.4z" />
                    </g>
                </svg>
            </a>
            <img src="assets/img/contact/map.jpg" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover"
                alt="Map">
            <div class="d-none d-xxl-block" style="height: 600px"></div>
            <div class="d-none d-xl-block d-xxl-none" style="height: 500px"></div>
            <div class="d-none d-lg-block d-xl-none" style="height: 420px"></div>
            <div class="d-none d-md-block d-lg-none" style="height: 350px"></div>
            <div class="d-md-none" style="height: 300px"></div>
            <span class="position-absolute top-0 start-0 z-1 w-100 h-100 bg-body opacity-25"></span>
        </section>


        <!-- FAQ accordion -->
        <section class="container pt-5 mt-2 mt-sm-3 mt-lg-4 mt-xl-5 mb-5">
            <h2 class="text-center pt-xxl-3 pb-lg-2 pb-xl-3">Pertanyaan Umum (FAQ)</h2>
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-9 col-xl-8">

                    <!-- Accordion -->
                    <div class="accordion accordion-alt-icon" id="faq">
                        @forelse($faqs as $index => $faq)
                            <!-- Question -->
                            <div class="accordion-item">
                                <h3 class="accordion-header" id="faqHeading-{{ $faq->id }}">
                                    <button type="button" class="accordion-button hover-effect-underline collapsed"
                                        data-bs-toggle="collapse" data-bs-target="#faqCollapse-{{ $faq->id }}" aria-expanded="false"
                                        aria-controls="faqCollapse-{{ $faq->id }}">
                                        <span class="me-2">{{ $faq->question }}</span>
                                    </button>
                                </h3>
                                <div class="accordion-collapse collapse" id="faqCollapse-{{ $faq->id }}" aria-labelledby="faqHeading-{{ $faq->id }}"
                                    data-bs-parent="#faq">
                                    <div class="accordion-body">{!! nl2br(e($faq->answer)) !!}</div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <p class="text-muted">Belum ada pertanyaan yang tersedia saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>


    </main>
@endsection
