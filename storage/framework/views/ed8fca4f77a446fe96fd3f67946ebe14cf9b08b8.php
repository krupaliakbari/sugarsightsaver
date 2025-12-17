<?php if (isset($component)) { $__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a = $component; } ?>
<?php $component = App\View\Components\BaseLayout::resolve(['scrollspy' => false] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('base-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\BaseLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

     <?php $__env->slot('pageTitle', null, []); ?> 
        <?php echo e($title); ?> 
     <?php $__env->endSlot(); ?>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
     <?php $__env->slot('headerFiles', null, []); ?> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/scss/light/assets/authentication/auth-boxed.scss']); ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/scss/dark/assets/authentication/auth-boxed.scss']); ?>
        <!--  END CUSTOM STYLE FILE  -->
     <?php $__env->endSlot(); ?>
    <!-- END GLOBAL MANDATORY STYLES -->
    
    <div class="auth-container d-flex">

        <div class="container mx-auto align-self-center">
    
            <div class="row">
    
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                    <div class="card mt-3 mb-3">
                        <div class="card-body">
                            
                            <!-- Logo Section -->
                            <div class="text-center mb-4">
                                <img src="<?php echo e(Vite::asset('resources/images/logo.png')); ?>" alt="Sugar Sight Logo" style="height: 80px; width: auto; margin-bottom: 1rem;">
                            </div>

                        <form method="post" id="adminLogins" action="<?php echo e(route('user-login')); ?>" onsubmit="return validateForm()">
                                <?php echo e(csrf_field()); ?>

    
                            <div class="row">
                                <div class="col-md-12 mb-3">

                                    <?php if(session()->has('error')): ?>
                                        <div class="alert alert-danger"><?php echo e(session()->get('error')); ?></div>
                                    <?php endif; ?>

                                    <?php if(session()->has('success')): ?>
                                        <div class="alert alert-success"><?php echo e(session()->get('success')); ?></div>
                                    <?php endif; ?>
                                    
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
                                        <a href="<?php echo e(route('password-reset')); ?>" style="color: #6c757d; text-decoration: none;">Forgot Password?</a>
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
     <?php $__env->slot('footerFiles', null, []); ?> 

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

     <?php $__env->endSlot(); ?>
    <!--  END CUSTOM SCRIPTS FILE  -->
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a)): ?>
<?php $component = $__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a; ?>
<?php unset($__componentOriginal6121507de807c98d4e75d845c5e3ae4201a89c9a); ?>
<?php endif; ?><?php /**PATH C:\Users\ANZO-KRUPALI\Desktop\sugarsightsaver1\resources\views/pages/authentication/boxed/signin.blade.php ENDPATH**/ ?>