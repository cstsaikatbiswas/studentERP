<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include BASE_PATH . '/view/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-edit mr-2"></i>Edit Batch
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

            <!-- Edit Batch Form -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle mr-1"></i> Edit Batch Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo BASE_URL; ?>/academic/batches/edit?id=<?php echo $batch['id']; ?>" id="editBatchForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Program</label>
                                            <input type="text" class="form-control" value="<?php echo $batch['program_name']; ?>" readonly>
                                            <small class="form-text text-muted">Program cannot be changed after creation</small>
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
                                                   value="<?php echo htmlspecialchars($formData['batch_code']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="batch_name" class="font-weight-bold">Batch Name *</label>
                                            <input type="text" class="form-control" id="batch_name" name="batch_name" required
                                                   value="<?php echo htmlspecialchars($formData['batch_name']); ?>">
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
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="current_semester" class="font-weight-bold">Current Semester</label>
                                            <input type="number" class="form-control" id="current_semester" name="current_semester"
                                                   value="<?php echo htmlspecialchars($formData['current_semester']); ?>"
                                                   min="1" max="<?php echo $batch['total_semesters']; ?>">
                                            <small class="form-text text-muted">Max: <?php echo $batch['total_semesters']; ?> semesters</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="max_capacity" class="font-weight-bold">Maximum Capacity *</label>
                                            <input type="number" class="form-control" id="max_capacity" name="max_capacity" required
                                                   value="<?php echo htmlspecialchars($formData['max_capacity']); ?>"
                                                   min="<?php echo $batch['student_count']; ?>" 
                                                   max="500" 
                                                   title="Cannot be less than current student count (<?php echo $batch['student_count']; ?>)">
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
                                              rows="3"><?php echo htmlspecialchars($formData['admission_criteria']); ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="fee_structure" class="font-weight-bold">Fee Structure (JSON)</label>
                                    <textarea class="form-control" id="fee_structure" name="fee_structure" 
                                              rows="4"><?php echo htmlspecialchars($formData['fee_structure']); ?></textarea>
                                    <small class="form-text text-muted">Enter fee structure in JSON format</small>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save mr-1"></i> Update Batch
                                    </button>
                                    <a href="<?php echo BASE_URL; ?>/academic/batches" class="btn btn-outline-secondary btn-lg">
                                        <i class="fas fa-times mr-1"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Batch Information -->
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle mr-1"></i> Batch Details
                            </h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Program:</strong> <?php echo $batch['program_name']; ?></p>
                            <p><strong>Department:</strong> <?php echo $batch['department_name']; ?></p>
                            <p><strong>Created:</strong> <?php echo date('F j, Y, g:i a', strtotime($batch['created_at'])); ?></p>
                            <p><strong>Last Updated:</strong> <?php echo date('F j, Y, g:i a', strtotime($batch['updated_at'])); ?></p>
                            
                            <div class="mt-3 p-3 bg-light rounded">
                                <h6 class="font-weight-bold">Current Statistics</h6>
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="border rounded p-2 mb-2">
                                            <h5 class="mb-0 text-primary"><?php echo $batch['student_count']; ?></h5>
                                            <small>Enrolled Students</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="border rounded p-2 mb-2">
                                            <h5 class="mb-0 text-success"><?php echo $batch['max_capacity']; ?></h5>
                                            <small>Maximum Capacity</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="progress mt-2" style="height: 20px;">
                                    <?php 
                                        $capacity_percentage = ($batch['student_count'] / $batch['max_capacity']) * 100;
                                        $progress_class = $capacity_percentage >= 90 ? 'bg-danger' : 
                                                         ($capacity_percentage >= 75 ? 'bg-warning' : 'bg-success');
                                    ?>
                                    <div class="progress-bar <?php echo $progress_class; ?>" 
                                         role="progressbar" 
                                         style="width: <?php echo min($capacity_percentage, 100); ?>%"
                                         aria-valuenow="<?php echo $batch['student_count']; ?>" 
                                         aria-valuemin="0" 
                                         aria-valuemax="<?php echo $batch['max_capacity']; ?>">
                                        <?php echo round($capacity_percentage, 1); ?>% Full
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card shadow mt-4">
                        <div class="card-header bg-warning text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-bolt mr-1"></i> Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <a href="<?php echo BASE_URL; ?>/academic/batches/view?id=<?php echo $batch['id']; ?>" 
                               class="btn btn-info btn-block mb-2">
                                <i class="fas fa-eye mr-1"></i> View Batch Details
                            </a>
                            <?php if ($batch['student_count'] > 0): ?>
                                <a href="<?php echo BASE_URL; ?>/students?batch_id=<?php echo $batch['id']; ?>" 
                                   class="btn btn-success btn-block mb-2">
                                    <i class="fas fa-user-graduate mr-1"></i> View Students (<?php echo $batch['student_count']; ?>)
                                </a>
                            <?php endif; ?>
                            <button type="button" class="btn btn-danger btn-block delete-batch" 
                                    data-id="<?php echo $batch['id']; ?>"
                                    data-name="<?php echo $batch['batch_name']; ?>">
                                <i class="fas fa-trash mr-1"></i> Delete Batch
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteBatchModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete batch "<strong id="deleteBatchName"></strong>"?</p>
                <p class="text-danger"><small>This action cannot be undone. If this batch has students enrolled, it cannot be deleted.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="#" id="confirmBatchDelete" class="btn btn-danger">Delete Batch</a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Delete confirmation
    $('.delete-batch').on('click', function() {
        const batchId = $(this).data('id');
        const batchName = $(this).data('name');
        
        $('#deleteBatchName').text(batchName);
        $('#confirmBatchDelete').attr('href', '<?php echo BASE_URL; ?>/academic/batches/delete?id=' + batchId);
        $('#deleteBatchModal').modal('show');
    });

    // Form validation
    $('#editBatchForm').on('submit', function(e) {
        const currentStudents = <?php echo $batch['student_count']; ?>;
        const maxCapacity = parseInt($('#max_capacity').val());
        
        if (maxCapacity < currentStudents) {
            e.preventDefault();
            alert('Maximum capacity cannot be less than current student count (' + currentStudents + ').');
            return false;
        }

        // Check batch code availability
        const batchCode = $('#batch_code').val().trim();
        const programId = <?php echo $batch['program_id']; ?>;
        const batchId = <?php echo $batch['id']; ?>;
        
        $.ajax({
            url: '<?php echo BASE_URL; ?>/academic/api/check-batch-code',
            method: 'POST',
            async: false,
            data: {
                program_id: programId,
                batch_code: batchCode,
                current_id: batchId
            },
            success: function(response) {
                if (response.exists) {
                    e.preventDefault();
                    alert('Batch code already exists for this program. Please use a different code.');
                }
            }
        });
    });
});
</script>

