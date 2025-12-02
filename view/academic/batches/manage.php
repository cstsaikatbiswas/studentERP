<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include BASE_PATH . '/view/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-users mr-2"></i>Batch Management
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo BASE_URL; ?>/academic/batches/add" class="btn btn-primary">
                        <i class="fas fa-plus-circle mr-1"></i> Add Batch
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

            <!-- Filter Section -->
            <div class="card shadow mb-4">
                <div class="card-header bg-light">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-filter mr-1"></i> Filter Batches
                    </h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="<?php echo BASE_URL; ?>/academic/batches" id="filterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="program_filter" class="font-weight-bold">Program</label>
                                    <select class="form-control" id="program_filter" name="program_id">
                                        <option value="">All Programs</option>
                                        <?php foreach ($programs as $program): ?>
                                            <option value="<?php echo $program['id']; ?>" 
                                                <?php echo isset($_GET['program_id']) && $_GET['program_id'] == $program['id'] ? 'selected' : ''; ?>>
                                                <?php echo $program['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="year_filter" class="font-weight-bold">Batch Year</label>
                                    <select class="form-control" id="year_filter" name="batch_year">
                                        <option value="">All Years</option>
                                        <?php foreach ($batch_years as $year): ?>
                                            <option value="<?php echo $year['batch_year']; ?>" 
                                                <?php echo isset($_GET['batch_year']) && $_GET['batch_year'] == $year['batch_year'] ? 'selected' : ''; ?>>
                                                <?php echo $year['batch_year']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status_filter" class="font-weight-bold">Status</label>
                                    <select class="form-control" id="status_filter" name="status">
                                        <option value="">All Status</option>
                                        <option value="active" <?php echo isset($_GET['status']) && $_GET['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                        <option value="completed" <?php echo isset($_GET['status']) && $_GET['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                        <option value="upcoming" <?php echo isset($_GET['status']) && $_GET['status'] == 'upcoming' ? 'selected' : ''; ?>>Upcoming</option>
                                        <option value="cancelled" <?php echo isset($_GET['status']) && $_GET['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="department_filter" class="font-weight-bold">Department</label>
                                    <select class="form-control" id="department_filter" name="department_id">
                                        <option value="">All Departments</option>
                                        <?php foreach ($departments as $dept): ?>
                                            <option value="<?php echo $dept['id']; ?>" 
                                                <?php echo isset($_GET['department_id']) && $_GET['department_id'] == $dept['id'] ? 'selected' : ''; ?>>
                                                <?php echo $dept['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search mr-1"></i> Apply Filters
                            </button>
                            <a href="<?php echo BASE_URL; ?>/academic/batches" class="btn btn-secondary">
                                <i class="fas fa-redo mr-1"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Batch Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Batches
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $batch_stats['total_batches'] ?? 0; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Active Batches
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $batch_stats['active_batches'] ?? 0; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Total Students
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $batch_stats['total_students'] ?? 0; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Avg Batch Size
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo round($batch_stats['avg_batch_size'] ?? 0, 1); ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-bar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Batches Table -->
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list mr-1"></i> All Batches
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (empty($batches)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Batches Found</h5>
                            <p class="text-muted">Get started by adding your first batch.</p>
                            <a href="<?php echo BASE_URL; ?>/academic/batches/add" class="btn btn-primary">
                                <i class="fas fa-plus-circle mr-1"></i> Add Batch
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="batchesTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Batch Code</th>
                                        <th>Batch Name</th>
                                        <th>Program</th>
                                        <th>Department</th>
                                        <th>Year</th>
                                        <th>Students</th>
                                        <th>Semester</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($batches as $index => $batch): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td>
                                                <span class="badge badge-info"><?php echo $batch['batch_code']; ?></span>
                                            </td>
                                            <td>
                                                <strong><?php echo $batch['batch_name']; ?></strong>
                                                <br>
                                                <small class="text-muted">
                                                    <?php echo date('M Y', strtotime($batch['start_date'])); ?> - 
                                                    <?php echo $batch['end_date'] ? date('M Y', strtotime($batch['end_date'])) : 'Present'; ?>
                                                </small>
                                            </td>
                                            <td>
                                                <strong><?php echo $batch['program_name']; ?></strong>
                                                <br><small class="text-muted"><?php echo $batch['program_code']; ?></small>
                                            </td>
                                            <td><?php echo $batch['department_name']; ?></td>
                                            <td>
                                                <span class="badge badge-secondary"><?php echo $batch['batch_year']; ?></span>
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
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
                                                        <?php echo $batch['student_count']; ?>/<?php echo $batch['max_capacity']; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-primary">Sem <?php echo $batch['current_semester']; ?></span>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?php 
                                                    echo $batch['status'] == 'active' ? 'success' : 
                                                          ($batch['status'] == 'completed' ? 'secondary' : 
                                                          ($batch['status'] == 'upcoming' ? 'warning' : 'danger'));
                                                ?>">
                                                    <?php echo ucfirst($batch['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="<?php echo BASE_URL; ?>/academic/batches/view?id=<?php echo $batch['id']; ?>" 
                                                       class="btn btn-info" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?php echo BASE_URL; ?>/academic/batches/edit?id=<?php echo $batch['id']; ?>" 
                                                       class="btn btn-primary" title="Edit Batch">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-danger delete-batch" 
                                                            data-id="<?php echo $batch['id']; ?>"
                                                            data-name="<?php echo $batch['batch_name']; ?>"
                                                            title="Delete Batch">
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
    // Initialize DataTable
    $('#batchesTable').DataTable({
        "pageLength": 10,
        "order": [[0, 'asc']],
        "language": {
            "search": "Search batches:",
            "lengthMenu": "Show _MENU_ batches per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ batches"
        }
    });

    // Delete confirmation
    $('.delete-batch').on('click', function() {
        const batchId = $(this).data('id');
        const batchName = $(this).data('name');
        
        $('#deleteBatchName').text(batchName);
        $('#confirmBatchDelete').attr('href', '<?php echo BASE_URL; ?>/academic/batches/delete?id=' + batchId);
        $('#deleteBatchModal').modal('show');
    });

    // Filter form submission
    $('#filterForm').on('submit', function(e) {
        // Convert form data to URL parameters
        const formData = $(this).serialize();
        const url = '<?php echo BASE_URL; ?>/academic/batches?' + formData;
        window.location.href = url;
        e.preventDefault();
    });
});
</script>