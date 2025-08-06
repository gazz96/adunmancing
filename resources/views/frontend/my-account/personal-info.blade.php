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

                        <!-- Page title -->
                        <h1 class="h2 mb-1 mb-sm-2">Personal info</h1>

                        <!-- Success Message -->
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="ci-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <!-- Error Messages -->
                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="ci-warning me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="ci-warning me-2"></i>
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <!-- Basic info -->
                        <div class="border-bottom py-4">
                            <div class="nav flex-nowrap align-items-center justify-content-between pb-1 mb-3">
                                <h2 class="h6 mb-0">Basic info</h2>
                                <a class="nav-link hiding-collapse-toggle text-decoration-underline p-0 collapsed"
                                    href=".basic-info" data-bs-toggle="collapse" aria-expanded="false"
                                    aria-controls="basicInfoPreview basicInfoEdit">Edit</a>
                            </div>
                            <div class="collapse basic-info show" id="basicInfoPreview">
                                <ul class="list-unstyled fs-sm m-0">
                                    <li>{{$user->name}}</li>
                                    @if($user->birth_date)
                                    <li>{{ date('d F Y', strtotime($user->birth_date))}}</li>
                                    @endif
                                    <li>{{ $user->email }}</li>
                                </ul>
                            </div>
                            <div class="collapse basic-info" id="basicInfoEdit">
                                <form class="row g-3 g-sm-4 needs-validation" method="POST" action="{{ route('web.my-account.save-personal-info') }}" novalidate>
                                    @csrf
                                    <div class="col-sm-12">
                                        <label for="fn" class="form-label">Full name</label>
                                        <div class="position-relative">
                                            <input name="name" type="text" class="form-control" id="fn" value="{{$user->name}}" required>
                                            @error('name')
                                            <div class="d-block invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <label for="fn" class="form-label">Email</label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control" id="fn" value="{{$user->email}}" disabled>
                                            @error('email')
                                             <div class="d-block invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <label for="iPhoneNumber" class="form-label">Phone Number</label>
                                        <div class="position-relative">
                                            <input type="text" name="phone_number" class="form-control" id="iPhoneNumber" value="{{$user->phone_number}}">
                                            @error('phone_number')
                                             <div class="d-block invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-12">
                                        <label for="birthdate" class="form-label">Date of birth</label>
                                        <div class="position-relative">
                                            <input name="birth_date" type="text" class="form-control form-icon-end" id="birthdate" data-datepicker='{"dateFormat": "Y-m-d"}'
                                                placeholder="Choose date" value="{{$user->birth_date}}">
                                            <i class="ci-calendar position-absolute top-50 end-0 translate-middle-y me-3"></i>
                                            @error('birth_date')
                                               <div class="d-block invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex gap-3 pt-2 pt-sm-0">
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                            <button type="button" class="btn btn-secondary" data-bs-toggle="collapse"
                                                data-bs-target=".basic-info" aria-expanded="true"
                                                aria-controls="basicInfoPreview basicInfoEdit">Close</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                     

                        <!-- Password -->
                        <div class="border-bottom py-4">
                            <div class="nav flex-nowrap align-items-center justify-content-between pb-1 mb-3">
                                <div class="d-flex align-items-center gap-3 me-4">
                                    <h2 class="h6 mb-0">Password</h2>
                                </div>
                                <a class="nav-link hiding-collapse-toggle text-decoration-underline p-0 collapsed"
                                    href=".password-change" data-bs-toggle="collapse" aria-expanded="false"
                                    aria-controls="passChangePreview passChangeEdit">Edit</a>
                            </div>
                            <div class="collapse password-change show" id="passChangePreview">
                                <ul class="list-unstyled fs-sm m-0">
                                    <li>**************</li>
                                </ul>
                            </div>
                            <div class="collapse password-change" id="passChangeEdit">
                                <form class="row g-3 g-sm-4 needs-validation" method="POST" action="{{ route('web.my-account.update-password')}}" novalidate>
                                    @csrf
                                    <div class="col-sm-6">
                                        <label for="current-password" class="form-label">Current password</label>
                                        <div class="password-toggle">
                                            <input name="current_password" type="password" class="form-control" id="current-password"
                                                placeholder="Enter your current password" required>
                                            <label class="password-toggle-button" aria-label="Show/hide password">
                                                <input type="checkbox" class="btn-check">
                                            </label>
                                        </div>
                                        @error('current_password')
                                        <span class="d-block invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="new-password" class="form-label">New password</label>
                                        <div class="password-toggle">
                                            <input name="new_password" type="password" class="form-control" id="new-password"
                                                placeholder="Create new password" required>
                                            <label class="password-toggle-button" aria-label="Show/hide password">
                                                <input type="checkbox" class="btn-check">
                                            </label>
                                        </div>
                                        @error('new_password')
                                        <span class="d-block invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="confirm-password" class="form-label">Confirm new password</label>
                                        <div class="password-toggle">
                                            <input name="new_password_confirmation" type="password" class="form-control" id="confirm-password"
                                                placeholder="Confirm new password" required>
                                            <label class="password-toggle-button" aria-label="Show/hide password">
                                                <input type="checkbox" class="btn-check">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex gap-3 pt-2 pt-sm-0">
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                            <button type="button" class="btn btn-secondary" data-bs-toggle="collapse"
                                                data-bs-target=".password-change" aria-expanded="true"
                                                aria-controls="passChangePreview passChangeEdit">Close</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Delete account -->
                        <div class="pt-3 mt-2 mt-sm-3 d-none">
                            <h2 class="h6">Delete account</h2>
                            <p class="fs-sm">When you delete your account, your public profile will be deactivated
                                immediately. If you change your mind before the 14 days are up, sign in with your email and
                                password, and we'll send you a link to reactivate your account.</p>
                            <a class="text-danger fs-sm fw-medium" href="#!">Delete account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection


@section('footer_scripts')
<script>
$(document).ready(function() {
    // Auto-close forms after successful save
    @if(session('success'))
        // Close any open form sections after successful save
        $('.collapse.show:not(#basicInfoPreview, #passChangePreview)').collapse('hide');
        
        // Scroll to top to show success message
        $('html, body').animate({
            scrollTop: 0
        }, 500);
        
        // Auto-dismiss success alert after 5 seconds
        setTimeout(function() {
            $('.alert-success').fadeOut('slow');
        }, 5000);
    @endif
    
    // Handle form submission loading states
    $('form').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.text();
        
        // Show loading state
        submitBtn.prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...');
        
        // Reset button if there's an error (this will happen on page reload for validation errors)
        setTimeout(function() {
            if ($('.alert-danger').length > 0) {
                submitBtn.prop('disabled', false).text(originalText);
            }
        }, 100);
    });
    
    // Auto-dismiss error alerts after 10 seconds
    if ($('.alert-danger').length > 0) {
        setTimeout(function() {
            $('.alert-danger').fadeOut('slow');
        }, 10000);
    }
    
    // Focus on first invalid field if there are validation errors
    @if($errors->any())
        const firstErrorField = $('.is-invalid, .form-control:has(.invalid-feedback)').first();
        if (firstErrorField.length > 0) {
            // Open the form section if it's collapsed
            const formSection = firstErrorField.closest('.collapse');
            if (formSection.length > 0 && !formSection.hasClass('show')) {
                formSection.collapse('show');
            }
            
            // Focus on the field after a short delay
            setTimeout(function() {
                firstErrorField.focus();
            }, 300);
        }
    @endif
    
    // Handle error or session error messages - scroll to top to show them
    @if(session('error') || $errors->any())
        $('html, body').animate({
            scrollTop: 0
        }, 500);
    @endif
    
    // Add form validation feedback
    $('.needs-validation').on('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        $(this).addClass('was-validated');
    });
    
    // Clear validation state when user starts typing
    $('.form-control').on('input', function() {
        $(this).removeClass('is-invalid');
        $(this).siblings('.invalid-feedback').hide();
    });
});
</script>
@endsection