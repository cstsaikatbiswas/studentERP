<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include BASE_PATH . '/view/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-tags mr-2"></i>Institute Types
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addTypeModal">
                        <i class="fas fa-plus-circle mr-1"></i> Add Type
                    </button>
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

            <!-- Institute Types Stats -->
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card border-left-primary shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Types
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $typeStats['total_types'] ?? 0; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tags fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card border-left-success shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Active Types
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $typeStats['active_types'] ?? 0; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card border-left-info shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Universities
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php 
                                            $univ_count = array_filter($instituteTypes, function($type) {
                                                return strpos(strtolower($type['name']), 'university') !== false;
                                            });
                                            echo count($univ_count);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card border-left-warning shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Colleges
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php 
                                            $college_count = array_filter($instituteTypes, function($type) {
                                                return strpos(strtolower($type['name']), 'college') !== false;
                                            });
                                            echo count($college_count);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-school fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Types Management -->
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list mr-1"></i> Manage Institute Types
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (empty($instituteTypes)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Institute Types Found</h5>
                            <p class="text-muted">Get started by adding your first institute type.</p>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addTypeModal">
                                <i class="fas fa-plus-circle mr-1"></i> Add Institute Type
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="typesTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Type Name</th>
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th>Institutes</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($instituteTypes as $index => $type): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td>
                                                <strong><?php echo $type['name']; ?></strong>
                                            </td>
                                            <td>
                                                <span class="badge badge-info"><?php echo $type['code']; ?></span>
                                            </td>
                                            <td><?php echo $type['description'] ?: 'No description'; ?></td>
                                            <td>
                                                <span class="badge badge-primary"><?php echo $type['institute_count'] ?? 0; ?></span>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?php echo $type['status'] == 'active' ? 'success' : 'secondary'; ?>">
                                                    <?php echo ucfirst($type['status']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('M j, Y', strtotime($type['created_at'])); ?></td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="<?php echo BASE_URL; ?>/institutes/types/edit?id=<?php echo $type['id']; ?>" 
                                                       class="btn btn-primary" title="Edit Type">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-danger delete-type" 
                                                            data-id="<?php echo $type['id']; ?>"
                                                            data-name="<?php echo $type['name']; ?>"
                                                            title="Delete Type">
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

<!-- Add Type Modal -->
<div class="modal fade" id="addTypeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Institute Type</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form method="POST" action="<?php echo BASE_URL; ?>/institutes/types">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="font-weight-bold">Type Name *</label>
                        <input type="text" class="form-control" id="name" name="name" required
                               value="<?php echo htmlspecialchars($formData['name']); ?>"
                               placeholder="Enter type name">
                    </div>
                    <div class="form-group">
                        <label for="code" class="font-weight-bold">Type Code *</label>
                        <input type="text" class="form-control" id="code" name="code" required
                               value="<?php echo htmlspecialchars($formData['code']); ?>"
                               placeholder="Enter unique code">
                        <small class="form-text text-muted">Unique identifier for the type</small>
                    </div>
                    <div class="form-group">
                        <label for="description" class="font-weight-bold">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"
                                  placeholder="Enter type description"><?php echo htmlspecialchars($formData['description']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status" class="font-weight-bold">Status *</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="active" <?php echo $formData['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo $formData['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Type</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteTypeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete institute type "<strong id="deleteTypeName"></strong>"?</p>
                <p class="text-danger"><small>This action cannot be undone. If this type is used by any institutes, it cannot be deleted.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="#" id="confirmTypeDelete" class="btn btn-danger">Delete Type</a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#typesTable').DataTable({
        "pageLength": 10,
        "order": [[0, 'asc']],
        "language": {
            "search": "Search types:",
            "lengthMenu": "Show _MENU_ types per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ types"
        }
    });

    // Delete confirmation
    $('.delete-type').on('click', function() {
        const typeId = $(this).data('id');
        const typeName = $(this).data('name');
        
        $('#deleteTypeName').text(typeName);
        $('#confirmTypeDelete').attr('href', '<?php echo BASE_URL; ?>/institutes/types/delete?id=' + typeId);
        $('#deleteTypeModal').modal('show');
    });

    // Auto-generate code from name
    $('#name').on('blur', function() {
        if ($('#code').val() === '') {
            const name = $(this).val();
            const code = name.replace(/[^a-zA-Z0-9]/g, '_').toUpperCase().substring(0, 20);
            $('#code').val(code);
        }
    });
});
</script>