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
                        <i class="fas fa-layer-group mr-2"></i>Semester <?php echo $semester; ?> Details
                    </h1>
                    <p class="mb-0 text-muted">
                        <strong>Program:</strong> <?php echo $program['name']; ?> (<?php echo $program['code']; ?>)
                    </p>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <a href="<?php echo BASE_URL; ?>/academic/curriculum?program_id=<?php echo $program['id']; ?>" 
                           class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Back to Curriculum
                        </a>
                        <a href="<?php echo BASE_URL; ?>/academic/curriculum/add-subject?program_id=<?php echo $program['id']; ?>&semester=<?php echo $semester; ?>" 
                           class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i> Add Subject
                        </a>
                    </div>
                    <!-- Semester Navigation -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown">
                            Jump to Semester
                        </button>
                        <div class="dropdown-menu">
                            <?php foreach ($semesters as $sem): ?>
                                <a class="dropdown-item <?php echo $sem == $semester ? 'active' : ''; ?>" 
                                   href="<?php echo BASE_URL; ?>/academic/curriculum/semester-view?program_id=<?php echo $program['id']; ?>&semester=<?php echo $sem; ?>">
                                    Semester <?php echo $sem; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Semester Statistics -->
            <div class="row mb-4">
                <div class="col-md-2">
                    <div class="card border-left-primary shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Subjects
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $semesterStats['total_subjects']; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-book fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card border-left-success shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Credits
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $semesterStats['total_credits']; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-star fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card border-left-info shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Theory Hours
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $semesterStats['theory_hours']; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card border-left-warning shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Practical Hours
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $semesterStats['practical_hours']; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-flask fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card border-left-dark shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                        Core Subjects
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $semesterStats['core_subjects']; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-cube fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card border-left-secondary shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                        Elective Subjects
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $semesterStats['elective_subjects']; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subjects List -->
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list mr-1"></i> Subjects - Semester <?php echo $semester; ?>
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (empty($semesterSubjects)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Subjects in This Semester</h5>
                            <p class="text-muted">Add subjects to build the semester curriculum.</p>
                            <a href="<?php echo BASE_URL; ?>/academic/curriculum/add-subject?program_id=<?php echo $program['id']; ?>&semester=<?php echo $semester; ?>" 
                               class="btn btn-primary">
                                <i class="fas fa-plus-circle mr-1"></i> Add Subjects
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($semesterSubjects as $subject): ?>
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 subject-card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">
                                                <span class="badge badge-info"><?php echo $subject['course_code'] ?: $subject['subject_code']; ?></span>
                                                <?php echo $subject['subject_name']; ?>
                                            </h6>
                                            <div>
                                                <?php if ($subject['is_optional']): ?>
                                                    <span class="badge badge-warning">Optional</span>
                                                <?php endif; ?>
                                                <span class="badge badge-<?php echo $subject['course_type'] == 'mandatory' ? 'dark' : 'info'; ?>">
                                                    <?php echo ucfirst($subject['course_type']); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-2">
                                                <div class="col-6">
                                                    <small class="text-muted">Credits:</small>
                                                    <br><strong><?php echo $subject['credit_hours']; ?></strong>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">Type:</small>
                                                    <br>
                                                    <span class="badge badge-<?php echo $subject['subject_type'] == 'core' ? 'primary' : 'success'; ?>">
                                                        <?php echo ucfirst($subject['subject_type']); ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6">
                                                    <small class="text-muted">Theory:</small>
                                                    <br><strong><?php echo $subject['theory_hours']; ?> hrs</strong>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">Practical:</small>
                                                    <br><strong><?php echo $subject['practical_hours']; ?> hrs</strong>
                                                </div>
                                            </div>
                                            <?php if ($subject['department_name']): ?>
                                                <div class="mb-2">
                                                    <small class="text-muted">Department:</small>
                                                    <br><strong><?php echo $subject['department_name']; ?></strong>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($subject['description']): ?>
                                                <div class="mb-2">
                                                    <small class="text-muted">Description:</small>
                                                    <br><small><?php echo substr($subject['description'], 0, 100); ?>...</small>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($subject['learning_outcomes']): ?>
                                                <div class="mb-2">
                                                    <small class="text-muted">Learning Outcomes:</small>
                                                    <br><small><?php echo substr($subject['learning_outcomes'], 0, 100); ?>...</small>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-footer">
                                            <div class="btn-group btn-group-sm w-100" role="group">
                                                <a href="<?php echo BASE_URL; ?>/academic/curriculum/remove-subject?id=<?php echo $subject['id']; ?>&program_id=<?php echo $program['id']; ?>" 
                                                   class="btn btn-outline-danger remove-subject"
                                                   onclick="return confirm('Are you sure you want to remove this subject from the curriculum?')">
                                                    <i class="fas fa-trash mr-1"></i> Remove
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
.subject-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.subject-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.subject-card .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}
</style>

<script>
$(document).ready(function() {
    // Confirm subject removal
    $('.remove-subject').on('click', function(e) {
        if (!confirm('Are you sure you want to remove this subject from the curriculum?')) {
            e.preventDefault();
        }
    });
});
</script>