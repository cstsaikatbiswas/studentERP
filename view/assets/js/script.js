// Custom JavaScript for Student ERP

$(document).ready(function() {
    // Auto-dismiss alerts after 5 seconds
    $('.alert').delay(5000).fadeOut('slow');
    
    // Password confirmation validation
    $('#registerForm').on('submit', function(e) {
        const password = $('#password').val();
        const confirmPassword = $('#confirm_password').val();
        
        if (password !== confirmPassword) {
            e.preventDefault();
            showAlert('Passwords do not match!', 'danger');
            $('#confirm_password').focus();
        }
        
        if (password.length < 8) {
            e.preventDefault();
            showAlert('Password must be at least 8 characters long!', 'danger');
            $('#password').focus();
        }
    });
    
    // Form field enhancements
    $('.form-control').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });
    
    // Loading buttons
    $('form').on('submit', function() {
        const btn = $(this).find('button[type="submit"]');
        if (btn.length) {
            btn.prop('disabled', true);
            btn.html('<span class="loading"></span> Processing...');
        }
    });
});

// Show custom alert
function showAlert(message, type = 'info') {
    const alert = $(`
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    `);
    
    $('.container:first').prepend(alert);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        alert.alert('close');
    }, 5000);
}

// Format dates
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
}

// Handle API calls
function apiCall(url, method = 'GET', data = null) {
    return $.ajax({
        url: url,
        method: method,
        data: data,
        dataType: 'json'
    });
}