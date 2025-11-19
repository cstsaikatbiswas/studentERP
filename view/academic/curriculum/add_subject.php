<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include BASE_PATH . '/view/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <div>
                    <h1 class="h2">
                        <i class="fas fa-plus-circle mr-2"></i>Add Subject to Curriculum
                    </h1>
                    <p class="mb-0 text-muted">
                        <strong>Program:</strong> <?php echo $program['name']; ?> (<?php echo $program['code']; ?>)
                    </p>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo BASE_URL; ?>/academic/curriculum?program_id=<?php echo $program['id']; ?>" 
                       class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Curriculum
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
                            <form method="POST" action="<?php echo BASE_URL; ?>/academic/curriculum/add-subject?program_id=<?php echo $program['id']; ?>">
                                <input type="hidden" name="program_id" value="<?php echo $program['id']; ?>">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject_id" class="font-weight-bold">Select Subject *</label>
                                            <select class="form-control" id="subject_id" name="subject_id" required>
                                                <option value="">Choose a subject...</option>
                                                <?php foreach ($availableSubjects as $subject): ?>
                                                    <option value="<?php echo $subject['id']; ?>" 
                                                        <?php echo $formData['subject_id'] == $subject['id'] ? 'selected' : ''; ?>>
                                                        <?php echo $subject['code']; ?> - <?php echo $subject['name']; ?>
                                                        (<?php echo $subject['credit_hours']; ?> credits)
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="semester" class="font-weight-bold">Semester *</label>
                                            <select class="form-control" id="semester" name="semester" required>
                                                <option value="">Select Semester</option>
                                                <?php foreach ($semesters as $sem): ?>
                                                    <option value="<?php echo $sem; ?>" 
                                                        <?php echo $formData['semester'] == $sem ? 'selected' : ''; ?>>
                                                        Semester <?php echo $sem; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_code" class="font-weight-bold">Course Code</label>
                                            <input type="text" class="form-control" id="course_code" name="course_code"
                                                   value="<?php echo htmlspecialchars($formData['course_code']); ?>"
                                                   placeholder="Enter course code (optional)">
                                            <small class="form-text text-muted">Leave blank to use subject code</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_type" class="font-weight-bold">Course Type *</label>
                                            <select class="form-control" id="course_type" name="course_type" required>
                                                <option value="mandatory" <?php echo $formData['course_type'] == 'mandatory' ? 'selected' : ''; ?>>Mandatory</option>
                                                <option value="elective" <?php echo $formData['course_type'] == 'elective' ? 'selected' : ''; ?>>Elective</option>
                                                <option value="audit" <?php echo $formData['course_type'] == 'audit' ? 'selected' : ''; ?>>Audit</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="min_credits" class="font-weight-bold">Minimum Credits</label>
                                            <input type="number" class="form-control" id="min_credits" name="min_credits"
                                                   value="<?php echo htmlspecialchars($formData['min_credits']); ?>"
                                                   step="0.5" min="0" max="10"
                                                   placeholder="Min credits">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="max_credits" class="font-weight-bold">Maximum Credits</label>
                                            <input type="number" class="form-control" id="max_credits" name="max_credits"
                                                   value="<?php echo htmlspecialchars($formData['max_credits']); ?>"
                                                   step="0.5" min="0" max="10"
                                                   placeholder="Max credits">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-check mt-4">
                                                <input type="checkbox" class="form-check-input" id="is_optional" name="is_optional"
                                                       <?php echo $formData['is_optional'] ? 'checked' : ''; ?>>
                                                <label class="form-check-label font-weight-bold" for="is_optional">
                                                    Optional Subject
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="teaching_methodology" class="font-weight-bold">Teaching Methodology</label>
                                    <textarea class="form-control" id="teaching_methodology" name="teaching_methodology" 
                                              rows="3" placeholder="Describe teaching methods..."><?php echo htmlspecialchars($formData['teaching_methodology']); ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="assessment_pattern" class="font-weight-bold">Assessment Pattern</label>
                                    <textarea class="form-control" id="assessment_pattern" name="assessment_pattern" 
                                              rows="3" placeholder='e.g., {"internal": 40, "external": 60}'><?php echo htmlspecialchars($formData['assessment_pattern']); ?></textarea>
                                    <small class="form-text text-muted">Enter assessment pattern in JSON format</small>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-plus-circle mr-1"></i> Add to Curriculum
                                    </button>
                                    <a href="<?php echo BASE_URL; ?>/academic/curriculum?program_id=<?php echo $program['id']; ?>" 
                                       class="btn btn-outline-secondary btn-lg">
                                        <i class="fas fa-times mr-1"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Program Information -->
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle mr-1"></i> Program Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Program:</strong> <?php echo $program['name']; ?></p>
                            <p><strong>Code:</strong> <?php echo $program['code']; ?></p>
                            <p><strong>Duration:</strong> <?php echo $program['duration_years']; ?> Years</p>
                            <p><strong>Total Semesters:</strong> <?php echo $program['total_semesters']; ?></p>
                            <p><strong>Total Credits:</strong> <?php echo $program['total_credits']; ?></p>
                            <p><strong>Degree Type:</strong> <?php echo ucfirst($program['degree_type']); ?></p>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="card shadow mt-4">
                        <div class="card-header bg-warning text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-chart-bar mr-1"></i> Quick Stats
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php
                            $totalSubjects = 0;
                            foreach ($curriculum as $semester => $subjects) {
                                $totalSubjects += count($subjects);
                            }
                            ?>
                            <p><strong>Total Subjects:</strong> <?php echo $totalSubjects; ?></p>
                            <p><strong>Subjects per Semester:</strong></p>
                            <ul class="list-unstyled">
                                <?php for ($sem = 1; $sem <= $program['total_semesters']; $sem++): ?>
                                    <li>Semester <?php echo $sem; ?>: 
                                        <?php echo isset($curriculum[$sem]) ? count($curriculum[$sem]) : 0; ?> subjects
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
$(document).ready(function() {
    // Auto-fill course code based on selected subject
    $('#subject_id').on('change', function() {
        const subjectId = $(this).val();
        if (subjectId && $('#course_code').val() === '') {
            // You could fetch subject details via AJAX and auto-fill course code
            // For now, we'll just leave it as is
        }
    });

    // Form validation
    $('form').on('submit', function(e) {
        const subjectId = $('#subject_id').val();
        const semester = $('#semester').val();
        
        if (!subjectId || !semester) {
            e.preventDefault();
            alert('Please fill all required fields.');
            return false;
        }
    });
});
</script>