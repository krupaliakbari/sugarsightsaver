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
    
            <div class="row justify-content-center">
    
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                    <div class="card mt-3 mb-3" style="border: none; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                        <div class="card-body" style="padding: 3rem;">
                            
                            <!-- Logo Section -->
                            <div class="text-center mb-4">
                                <img src="{{Vite::asset('resources/images/logo.png')}}" alt="Sugar Sight Logo" style="height: 80px; width: auto; margin-bottom: 1rem;">
                                <h3 style="color: #634299; font-weight: 700; margin-bottom: 0.5rem;">Sugar Sight</h3>
                                <p style="color: #6c757d; font-size: 14px;">Reset Password</p>
                            </div>

                        <form method="post" id="doctorResetPassword" action="{{route('doctor.reset-password')}}" onsubmit="return validateResetPasswordForm()">
                                {{csrf_field()}}
                                <input type="hidden" name="email" value="{{ $email }}">
                                <input type="hidden" name="token" value="{{ $token }}">
    
                            <div class="row">
                                <div class="col-md-12 mb-4">

                                    @if(session()->has('error'))
                                        <div class="alert alert-danger" style="border-radius: 10px; border: none;">{{session()->get('error')}}</div>
                                    @endif

                                    @if(session()->has('success'))
                                        <div class="alert alert-success" style="border-radius: 10px; border: none;">{{session()->get('success')}}</div>
                                    @endif
                                    
                                    <h2 style="color: #2E354C; font-weight: 700; text-align: center; margin-bottom: 0.5rem;">Reset Password</h2>
                                    <p style="color: #6c757d; text-align: center; margin-bottom: 0;">Enter your new password below</p>
                                    
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label" style="color: #2E354C; font-weight: 600; margin-bottom: 0.5rem;">New Password</label>
                                        <input type="password" name="password" id="resetPassword" placeholder="Enter your new password" class="form-control" style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px; font-size: 16px; transition: all 0.3s ease;">
                                        <div id="resetPasswordError" class="text-danger p-1" style="display: none;">Password is required</div>
                                        @error('password')
                                            <div class="text-danger p-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label" style="color: #2E354C; font-weight: 600; margin-bottom: 0.5rem;">Confirm New Password</label>
                                        <input type="password" name="password_confirmation" id="resetPasswordConfirm" placeholder="Confirm your new password" class="form-control" style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px; font-size: 16px; transition: all 0.3s ease;">
                                        <div id="resetPasswordConfirmError" class="text-danger p-1" style="display: none;">Password confirmation is required</div>
                                        @error('password_confirmation')
                                            <div class="text-danger p-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-4">
                                        <button class="btn w-100" style="background: linear-gradient(135deg, #634299 0%, #8B5FBF 100%); border: none; border-radius: 10px; padding: 12px; font-size: 16px; font-weight: 600; color: white; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(99, 66, 153, 0.3);">RESET PASSWORD</button>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="text-center mt-4" style="padding-top: 1rem; border-top: 1px solid #e9ecef;">
                                        <p style="color: #6c757d; margin-bottom: 0;">Remember your password? 
                                            <a href="{{ route('doctor.login') }}" style="color: #634299; text-decoration: none; font-weight: 600;">Sign in here</a>
                                        </p>
                                    </div>
                                </div>
                                
                            </div>

                        </form>
                            
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>

    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>

    <script>
    function validateResetPasswordForm() {
        var password = document.getElementById("resetPassword").value;
        var passwordConfirm = document.getElementById("resetPasswordConfirm").value;

        var passwordError = document.getElementById("resetPasswordError");
        var passwordConfirmError = document.getElementById("resetPasswordConfirmError");

        passwordError.style.display = "none";
        passwordConfirmError.style.display = "none";

        var isValid = true;

        if (password.trim() === "") {
            passwordError.style.display = "block";
            isValid = false;
        }

        if (passwordConfirm.trim() === "") {
            passwordConfirmError.style.display = "block";
            isValid = false;
        }

        if (password !== passwordConfirm) {
            passwordConfirmError.innerHTML = "Passwords do not match";
            passwordConfirmError.style.display = "block";
            isValid = false;
        }

        return isValid;
    }
</script>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
