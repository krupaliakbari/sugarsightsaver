/**
 * Global Alert Configuration
 * 
 * This file contains global configuration for alert auto-hide functionality.
 * Modify these settings to change behavior across the entire application.
 */

window.AlertConfig = {
    // Auto-hide duration in milliseconds
    // 5000 = 5 seconds, 3000 = 3 seconds, 10000 = 10 seconds
    AUTO_HIDE_DURATION: 5000,
    
    // Enable/disable auto-hide functionality
    ENABLE_AUTO_HIDE: true,
    
    // Add close button to alerts that don't have one
    ADD_CLOSE_BUTTON: true,
    
    // Enable fade animation when hiding
    ENABLE_FADE_ANIMATION: true,
    
    // Alert types that should be auto-hidden
    // Add or remove alert types as needed
    ALERT_TYPES: [
        'alert-success',
        'alert-danger', 
        'alert-warning',
        'alert-info',
        'alert-primary',
        'alert-secondary',
        'alert-light',
        'alert-dark'
    ]
};
