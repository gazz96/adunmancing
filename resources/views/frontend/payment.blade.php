@extends('frontend.layouts.default')

@section('content')
    <!-- Page content -->
    <main class="content-wrapper">

        <!-- Breadcrumb -->
        <nav class="container pt-1 pt-md-0 my-3 my-md-4" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/shop') }}">Shop</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/checkout') }}">Checkout</a></li>
                <li class="breadcrumb-item active" aria-current="page">Payment</li>
            </ol>
        </nav>

        <!-- Payment section -->
        <section class="container pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    
                    <!-- Payment success message -->
                    <div class="text-center mb-5">
                        <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px;">
                            <i class="ci-check text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h1 class="h3 mb-2">Pesanan Berhasil Dibuat!</h1>
                        <p class="text-muted mb-0">Order #{{ $order->order_number }}</p>
                    </div>

                    <!-- Order summary card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">Ringkasan Pesanan</h5>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Total Items</small>
                                        <span class="fw-semibold">{{ $order->items->count() }} item</span>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Subtotal</small>
                                        <span class="fw-semibold">Rp {{ number_format($order->total_amount) }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Ongkos Kirim</small>
                                        <span class="fw-semibold">Rp {{ number_format($order->delivery_price) }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Total Pembayaran</small>
                                        <span class="fw-semibold fs-5 text-primary">Rp {{ number_format($order->total) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment instructions -->
                    @if($order->paymentMethod->type === 'bank_transfer')
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <h5 class="card-title mb-3">
                                    <i class="ci-credit-card me-2"></i>
                                    Instruksi Pembayaran - {{ $order->paymentMethod->name }}
                                </h5>
                                
                                <!-- Bank details -->
                                <div class="alert alert-primary mb-4">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <small class="text-muted d-block">Bank</small>
                                            <strong>{{ $order->paymentMethod->name }}</strong>
                                        </div>
                                        <div class="col-sm-6">
                                            <small class="text-muted d-block">Nomor Rekening</small>
                                            <strong id="account-number">{{ $order->paymentMethod->account_number }}</strong>
                                            <button type="button" class="btn btn-link p-0 ms-2" onclick="copyToClipboard('account-number')">
                                                <i class="ci-copy"></i>
                                            </button>
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <small class="text-muted d-block">Atas Nama</small>
                                            <strong>{{ $order->paymentMethod->account_name }}</strong>
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <small class="text-muted d-block">Jumlah Transfer</small>
                                            <strong id="transfer-amount" class="text-primary">Rp {{ number_format($order->total) }}</strong>
                                            <button type="button" class="btn btn-link p-0 ms-2" onclick="copyToClipboard('transfer-amount')">
                                                <i class="ci-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h6 class="mb-2">Langkah-langkah pembayaran:</h6>
                                    <ol class="ps-3">
                                        <li>Transfer sesuai jumlah yang tertera di atas ke rekening {{ $order->paymentMethod->name }}</li>
                                        <li>Pastikan jumlah transfer sesuai dengan total pembayaran</li>
                                        <li>Upload bukti transfer pada form di bawah ini</li>
                                        <li>Tim kami akan memverifikasi pembayaran dalam 1x24 jam</li>
                                        <li>Pesanan akan diproses setelah pembayaran diverifikasi</li>
                                    </ol>
                                </div>

                                @if($order->paymentMethod->instructions)
                                    <div class="alert alert-info">
                                        <i class="ci-info-circle me-2"></i>
                                        {{ $order->paymentMethod->instructions }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Payment proof upload form -->
                        @if($order->payment_status === 'pending')
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <h5 class="card-title mb-3">
                                        <i class="ci-upload me-2"></i>
                                        Upload Bukti Transfer
                                    </h5>
                                    
                                    <form action="{{ route('web.payment.upload-proof', $order->id) }}" method="POST" 
                                          enctype="multipart/form-data" id="payment-proof-form">
                                        @csrf
                                        
                                        <div class="mb-3">
                                            <label for="payment_proof" class="form-label">Bukti Transfer *</label>
                                            <input type="file" class="form-control" id="payment_proof" name="payment_proof" 
                                                   accept="image/*" required>
                                            <small class="form-text text-muted">
                                                Upload foto/screenshot bukti transfer. Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.
                                            </small>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="payment_notes" class="form-label">Catatan (Opsional)</label>
                                            <textarea class="form-control" id="payment_notes" name="payment_notes" 
                                                      rows="3" placeholder="Tambahkan catatan jika diperlukan"></textarea>
                                        </div>
                                        
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <a href="{{ route('web.my-account') }}" class="btn btn-outline-secondary me-md-2">
                                                Nanti Saja
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="ci-upload me-2"></i>Upload Bukti Transfer
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @elseif($order->payment_status === 'verification')
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-4 text-center">
                                    <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                         style="width: 60px; height: 60px;">
                                        <i class="ci-clock text-white"></i>
                                    </div>
                                    <h5>Bukti Pembayaran Sedang Diverifikasi</h5>
                                    <p class="text-muted mb-3">
                                        Terima kasih telah mengupload bukti pembayaran. Tim kami sedang memverifikasi pembayaran Anda.
                                    </p>
                                    @if($order->payment_proof_url)
                                        <div class="mb-3">
                                            <small class="text-muted d-block mb-2">Bukti transfer yang diupload:</small>
                                            <img src="{{ $order->payment_proof_url }}" alt="Payment Proof" 
                                                 class="img-thumbnail" style="max-height: 200px;">
                                        </div>
                                    @endif
                                    <a href="{{ route('web.my-account') }}" class="btn btn-primary">
                                        Lihat Status Pesanan
                                    </a>
                                </div>
                            </div>
                        @elseif($order->payment_status === 'paid')
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-4 text-center">
                                    <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                         style="width: 60px; height: 60px;">
                                        <i class="ci-check text-white"></i>
                                    </div>
                                    <h5 class="text-success">Pembayaran Berhasil</h5>
                                    <p class="text-muted mb-3">
                                        Pembayaran Anda telah dikonfirmasi. Pesanan sedang diproses.
                                    </p>
                                    <a href="{{ route('web.my-account') }}" class="btn btn-primary">
                                        Lihat Status Pesanan
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endif

                </div>
            </div>
        </section>
    </main>
@endsection

@section('footer_scripts')
    <script>
        function copyToClipboard(elementId) {
            const element = document.getElementById(elementId);
            const text = element.textContent.trim();
            
            navigator.clipboard.writeText(text.replace('Rp ', '').replace(/\./g, '')).then(function() {
                // Show success feedback
                const button = element.nextElementSibling;
                const originalIcon = button.innerHTML;
                button.innerHTML = '<i class="ci-check text-success"></i>';
                
                setTimeout(() => {
                    button.innerHTML = originalIcon;
                }, 2000);
            });
        }

        // Form validation
        document.getElementById('payment-proof-form')?.addEventListener('submit', function(e) {
            const fileInput = document.getElementById('payment_proof');
            if (fileInput.files.length === 0) {
                e.preventDefault();
                alert('Silakan pilih file bukti transfer terlebih dahulu.');
                return false;
            }

            // Check file size (max 2MB)
            const maxSize = 2 * 1024 * 1024; // 2MB
            if (fileInput.files[0].size > maxSize) {
                e.preventDefault();
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                return false;
            }
        });
    </script>
@endsection