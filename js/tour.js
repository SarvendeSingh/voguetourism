/**
 * Tour System JavaScript Functions
 * Handles inquiry forms, filtering, and other interactive elements
 */

// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize inquiry form submission
    initInquiryForm();
    
    // Initialize duration filters
    initDurationFilter();
    
    // Initialize destination filters (for cruise page)
    initDestinationFilter();
    
    // Initialize Bootstrap tooltips
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // Initialize Bootstrap popovers
    if (typeof bootstrap !== 'undefined' && bootstrap.Popover) {
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    }
});

/**
 * Initialize the inquiry form submission via AJAX
 */
function initInquiryForm() {
    // Get all inquiry forms on the page
    const inquiryForms = document.querySelectorAll('.inquiry-form');
    
    // Add submit event listener to each form
    inquiryForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get the form data
            const formData = new FormData(form);
            
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...';
            submitBtn.disabled = true;
            
            // Clear previous messages
            const messageContainer = form.querySelector('.form-message');
            if (messageContainer) {
                messageContainer.innerHTML = '';
                messageContainer.classList.remove('alert-success', 'alert-danger');
            }
            
            // Send AJAX request
            fetch('process-inquiry.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Display response message
                if (messageContainer) {
                    messageContainer.classList.add(data.success ? 'alert-success' : 'alert-danger');
                    messageContainer.classList.add('alert');
                    messageContainer.innerHTML = data.message;
                    messageContainer.style.display = 'block';
                }
                
                // Reset form if successful
                if (data.success) {
                    form.reset();
                    
                    // Close modal after 2 seconds if form is in a modal
                    if (form.closest('.modal')) {
                        setTimeout(() => {
                            const modal = bootstrap.Modal.getInstance(form.closest('.modal'));
                            if (modal) {
                                modal.hide();
                            }
                        }, 2000);
                    }
                }
                
                // Reset button state
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Display error message
                if (messageContainer) {
                    messageContainer.classList.add('alert', 'alert-danger');
                    messageContainer.innerHTML = 'An error occurred. Please try again later.';
                    messageContainer.style.display = 'block';
                }
                
                // Reset button state
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
            });
        });
    });
}

/**
 * Initialize duration filter functionality
 */
function initDurationFilter() {
    const durationFilter = document.getElementById('duration-filter');
    if (!durationFilter) return;
    
    durationFilter.addEventListener('change', function() {
        const selectedDuration = this.value;
        const tourCards = document.querySelectorAll('.tour-card');
        
        tourCards.forEach(card => {
            const cardDuration = card.getAttribute('data-duration');
            
            if (selectedDuration === '' || selectedDuration === cardDuration) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
        
        // Update visible count
        updateVisibleCount(tourCards);
    });
}

/**
 * Initialize destination filter functionality (for cruise page)
 */
function initDestinationFilter() {
    const destinationFilter = document.getElementById('destination-filter');
    if (!destinationFilter) return;
    
    destinationFilter.addEventListener('change', function() {
        const selectedDestination = this.value;
        const tourCards = document.querySelectorAll('.tour-card');
        
        tourCards.forEach(card => {
            const cardDestination = card.getAttribute('data-destination');
            
            // If no destination is selected or the card's destination matches the selected one
            if (selectedDestination === '' || selectedDestination === cardDestination) {
                // Check if there's also a duration filter active
                const durationFilter = document.getElementById('duration-filter');
                if (durationFilter && durationFilter.value !== '') {
                    const cardDuration = card.getAttribute('data-duration');
                    if (durationFilter.value === cardDuration) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                } else {
                    card.style.display = 'block';
                }
            } else {
                card.style.display = 'none';
            }
        });
        
        // Update visible count
        updateVisibleCount(tourCards);
    });
}

/**
 * Update the count of visible tour cards
 */
function updateVisibleCount(tourCards) {
    const countElement = document.getElementById('visible-count');
    if (!countElement) return;
    
    let visibleCount = 0;
    tourCards.forEach(card => {
        if (card.style.display !== 'none') {
            visibleCount++;
        }
    });
    
    countElement.textContent = visibleCount;
    
    // Show/hide no results message
    const noResultsMsg = document.getElementById('no-results-message');
    if (noResultsMsg) {
        noResultsMsg.style.display = visibleCount === 0 ? 'block' : 'none';
    }
}

/**
 * Open the inquiry modal and pre-fill tour information
 */
function openInquiryModal(tourId, tourName, destinationId) {
    // Find the modal and form
    const modal = document.getElementById('inquiryModal');
    const form = modal.querySelector('.inquiry-form');
    
    // Set the tour ID and destination ID in hidden fields
    if (form) {
        const tourIdField = form.querySelector('input[name="tour_id"]');
        const destinationIdField = form.querySelector('input[name="destination_id"]');
        const tourNameField = form.querySelector('.tour-name');
        
        if (tourIdField) tourIdField.value = tourId;
        if (destinationIdField) destinationIdField.value = destinationId;
        if (tourNameField) tourNameField.textContent = tourName;
    }
    
    // Open the modal
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();
    }
}