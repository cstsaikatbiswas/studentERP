<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include BASE_PATH . '/view/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-user-plus mr-2"></i>Add Staff
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo BASE_URL; ?>/staff/manage" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back to List
                    </a>
                </div>
            </div>

            <!-- Alerts -->
            <?php if (isset($error) && $error != ''): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error; ?>
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (isset($success) && $success != ''): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $success; ?>
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <!-- Add Staff Form -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-user-circle mr-1"></i> Personal Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo BASE_URL; ?>/staff/add" id="addStaffForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">First Name *</label>
                                            <input type="text" class="form-control" name="first_name" 
                                                   value="<?php echo htmlspecialchars($formData['first_name']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Middle Name</label>
                                            <input type="text" class="form-control" name="middle_name"
                                                   value="<?php echo htmlspecialchars($formData['middle_name']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Last Name *</label>
                                            <input type="text" class="form-control" name="last_name"
                                                   value="<?php echo htmlspecialchars($formData['last_name']); ?>"
                                                   required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Gender *</label>
                                            <select class="form-control" name="gender" required>
                                                <option value="male" <?php echo $formData['gender'] == 'male' ? 'selected' : ''; ?>>Male</option>
                                                <option value="female" <?php echo $formData['gender'] == 'female' ? 'selected' : ''; ?>>Female</option>
                                                <option value="other" <?php echo $formData['gender'] == 'other' ? 'selected' : ''; ?>>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Date of Birth</label>
                                            <input type="date" class="form-control" name="date_of_birth"
                                                   value="<?php echo htmlspecialchars($formData['date_of_birth']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Category *</label>
                                            <select class="form-control" name="category_id" required id="categorySelect">
                                                <option value="">Select Category</option>
                                                <?php foreach ($categories as $category): ?>
                                                    <option value="<?php echo $category['id']; ?>"
                                                        <?php echo $formData['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                                                        <?php echo $category['name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Designation *</label>
                                            <select class="form-control" name="designation_id" required id="designationSelect">
                                                <option value="">Select Designation</option>
                                                <?php foreach ($designations as $designation): ?>
                                                    <option value="<?php echo $designation['id']; ?>"
                                                        <?php echo $formData['designation_id'] == $designation['id'] ? 'selected' : ''; ?>>
                                                        <?php echo $designation['name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Email</label>
                                            <input type="email" class="form-control" name="email"
                                                   value="<?php echo htmlspecialchars($formData['email']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Phone</label>
                                            <input type="text" class="form-control" name="phone"
                                                   value="<?php echo htmlspecialchars($formData['phone']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Alternate Phone</label>
                                            <input type="text" class="form-control" name="alternate_phone"
                                                   value="<?php echo htmlspecialchars($formData['alternate_phone']); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">Address</label>
                                    <textarea class="form-control" name="address" rows="3"><?php echo htmlspecialchars($formData['address']); ?></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">City</label>
                                            <input type="text" class="form-control" name="city"
                                                   value="<?php echo htmlspecialchars($formData['city']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">State</label>
                                            <input type="text" class="form-control" name="state"
                                                   value="<?php echo htmlspecialchars($formData['state']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Pincode</label>
                                            <input type="text" class="form-control" name="pincode"
                                                   value="<?php echo htmlspecialchars($formData['pincode']); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Emergency Contact Name</label>
                                            <input type="text" class="form-control" name="emergency_contact_name"
                                                   value="<?php echo htmlspecialchars($formData['emergency_contact_name']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Emergency Contact Phone</label>
                                            <input type="text" class="form-control" name="emergency_contact_phone"
                                                   value="<?php echo htmlspecialchars($formData['emergency_contact_phone']); ?>">
                                        </div>
                                    </div>
                                </div>

                                <!-- Professional Information -->
                                <div class="card mt-4">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0">
                                            <i class="fas fa-briefcase mr-1"></i> Professional Information
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Qualification</label>
                                                    <textarea class="form-control" name="qualification" rows="3"><?php echo htmlspecialchars($formData['qualification']); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Experience (Years)</label>
                                                    <input type="number" class="form-control" name="experience_years"
                                                           value="<?php echo htmlspecialchars($formData['experience_years']); ?>"
                                                           min="0" max="50">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Joining Date</label>
                                                    <input type="date" class="form-control" name="joining_date"
                                                           value="<?php echo htmlspecialchars($formData['joining_date']); ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Salary (₹)</label>
                                                    <input type="number" class="form-control" name="salary"
                                                           value="<?php echo htmlspecialchars($formData['salary']); ?>"
                                                           step="0.01" min="0">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Status *</label>
                                                    <select class="form-control" name="status" required>
                                                        <option value="active" <?php echo $formData['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                                        <option value="inactive" <?php echo $formData['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                                        <option value="suspended" <?php echo $formData['status'] == 'suspended' ? 'selected' : ''; ?>>Suspended</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bank Details -->
                                <div class="card mt-4">
                                    <div class="card-header bg-warning">
                                        <h6 class="mb-0">
                                            <i class="fas fa-university mr-1"></i> Bank Details
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Bank Name</label>
                                                    <input type="text" class="form-control" name="bank_name"
                                                           value="<?php echo htmlspecialchars($formData['bank_name']); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Account Number</label>
                                                    <input type="text" class="form-control" name="bank_account_number"
                                                           value="<?php echo htmlspecialchars($formData['bank_account_number']); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">IFSC Code</label>
                                                    <input type="text" class="form-control" name="ifsc_code"
                                                           value="<?php echo htmlspecialchars($formData['ifsc_code']); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">PAN Number</label>
                                                    <input type="text" class="form-control" name="pan_number"
                                                           value="<?php echo htmlspecialchars($formData['pan_number']); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Aadhaar Number</label>
                                                    <input type="text" class="form-control" name="aadhaar_number"
                                                           value="<?php echo htmlspecialchars($formData['aadhaar_number']); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Notes -->
                                <div class="form-group mt-4">
                                    <label class="font-weight-bold">Notes</label>
                                    <textarea class="form-control" name="notes" rows="4"><?php echo htmlspecialchars($formData['notes']); ?></textarea>
                                </div>

                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save mr-1"></i> Add Staff
                                    </button>
                                    <button type="reset" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-redo mr-1"></i> Reset
                                    </button>
                                    <a href="<?php echo BASE_URL; ?>/staff/manage" class="btn btn-outline-secondary btn-lg">
                                        <i class="fas fa-times mr-1"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
$(document).ready(function() {
    // Form validation
    $('#addStaffForm').on('submit', function(e) {
        const phone = $('input[name="phone"]').val();
        const email = $('input[name="email"]').val();
        
        if (phone && !/^[0-9]{10}$/.test(phone)) {
            e.preventDefault();
            alert('Please enter a valid 10-digit phone number.');
            return false;
        }
        
        if (email && !isValidEmail(email)) {
            e.preventDefault();
            alert('Please enter a valid email address.');
            return false;
        }
    });

    function isValidEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
});
</script>