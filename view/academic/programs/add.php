<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include BASE_PATH . '/view/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-plus-circle mr-2"></i>Add Academic Program
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo BASE_URL; ?>/academic/programs" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Programs
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

            <!-- Add Program Form -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle mr-1"></i> Program Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo BASE_URL; ?>/academic/programs/add" id="addProgramForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="font-weight-bold">Program Name *</label>
                                            <input type="text" class="form-control" id="name" name="name" required
                                                   value="<?php echo htmlspecialchars($formData['name']); ?>"
                                                   placeholder="Enter program name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code" class="font-weight-bold">Program Code *</label>
                                            <input type="text" class="form-control" id="code" name="code" required
                                                   value="<?php echo htmlspecialchars($formData['code']); ?>"
                                                   placeholder="Enter unique code">
                                            <small class="form-text text-muted">Unique identifier for the program</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description" class="font-weight-bold">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"
                                              placeholder="Enter program description"><?php echo htmlspecialchars($formData['description']); ?></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="department_id" class="font-weight-bold">Department *</label>
                                            <select class="form-control" id="department_id" name="department_id" required>
                                                <option value="">Select Department</option>
                                                <?php foreach ($departments as $department): ?>
                                                    <option value="<?php echo $department['id']; ?>" 
                                                        <?php echo $formData['department_id'] == $department['id'] ? 'selected' : ''; ?>>
                                                        <?php echo $department['name']; ?> (<?php echo $department['code']; ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="degree_type" class="font-weight-bold">Degree Type *</label>
                                            <select class="form-control" id="degree_type" name="degree_type" required>
                                                <option value="">Select Degree Type</option>
                                                <option value="undergraduate" <?php echo $formData['degree_type'] == 'undergraduate' ? 'selected' : ''; ?>>Undergraduate</option>
                                                <option value="postgraduate" <?php echo $formData['degree_type'] == 'postgraduate' ? 'selected' : ''; ?>>Postgraduate</option>
                                                <option value="diploma" <?php echo $formData['degree_type'] == 'diploma' ? 'selected' : ''; ?>>Diploma</option>
                                                <option value="certificate" <?php echo $formData['degree_type'] == 'certificate' ? 'selected' : ''; ?>>Certificate</option>
                                                <option value="phd" <?php echo $formData['degree_type'] == 'phd' ? 'selected' : ''; ?>>PhD</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="duration_years" class="font-weight-bold">Duration (Years) *</label>
                                            <input type="number" class="form-control" id="duration_years" name="duration_years" required
                                                   value="<?php echo htmlspecialchars($formData['duration_years']); ?>"
                                                   min="1" max="6" placeholder="e.g., 4">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="total_credits" class="font-weight-bold">Total Credits *</label>
                                            <input type="number" class="form-control" id="total_credits" name="total_credits" required
                                                   value="<?php echo htmlspecialchars($formData['total_credits']); ?>"
                                                   min="1" placeholder="e.g., 120">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="total_semesters" class="font-weight-bold">Total Semesters</label>
                                            <input type="number" class="form-control" id="total_semesters" name="total_semesters"
                                                   value="<?php echo htmlspecialchars($formData['total_semesters']); ?>"
                                                   min="1" max="12" placeholder="e.g., 8">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="program_level" class="font-weight-bold">Program Level</label>
                                            <select class="form-control" id="program_level" name="program_level">
                                                <option value="foundation" <?php echo $formData['program_level'] == 'foundation' ? 'selected' : ''; ?>>Foundation</option>
                                                <option value="diploma" <?php echo $formData['program_level'] == 'diploma' ? 'selected' : ''; ?>>Diploma</option>
                                                <option value="bachelor" <?php echo $formData['program_level'] == 'bachelor' ? 'selected' : ''; ?>>Bachelor</option>
                                                <option value="master" <?php echo $formData['program_level'] == 'master' ? 'selected' : ''; ?>>Master</option>
                                                <option value="doctoral" <?php echo $formData['program_level'] == 'doctoral' ? 'selected' : ''; ?>>Doctoral</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="accreditation_status" class="font-weight-bold">Accreditation Status</label>
                                            <select class="form-control" id="accreditation_status" name="accreditation_status">
                                                <option value="pending" <?php echo $formData['accreditation_status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                <option value="approved" <?php echo $formData['accreditation_status'] == 'approved' ? 'selected' : ''; ?>>Approved</option>
                                                <option value="accredited" <?php echo $formData['accreditation_status'] == 'accredited' ? 'selected' : ''; ?>>Accredited</option>
                                                <option value="rejected" <?php echo $formData['accreditation_status'] == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start_date" class="font-weight-bold">Start Date</label>
                                            <input type="date" class="form-control" id="start_date" name="start_date"
                                                   value="<?php echo htmlspecialchars($formData['start_date']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end_date" class="font-weight-bold">End Date</label>
                                            <input type="date" class="form-control" id="end_date" name="end_date"
                                                   value="<?php echo htmlspecialchars($formData['end_date']); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="max_students" class="font-weight-bold">Maximum Students</label>
                                            <input type="number" class="form-control" id="max_students" name="max_students"
                                                   value="<?php echo htmlspecialchars($formData['max_students']); ?>"
                                                   min="1" placeholder="e.g., 100">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="program_fee" class="font-weight-bold">Program Fee (₹)</label>
                                            <input type="number" class="form-control" id="program_fee" name="program_fee"
                                                   value="<?php echo htmlspecialchars($formData['program_fee']); ?>"
                                                   min="0" step="0.01" placeholder="e.g., 50000.00">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="status" class="font-weight-bold">Status *</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="active" <?php echo $formData['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?php echo $formData['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                        <option value="draft" <?php echo $formData['status'] == 'draft' ? 'selected' : ''; ?>>Draft</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save mr-1"></i> Add Program
                                    </button>
                                    <button type="reset" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-redo mr-1"></i> Reset
                                    </button>
                                    <a href="<?php echo BASE_URL; ?>/academic/programs" class="btn btn-outline-secondary btn-lg">
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
    // Auto-generate code from name
    $('#name').on('blur', function() {
        if ($('#code').val() === '') {
            const name = $(this).val();
            const code = name.replace(/[^a-zA-Z0-9]/g, '_').toUpperCase().substring(0, 20);
            $('#code').val(code);
        }
    });

    // Calculate semesters based on duration
    $('#duration_years').on('change', function() {
        const years = $(this).val();
        if (years && !$('#total_semesters').val()) {
            $('#total_semesters').val(years * 2);
        }
    });

    // Form validation
    $('#addProgramForm').on('submit', function(e) {
        const name = $('#name').val().trim();
        const code = $('#code').val().trim();
        const department = $('#department_id').val();
        const degreeType = $('#degree_type').val();
        
        if (name === '' || code === '' || department === '' || degreeType === '') {
            e.preventDefault();
            alert('Please fill all required fields.');
            return false;
        }

        // Validate code format
        const codeRegex = /^[a-zA-Z0-9_]+$/;
        if (!codeRegex.test(code)) {
            e.preventDefault();
            alert('Program code can only contain letters, numbers, and underscores.');
            return false;
        }
    });
});
</script>