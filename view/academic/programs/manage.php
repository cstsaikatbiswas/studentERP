<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include BASE_PATH . '/view/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-graduation-cap mr-2"></i>Academic Programs
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo BASE_URL; ?>/academic/programs/add" class="btn btn-primary">
                        <i class="fas fa-plus-circle mr-1"></i> Add Program
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

            <!-- Programs Statistics -->
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Programs
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalPrograms">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
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
                                        Active Programs
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="activePrograms">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                                        Undergraduate
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="undergraduatePrograms">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
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
                                        Postgraduate
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="postgraduatePrograms">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Programs Table -->
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list mr-1"></i> All Academic Programs
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (empty($programs)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Programs Found</h5>
                            <p class="text-muted">Get started by adding your first academic program.</p>
                            <a href="<?php echo BASE_URL; ?>/academic/programs/add" class="btn btn-primary">
                                <i class="fas fa-plus-circle mr-1"></i> Add Program
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="programsTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Program Name</th>
                                        <th>Code</th>
                                        <th>Department</th>
                                        <th>Degree Type</th>
                                        <th>Duration</th>
                                        <th>Credits</th>
                                        <th>Students</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($programs as $index => $program): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td>
                                                <strong><?php echo $program['name']; ?></strong>
                                                <?php if ($program['description']): ?>
                                                    <br><small class="text-muted"><?php echo substr($program['description'], 0, 50); ?>...</small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-info"><?php echo $program['code']; ?></span>
                                            </td>
                                            <td>
                                                <?php echo $program['department_name']; ?>
                                                <br><small class="text-muted"><?php echo $program['department_code']; ?></small>
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary"><?php echo ucfirst($program['degree_type']); ?></span>
                                            </td>
                                            <td><?php echo $program['duration_years']; ?> Years</td>
                                            <td><?php echo $program['total_credits']; ?> Credits</td>
                                            <td>
                                                <span class="badge badge-primary"><?php echo $program['current_students']; ?></span> / 
                                                <span class="badge badge-secondary"><?php echo $program['max_students']; ?></span>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?php 
                                                    echo $program['status'] == 'active' ? 'success' : 
                                                          ($program['status'] == 'inactive' ? 'secondary' : 'warning'); 
                                                ?>">
                                                    <?php echo ucfirst($program['status']); ?>
                                                </span>
                                                <?php if ($program['accreditation_status'] == 'accredited'): ?>
                                                    <br><span class="badge badge-success">Accredited</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="<?php echo BASE_URL; ?>/academic/programs/view?id=<?php echo $program['id']; ?>" 
                                                       class="btn btn-info" title="View Program">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?php echo BASE_URL; ?>/academic/programs/edit?id=<?php echo $program['id']; ?>" 
                                                       class="btn btn-primary" title="Edit Program">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?php echo BASE_URL; ?>/academic/curriculum?program_id=<?php echo $program['id']; ?>" 
                                                       class="btn btn-warning" title="Manage Curriculum">
                                                        <i class="fas fa-book"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-danger delete-program" 
                                                            data-id="<?php echo $program['id']; ?>"
                                                            data-name="<?php echo $program['name']; ?>"
                                                            title="Delete Program">
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

            <!-- Quick Actions -->
            <div class="row mt-4">
                <div class="col-md-4 mb-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-plus-circle fa-2x mb-2"></i>
                            <h5>Add New Program</h5>
                            <p class="mb-3">Create a new academic program</p>
                            <a href="<?php echo BASE_URL; ?>/academic/programs/add" class="btn btn-light">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-book fa-2x mb-2"></i>
                            <h5>Manage Curriculum</h5>
                            <p class="mb-3">Design program curriculum</p>
                            <a href="<?php echo BASE_URL; ?>/academic/curriculum/manage" class="btn btn-light">Manage</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-bar fa-2x mb-2"></i>
                            <h5>Program Analytics</h5>
                            <p class="mb-3">View program statistics</p>
                            <a href="#" class="btn btn-light">View Reports</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteProgramModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete program "<strong id="deleteProgramName"></strong>"?</p>
                <p class="text-danger"><small>This action cannot be undone. All associated batches and curriculum will be affected.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="#" id="confirmProgramDelete" class="btn btn-danger">Delete Program</a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#programsTable').DataTable({
        "pageLength": 10,
        "order": [[0, 'asc']],
        "language": {
            "search": "Search programs:",
            "lengthMenu": "Show _MENU_ programs per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ programs"
        }
    });

    // Delete confirmation
    $('.delete-program').on('click', function() {
        const programId = $(this).data('id');
        const programName = $(this).data('name');
        
        $('#deleteProgramName').text(programName);
        $('#confirmProgramDelete').attr('href', '<?php echo BASE_URL; ?>/academic/programs/delete?id=' + programId);
        $('#deleteProgramModal').modal('show');
    });

    // Load program statistics
    loadProgramStatistics();
});

function loadProgramStatistics() {
    $.ajax({
        url: '<?php echo BASE_URL; ?>/academic/api/program-statistics',
        method: 'GET',
        success: function(stats) {
            $('#totalPrograms').text(stats.total_programs || 0);
            $('#activePrograms').text(stats.active_programs || 0);
            $('#undergraduatePrograms').text(stats.undergraduate_programs || 0);
            $('#postgraduatePrograms').text(stats.postgraduate_programs || 0);
        }
    });
}
</script>