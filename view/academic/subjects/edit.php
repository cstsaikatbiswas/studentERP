<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include BASE_PATH . '/view/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-edit mr-2"></i>Edit Subject
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo BASE_URL; ?>/academic/subjects" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Subjects
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

            <!-- Edit Subject Form -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle mr-1"></i> Edit Subject Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo BASE_URL; ?>/academic/subjects/edit?id=<?php echo $subject['id']; ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="font-weight-bold">Subject Name *</label>
                                            <input type="text" class="form-control" id="name" name="name" required 
                                                   value="<?php echo htmlspecialchars($formData['name']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code" class="font-weight-bold">Subject Code *</label>
                                            <input type="text" class="form-control" id="code" name="code" required
                                                   value="<?php echo htmlspecialchars($formData['code']); ?>">
                                            <small class="form-text text-muted">Unique identifier for the subject</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description" class="font-weight-bold">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($formData['description']); ?></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="credit_hours" class="font-weight-bold">Credit Hours *</label>
                                            <input type="number" class="form-control" id="credit_hours" name="credit_hours" 
                                                   value="<?php echo htmlspecialchars($formData['credit_hours']); ?>"
                                                   min="0" max="10" step="0.5" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="theory_hours" class="font-weight-bold">Theory Hours</label>
                                            <input type="number" class="form-control" id="theory_hours" name="theory_hours"
                                                   value="<?php echo htmlspecialchars($formData['theory_hours']); ?>"
                                                   min="0" max="40">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="practical_hours" class="font-weight-bold">Practical Hours</label>
                                            <input type="number" class="form-control" id="practical_hours" name="practical_hours"
                                                   value="<?php echo htmlspecialchars($formData['practical_hours']); ?>"
                                                   min="0" max="40">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject_type" class="font-weight-bold">Subject Type *</label>
                                            <select class="form-control" id="subject_type" name="subject_type" required>
                                                <option value="core" <?php echo $formData['subject_type'] == 'core' ? 'selected' : ''; ?>>Core</option>
                                                <option value="elective" <?php echo $formData['subject_type'] == 'elective' ? 'selected' : ''; ?>>Elective</option>
                                                <option value="lab" <?php echo $formData['subject_type'] == 'lab' ? 'selected' : ''; ?>>Lab</option>
                                                <option value="project" <?php echo $formData['subject_type'] == 'project' ? 'selected' : ''; ?>>Project</option>
                                                <option value="seminar" <?php echo $formData['subject_type'] == 'seminar' ? 'selected' : ''; ?>>Seminar</option>
                                                <option value="workshop" <?php echo $formData['subject_type'] == 'workshop' ? 'selected' : ''; ?>>Workshop</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="difficulty_level" class="font-weight-bold">Difficulty Level</label>
                                            <select class="form-control" id="difficulty_level" name="difficulty_level">
                                                <option value="basic" <?php echo $formData['difficulty_level'] == 'basic' ? 'selected' : ''; ?>>Basic</option>
                                                <option value="intermediate" <?php echo $formData['difficulty_level'] == 'intermediate' ? 'selected' : ''; ?>>Intermediate</option>
                                                <option value="advanced" <?php echo $formData['difficulty_level'] == 'advanced' ? 'selected' : ''; ?>>Advanced</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

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

                                <div class="form-group">
                                    <label for="prerequisites" class="font-weight-bold">Prerequisites</label>
                                    <textarea class="form-control" id="prerequisites" name="prerequisites" rows="2"><?php echo htmlspecialchars($formData['prerequisites']); ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="learning_outcomes" class="font-weight-bold">Learning Outcomes</label>
                                    <textarea class="form-control" id="learning_outcomes" name="learning_outcomes" rows="3"><?php echo htmlspecialchars($formData['learning_outcomes']); ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="status" class="font-weight-bold">Status *</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="active" <?php echo $formData['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?php echo $formData['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save mr-1"></i> Update Subject
                                    </button>
                                    <a href="<?php echo BASE_URL; ?>/academic/subjects" class="btn btn-outline-secondary btn-lg">
                                        <i class="fas fa-times mr-1"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Subject Information -->
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle mr-1"></i> Subject Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Created:</strong> <?php echo date('F j, Y, g:i a', strtotime($subject['created_at'])); ?></p>
                            <p><strong>Last Updated:</strong> <?php echo date('F j, Y, g:i a', strtotime($subject['updated_at'])); ?></p>
                            <p><strong>Created By:</strong> <?php echo $subject['created_by_name'] ?? 'System'; ?></p>
                            
                            <div class="mt-3 p-3 bg-light rounded">
                                <h6 class="font-weight-bold">Quick Stats</h6>
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="border rounded p-2 mb-2">
                                            <h5 class="mb-0 text-primary"><?php echo $formData['credit_hours']; ?></h5>
                                            <small>Credits</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="border rounded p-2 mb-2">
                                            <h5 class="mb-0 text-success"><?php echo ($formData['theory_hours'] + $formData['practical_hours']); ?></h5>
                                            <small>Total Hours</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Usage Information -->
                    <div class="card shadow mt-4">
                        <div class="card-header bg-warning text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-exclamation-triangle mr-1"></i> Important Note
                            </h6>
                        </div>
                        <div class="card-body">
                            <p class="small mb-2">
                                <strong>Subject Code:</strong> Once created, the subject code cannot be changed as it might be referenced in programs and student records.
                            </p>
                            <p class="small mb-0">
                                <strong>Department:</strong> Changing the department will affect how this subject is categorized and assigned to faculty.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
$(document).ready(function() {
    // Calculate total hours
    function calculateTotalHours() {
        const theory = parseInt($('#theory_hours').val()) || 0;
        const practical = parseInt($('#practical_hours').val()) || 0;
        const total = theory + practical;
        
        if (total > 0) {
            $('#totalHours').text('Total: ' + total + ' hours per week');
        } else {
            $('#totalHours').text('');
        }
    }

    $('#theory_hours, #practical_hours').on('change', calculateTotalHours);
    
    // Initialize total hours display
    $('<small id="totalHours" class="form-text text-info"></small>').insertAfter('#practical_hours');
    calculateTotalHours();
});
</script>