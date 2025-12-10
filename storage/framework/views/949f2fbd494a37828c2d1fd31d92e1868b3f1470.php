<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.base-layout','data' => ['scrollspy' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('base-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['scrollspy' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>

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
    
            <div class="row justify-content-center">
    
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                    <div class="card mt-2 mb-2" style="border: none; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                        <div class="card-body" style="padding: 1.5rem;">
                            
                            <!-- Logo Section -->
                            <div class="text-center mb-2">
                                <img src="<?php echo e(Vite::asset('resources/images/logo.png')); ?>" alt="Sugar Sight Logo" style="height: 60px; width: auto; margin-bottom: 0.5rem;">
                                
                            </div>

                        <form method="post" id="doctorLogin" action="<?php echo e(route('doctor.login')); ?>" onsubmit="return validateDoctorForm()">
                                <?php echo e(csrf_field()); ?>

    
                            <div class="row">
                                <div class="col-md-12 mb-2">

                                    <?php if(session()->has('error')): ?>
                                        <div class="alert alert-danger" style="border-radius: 10px; border: none;"><?php echo e(session()->get('error')); ?></div>
                                    <?php endif; ?>

                                    <?php if(session()->has('success')): ?>
                                        <div class="alert alert-success" style="border-radius: 10px; border: none;"><?php echo e(session()->get('success')); ?></div>
                                    <?php endif; ?>
                                    
                                    <h2 style="color: #2E354C; font-weight: 700; text-align: center; margin-bottom: 0.25rem; font-size: 1.5rem;">Welcome Back</h2>
                                    <p style="color: #6c757d; text-align: center; margin-bottom: 0; font-size: 0.9rem;">Sign in to your doctor account</p>
                                    
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-2">
                                        <label class="form-label" style="color: #2E354C; font-weight: 600; margin-bottom: 0.25rem; font-size: 0.9rem;">Email Address</label>
                                        <input type="email" name="email" id="doctorEmail" placeholder="Enter your email address" class="form-control" value="<?php echo e(old('email')); ?>" style="border-radius: 10px; border: 2px solid #e9ecef; padding: 8px 12px; font-size: 14px; transition: all 0.3s ease;">
                                        <div id="doctorEmailError" class="text-danger p-1" style="display: none;">Email is required.</div>
                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-danger p-1"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                   
    <div class="mb-2">
        <label class="form-label" style="color: #2E354C; font-weight: 600; margin-bottom: 0.25rem; font-size: 0.9rem;">Password</label>
        <div class="input-group">
            <input type="password" name="password" id="doctorPassword" placeholder="Enter your password" class="form-control" style="border-radius: 10px 0 0 10px; border: 2px solid #e9ecef; padding: 8px 12px; font-size: 14px; transition: all 0.3s ease; border-right: none;">
            <span class="input-group-text toggle-password" style="background: white; border: 2px solid #e9ecef; border-left: none; border-radius: 0 10px 10px 0; cursor: pointer;">
                <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
            </span>
        </div>
        <div id="doctorPasswordError" class="text-danger p-1" style="display: none;">Password is required.</div>
        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="text-danger p-1"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

                                </div>

                                <div class="col-12">
                                    <div class="mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1" style="border-radius: 4px;">
                                            <label class="form-check-label" for="remember" style="color: #2E354C; font-weight: 500;">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-2">
                                        <button class="btn w-100" style="background: linear-gradient(135deg, #634299 0%, #8B5FBF 100%); border: none; border-radius: 10px; padding: 10px; font-size: 15px; font-weight: 600; color: white; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(99, 66, 153, 0.3);">SIGN IN</button>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="text-center mb-2">
                                        <a href="<?php echo e(route('doctor.forgot-password')); ?>" style="color: #634299; text-decoration: none; font-weight: 500; font-size: 0.9rem;">Forgot Password?</a>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="text-center mt-2" style="padding-top: 0.5rem; border-top: 1px solid #e9ecef;">
                                        <p style="color: #6c757d; margin-bottom: 0; font-size: 0.9rem;">Don't have an account? 
                                            <a href="<?php echo e(route('doctor.register.show')); ?>" style="color: #634299; text-decoration: none; font-weight: 600;">Register here</a>
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
     <?php $__env->slot('footerFiles', null, []); ?> 
    <script>
        function validateDoctorForm() {
            var email = document.getElementById("doctorEmail").value;
            var password = document.getElementById("doctorPassword").value;

            var emailError = document.getElementById("doctorEmailError");
            var passwordError = document.getElementById("doctorPasswordError");

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
            const passwordInput = document.getElementById('doctorPassword');
            const toggleIcon = document.getElementById('togglePasswordIcon');

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
        });
    </script>
 <?php $__env->endSlot(); ?>
    <!--  END CUSTOM SCRIPTS FILE  -->
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php /**PATH /home4/wethew2a/sugarsightsaver.in/resources/views/doctor/auth/login.blade.php ENDPATH**/ ?>