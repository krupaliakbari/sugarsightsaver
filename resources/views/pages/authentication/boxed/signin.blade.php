<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
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

                        <form method="post" id="adminLogins" action="{{route('user-login')}}" onsubmit="return validateForm()">
                                {{csrf_field()}}
    
                            <div class="row">
                                <div class="col-md-12 mb-3">

                                    @if(session()->has('error'))
                                        <div class="alert alert-danger">{{session()->get('error')}}</div>
                                    @endif

                                    @if(session()->has('success'))
                                        <div class="alert alert-success">{{session()->get('success')}}</div>
                                    @endif
                                    
                                    <h2>Sign In</h2>
                                    <p>Enter your email and password to login</p>
                                    
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" id="email" placeholder="Email address" class="form-control">
                                        <div id="emailError" class="text-danger p-1" style="display: none;">Email is required.</div>
                                    </div>
                                </div>
                               <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="password" placeholder="Password" class="form-control" style="border-right: none;">
                                           <span class="input-group-text toggle-password" style="cursor: pointer; background: white; border-left: none !important;">
    <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
</span>
                                        </div>
                                        <div id="passwordError" class="text-danger p-1" style="display: none;">Password is required.</div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">
                                            <label class="form-check-label" for="remember">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                
                                
                                <div class="col-12">
                                    <div class="mb-4">
                                        <button class="btn btn-dark w-100">SIGN IN</button>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="text-center">
                                        <a href="{{ route('password-reset') }}" style="color: #6c757d; text-decoration: none;">Forgot Password?</a>
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
    function validateForm() {
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;

        var emailError = document.getElementById("emailError");
        var passwordError = document.getElementById("passwordError");

        emailError.style.display = "none";
        passwordError.style.display = "none";

        if (email.trim() === "") {
            emailError.style.display = "block";
            return false;
        }

        if (password.trim() === "") {
            passwordError.style.display = "block";
            return false;
        }

        return true;
    }

    // Password toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('.toggle-password');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        if (togglePassword && passwordInput && toggleIcon) {
            togglePassword.addEventListener('click', function() {
                // Toggle the type attribute
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle the icon
                if (type === 'password') {
                    toggleIcon.classList.remove('bi-eye');
                    toggleIcon.classList.add('bi-eye-slash');
                } else {
                    toggleIcon.classList.remove('bi-eye-slash');
                    toggleIcon.classList.add('bi-eye');
                }
            });
        }
    });
</script>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>