/**
 * Centralized BMI Interpretation JavaScript
 * This file provides BMI calculation and interpretation functionality
 * for all patient forms in the Sugar Sight application.
 */

// BMI Interpretation Class
class BMIIterpretation {
    constructor() {
        this.ranges = {
            underweight: { min: 0, max: 18.4, text: 'Underweight', class: 'badge bg-warning' },
            normal: { min: 18.5, max: 22.9, text: 'Normal Weight', class: 'badge bg-success' },
            overweight: { min: 23.0, max: 24.9, text: 'Overweight', class: 'badge bg-warning' },
            obesity1: { min: 25.0, max: 29.9, text: 'Obesity Grade 1', class: 'badge bg-danger' },
            obesity2: { min: 30.0, max: 34.9, text: 'Obesity Grade 2', class: 'badge bg-danger' },
            obesity3: { min: 35.0, max: 999, text: 'Obesity Grade 3', class: 'badge bg-danger' }
        };
    }

    /**
     * Calculate BMI from height and weight
     * @param {number} height - Height in meters
     * @param {number} weight - Weight in kilograms
     * @returns {number} BMI value
     */
    calculateBMI(height, weight) {
        if (!height || !weight || height <= 0 || weight <= 0) {
            return null;
        }
        return weight / (height * height);
    }

    /**
     * Get BMI interpretation based on BMI value
     * @param {number} bmi - BMI value
     * @returns {object} Interpretation object with text and CSS class
     */
    getInterpretation(bmi) {
        if (!bmi || isNaN(bmi)) {
            return { text: '', class: '' };
        }

        for (const [key, range] of Object.entries(this.ranges)) {
            if (bmi >= range.min && bmi <= range.max) {
                return { text: range.text, class: range.class };
            }
        }

        return { text: '', class: '' };
    }

    /**
     * Display BMI interpretation in the UI
     * @param {number} bmi - BMI value
     * @param {string} targetElementId - ID of the element to display interpretation
     */
    displayInterpretation(bmi, targetElementId = 'bmi-text') {
        const element = document.getElementById(targetElementId);
        if (!element) return;

        const interpretation = this.getInterpretation(bmi);
        
        if (interpretation.text) {
            element.textContent = interpretation.text;
            element.className = interpretation.class;
        } else {
            element.textContent = '';
            element.className = '';
        }
    }

    /**
     * Calculate and display BMI with interpretation
     * @param {string} heightId - ID of height input field
     * @param {string} weightId - ID of weight input field
     * @param {string} bmiId - ID of BMI input field
     * @param {string} interpretationId - ID of interpretation display element
     */
    calculateAndDisplay(heightId, weightId, bmiId, interpretationId = 'bmi-text') {
        const height = parseFloat(document.getElementById(heightId)?.value || 0);
        const weight = parseFloat(document.getElementById(weightId)?.value || 0);
        
        const bmi = this.calculateBMI(height, weight);
        const bmiElement = document.getElementById(bmiId);
        
        if (bmi && bmiElement) {
            bmiElement.value = bmi.toFixed(1);
            this.displayInterpretation(bmi, interpretationId);
        } else if (bmiElement) {
            bmiElement.value = '';
            this.displayInterpretation(null, interpretationId);
        }
    }

    /**
     * Initialize BMI functionality for a form
     * @param {object} options - Configuration options
     * @param {string} options.heightId - ID of height input field (default: 'height')
     * @param {string} options.weightId - ID of weight input field (default: 'weight')
     * @param {string} options.bmiId - ID of BMI input field (default: 'bmi')
     * @param {string} options.interpretationId - ID of interpretation display element (default: 'bmi-text')
     * @param {boolean} options.autoCalculate - Whether to auto-calculate on input change (default: true)
     * @param {boolean} options.initializeOnLoad - Whether to initialize with existing BMI value (default: true)
     */
    initialize(options = {}) {
        const config = {
            heightId: 'height',
            weightId: 'weight',
            bmiId: 'bmi',
            interpretationId: 'bmi-text',
            autoCalculate: true,
            initializeOnLoad: true,
            ...options
        };

        // Initialize with existing BMI value on page load
        if (config.initializeOnLoad) {
            const existingBMI = parseFloat(document.getElementById(config.bmiId)?.value || 0);
            if (existingBMI && !isNaN(existingBMI)) {
                this.displayInterpretation(existingBMI, config.interpretationId);
            }
        }

        // Set up auto-calculation on input change
        if (config.autoCalculate) {
            const heightElement = document.getElementById(config.heightId);
            const weightElement = document.getElementById(config.weightId);

            if (heightElement && weightElement) {
                const calculateHandler = () => {
                    this.calculateAndDisplay(config.heightId, config.weightId, config.bmiId, config.interpretationId);
                };

                heightElement.addEventListener('input', calculateHandler);
                weightElement.addEventListener('input', calculateHandler);
            }
        }
    }
}

// Create global instance
window.BMIIterpretation = new BMIIterpretation();

// Auto-initialize if jQuery is available and document is ready
if (typeof $ !== 'undefined') {
    $(document).ready(function() {
        // Auto-initialize BMI functionality if elements exist
        if (document.getElementById('height') && document.getElementById('weight') && document.getElementById('bmi')) {
            window.BMIIterpretation.initialize();
        }
    });
}
