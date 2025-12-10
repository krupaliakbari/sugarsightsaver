<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/authentication/auth-boxed.scss'])
        @vite(['resources/scss/dark/assets/authentication/auth-boxed.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    
    <div class="auth-container d-flex">

        <div class="container mx-auto align-self-center">
    
            <div class="row">
    
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                    <div class="card mt-3 mb-3">
                        <div class="card-body">
                            
                            <!-- Logo Section -->
                            <div class="text-center mb-4">
                                <img src="{{Vite::asset('resources/images/logo.png')}}" alt="Sugar Sight Logo" style="height: 80px; width: auto; margin-bottom: 1rem;">
                            </div>

                            @if($setRestform == 0)
                                <!-- Forgot Password Form -->
                                <form method="post" id="forgotPasswordForm" action="{{route('user-password-reset')}}" onsubmit="return validateForgotForm()">
                                    {{csrf_field()}}
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            @if(session()->has('error'))
                                                <div class="alert alert-danger">{{session()->get('error')}}</div>
                                            @endif

                                            @if(session()->has('success'))
                                                <div class="alert alert-success">{{session()->get('success')}}</div>
                                            @endif
                                            
                                            <h2>Password Reset</h2>
                                            <p>Enter your email address and we'll send you a link to reset your password.</p>
                                            
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Email Address</label>
                                                <input type="email" name="email" id="forgotEmail" placeholder="Enter your email address" class="form-control" value="{{ old('email') }}">
                                                <div id="forgotEmailError" class="text-danger p-1" style="display: none;">Email is required.</div>
                                                @error('email')
                                                    <div class="text-danger p-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-4">
                                                <button class="btn btn-dark w-100">SEND RESET LINK</button>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="text-center">
                                                <a href="{{ route('admin-login') }}" style="color: #6c757d; text-decoration: none;">Back to Login</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <!-- Reset Password Form -->
                                <form method="post" id="resetPasswordForm" action="{{route('user-password-reset-request')}}" onsubmit="return validateResetForm()">
                                    {{csrf_field()}}
                                    <input type="hidden" name="email" value="{{$email}}">
                                    <input type="hidden" name="token" value="{{$token}}">
                                    
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            @if(session()->has('error'))
                                                <div class="alert alert-danger">{{session()->get('error')}}</div>
                                            @endif

                                            @if(session()->has('success'))
                                                <div class="alert alert-success">{{session()->get('success')}}</div>
                                            @endif
                                            
                                            <h2>Reset Password</h2>
                                            <p>Enter your new password below.</p>
                                            
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">New Password</label>
                                                <input type="password" name="password" id="newPassword" placeholder="Enter new password" class="form-control">
                                                <div id="newPasswordError" class="text-danger p-1" style="display: none;">Password is required</div>
                                                @error('password')
                                                    <div class="text-danger p-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Confirm Password</label>
                                                <input type="password" name="password_confirmation" id="confirmPassword" placeholder="Confirm new password" class="form-control">
                                                <div id="confirmPasswordError" class="text-danger p-1" style="display: none;">Password confirmation is required</div>
                                                @error('password_confirmation')
                                                    <div class="text-danger p-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-4">
                                                <button class="btn btn-dark w-100">RESET PASSWORD</button>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="text-center">
                                                <a href="{{ route('admin-login') }}" style="color: #6c757d; text-decoration: none;">Back to Login</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endif
                            
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>

    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>

    <script>
    function validateForgotForm() {
        var email = document.getElementById("forgotEmail").value;
        var emailError = document.getElementById("forgotEmailError");

        emailError.style.display = "none";

        if (email.trim() === "") {
            emailError.style.display = "block";
            return false;
        }

        return true;
    }

    function validateResetForm() {
        var password = document.getElementById("newPassword").value;
        var confirmPassword = document.getElementById("confirmPassword").value;
        var passwordError = document.getElementById("newPasswordError");
        var confirmPasswordError = document.getElementById("confirmPasswordError");

        passwordError.style.display = "none";
        confirmPasswordError.style.display = "none";

        if (password.trim() === "") {
            passwordError.style.display = "block";
            return false;
        }

        if (confirmPassword.trim() === "") {
            confirmPasswordError.style.display = "block";
            return false;
        }

        if (password !== confirmPassword) {
            confirmPasswordError.innerHTML = "Passwords do not match";
            confirmPasswordError.style.display = "block";
            return false;
        }

        return true;
    }
</script>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
