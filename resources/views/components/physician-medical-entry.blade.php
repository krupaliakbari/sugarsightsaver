@props([
    'physicianRecord' => null,
    'fieldPrefix' => 'physician_record',
    'showTitle' => true
])

@if($showTitle)
<!-- New Medical Fields -->
<div class="row mb-3">
    <div class="col-12">
        <h6 class="text-primary mb-3">Additional Medical Information</h6>
    </div>
</div>
@endif

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
            <input class="form-check-input" type="checkbox" name="{{ $fieldPrefix }}[hypertension]" id="{{ $fieldPrefix }}_hypertension" value="1" 
                   {{ old($fieldPrefix . '.hypertension', $physicianRecord?->hypertension) ? 'checked' : '' }}>
            <label class="form-check-label" for="{{ $fieldPrefix }}_hypertension">Hypertension</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="{{ $fieldPrefix }}[dyslipidemia]" id="{{ $fieldPrefix }}_dyslipidemia" value="1" 
                   {{ old($fieldPrefix . '.dyslipidemia', $physicianRecord?->dyslipidemia) ? 'checked' : '' }}>
            <label class="form-check-label" for="{{ $fieldPrefix }}_dyslipidemia">Dyslipidemia</label>
        </div>
    </div>
</div>

<!-- Retinopathy -->
<div class="row mb-3">
    <div class="col-12">
        <label class="form-label">Retinopathy</label>
        <div class="mt-2">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="{{ $fieldPrefix }}[retinopathy]" id="{{ $fieldPrefix }}_retinopathy_yes" value="yes" 
                       {{ old($fieldPrefix . '.retinopathy', $physicianRecord?->retinopathy) == 'yes' ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $fieldPrefix }}_retinopathy_yes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="{{ $fieldPrefix }}[retinopathy]" id="{{ $fieldPrefix }}_retinopathy_no" value="no" 
                       {{ old($fieldPrefix . '.retinopathy', $physicianRecord?->retinopathy) == 'no' ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $fieldPrefix }}_retinopathy_no">No</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="{{ $fieldPrefix }}[retinopathy]" id="{{ $fieldPrefix }}_retinopathy_to_be_checked" value="to_be_checked" 
                       {{ old($fieldPrefix . '.retinopathy', $physicianRecord?->retinopathy) == 'to_be_checked' ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $fieldPrefix }}_retinopathy_to_be_checked">To be checked</label>
            </div>
        </div>
        @error($fieldPrefix . '.retinopathy')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<!-- Neuropathy -->
<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label">Neuropathy</label>
        <div class="mt-2">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="{{ $fieldPrefix }}[neuropathy]" id="{{ $fieldPrefix }}_neuropathy_peripheral" value="peripheral" 
                       {{ old($fieldPrefix . '.neuropathy', $physicianRecord?->neuropathy) == 'peripheral' ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $fieldPrefix }}_neuropathy_peripheral">Peripheral</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="{{ $fieldPrefix }}[neuropathy]" id="{{ $fieldPrefix }}_neuropathy_autonomic" value="autonomic" 
                       {{ old($fieldPrefix . '.neuropathy', $physicianRecord?->neuropathy) == 'autonomic' ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $fieldPrefix }}_neuropathy_autonomic">Autonomic</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="{{ $fieldPrefix }}[neuropathy]" id="{{ $fieldPrefix }}_neuropathy_no" value="no" 
                       {{ old($fieldPrefix . '.neuropathy', $physicianRecord?->neuropathy) == 'no' ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $fieldPrefix }}_neuropathy_no">No</label>
            </div>
        </div>
        @error($fieldPrefix . '.neuropathy')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="{{ $fieldPrefix }}_nephropathy" class="form-label">Nephropathy</label>
        <select class="form-select @error($fieldPrefix . '.nephropathy') is-invalid @enderror" id="{{ $fieldPrefix }}_nephropathy" name="{{ $fieldPrefix }}[nephropathy]">
            <option value="">Select</option>
            <option value="no" {{ old($fieldPrefix . '.nephropathy', $physicianRecord?->nephropathy) == 'no' ? 'selected' : '' }}>No</option>
            <option value="microalbuminuria" {{ old($fieldPrefix . '.nephropathy', $physicianRecord?->nephropathy) == 'microalbuminuria' ? 'selected' : '' }}>Microalbuminuria</option>
            <option value="proteinuria" {{ old($fieldPrefix . '.nephropathy', $physicianRecord?->nephropathy) == 'proteinuria' ? 'selected' : '' }}>Proteinuria</option>
            <option value="ckd" {{ old($fieldPrefix . '.nephropathy', $physicianRecord?->nephropathy) == 'ckd' ? 'selected' : '' }}>CKD</option>
            <option value="on_dialysis" {{ old($fieldPrefix . '.nephropathy', $physicianRecord?->nephropathy) == 'on_dialysis' ? 'selected' : '' }}>On Dialysis</option>
        </select>
        @error($fieldPrefix . '.nephropathy')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<!-- Cardiovascular and Foot Disease -->
<div class="row mb-3">
    <div class="col-md-6">
        <label for="{{ $fieldPrefix }}_cardiovascular" class="form-label">Cardiovascular</label>
        <select class="form-select @error($fieldPrefix . '.cardiovascular') is-invalid @enderror" id="{{ $fieldPrefix }}_cardiovascular" name="{{ $fieldPrefix }}[cardiovascular]">
            <option value="">Select</option>
            <option value="no" {{ old($fieldPrefix . '.cardiovascular', $physicianRecord?->cardiovascular) == 'no' ? 'selected' : '' }}>No</option>
            <option value="ihd" {{ old($fieldPrefix . '.cardiovascular', $physicianRecord?->cardiovascular) == 'ihd' ? 'selected' : '' }}>IHD</option>
            <option value="stroke" {{ old($fieldPrefix . '.cardiovascular', $physicianRecord?->cardiovascular) == 'stroke' ? 'selected' : '' }}>Stroke</option>
            <option value="pvd" {{ old($fieldPrefix . '.cardiovascular', $physicianRecord?->cardiovascular) == 'pvd' ? 'selected' : '' }}>PVD</option>
        </select>
        @error($fieldPrefix . '.cardiovascular')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="{{ $fieldPrefix }}_foot_disease" class="form-label">Foot Disease</label>
        <select class="form-select @error($fieldPrefix . '.foot_disease') is-invalid @enderror" id="{{ $fieldPrefix }}_foot_disease" name="{{ $fieldPrefix }}[foot_disease]">
            <option value="">Select</option>
            <option value="no" {{ old($fieldPrefix . '.foot_disease', $physicianRecord?->foot_disease) == 'no' ? 'selected' : '' }}>No</option>
            <option value="ulcer" {{ old($fieldPrefix . '.foot_disease', $physicianRecord?->foot_disease) == 'ulcer' ? 'selected' : '' }}>Ulcer</option>
            <option value="gangrene" {{ old($fieldPrefix . '.foot_disease', $physicianRecord?->foot_disease) == 'gangrene' ? 'selected' : '' }}>Gangrene</option>
            <option value="deformity" {{ old($fieldPrefix . '.foot_disease', $physicianRecord?->foot_disease) == 'deformity' ? 'selected' : '' }}>Deformity</option>
        </select>
        @error($fieldPrefix . '.foot_disease')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<!-- Others -->
<div class="row mb-3">
    <div class="col-12">
        <label class="form-label">Others</label>
        <div class="row">
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="{{ $fieldPrefix }}[others][]" id="{{ $fieldPrefix }}_infections" value="infections" 
                           {{ in_array('infections', old($fieldPrefix . '.others', $physicianRecord?->others ?? [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ $fieldPrefix }}_infections">Infections</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="{{ $fieldPrefix }}[others][]" id="{{ $fieldPrefix }}_dental_problems" value="dental_problems" 
                           {{ in_array('dental_problems', old($fieldPrefix . '.others', $physicianRecord?->others ?? [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ $fieldPrefix }}_dental_problems">Dental Problems</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="{{ $fieldPrefix }}[others][]" id="{{ $fieldPrefix }}_erectile_dysfunction" value="erectile_dysfunction" 
                           {{ in_array('erectile_dysfunction', old($fieldPrefix . '.others', $physicianRecord?->others ?? [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ $fieldPrefix }}_erectile_dysfunction">Erectile Dysfunction</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="{{ $fieldPrefix }}[others][]" id="{{ $fieldPrefix }}_other_condition" value="other" 
                           {{ in_array('other', old($fieldPrefix . '.others', $physicianRecord?->others ?? [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ $fieldPrefix }}_other_condition">Other</label>
                </div>
            </div>
        </div>
        @error($fieldPrefix . '.others')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<!-- Others Details -->
<div class="row mb-3" id="{{ $fieldPrefix }}_others_details_row" style="display: none;">
    <div class="col-12">
        <label for="{{ $fieldPrefix }}_others_details" class="form-label">Other Details</label>
        <input type="text" class="form-control @error($fieldPrefix . '.others_details') is-invalid @enderror" id="{{ $fieldPrefix }}_others_details" name="{{ $fieldPrefix }}[others_details]" 
               value="{{ old($fieldPrefix . '.others_details', $physicianRecord?->others_details) }}" 
               placeholder="Please specify other conditions...">
        @error($fieldPrefix . '.others_details')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<!-- HBA1C Range -->
<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label">HBA1C Range</label>
        <div class="mt-2">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="{{ $fieldPrefix }}[hba1c_range]" id="{{ $fieldPrefix }}_hba1c_less_7" value="less_than_7" 
                       {{ old($fieldPrefix . '.hba1c_range', $physicianRecord?->hba1c_range) == 'less_than_7' ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $fieldPrefix }}_hba1c_less_7">< 7</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="{{ $fieldPrefix }}[hba1c_range]" id="{{ $fieldPrefix }}_hba1c_7_to_9" value="7_to_9" 
                       {{ old($fieldPrefix . '.hba1c_range', $physicianRecord?->hba1c_range) == '7_to_9' ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $fieldPrefix }}_hba1c_7_to_9">7 to 9</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="{{ $fieldPrefix }}[hba1c_range]" id="{{ $fieldPrefix }}_hba1c_greater_9" value="greater_than_9" 
                       {{ old($fieldPrefix . '.hba1c_range', $physicianRecord?->hba1c_range) == 'greater_than_9' ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $fieldPrefix }}_hba1c_greater_9">> 9</label>
            </div>
        </div>
        @error($fieldPrefix . '.hba1c_range')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle "Other" checkbox functionality
    const otherCheckbox = document.getElementById('{{ $fieldPrefix }}_other_condition');
    const othersDetailsRow = document.getElementById('{{ $fieldPrefix }}_others_details_row');
    const othersDetailsInput = document.getElementById('{{ $fieldPrefix }}_others_details');
    
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
