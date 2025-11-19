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
                        <i class="fas fa-book-open mr-2"></i>Curriculum Management
                    </h1>
                    <p class="mb-0 text-muted">
                        <strong>Program:</strong> <?php echo $program['name']; ?> (<?php echo $program['code']; ?>)
                        | <strong>Duration:</strong> <?php echo $program['duration_years']; ?> Years
                        | <strong>Semesters:</strong> <?php echo $program['total_semesters']; ?>
                    </p>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo BASE_URL; ?>/academic/curriculum/add-subject?program_id=<?php echo $program['id']; ?>" 
                       class="btn btn-primary mr-2">
                        <i class="fas fa-plus-circle mr-1"></i> Add Subject
                    </a>
                    <a href="<?php echo BASE_URL; ?>/academic/programs" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Programs
                    </a>
                </div>
            </div>

            <!-- Alerts -->
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <!-- Program Overview -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-left-primary shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Subjects
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php 
                                            $totalSubjects = 0;
                                            foreach ($curriculum as $semester => $subjects) {
                                                $totalSubjects += count($subjects);
                                            }
                                            echo $totalSubjects;
                                        ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-book fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-left-success shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Credits
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $program['total_credits']; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-star fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-left-info shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Semesters
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $program['total_semesters']; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-layer-group fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-left-warning shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Current Students
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $program['current_students']; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Curriculum by Semester -->
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-sitemap mr-1"></i> Curriculum Structure
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (empty($curriculum)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Subjects in Curriculum</h5>
                            <p class="text-muted">Start building your curriculum by adding subjects to this program.</p>
                            <a href="<?php echo BASE_URL; ?>/academic/curriculum/add-subject?program_id=<?php echo $program['id']; ?>" 
                               class="btn btn-primary">
                                <i class="fas fa-plus-circle mr-1"></i> Add First Subject
                            </a>
                        </div>
                    <?php else: ?>
                        <?php for ($semester = 1; $semester <= $program['total_semesters']; $semester++): ?>
                            <div class="semester-section mb-5">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="font-weight-bold text-primary">
                                        <i class="fas fa-layer-group mr-2"></i>Semester <?php echo $semester; ?>
                                    </h5>
                                    <div>
                                        <a href="<?php echo BASE_URL; ?>/academic/curriculum/semester-view?program_id=<?php echo $program['id']; ?>&semester=<?php echo $semester; ?>" 
                                           class="btn btn-sm btn-outline-primary mr-2">
                                            <i class="fas fa-eye mr-1"></i> View Details
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>/academic/curriculum/add-subject?program_id=<?php echo $program['id']; ?>&semester=<?php echo $semester; ?>" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus mr-1"></i> Add Subject
                                        </a>
                                    </div>
                                </div>

                                <?php if (isset($curriculum[$semester]) && !empty($curriculum[$semester])): ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Subject Code</th>
                                                    <th>Subject Name</th>
                                                    <th>Type</th>
                                                    <th>Credits</th>
                                                    <th>Course Type</th>
                                                    <th>Department</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($curriculum[$semester] as $subject): ?>
                                                    <tr>
                                                        <td>
                                                            <span class="badge badge-info"><?php echo $subject['course_code'] ?: $subject['subject_code']; ?></span>
                                                        </td>
                                                        <td>
                                                            <strong><?php echo $subject['subject_name']; ?></strong>
                                                            <?php if ($subject['is_optional']): ?>
                                                                <span class="badge badge-warning ml-1">Optional</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-<?php echo $subject['subject_type'] == 'core' ? 'primary' : 'success'; ?>">
                                                                <?php echo ucfirst($subject['subject_type']); ?>
                                                            </span>
                                                        </td>
                                                        <td><?php echo $subject['credit_hours']; ?></td>
                                                        <td>
                                                            <span class="badge badge-<?php echo $subject['course_type'] == 'mandatory' ? 'dark' : 'info'; ?>">
                                                                <?php echo ucfirst($subject['course_type']); ?>
                                                            </span>
                                                        </td>
                                                        <td><?php echo $subject['department_name'] ?: 'N/A'; ?></td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <button type="button" 
                                                                        class="btn btn-primary edit-subject"
                                                                        data-toggle="modal" 
                                                                        data-target="#editSubjectModal"
                                                                        data-id="<?php echo $subject['id']; ?>"
                                                                        data-subject='<?php echo json_encode($subject); ?>'
                                                                        title="Edit Subject">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <a href="<?php echo BASE_URL; ?>/academic/curriculum/remove-subject?id=<?php echo $subject['id']; ?>&program_id=<?php echo $program['id']; ?>" 
                                                                   class="btn btn-danger remove-subject"
                                                                   title="Remove Subject"
                                                                   onclick="return confirm('Are you sure you want to remove this subject from the curriculum?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        No subjects added to this semester yet.
                                        <a href="<?php echo BASE_URL; ?>/academic/curriculum/add-subject?program_id=<?php echo $program['id']; ?>&semester=<?php echo $semester; ?>" 
                                           class="alert-link">Add subjects now</a>.
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if ($semester < $program['total_semesters']): ?>
                                <hr class="my-4">
                            <?php endif; ?>
                        <?php endfor; ?>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Edit Subject Modal -->
<div class="modal fade" id="editSubjectModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Subject in Curriculum</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editSubjectForm" method="POST" action="<?php echo BASE_URL; ?>/academic/curriculum/update-subject">
                <div class="modal-body" id="editSubjectModalBody">
                    <!-- Content will be loaded via JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Subject</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Edit subject modal
    $('.edit-subject').on('click', function() {
        const subjectData = $(this).data('subject');
        const subjectId = $(this).data('id');
        
        $('#editSubjectModalBody').html(`
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2">Loading subject details...</p>
            </div>
        `);
        
        // Load edit form via AJAX
        $.ajax({
            url: '<?php echo BASE_URL; ?>/academic/curriculum/edit-subject-form?id=' + subjectId,
            method: 'GET',
            success: function(response) {
                $('#editSubjectModalBody').html(response);
            },
            error: function() {
                $('#editSubjectModalBody').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Error loading subject details. Please try again.
                    </div>
                `);
            }
        });
    });

    // Confirm removal
    $('.remove-subject').on('click', function(e) {
        if (!confirm('Are you sure you want to remove this subject from the curriculum?')) {
            e.preventDefault();
        }
    });
});
</script>