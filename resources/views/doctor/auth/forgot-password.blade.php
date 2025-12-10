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
                                
                            </div>

                        <form method="post" id="doctorForgotPassword" action="{{route('doctor.forgot-password')}}" onsubmit="return validateForgotPasswordForm()">
                                {{csrf_field()}}
    
                            <div class="row">
                                <div class="col-md-12 mb-4">

                                    @if(session()->has('error'))
                                        <div class="alert alert-danger" style="border-radius: 10px; border: none;">{{session()->get('error')}}</div>
                                    @endif

                                    @if(session()->has('success'))
                                        <div class="alert alert-success" style="border-radius: 10px; border: none;">{{session()->get('success')}}</div>
                                    @endif
                                    
                                    <h2 style="color: #2E354C; font-weight: 700; text-align: center; margin-bottom: 0.5rem;">Forgot Password?</h2>
                                    <p style="color: #6c757d; text-align: center; margin-bottom: 0;">Enter your email address and we'll send you a link to reset your password</p>
                                    
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label" style="color: #2E354C; font-weight: 600; margin-bottom: 0.5rem;">Email Address</label>
                                        <input type="email" name="email" id="forgotEmail" placeholder="Enter your email address" class="form-control" value="{{ old('email') }}" style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px; font-size: 16px; transition: all 0.3s ease;">
                                        <div id="forgotEmailError" class="text-danger p-1" style="display: none;">Email is required.</div>
                                        @error('email')
                                            <div class="text-danger p-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-4">
                                        <button class="btn w-100" style="background: linear-gradient(135deg, #634299 0%, #8B5FBF 100%); border: none; border-radius: 10px; padding: 12px; font-size: 16px; font-weight: 600; color: white; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(99, 66, 153, 0.3);">SEND RESET LINK</button>
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
    function validateForgotPasswordForm() {
        var email = document.getElementById("forgotEmail").value;

        var emailError = document.getElementById("forgotEmailError");

        emailError.style.display = "none";

        if (email.trim() === "") {
            emailError.style.display = "block";
            return false;
        }

        return true;
    }
</script>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
