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
                    <div class="card mt-3 mb-3" style="border: none; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                        <div class="card-body" style="padding: 3rem;">
                            
                            <!-- Logo Section -->
                            <div class="text-center mb-4">
                                <img src="<?php echo e(Vite::asset('resources/images/logo.png')); ?>" alt="Sugar Sight Logo" style="height: 80px; width: auto; margin-bottom: 1rem;">
                                
                            </div>

                        <form method="post" id="doctorForgotPassword" action="<?php echo e(route('doctor.forgot-password')); ?>" onsubmit="return validateForgotPasswordForm()">
                                <?php echo e(csrf_field()); ?>

    
                            <div class="row">
                                <div class="col-md-12 mb-4">

                                    <?php if(session()->has('error')): ?>
                                        <div class="alert alert-danger" style="border-radius: 10px; border: none;"><?php echo e(session()->get('error')); ?></div>
                                    <?php endif; ?>

                                    <?php if(session()->has('success')): ?>
                                        <div class="alert alert-success" style="border-radius: 10px; border: none;"><?php echo e(session()->get('success')); ?></div>
                                    <?php endif; ?>
                                    
                                    <h2 style="color: #2E354C; font-weight: 700; text-align: center; margin-bottom: 0.5rem;">Forgot Password?</h2>
                                    <p style="color: #6c757d; text-align: center; margin-bottom: 0;">Enter your email address and we'll send you a link to reset your password</p>
                                    
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label" style="color: #2E354C; font-weight: 600; margin-bottom: 0.5rem;">Email Address</label>
                                        <input type="email" name="email" id="forgotEmail" placeholder="Enter your email address" class="form-control" value="<?php echo e(old('email')); ?>" style="border-radius: 10px; border: 2px solid #e9ecef; padding: 12px 16px; font-size: 16px; transition: all 0.3s ease;">
                                        <div id="forgotEmailError" class="text-danger p-1" style="display: none;">Email is required.</div>
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
                                    <div class="mb-4">
                                        <button class="btn w-100" style="background: linear-gradient(135deg, #634299 0%, #8B5FBF 100%); border: none; border-radius: 10px; padding: 12px; font-size: 16px; font-weight: 600; color: white; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(99, 66, 153, 0.3);">SEND RESET LINK</button>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="text-center mt-4" style="padding-top: 1rem; border-top: 1px solid #e9ecef;">
                                        <p style="color: #6c757d; margin-bottom: 0;">Remember your password? 
                                            <a href="<?php echo e(route('doctor.login')); ?>" style="color: #634299; text-decoration: none; font-weight: 600;">Sign in here</a>
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

     <?php $__env->endSlot(); ?>
    <!--  END CUSTOM SCRIPTS FILE  -->
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php /**PATH /home4/wethew2a/sugarsightsaver.in/resources/views/doctor/auth/forgot-password.blade.php ENDPATH**/ ?>