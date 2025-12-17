<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'physicianRecord' => null,
    'fieldPrefix' => 'physician_record',
    'showTitle' => true
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'physicianRecord' => null,
    'fieldPrefix' => 'physician_record',
    'showTitle' => true
]); ?>
<?php foreach (array_filter(([
    'physicianRecord' => null,
    'fieldPrefix' => 'physician_record',
    'showTitle' => true
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php if($showTitle): ?>
<!-- New Medical Fields -->
<div class="row mb-3">
    <div class="col-12">
        <h6 class="text-primary mb-3">Additional Medical Information</h6>
    </div>
</div>
<?php endif; ?>

<style>
    .error-message {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    padding: 8px 12px;
    background-color: #f8d7da;
    border-radius: 4px;
    /* No border, no close icon */
}

/* Remove Bootstrap invalid styling */
.form-control.is-invalid,
.form-select.is-invalid {
    border-color: #ced4da !important; /* Keep normal border color */
    background-image: none !important; /* Remove validation icon */
    box-shadow: none !important; /* Remove red glow */
}
</style>

<!-- Hypertension and Dyslipidemia -->
<div class="row mb-3">
    <div class="col-md-6">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="<?php echo e($fieldPrefix); ?>[hypertension]" id="<?php echo e($fieldPrefix); ?>_hypertension" value="1" 
                   <?php echo e(old($fieldPrefix . '.hypertension', $physicianRecord?->hypertension) ? 'checked' : ''); ?>>
            <label class="form-check-label" for="<?php echo e($fieldPrefix); ?>_hypertension">Hypertension</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="<?php echo e($fieldPrefix); ?>[dyslipidemia]" id="<?php echo e($fieldPrefix); ?>_dyslipidemia" value="1" 
                   <?php echo e(old($fieldPrefix . '.dyslipidemia', $physicianRecord?->dyslipidemia) ? 'checked' : ''); ?>>
            <label class="form-check-label" for="<?php echo e($fieldPrefix); ?>_dyslipidemia">Dyslipidemia</label>
        </div>
    </div>
</div>

<!-- Retinopathy -->
<div class="row mb-3">
    <div class="col-12">
        <label class="form-label">Retinopathy</label>
        <div class="mt-2">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="<?php echo e($fieldPrefix); ?>[retinopathy]" id="<?php echo e($fieldPrefix); ?>_retinopathy_yes" value="yes" 
                       <?php echo e(old($fieldPrefix . '.retinopathy', $physicianRecord?->retinopathy) == 'yes' ? 'checked' : ''); ?>>
                <label class="form-check-label" for="<?php echo e($fieldPrefix); ?>_retinopathy_yes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="<?php echo e($fieldPrefix); ?>[retinopathy]" id="<?php echo e($fieldPrefix); ?>_retinopathy_no" value="no" 
                       <?php echo e(old($fieldPrefix . '.retinopathy', $physicianRecord?->retinopathy) == 'no' ? 'checked' : ''); ?>>
                <label class="form-check-label" for="<?php echo e($fieldPrefix); ?>_retinopathy_no">No</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="<?php echo e($fieldPrefix); ?>[retinopathy]" id="<?php echo e($fieldPrefix); ?>_retinopathy_to_be_checked" value="to_be_checked" 
                       <?php echo e(old($fieldPrefix . '.retinopathy', $physicianRecord?->retinopathy) == 'to_be_checked' ? 'checked' : ''); ?>>
                <label class="form-check-label" for="<?php echo e($fieldPrefix); ?>_retinopathy_to_be_checked">To be checked</label>
            </div>
        </div>
        <?php $__errorArgs = [$fieldPrefix . '.retinopathy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>

<!-- Neuropathy -->
<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label">Neuropathy</label>
        <div class="mt-2">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="<?php echo e($fieldPrefix); ?>[neuropathy]" id="<?php echo e($fieldPrefix); ?>_neuropathy_peripheral" value="peripheral" 
                       <?php echo e(old($fieldPrefix . '.neuropathy', $physicianRecord?->neuropathy) == 'peripheral' ? 'checked' : ''); ?>>
                <label class="form-check-label" for="<?php echo e($fieldPrefix); ?>_neuropathy_peripheral">Peripheral</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="<?php echo e($fieldPrefix); ?>[neuropathy]" id="<?php echo e($fieldPrefix); ?>_neuropathy_autonomic" value="autonomic" 
                       <?php echo e(old($fieldPrefix . '.neuropathy', $physicianRecord?->neuropathy) == 'autonomic' ? 'checked' : ''); ?>>
                <label class="form-check-label" for="<?php echo e($fieldPrefix); ?>_neuropathy_autonomic">Autonomic</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="<?php echo e($fieldPrefix); ?>[neuropathy]" id="<?php echo e($fieldPrefix); ?>_neuropathy_no" value="no" 
                       <?php echo e(old($fieldPrefix . '.neuropathy', $physicianRecord?->neuropathy) == 'no' ? 'checked' : ''); ?>>
                <label class="form-check-label" for="<?php echo e($fieldPrefix); ?>_neuropathy_no">No</label>
            </div>
        </div>
        <?php $__errorArgs = [$fieldPrefix . '.neuropathy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="col-md-6">
        <label for="<?php echo e($fieldPrefix); ?>_nephropathy" class="form-label">Nephropathy</label>
        <select class="form-select <?php $__errorArgs = [$fieldPrefix . '.nephropathy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="<?php echo e($fieldPrefix); ?>_nephropathy" name="<?php echo e($fieldPrefix); ?>[nephropathy]">
            <option value="">Select</option>
            <option value="no" <?php echo e(old($fieldPrefix . '.nephropathy', $physicianRecord?->nephropathy) == 'no' ? 'selected' : ''); ?>>No</option>
            <option value="microalbuminuria" <?php echo e(old($fieldPrefix . '.nephropathy', $physicianRecord?->nephropathy) == 'microalbuminuria' ? 'selected' : ''); ?>>Microalbuminuria</option>
            <option value="proteinuria" <?php echo e(old($fieldPrefix . '.nephropathy', $physicianRecord?->nephropathy) == 'proteinuria' ? 'selected' : ''); ?>>Proteinuria</option>
            <option value="ckd" <?php echo e(old($fieldPrefix . '.nephropathy', $physicianRecord?->nephropathy) == 'ckd' ? 'selected' : ''); ?>>CKD</option>
            <option value="on_dialysis" <?php echo e(old($fieldPrefix . '.nephropathy', $physicianRecord?->nephropathy) == 'on_dialysis' ? 'selected' : ''); ?>>On Dialysis</option>
        </select>
        <?php $__errorArgs = [$fieldPrefix . '.nephropathy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>

<!-- Cardiovascular and Foot Disease -->
<div class="row mb-3">
    <div class="col-md-6">
        <label for="<?php echo e($fieldPrefix); ?>_cardiovascular" class="form-label">Cardiovascular</label>
        <select class="form-select <?php $__errorArgs = [$fieldPrefix . '.cardiovascular'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="<?php echo e($fieldPrefix); ?>_cardiovascular" name="<?php echo e($fieldPrefix); ?>[cardiovascular]">
            <option value="">Select</option>
            <option value="no" <?php echo e(old($fieldPrefix . '.cardiovascular', $physicianRecord?->cardiovascular) == 'no' ? 'selected' : ''); ?>>No</option>
            <option value="ihd" <?php echo e(old($fieldPrefix . '.cardiovascular', $physicianRecord?->cardiovascular) == 'ihd' ? 'selected' : ''); ?>>IHD</option>
            <option value="stroke" <?php echo e(old($fieldPrefix . '.cardiovascular', $physicianRecord?->cardiovascular) == 'stroke' ? 'selected' : ''); ?>>Stroke</option>
            <option value="pvd" <?php echo e(old($fieldPrefix . '.cardiovascular', $physicianRecord?->cardiovascular) == 'pvd' ? 'selected' : ''); ?>>PVD</option>
        </select>
        <?php $__errorArgs = [$fieldPrefix . '.cardiovascular'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="col-md-6">
        <label for="<?php echo e($fieldPrefix); ?>_foot_disease" class="form-label">Foot Disease</label>
        <select class="form-select <?php $__errorArgs = [$fieldPrefix . '.foot_disease'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="<?php echo e($fieldPrefix); ?>_foot_disease" name="<?php echo e($fieldPrefix); ?>[foot_disease]">
            <option value="">Select</option>
            <option value="no" <?php echo e(old($fieldPrefix . '.foot_disease', $physicianRecord?->foot_disease) == 'no' ? 'selected' : ''); ?>>No</option>
            <option value="ulcer" <?php echo e(old($fieldPrefix . '.foot_disease', $physicianRecord?->foot_disease) == 'ulcer' ? 'selected' : ''); ?>>Ulcer</option>
            <option value="gangrene" <?php echo e(old($fieldPrefix . '.foot_disease', $physicianRecord?->foot_disease) == 'gangrene' ? 'selected' : ''); ?>>Gangrene</option>
            <option value="deformity" <?php echo e(old($fieldPrefix . '.foot_disease', $physicianRecord?->foot_disease) == 'deformity' ? 'selected' : ''); ?>>Deformity</option>
        </select>
        <?php $__errorArgs = [$fieldPrefix . '.foot_disease'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>

<!-- Others -->
<div class="row mb-3">
    <div class="col-12">
        <label class="form-label">Others</label>
        <div class="row">
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="<?php echo e($fieldPrefix); ?>[others][]" id="<?php echo e($fieldPrefix); ?>_infections" value="infections" 
                           <?php echo e(in_array('infections', old($fieldPrefix . '.others', $physicianRecord?->others ?? [])) ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="<?php echo e($fieldPrefix); ?>_infections">Infections</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="<?php echo e($fieldPrefix); ?>[others][]" id="<?php echo e($fieldPrefix); ?>_dental_problems" value="dental_problems" 
                           <?php echo e(in_array('dental_problems', old($fieldPrefix . '.others', $physicianRecord?->others ?? [])) ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="<?php echo e($fieldPrefix); ?>_dental_problems">Dental Problems</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="<?php echo e($fieldPrefix); ?>[others][]" id="<?php echo e($fieldPrefix); ?>_erectile_dysfunction" value="erectile_dysfunction" 
                           <?php echo e(in_array('erectile_dysfunction', old($fieldPrefix . '.others', $physicianRecord?->others ?? [])) ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="<?php echo e($fieldPrefix); ?>_erectile_dysfunction">Erectile Dysfunction</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="<?php echo e($fieldPrefix); ?>[others][]" id="<?php echo e($fieldPrefix); ?>_other_condition" value="other" 
                           <?php echo e(in_array('other', old($fieldPrefix . '.others', $physicianRecord?->others ?? [])) ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="<?php echo e($fieldPrefix); ?>_other_condition">Other</label>
                </div>
            </div>
        </div>
        <?php $__errorArgs = [$fieldPrefix . '.others'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>

<!-- Others Details -->
<div class="row mb-3" id="<?php echo e($fieldPrefix); ?>_others_details_row" style="display: none;">
    <div class="col-12">
        <label for="<?php echo e($fieldPrefix); ?>_others_details" class="form-label">Other Details</label>
        <input type="text" class="form-control <?php $__errorArgs = [$fieldPrefix . '.others_details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="<?php echo e($fieldPrefix); ?>_others_details" name="<?php echo e($fieldPrefix); ?>[others_details]" 
               value="<?php echo e(old($fieldPrefix . '.others_details', $physicianRecord?->others_details)); ?>" 
               placeholder="Please specify other conditions...">
        <?php $__errorArgs = [$fieldPrefix . '.others_details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>

<!-- HBA1C Range -->
<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label">HBA1C Range</label>
        <div class="mt-2">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="<?php echo e($fieldPrefix); ?>[hba1c_range]" id="<?php echo e($fieldPrefix); ?>_hba1c_less_7" value="less_than_7" 
                       <?php echo e(old($fieldPrefix . '.hba1c_range', $physicianRecord?->hba1c_range) == 'less_than_7' ? 'checked' : ''); ?>>
                <label class="form-check-label" for="<?php echo e($fieldPrefix); ?>_hba1c_less_7">< 7</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="<?php echo e($fieldPrefix); ?>[hba1c_range]" id="<?php echo e($fieldPrefix); ?>_hba1c_7_to_9" value="7_to_9" 
                       <?php echo e(old($fieldPrefix . '.hba1c_range', $physicianRecord?->hba1c_range) == '7_to_9' ? 'checked' : ''); ?>>
                <label class="form-check-label" for="<?php echo e($fieldPrefix); ?>_hba1c_7_to_9">7 to 9</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="<?php echo e($fieldPrefix); ?>[hba1c_range]" id="<?php echo e($fieldPrefix); ?>_hba1c_greater_9" value="greater_than_9" 
                       <?php echo e(old($fieldPrefix . '.hba1c_range', $physicianRecord?->hba1c_range) == 'greater_than_9' ? 'checked' : ''); ?>>
                <label class="form-check-label" for="<?php echo e($fieldPrefix); ?>_hba1c_greater_9">> 9</label>
            </div>
        </div>
        <?php $__errorArgs = [$fieldPrefix . '.hba1c_range'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle "Other" checkbox functionality
    const otherCheckbox = document.getElementById('<?php echo e($fieldPrefix); ?>_other_condition');
    const othersDetailsRow = document.getElementById('<?php echo e($fieldPrefix); ?>_others_details_row');
    const othersDetailsInput = document.getElementById('<?php echo e($fieldPrefix); ?>_others_details');
    
    if (otherCheckbox && othersDetailsRow && othersDetailsInput) {
        otherCheckbox.addEventListener('change', function() {
            if (this.checked) {
                othersDetailsRow.style.display = 'block';
            } else {
                othersDetailsRow.style.display = 'none';
                othersDetailsInput.value = '';
            }
        });

        // Check if "Other" is already selected on page load
        if (otherCheckbox.checked) {
            othersDetailsRow.style.display = 'block';
        }
    }
});
</script>
<?php /**PATH C:\Users\ANZO-KRUPALI\Desktop\sugarsightsaver1\resources\views/components/physician-medical-entry.blade.php ENDPATH**/ ?>