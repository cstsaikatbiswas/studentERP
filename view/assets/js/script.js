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


// Institutes Module JavaScript
$(document).ready(function() {
    // Sidebar collapse functionality
    $('.nav-link[data-toggle="collapse"]').on('click', function() {
        $(this).toggleClass('collapsed');
    });

    // Auto-generate code from name
    $('.auto-generate-code').on('blur', function() {
        const target = $(this).data('target');
        const value = $(this).val();
        if (value && !$(target).val()) {
            const code = value
                .replace(/[^a-zA-Z0-9]/g, '_')
                .toUpperCase()
                .substring(0, 20);
            $(target).val(code);
        }
    });

    // Form validation for institutes
    $('.institute-form').on('submit', function(e) {
        let valid = true;
        const required = $(this).find('[required]');
        
        required.each(function() {
            if (!$(this).val().trim()) {
                valid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!valid) {
            e.preventDefault();
            alert('Please fill all required fields.');
        }
    });

    // Check institute code availability
    $('.check-code').on('blur', function() {
        const code = $(this).val();
        const currentId = $(this).data('current-id');
        
        if (code.length >= 2) {
            $.ajax({
                url: 'institutes/api/check-code',
                method: 'POST',
                data: {
                    code: code,
                    current_id: currentId
                },
                success: function(response) {
                    if (response.exists) {
                        $('.code-feedback').html('<small class="text-danger">This code is already in use.</small>');
                    } else {
                        $('.code-feedback').html('<small class="text-success">Code is available.</small>');
                    }
                }
            });
        }
    });

    // Initialize tooltips
    $('[title]').tooltip();

    // Loading states for buttons
    $('form').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        if (submitBtn.length) {
            submitBtn.prop('disabled', true).html('<span class="loading mr-2"></span> Processing...');
        }
    });
});

// Institute statistics loader
function loadInstituteStats() {
    $.ajax({
        url: 'institutes/api/statistics',
        method: 'GET',
        success: function(stats) {
            $('#totalInstitutes').text(stats.total_institutes || 0);
            $('#activeInstitutes').text(stats.active_institutes || 0);
            $('#instituteTypes').text(stats.institute_types || 0);
        }
    });
}

// Recent activity loader
function loadRecentActivity() {
    $.ajax({
        url: 'institutes/api/recent',
        method: 'GET',
        success: function(activity) {
            const tbody = $('#recentActivityBody');
            tbody.empty();
            
            if (activity && activity.length > 0) {
                activity.forEach(function(item, index) {
                    tbody.append(`
                        <tr>
                            <td>${item.name}</td>
                            <td><span class="badge badge-secondary">${item.type}</span></td>
                            <td><span class="badge badge-${item.status === 'active' ? 'success' : 'secondary'}">${item.status}</span></td>
                            <td>${new Date(item.updated_at).toLocaleDateString()}</td>
                            <td>
                                <a href="institutes/edit?id=${item.id}" class="btn btn-sm btn-primary">Edit</a>
                            </td>
                        </tr>
                    `);
                });
            } else {
                tbody.append('<tr><td colspan="5" class="text-center">No recent activity</td></tr>');
            }
        }
    });
}

// Load data when dashboard is ready
if ($('#totalInstitutes').length) {
    loadInstituteStats();
    loadRecentActivity();
}