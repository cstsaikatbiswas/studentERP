<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include BASE_PATH . '/view/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-university mr-2"></i>Manage Institutes
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="institutes/add" class="btn btn-primary">
                        <i class="fas fa-plus-circle mr-1"></i> Add Institute
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

            <!-- Institutes Table -->
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list mr-1"></i> All Institutes
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (empty($institutes)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-university fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Institutes Found</h5>
                            <p class="text-muted">Get started by adding your first institute.</p>
                            <a href="add" class="btn btn-primary">
                                <i class="fas fa-plus-circle mr-1"></i> Add Institute
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="institutesTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>City</th>
                                        <th>Status</th>
                                        <th>Established</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($institutes as $index => $institute): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td>
                                                <span class="badge badge-info"><?php echo $institute['code']; ?></span>
                                            </td>
                                            <td>
                                                <strong><?php echo $institute['name']; ?></strong>
                                                <?php if (!empty($institute['email'])): ?>
                                                    <br><small class="text-muted"><?php echo $institute['email']; ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary"><?php echo ucfirst($institute['type']); ?></span>
                                            </td>
                                            <td><?php echo $institute['city'] ?: 'N/A'; ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo $institute['status'] == 'active' ? 'success' : 'secondary'; ?>">
                                                    <?php echo ucfirst($institute['status']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo $institute['established_year'] ?: 'N/A'; ?></td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="institutes/edit?id=<?php echo $institute['id']; ?>" 
                                                       class="btn btn-primary" 
                                                       title="Edit Institute">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-info view-institute" 
                                                            data-id="<?php echo $institute['id']; ?>"
                                                            title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" 
                                                            class="btn btn-danger delete-institute" 
                                                            data-id="<?php echo $institute['id']; ?>"
                                                            data-name="<?php echo $institute['name']; ?>"
                                                            title="Delete Institute">
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

            <!-- Quick Stats -->
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Institutes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo count($institutes); ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-university fa-2x text-gray-300"></i>
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
                                        Active Institutes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php 
                                            $active_count = array_filter($institutes, function($inst) {
                                                return $inst['status'] == 'active';
                                            });
                                            echo count($active_count);
                                        ?>
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
                                        Institute Types
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php 
                                            $types = array_unique(array_column($institutes, 'type'));
                                            echo count($types);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tags fa-2x text-gray-300"></i>
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
                                        This Month
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php 
                                            $this_month = date('Y-m');
                                            $month_count = array_filter($institutes, function($inst) use ($this_month) {
                                                return date('Y-m', strtotime($inst['created_at'])) == $this_month;
                                            });
                                            echo count($month_count);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                <p>Are you sure you want to delete institute "<strong id="deleteInstituteName"></strong>"?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="#" id="confirmDelete" class="btn btn-danger">Delete Institute</a>
            </div>
        </div>
    </div>
</div>

<!-- View Institute Modal -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Institute Details</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="instituteDetails">
                <!-- Details will be loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#institutesTable').DataTable({
        "pageLength": 10,
        "order": [[0, 'asc']],
        "language": {
            "search": "Search institutes:",
            "lengthMenu": "Show _MENU_ institutes per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ institutes"
        }
    });

    // Delete confirmation
    $('.delete-institute').on('click', function() {
        const instituteId = $(this).data('id');
        const instituteName = $(this).data('name');
        
        $('#deleteInstituteName').text(instituteName);
        $('#confirmDelete').attr('href', 'institutes/delete?id=' + instituteId);
        $('#deleteModal').modal('show');
    });

    // View institute details
    $('.view-institute').on('click', function() {
        const instituteId = $(this).data('id');
        
        $.ajax({
            url: 'institutes/api/details?id=' + instituteId,
            method: 'GET',
            success: function(response) {
                $('#instituteDetails').html(response);
                $('#viewModal').modal('show');
            },
            error: function() {
                alert('Error loading institute details.');
            }
        });
    });
});
</script>