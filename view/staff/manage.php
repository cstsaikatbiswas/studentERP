<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include BASE_PATH . '/view/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-users mr-2"></i>Staff Management
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo BASE_URL; ?>/staff/add" class="btn btn-primary">
                        <i class="fas fa-plus-circle mr-1"></i> Add Staff
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
                <div class="card-header bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-filter mr-1"></i> Filter Staff
                    </h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="<?php echo BASE_URL; ?>/staff/manage" class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">All Categories</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['id']; ?>" 
                                            <?php echo isset($_GET['category_id']) && $_GET['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                                            <?php echo $category['name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Designation</label>
                                <select name="designation_id" class="form-control">
                                    <option value="">All Designations</option>
                                    <?php foreach ($designations as $designation): ?>
                                        <option value="<?php echo $designation['id']; ?>"
                                            <?php echo isset($_GET['designation_id']) && $_GET['designation_id'] == $designation['id'] ? 'selected' : ''; ?>>
                                            <?php echo $designation['name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="active" <?php echo isset($_GET['status']) && $_GET['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?php echo isset($_GET['status']) && $_GET['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                    <option value="suspended" <?php echo isset($_GET['status']) && $_GET['status'] == 'suspended' ? 'selected' : ''; ?>>Suspended</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Institute</label>
                                <select name="institute_id" class="form-control">
                                    <option value="">All Institutes</option>
                                    <?php foreach ($institutes as $institute): ?>
                                        <option value="<?php echo $institute['id']; ?>"
                                            <?php echo isset($_GET['institute_id']) && $_GET['institute_id'] == $institute['id'] ? 'selected' : ''; ?>>
                                            <?php echo $institute['name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search mr-1"></i> Filter
                            </button>
                            <a href="<?php echo BASE_URL; ?>/staff/manage" class="btn btn-secondary">
                                <i class="fas fa-redo mr-1"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Staff List -->
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list mr-1"></i> Staff List
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (empty($staff_list)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Staff Found</h5>
                            <p class="text-muted">Get started by adding your first staff member.</p>
                            <a href="<?php echo BASE_URL; ?>/staff/add" class="btn btn-primary">
                                <i class="fas fa-plus-circle mr-1"></i> Add Staff
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="staffTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Staff ID</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Designation</th>
                                        <th>Contact</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($staff_list as $index => $staff): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td>
                                                <span class="badge badge-info"><?php echo $staff['staff_id']; ?></span>
                                            </td>
                                            <td>
                                                <strong><?php echo $staff['first_name'] . ' ' . $staff['last_name']; ?></strong>
                                                <?php if (!empty($staff['email'])): ?>
                                                    <br><small class="text-muted"><?php echo $staff['email']; ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary"><?php echo $staff['category_name']; ?></span>
                                            </td>
                                            <td><?php echo $staff['designation_name']; ?></td>
                                            <td>
                                                <?php if (!empty($staff['phone'])): ?>
                                                    <i class="fas fa-phone text-muted mr-1"></i> <?php echo $staff['phone']; ?>
                                                    <br>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    $status_badge = [
                                                        'active' => 'success',
                                                        'inactive' => 'secondary',
                                                        'suspended' => 'warning',
                                                        'retired' => 'info',
                                                        'resigned' => 'danger'
                                                    ];
                                                ?>
                                                <span class="badge badge-<?php echo $status_badge[$staff['status']] ?? 'secondary'; ?>">
                                                    <?php echo ucfirst($staff['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="<?php echo BASE_URL; ?>/staff/view?id=<?php echo $staff['id']; ?>" 
                                                       class="btn btn-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?php echo BASE_URL; ?>/staff/edit?id=<?php echo $staff['id']; ?>" 
                                                       class="btn btn-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?php echo BASE_URL; ?>/staff/allocation?staff_id=<?php echo $staff['id']; ?>" 
                                                       class="btn btn-warning" title="Allocate">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-danger delete-staff" 
                                                            data-id="<?php echo $staff['id']; ?>"
                                                            data-name="<?php echo $staff['first_name'] . ' ' . $staff['last_name']; ?>"
                                                            title="Delete">
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

            <!-- Statistics -->
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Staff
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalStaff">0</div>
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
                                        Active Staff
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="activeStaff">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-check fa-2x text-gray-300"></i>
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
                                        Teaching Staff
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="teachingStaff">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
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
                                        Non-Teaching Staff
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="nonTeachingStaff">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete staff member "<strong id="deleteStaffName"></strong>"?</p>
                <p class="text-danger"><small>This action cannot be undone. All allocations and records will be deleted.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="#" id="confirmDelete" class="btn btn-danger">Delete Staff</a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#staffTable').DataTable({
        "pageLength": 10,
        "order": [[0, 'asc']],
        "language": {
            "search": "Search staff:",
            "lengthMenu": "Show _MENU_ staff per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ staff"
        }
    });

    // Delete confirmation
    $('.delete-staff').on('click', function() {
        const staffId = $(this).data('id');
        const staffName = $(this).data('name');
        
        $('#deleteStaffName').text(staffName);
        $('#confirmDelete').attr('href', '<?php echo BASE_URL; ?>/staff/delete?id=' + staffId);
        $('#deleteModal').modal('show');
    });

    // Load statistics
    $.ajax({
        url: '<?php echo BASE_URL; ?>/staff/api/statistics',
        method: 'GET',
        success: function(stats) {
            $('#totalStaff').text(stats.total_staff || 0);
            $('#activeStaff').text(stats.active_staff || 0);
            $('#teachingStaff').text(stats.teaching_staff || 0);
            $('#nonTeachingStaff').text(stats.non_teaching_staff || 0);
        }
    });
});
</script>