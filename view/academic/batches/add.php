<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include BASE_PATH . '/view/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-plus-circle mr-2"></i>Add New Batch
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo BASE_URL; ?>/academic/batches" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Batches
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

            <!-- Add Batch Form -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle mr-1"></i> Batch Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo BASE_URL; ?>/academic/batches/add" id="addBatchForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="program_id" class="font-weight-bold">Program *</label>
                                            <select class="form-control" id="program_id" name="program_id" required>
                                                <option value="">Select Program</option>
                                                <?php foreach ($programs as $program): ?>
                                                    <option value="<?php echo $program['id']; ?>" 
                                                        <?php echo $formData['program_id'] == $program['id'] ? 'selected' : ''; ?>>
                                                        <?php echo $program['name']; ?> (<?php echo $program['code']; ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <small class="form-text text-muted">Select the academic program for this batch</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="batch_year" class="font-weight-bold">Batch Year *</label>
                                            <select class="form-control" id="batch_year" name="batch_year" required>
                                                <option value="">Select Year</option>
                                                <?php 
                                                    $current_year = date('Y');
                                                    for ($year = $current_year; $year >= $current_year - 10; $year--): 
                                                ?>
                                                    <option value="<?php echo $year; ?>" 
                                                        <?php echo $formData['batch_year'] == $year ? 'selected' : ''; ?>>
                                                        <?php echo $year; ?> - <?php echo $year + 1; ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="batch_code" class="font-weight-bold">Batch Code *</label>
                                            <input type="text" class="form-control" id="batch_code" name="batch_code" required
                                                   value="<?php echo htmlspecialchars($formData['batch_code']); ?>"
                                                   placeholder="e.g., BCA2023">
                                            <small class="form-text text-muted">Unique identifier for the batch</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="batch_name" class="font-weight-bold">Batch Name *</label>
                                            <input type="text" class="form-control" id="batch_name" name="batch_name" required
                                                   value="<?php echo htmlspecialchars($formData['batch_name']); ?>"
                                                   placeholder="e.g., Computer Science 2023 Batch">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start_date" class="font-weight-bold">Start Date *</label>
                                            <input type="date" class="form-control" id="start_date" name="start_date" required
                                                   value="<?php echo htmlspecialchars($formData['start_date']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end_date" class="font-weight-bold">Expected End Date</label>
                                            <input type="date" class="form-control" id="end_date" name="end_date"
                                                   value="<?php echo htmlspecialchars($formData['end_date']); ?>">
                                            <small class="form-text text-muted">Leave empty if ongoing</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="current_semester" class="font-weight-bold">Current Semester</label>
                                            <input type="number" class="form-control" id="current_semester" name="current_semester"
                                                   value="<?php echo htmlspecialchars($formData['current_semester']); ?>"
                                                   min="1" max="12" value="1">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="max_capacity" class="font-weight-bold">Maximum Capacity *</label>
                                            <input type="number" class="form-control" id="max_capacity" name="max_capacity" required
                                                   value="<?php echo htmlspecialchars($formData['max_capacity']); ?>"
                                                   min="1" max="500" placeholder="Maximum number of students">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="class_teacher_id" class="font-weight-bold">Class Teacher</label>
                                            <select class="form-control" id="class_teacher_id" name="class_teacher_id">
                                                <option value="">Select Class Teacher</option>
                                                <?php foreach ($faculty_members as $faculty): ?>
                                                    <option value="<?php echo $faculty['id']; ?>" 
                                                        <?php echo $formData['class_teacher_id'] == $faculty['id'] ? 'selected' : ''; ?>>
                                                        <?php echo $faculty['first_name'] . ' ' . $faculty['last_name']; ?>
                                                        (<?php echo $faculty['email']; ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status" class="font-weight-bold">Status *</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="upcoming" <?php echo $formData['status'] == 'upcoming' ? 'selected' : ''; ?>>Upcoming</option>
                                                <option value="active" <?php echo $formData['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                                <option value="completed" <?php echo $formData['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                                <option value="cancelled" <?php echo $formData['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="admission_criteria" class="font-weight-bold">Admission Criteria</label>
                                    <textarea class="form-control" id="admission_criteria" name="admission_criteria" 
                                              rows="3" placeholder="Describe admission criteria for this batch"><?php echo htmlspecialchars($formData['admission_criteria']); ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="fee_structure" class="font-weight-bold">Fee Structure (JSON)</label>
                                    <textarea class="form-control" id="fee_structure" name="fee_structure" 
                                              rows="4" placeholder='{"tuition_fee": 50000, "hostel_fee": 20000, "other_fees": 10000}'><?php echo htmlspecialchars($formData['fee_structure']); ?></textarea>
                                    <small class="form-text text-muted">Enter fee structure in JSON format</small>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save mr-1"></i> Create Batch
                                    </button>
                                    <button type="reset" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-redo mr-1"></i> Reset
                                    </button>
                                    <a href="<?php echo BASE_URL; ?>/academic/batches" class="btn btn-outline-secondary btn-lg">
                                        <i class="fas fa-times mr-1"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Quick Guidelines -->
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-lightbulb mr-1"></i> Guidelines
                            </h6>
                        </div>
                        <div class="card-body">
                            <h6 class="font-weight-bold">Batch Naming Convention:</h6>
                            <ul class="small">
                                <li>Batch Code: <code>PROGRAM_YEAR</code> (e.g., BCA2023)</li>
                                <li>Batch Name: <code>Program Name Year Batch</code> (e.g., Computer Science 2023 Batch)</li>
                            </ul>
                            
                            <h6 class="font-weight-bold mt-3">Status Guide:</h6>
                            <ul class="small">
                                <li><span class="badge badge-warning">Upcoming</span>: Admissions open, classes not started</li>
                                <li><span class="badge badge-success">Active</span>: Classes ongoing</li>
                                <li><span class="badge badge-secondary">Completed</span>: Course completed</li>
                                <li><span class="badge badge-danger">Cancelled</span>: Batch cancelled</li>
                            </ul>
                            
                            <h6 class="font-weight-bold mt-3">Capacity Planning:</h6>
                            <ul class="small">
                                <li>Consider infrastructure availability</li>
                                <li>Plan for faculty-student ratio</li>
                                <li>Include buffer for transfers</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Program Info Card -->
                    <div class="card shadow mt-4" id="programInfoCard" style="display: none;">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-university mr-1"></i> Program Details
                            </h6>
                        </div>
                        <div class="card-body">
                            <p id="programDuration"><strong>Duration:</strong> <span id="durationValue"></span> years</p>
                            <p id="programSemesters"><strong>Total Semesters:</strong> <span id="semestersValue"></span></p>
                            <p id="programCredits"><strong>Total Credits:</strong> <span id="creditsValue"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
$(document).ready(function() {
    // Auto-generate batch code and name
    $('#program_id, #batch_year').on('change', function() {
        const programId = $('#program_id').val();
        const batchYear = $('#batch_year').val();
        
        if (programId && batchYear) {
            $.ajax({
                url: '<?php echo BASE_URL; ?>/academic/api/program-details?id=' + programId,
                method: 'GET',
                success: function(program) {
                    if (program) {
                        // Update program info card
                        $('#programInfoCard').show();
                        $('#durationValue').text(program.duration_years);
                        $('#semestersValue').text(program.total_semesters);
                        $('#creditsValue').text(program.total_credits);
                        
                        // Auto-generate batch code
                        if (!$('#batch_code').val()) {
                            const batchCode = program.code + batchYear;
                            $('#batch_code').val(batchCode);
                        }
                        
                        // Auto-generate batch name
                        if (!$('#batch_name').val()) {
                            const batchName = program.name + ' ' + batchYear + ' Batch';
                            $('#batch_name').val(batchName);
                        }
                    }
                }
            });
        }
    });

    // Form validation
    $('#addBatchForm').on('submit', function(e) {
        const batchCode = $('#batch_code').val().trim();
        const programId = $('#program_id').val();
        
        if (!programId) {
            e.preventDefault();
            alert('Please select a program.');
            return false;
        }

        // Check if batch code already exists
        $.ajax({
            url: '<?php echo BASE_URL; ?>/academic/api/check-batch-code',
            method: 'POST',
            async: false,
            data: {
                program_id: programId,
                batch_code: batchCode
            },
            success: function(response) {
                if (response.exists) {
                    e.preventDefault();
                    alert('Batch code already exists for this program. Please use a different code.');
                }
            }
        });
    });

    // Set min date for start date to today
    $('#start_date').attr('min', new Date().toISOString().split('T')[0]);
    
    // Set end date based on program duration when program is selected
    $('#program_id').on('change', function() {
        const programId = $(this).val();
        if (programId) {
            $.ajax({
                url: '<?php echo BASE_URL; ?>/academic/api/program-details?id=' + programId,
                method: 'GET',
                success: function(program) {
                    if (program && program.duration_years) {
                        const startDate = $('#start_date').val();
                        if (startDate) {
                            const endDate = new Date(startDate);
                            endDate.setFullYear(endDate.getFullYear() + parseInt(program.duration_years));
                            $('#end_date').val(endDate.toISOString().split('T')[0]);
                        }
                    }
                }
            });
        }
    });
});
</script>
