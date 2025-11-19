<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include BASE_PATH . '/view/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-plus-circle mr-2"></i>Add Subject
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

            <!-- Add Subject Form -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle mr-1"></i> Subject Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo BASE_URL; ?>/academic/subjects/add" id="addSubjectForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="font-weight-bold">Subject Name *</label>
                                            <input type="text" class="form-control" id="name" name="name" required 
                                                   value="<?php echo htmlspecialchars($formData['name']); ?>"
                                                   placeholder="Enter subject name">
                                            <small class="form-text text-muted">Full name of the subject</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code" class="font-weight-bold">Subject Code *</label>
                                            <input type="text" class="form-control" id="code" name="code" required
                                                   value="<?php echo htmlspecialchars($formData['code']); ?>"
                                                   placeholder="Enter unique code">
                                            <small class="form-text text-muted">Unique identifier for the subject</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description" class="font-weight-bold">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"
                                              placeholder="Enter subject description"><?php echo htmlspecialchars($formData['description']); ?></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="credit_hours" class="font-weight-bold">Credit Hours *</label>
                                            <input type="number" class="form-control" id="credit_hours" name="credit_hours" 
                                                   value="<?php echo htmlspecialchars($formData['credit_hours']); ?>"
                                                   min="0" max="10" step="0.5" required>
                                            <small class="form-text text-muted">Typically 1-6 credits</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="theory_hours" class="font-weight-bold">Theory Hours</label>
                                            <input type="number" class="form-control" id="theory_hours" name="theory_hours"
                                                   value="<?php echo htmlspecialchars($formData['theory_hours']); ?>"
                                                   min="0" max="40" placeholder="0">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="practical_hours" class="font-weight-bold">Practical Hours</label>
                                            <input type="number" class="form-control" id="practical_hours" name="practical_hours"
                                                   value="<?php echo htmlspecialchars($formData['practical_hours']); ?>"
                                                   min="0" max="40" placeholder="0">
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
                                    <textarea class="form-control" id="prerequisites" name="prerequisites" rows="2"
                                              placeholder="Enter prerequisite subjects or requirements"><?php echo htmlspecialchars($formData['prerequisites']); ?></textarea>
                                    <small class="form-text text-muted">Subjects or knowledge required before taking this course</small>
                                </div>

                                <div class="form-group">
                                    <label for="learning_outcomes" class="font-weight-bold">Learning Outcomes</label>
                                    <textarea class="form-control" id="learning_outcomes" name="learning_outcomes" rows="3"
                                              placeholder="Enter expected learning outcomes"><?php echo htmlspecialchars($formData['learning_outcomes']); ?></textarea>
                                    <small class="form-text text-muted">What students will learn from this subject</small>
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
                                        <i class="fas fa-save mr-1"></i> Add Subject
                                    </button>
                                    <button type="reset" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-redo mr-1"></i> Reset
                                    </button>
                                    <a href="<?php echo BASE_URL; ?>/academic/subjects" class="btn btn-outline-secondary btn-lg">
                                        <i class="fas fa-times mr-1"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Help Section -->
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-question-circle mr-1"></i> Quick Guide
                            </h6>
                        </div>
                        <div class="card-body">
                            <h6>Subject Types:</h6>
                            <ul class="small pl-3">
                                <li><strong>Core:</strong> Mandatory for program completion</li>
                                <li><strong>Elective:</strong> Optional subjects to choose from</li>
                                <li><strong>Lab:</strong> Practical/laboratory work</li>
                                <li><strong>Project:</strong> Research or development project</li>
                                <li><strong>Seminar:</strong> Presentation and discussion based</li>
                                <li><strong>Workshop:</strong> Skill-based training sessions</li>
                            </ul>

                            <h6 class="mt-3">Credit Hours:</h6>
                            <ul class="small pl-3">
                                <li>1 credit = 15-16 hours of instruction</li>
                                <li>Typically 3 credits for standard subjects</li>
                                <li>Lab subjects often have 1-2 credits</li>
                            </ul>

                            <div class="alert alert-warning mt-3">
                                <small>
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    <strong>Note:</strong> Subject code must be unique across the system.
                                </small>
                            </div>
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

    // Form validation
    $('#addSubjectForm').on('submit', function(e) {
        const name = $('#name').val().trim();
        const code = $('#code').val().trim();
        const department = $('#department_id').val();
        
        if (name === '' || code === '' || department === '') {
            e.preventDefault();
            alert('Please fill all required fields.');
            return false;
        }

        // Validate code format (alphanumeric and underscores)
        const codeRegex = /^[a-zA-Z0-9_]+$/;
        if (!codeRegex.test(code)) {
            e.preventDefault();
            alert('Subject code can only contain letters, numbers, and underscores.');
            return false;
        }
    });

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