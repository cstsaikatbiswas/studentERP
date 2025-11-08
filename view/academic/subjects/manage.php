<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include BASE_PATH . '/view/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-book mr-2"></i>Subject Management
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo BASE_URL; ?>/academic/subjects/add" class="btn btn-primary">
                        <i class="fas fa-plus-circle mr-1"></i> Add Subject
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

            <!-- Subject Statistics -->
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Subjects
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalSubjects">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-book fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Core Subjects
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="coreSubjects">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-star fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Elective Subjects
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="electiveSubjects">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-list-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Lab Subjects
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="labSubjects">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-flask fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subjects Table -->
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list mr-1"></i> All Subjects
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (empty($subjects)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-book fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Subjects Found</h5>
                            <p class="text-muted">Get started by adding your first subject.</p>
                            <a href="<?php echo BASE_URL; ?>/academic/subjects/add" class="btn btn-primary">
                                <i class="fas fa-plus-circle mr-1"></i> Add Subject
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="subjectsTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Subject Name</th>
                                        <th>Code</th>
                                        <th>Department</th>
                                        <th>Type</th>
                                        <th>Credit Hours</th>
                                        <th>Contact Hours</th>
                                        <th>Difficulty</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($subjects as $index => $subject): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td>
                                                <strong><?php echo $subject['name']; ?></strong>
                                                <?php if ($subject['description']): ?>
                                                    <br><small class="text-muted"><?php echo substr($subject['description'], 0, 50); ?>...</small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-info"><?php echo $subject['code']; ?></span>
                                            </td>
                                            <td>
                                                <?php echo $subject['department_name'] ?: 'N/A'; ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?php 
                                                    echo $subject['subject_type'] == 'core' ? 'primary' : 
                                                          ($subject['subject_type'] == 'elective' ? 'success' : 
                                                          ($subject['subject_type'] == 'lab' ? 'info' : 'warning')); 
                                                ?>">
                                                    <?php echo ucfirst($subject['subject_type']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo $subject['credit_hours']; ?> Credits</td>
                                            <td>
                                                <?php if ($subject['theory_hours'] || $subject['practical_hours']): ?>
                                                    T:<?php echo $subject['theory_hours']; ?>h 
                                                    P:<?php echo $subject['practical_hours']; ?>h
                                                <?php else: ?>
                                                    N/A
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?php 
                                                    echo $subject['difficulty_level'] == 'basic' ? 'success' : 
                                                          ($subject['difficulty_level'] == 'intermediate' ? 'warning' : 'danger'); 
                                                ?>">
                                                    <?php echo ucfirst($subject['difficulty_level']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?php echo $subject['status'] == 'active' ? 'success' : 'secondary'; ?>">
                                                    <?php echo ucfirst($subject['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="<?php echo BASE_URL; ?>/academic/subjects/edit?id=<?php echo $subject['id']; ?>" 
                                                       class="btn btn-primary" title="Edit Subject">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-danger delete-subject" 
                                                            data-id="<?php echo $subject['id']; ?>"
                                                            data-name="<?php echo $subject['name']; ?>"
                                                            title="Delete Subject">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteSubjectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete subject "<strong id="deleteSubjectName"></strong>"?</p>
                <p class="text-danger"><small>This action cannot be undone. This subject will be removed from all programs.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="#" id="confirmSubjectDelete" class="btn btn-danger">Delete Subject</a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#subjectsTable').DataTable({
        "pageLength": 10,
        "order": [[0, 'asc']],
        "language": {
            "search": "Search subjects:",
            "lengthMenu": "Show _MENU_ subjects per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ subjects"
        }
    });

    // Delete confirmation
    $('.delete-subject').on('click', function() {
        const subjectId = $(this).data('id');
        const subjectName = $(this).data('name');
        
        $('#deleteSubjectName').text(subjectName);
        $('#confirmSubjectDelete').attr('href', '<?php echo BASE_URL; ?>/academic/subjects/delete?id=' + subjectId);
        $('#deleteSubjectModal').modal('show');
    });

    // Load subject statistics
    loadSubjectStatistics();
});

function loadSubjectStatistics() {
    $.ajax({
        url: '<?php echo BASE_URL; ?>/academic/api/subject-statistics',
        method: 'GET',
        success: function(stats) {
            $('#totalSubjects').text(stats.total_subjects || 0);
            $('#coreSubjects').text(stats.core_subjects || 0);
            $('#electiveSubjects').text(stats.elective_subjects || 0);
            $('#labSubjects').text(stats.lab_subjects || 0);
        }
    });
}
</script>