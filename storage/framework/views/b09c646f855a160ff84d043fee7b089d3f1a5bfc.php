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

                <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10 col-12 d-flex flex-column align-self-center mx-auto">
                    <div class="card mt-2 mb-2" style="border: none; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                        <div class="card-body" style="padding: 1.5rem;">

                            <!-- Logo Section -->
                            <div class="text-center mb-2">
                                <a href="/" title="Go to Home">
                                    <img src="<?php echo e(Vite::asset('resources/images/logo.png')); ?>" alt="Sugar Sight Logo" style="height: 60px; width: auto; margin-bottom: 0.5rem; cursor: pointer;">
                                </a>
                            </div>

                        <form method="post" id="doctorRegister" action="<?php echo e(route('doctor.register')); ?>" onsubmit="return validateDoctorRegisterForm()">
                                <?php echo e(csrf_field()); ?>


                            <div class="row">
                                <div class="col-md-12 mb-2">

                                    <?php if(session()->has('error')): ?>
                                        <div class="alert alert-danger" style="border-radius: 10px; border: none;"><?php echo e(session()->get('error')); ?></div>
                                    <?php endif; ?>

                                    <?php if(session()->has('success')): ?>
                                        <div class="alert alert-success" style="border-radius: 10px; border: none;"><?php echo e(session()->get('success')); ?></div>
                                    <?php endif; ?>

                                    <h2 style="color: #2E354C; font-weight: 700; text-align: center; margin-bottom: 0.25rem; font-size: 1.5rem;">Doctor Registration</h2>
                                    <p style="color: #6c757d; text-align: center; margin-bottom: 0; font-size: 0.9rem;">Create your account to access doctor portal</p>

                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label" style="color: #2E354C; font-weight: 600; margin-bottom: 0.25rem; font-size: 0.9rem;">Full Name <span style="color: #dc3545;">*</span></label>
                                        <input type="text" name="name" id="doctorName" placeholder="Enter your full name" class="form-control" value="<?php echo e(old('name')); ?>" style="border-radius: 10px; border: 2px solid #e9ecef; padding: 8px 12px; font-size: 14px; transition: all 0.3s ease;">
                                        <div id="doctorNameError" class="text-danger p-1" style="display: none;">Name is required.</div>
                                        <?php $__errorArgs = ['name'];
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
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label" style="color: #2E354C; font-weight: 600; margin-bottom: 0.25rem; font-size: 0.9rem;">Email Address <span style="color: #dc3545;">*</span></label>
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
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label" style="color: #2E354C; font-weight: 600; margin-bottom: 0.25rem; font-size: 0.9rem;">Phone Number <span style="color: #dc3545;">*</span></label>
                                        <input type="number" name="phone" id="doctorPhone" placeholder="Enter your Phone Number" class="form-control"  maxlength="10"
       oninput="validatePhoneInput(this)"  value="<?php echo e(old('phone')); ?>" style="border-radius: 10px; border: 2px solid #e9ecef; padding: 8px 12px; font-size: 14px; transition: all 0.3s ease;">
                                        <div id="doctorPhoneError" class="text-danger p-1" style="display: none;">Phone Number is required.</div>
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
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label" style="color: #2E354C; font-weight: 600; margin-bottom: 0.25rem; font-size: 0.9rem;">Password <span style="color: #dc3545;">*</span></label>
                                        <input type="password" name="password" id="doctorPassword" placeholder="Enter your password" class="form-control" style="border-radius: 10px; border: 2px solid #e9ecef; padding: 8px 12px; font-size: 14px; transition: all 0.3s ease;">
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
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label" style="color: #2E354C; font-weight: 600; margin-bottom: 0.25rem; font-size: 0.9rem;">Confirm Password <span style="color: #dc3545;">*</span></label>
                                        <input type="password" name="password_confirmation" id="doctorPasswordConfirm" placeholder="Confirm your password" class="form-control" style="border-radius: 10px; border: 2px solid #e9ecef; padding: 8px 12px; font-size: 14px; transition: all 0.3s ease;">
                                        <div id="doctorPasswordConfirmError" class="text-danger p-1" style="display: none;">Password confirmation is required.</div>
                                        <?php $__errorArgs = ['password_confirmation'];
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
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label" style="color: #2E354C; font-weight: 600; margin-bottom: 0.25rem; font-size: 0.9rem;">Hospital Name <span style="color: #dc3545;">*</span></label>
                                        <input type="text" name="hospital_name" id="hospitalName" placeholder="Enter hospital name" class="form-control" value="<?php echo e(old('hospital_name')); ?>" style="border-radius: 10px; border: 2px solid #e9ecef; padding: 8px 12px; font-size: 14px; transition: all 0.3s ease;">
                                        <div id="hospitalNameError" class="text-danger p-1" style="display: none;">Hospital name is required.</div>
                                        <?php $__errorArgs = ['hospital_name'];
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
                                <div class="col-md-12">
                                    <div class="mb-2">
                                        <label class="form-label" style="color: #2E354C; font-weight: 600; margin-bottom: 0.25rem; font-size: 0.9rem;">Doctor Type <span style="color: #dc3545;">*</span></label>
                                        <select name="doctor_type" id="doctorType" class="form-select" style="border-radius: 10px; border: 2px solid #e9ecef; padding: 8px 12px; font-size: 14px; transition: all 0.3s ease;">
                                            <option value="">Select Doctor Type</option>
                                       <option value="">Select Doctor Type</option>
                      <option value="diabetes_treating"
    <?php echo e((old('doctor_type') == 'diabetes_treating' || $type == 'diabetes_treating') ? 'selected' : ''); ?>>
    Diabetes-Treating Physician
</option>

<option value="ophthalmologist"
    <?php echo e((old('doctor_type') == 'ophthalmologist' || $type == 'ophthalmologist') ? 'selected' : ''); ?>>
    Ophthalmologist
</option>
                                        </select>
                                        <div id="doctorTypeError" class="text-danger p-1" style="display: none;">Doctor type is required.</div>
                                        <?php $__errorArgs = ['doctor_type'];
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
                                        <label class="form-label" style="color: #2E354C; font-weight: 600; margin-bottom: 0.25rem; font-size: 0.9rem;">Address <span style="color: #dc3545;">*</span></label>
                                        <textarea name="address" id="address" placeholder="Enter your address" class="form-control" rows="2" style="border-radius: 10px; border: 2px solid #e9ecef; padding: 8px 12px; font-size: 14px; transition: all 0.3s ease;"><?php echo e(old('address')); ?></textarea>
                                        <div id="addressError" class="text-danger p-1" style="display: none;">Address is required.</div>
                                        <?php $__errorArgs = ['address'];
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
                                        <label class="form-label" style="color: #2E354C; font-weight: 600; margin-bottom: 0.25rem; font-size: 0.9rem;">Qualification <span style="color: #dc3545;">*</span></label>
                                        <textarea name="qualification" id="qualification" placeholder="Enter your qualifications" class="form-control" rows="2" style="border-radius: 10px; border: 2px solid #e9ecef; padding: 8px 12px; font-size: 14px; transition: all 0.3s ease;"><?php echo e(old('qualification')); ?></textarea>
                                        <div id="qualificationError" class="text-danger p-1" style="display: none;">Qualification is required.</div>
                                        <?php $__errorArgs = ['qualification'];
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
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label" style="color: #2E354C; font-weight: 600; margin-bottom: 0.25rem; font-size: 0.9rem;">Medical Council Registration Number <span style="color: #dc3545;">*</span></label>
                                        <input type="text" name="medical_council_registration_number" id="medicalCouncilRegNumber" placeholder="Enter your medical council registration number" class="form-control" value="<?php echo e(old('medical_council_registration_number')); ?>" style="border-radius: 10px; border: 2px solid #e9ecef; padding: 8px 12px; font-size: 14px; transition: all 0.3s ease;">
                                        <div id="medicalCouncilRegNumberError" class="text-danger p-1" style="display: none;">Medical Council Registration Number is required.</div>
                                        <?php $__errorArgs = ['medical_council_registration_number'];
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
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label" style="color: #2E354C; font-weight: 600; margin-bottom: 0.25rem; font-size: 0.9rem;">State <span style="color: #dc3545;">*</span></label>
                                        <select name="state" id="state" class="form-select" style="border-radius: 10px; border: 2px solid #e9ecef; padding: 8px 12px; font-size: 14px; transition: all 0.3s ease;">
                                            <option value="">Select State</option>
                                            <option value="Andhra Pradesh" <?php echo e(old('state') == 'Andhra Pradesh' ? 'selected' : ''); ?>>Andhra Pradesh</option>
                                            <option value="Arunachal Pradesh" <?php echo e(old('state') == 'Arunachal Pradesh' ? 'selected' : ''); ?>>Arunachal Pradesh</option>
                                            <option value="Assam" <?php echo e(old('state') == 'Assam' ? 'selected' : ''); ?>>Assam</option>
                                            <option value="Bihar" <?php echo e(old('state') == 'Bihar' ? 'selected' : ''); ?>>Bihar</option>
                                            <option value="Chhattisgarh" <?php echo e(old('state') == 'Chhattisgarh' ? 'selected' : ''); ?>>Chhattisgarh</option>
                                            <option value="Goa" <?php echo e(old('state') == 'Goa' ? 'selected' : ''); ?>>Goa</option>
                                            <option value="Gujarat" <?php echo e(old('state') == 'Gujarat' ? 'selected' : ''); ?>>Gujarat</option>
                                            <option value="Haryana" <?php echo e(old('state') == 'Haryana' ? 'selected' : ''); ?>>Haryana</option>
                                            <option value="Himachal Pradesh" <?php echo e(old('state') == 'Himachal Pradesh' ? 'selected' : ''); ?>>Himachal Pradesh</option>
                                            <option value="Jharkhand" <?php echo e(old('state') == 'Jharkhand' ? 'selected' : ''); ?>>Jharkhand</option>
                                            <option value="Karnataka" <?php echo e(old('state') == 'Karnataka' ? 'selected' : ''); ?>>Karnataka</option>
                                            <option value="Kerala" <?php echo e(old('state') == 'Kerala' ? 'selected' : ''); ?>>Kerala</option>
                                            <option value="Madhya Pradesh" <?php echo e(old('state') == 'Madhya Pradesh' ? 'selected' : ''); ?>>Madhya Pradesh</option>
                                            <option value="Maharashtra" <?php echo e(old('state') == 'Maharashtra' ? 'selected' : ''); ?>>Maharashtra</option>
                                            <option value="Manipur" <?php echo e(old('state') == 'Manipur' ? 'selected' : ''); ?>>Manipur</option>
                                            <option value="Meghalaya" <?php echo e(old('state') == 'Meghalaya' ? 'selected' : ''); ?>>Meghalaya</option>
                                            <option value="Mizoram" <?php echo e(old('state') == 'Mizoram' ? 'selected' : ''); ?>>Mizoram</option>
                                            <option value="Nagaland" <?php echo e(old('state') == 'Nagaland' ? 'selected' : ''); ?>>Nagaland</option>
                                            <option value="Odisha" <?php echo e(old('state') == 'Odisha' ? 'selected' : ''); ?>>Odisha</option>
                                            <option value="Punjab" <?php echo e(old('state') == 'Punjab' ? 'selected' : ''); ?>>Punjab</option>
                                            <option value="Rajasthan" <?php echo e(old('state') == 'Rajasthan' ? 'selected' : ''); ?>>Rajasthan</option>
                                            <option value="Sikkim" <?php echo e(old('state') == 'Sikkim' ? 'selected' : ''); ?>>Sikkim</option>
                                            <option value="Tamil Nadu" <?php echo e(old('state') == 'Tamil Nadu' ? 'selected' : ''); ?>>Tamil Nadu</option>
                                            <option value="Telangana" <?php echo e(old('state') == 'Telangana' ? 'selected' : ''); ?>>Telangana</option>
                                            <option value="Tripura" <?php echo e(old('state') == 'Tripura' ? 'selected' : ''); ?>>Tripura</option>
                                            <option value="Uttar Pradesh" <?php echo e(old('state') == 'Uttar Pradesh' ? 'selected' : ''); ?>>Uttar Pradesh</option>
                                            <option value="Uttarakhand" <?php echo e(old('state') == 'Uttarakhand' ? 'selected' : ''); ?>>Uttarakhand</option>
                                            <option value="West Bengal" <?php echo e(old('state') == 'West Bengal' ? 'selected' : ''); ?>>West Bengal</option>
                                            <option value="Andaman and Nicobar Islands" <?php echo e(old('state') == 'Andaman and Nicobar Islands' ? 'selected' : ''); ?>>Andaman and Nicobar Islands</option>
                                            <option value="Chandigarh" <?php echo e(old('state') == 'Chandigarh' ? 'selected' : ''); ?>>Chandigarh</option>
                                            <option value="Dadra and Nagar Haveli and Daman and Diu" <?php echo e(old('state') == 'Dadra and Nagar Haveli and Daman and Diu' ? 'selected' : ''); ?>>Dadra and Nagar Haveli and Daman and Diu</option>
                                            <option value="Delhi" <?php echo e(old('state') == 'Delhi' ? 'selected' : ''); ?>>Delhi</option>
                                            <option value="Jammu and Kashmir" <?php echo e(old('state') == 'Jammu and Kashmir' ? 'selected' : ''); ?>>Jammu and Kashmir</option>
                                            <option value="Ladakh" <?php echo e(old('state') == 'Ladakh' ? 'selected' : ''); ?>>Ladakh</option>
                                            <option value="Lakshadweep" <?php echo e(old('state') == 'Lakshadweep' ? 'selected' : ''); ?>>Lakshadweep</option>
                                            <option value="Puducherry" <?php echo e(old('state') == 'Puducherry' ? 'selected' : ''); ?>>Puducherry</option>
                                        </select>
                                        <div id="stateError" class="text-danger p-1" style="display: none;">State is required</div>
                                        <?php $__errorArgs = ['state'];
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
                                    <div class="mb-2 mt-3">
                                        <button class="btn w-100" style="background: linear-gradient(135deg, #634299 0%, #8B5FBF 100%); border: none; border-radius: 10px; padding: 10px; font-size: 15px; font-weight: 600; color: white; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(99, 66, 153, 0.3);">REGISTER</button>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="text-center mt-2" style="padding-top: 0.5rem; border-top: 1px solid #e9ecef;">
                                        <p style="color: #6c757d; margin-bottom: 0; font-size: 0.9rem;">Already have an account?
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
    // Real-time validation error hiding
    document.addEventListener('DOMContentLoaded', function() {
        // Preselect doctor type from URL query parameter
        const urlParams = new URLSearchParams(window.location.search);
        const doctorTypeParam = urlParams.get('doctor_type');
        if (doctorTypeParam) {
            const doctorTypeSelect = document.getElementById('doctorType');
            if (doctorTypeSelect) {
                doctorTypeSelect.value = doctorTypeParam;
            }
        }

        // Get all form fields
        const fields = [
            { input: 'doctorName', error: 'doctorNameError' },
            { input: 'doctorEmail', error: 'doctorEmailError' },
            { input: 'doctorPhone', error: 'doctorPhoneError' },
            { input: 'doctorPassword', error: 'doctorPasswordError' },
            { input: 'doctorPasswordConfirm', error: 'doctorPasswordConfirmError' },
            { input: 'hospitalName', error: 'hospitalNameError' },
            { input: 'doctorType', error: 'doctorTypeError' },
            { input: 'address', error: 'addressError' },
            { input: 'qualification', error: 'qualificationError' },
            { input: 'medicalCouncilRegNumber', error: 'medicalCouncilRegNumberError' },
            { input: 'state', error: 'stateError' }
        ];

        // Add event listeners to hide errors when user starts typing
        fields.forEach(field => {
            const inputElement = document.getElementById(field.input);
            const errorElement = document.getElementById(field.error);

            if (inputElement && errorElement) {
                inputElement.addEventListener('input', function() {
                    errorElement.style.display = 'none';
                });

                inputElement.addEventListener('blur', function() {
                    errorElement.style.display = 'none';
                });
            }
        });
    });

    function validateDoctorRegisterForm() {
        var name = document.getElementById("doctorName").value;
        var email = document.getElementById("doctorEmail").value;
        var phone = document.getElementById("doctorPhone").value;
        var password = document.getElementById("doctorPassword").value;
        var passwordConfirm = document.getElementById("doctorPasswordConfirm").value;
        var hospitalName = document.getElementById("hospitalName").value;
        var doctorType = document.getElementById("doctorType").value;
        var address = document.getElementById("address").value;
        var qualification = document.getElementById("qualification").value;
        var medicalCouncilRegNumber = document.getElementById("medicalCouncilRegNumber").value;
        var state = document.getElementById("state").value;

        var nameError = document.getElementById("doctorNameError");
        var emailError = document.getElementById("doctorEmailError");
        var phoneError = document.getElementById("doctorPhoneError");
        var passwordError = document.getElementById("doctorPasswordError");
        var passwordConfirmError = document.getElementById("doctorPasswordConfirmError");
        var hospitalNameError = document.getElementById("hospitalNameError");
        var doctorTypeError = document.getElementById("doctorTypeError");
        var addressError = document.getElementById("addressError");
        var qualificationError = document.getElementById("qualificationError");
        var medicalCouncilRegNumberError = document.getElementById("medicalCouncilRegNumberError");
        var stateError = document.getElementById("stateError");

        // Hide all errors
        nameError.style.display = "none";
        emailError.style.display = "none";
        passwordError.style.display = "none";
        passwordConfirmError.style.display = "none";
        hospitalNameError.style.display = "none";
        doctorTypeError.style.display = "none";
        addressError.style.display = "none";
        qualificationError.style.display = "none";
        medicalCouncilRegNumberError.style.display = "none";
        stateError.style.display = "none";

        var isValid = true;

        if (name.trim() === "") {
            nameError.innerHTML = "Name is required.";
            nameError.style.display = "block";
            isValid = false;
        }
if (phone.trim() === "") {
    phoneError.innerHTML = "Phone Number is required.";
    phoneError.style.display = "block";
    isValid = false;
} else if (!/^\d{10}$/.test(phone)) {
    phoneError.innerHTML = "Phone Number must be exactly 10 digits.";
    phoneError.style.display = "block";
    isValid = false;
}

        if (email.trim() === "") {
            emailError.innerHTML = "Email is required.";
            emailError.style.display = "block";
            isValid = false;
        } else if (!isValidEmail(email)) {
            emailError.innerHTML = "Please enter valid email.";
            emailError.style.display = "block";
            isValid = false;
        }

        if (password.trim() === "") {
            passwordError.innerHTML = "Password is required.";
            passwordError.style.display = "block";
            isValid = false;
        } else if (password.length < 8) {
            passwordError.innerHTML = "Password must be at least 8 characters long.";
            passwordError.style.display = "block";
            isValid = false;
        }

        if (passwordConfirm.trim() === "") {
            passwordConfirmError.innerHTML = "Confirm password is required.";
            passwordConfirmError.style.display = "block";
            isValid = false;
        } else if (password !== passwordConfirm) {
            passwordConfirmError.innerHTML = "Password and confirm password does not match.";
            passwordConfirmError.style.display = "block";
            isValid = false;
        }

        if (hospitalName.trim() === "") {
            hospitalNameError.innerHTML = "Hospital name is required.";
            hospitalNameError.style.display = "block";
            isValid = false;
        }

        if (doctorType === "") {
            doctorTypeError.innerHTML = "Doctor type is required.";
            doctorTypeError.style.display = "block";
            isValid = false;
        }

        if (address.trim() === "") {
            addressError.innerHTML = "Address is required.";
            addressError.style.display = "block";
            isValid = false;
        }

        if (qualification.trim() === "") {
            qualificationError.innerHTML = "Qualification is required.";
            qualificationError.style.display = "block";
            isValid = false;
        }

        if (medicalCouncilRegNumber.trim() === "") {
            medicalCouncilRegNumberError.innerHTML = "Medical Council Registration Number is required.";
            medicalCouncilRegNumberError.style.display = "block";
            isValid = false;
        }

        if (state.trim() === "") {
            stateError.innerHTML = "State is required.";
            stateError.style.display = "block";
            isValid = false;
        }

        return isValid;
    }

    function isValidEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function validatePhoneInput(input) {
    // Remove non-numeric characters
    input.value = input.value.replace(/[^0-9]/g, '');

    // Limit to 10 digits
    if (input.value.length > 10) {
        input.value = input.value.slice(0, 10);
    }
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
<?php /**PATH /home4/wethew2a/sugarsightsaver.in/resources/views/doctor/auth/register.blade.php ENDPATH**/ ?>