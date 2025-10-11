<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include BASE_PATH . '/view/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-building mr-2"></i>Departments
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addDepartmentModal">
                        <i class="fas fa-plus-circle mr-1"></i> Add Department
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

            <!-- Department Statistics -->
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Departments
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $departmentStats['total_departments'] ?? 0; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-building fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Active Departments
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $departmentStats['active_departments'] ?? 0; ?>
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
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Academic
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $departmentStats['academic_departments'] ?? 0; ?>
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
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Administrative
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $departmentStats['administrative_departments'] ?? 0; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users-cog fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Departments Management -->
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-sitemap mr-1"></i> Manage Departments
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (empty($departments)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-building fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Departments Found</h5>
                            <p class="text-muted">Get started by adding your first department.</p>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addDepartmentModal">
                                <i class="fas fa-plus-circle mr-1"></i> Add First Department
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="departmentsTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Department Name</th>
                                        <th>Code</th>
                                        <th>Institute</th>
                                        <th>Type</th>
                                        <th>Head of Department</th>
                                        <th>Contact</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($departments as $index => $department): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td>
                                                <strong><?php echo $department['name']; ?></strong>
                                                <?php if ($department['description']): ?>
                                                    <br><small class="text-muted"><?php echo substr($department['description'], 0, 50); ?>...</small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-info"><?php echo $department['code']; ?></span>
                                            </td>
                                            <td>
                                                <strong><?php echo $department['institute_name']; ?></strong>
                                                <br><small class="text-muted"><?php echo $department['institute_code']; ?></small>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?php 
                                                    echo $department['type'] == 'academic' ? 'primary' : 
                                                          ($department['type'] == 'administrative' ? 'success' : 'warning'); 
                                                ?>">
                                                    <?php echo ucfirst($department['type']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo $department['head_of_department'] ?: 'Not assigned'; ?></td>
                                            <td>
                                                <?php if ($department['email']): ?>
                                                    <small><?php echo $department['email']; ?></small><br>
                                                <?php endif; ?>
                                                <?php if ($department['phone']): ?>
                                                    <small><?php echo $department['phone']; ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?php echo $department['status'] == 'active' ? 'success' : 'secondary'; ?>">
                                                    <?php echo ucfirst($department['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="<?php echo BASE_URL; ?>/institutes/departments/edit?id=<?php echo $department['id']; ?>" 
                                                       class="btn btn-primary" title="Edit Department">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-danger delete-department" 
                                                            data-id="<?php echo $department['id']; ?>"
                                                            data-name="<?php echo $department['name']; ?>"
                                                            title="Delete Department">
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

<!-- Add Department Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Department</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form method="POST" action="<?php echo BASE_URL; ?>/institutes/departments">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="institute_id" class="font-weight-bold">Institute *</label>
                                <select class="form-control" id="institute_id" name="institute_id" required>
                                    <option value="">Select Institute</option>
                                    <?php foreach ($institutes as $institute): ?>
                                        <option value="<?php echo $institute['id']; ?>" 
                                            <?php echo $formData['institute_id'] == $institute['id'] ? 'selected' : ''; ?>>
                                            <?php echo $institute['name']; ?> (<?php echo $institute['code']; ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type" class="font-weight-bold">Department Type *</label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="academic" <?php echo $formData['type'] == 'academic' ? 'selected' : ''; ?>>Academic</option>
                                    <option value="administrative" <?php echo $formData['type'] == 'administrative' ? 'selected' : ''; ?>>Administrative</option>
                                    <option value="support" <?php echo $formData['type'] == 'support' ? 'selected' : ''; ?>>Support</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="font-weight-bold">Department Name *</label>
                                <input type="text" class="form-control" id="name" name="name" required
                                       value="<?php echo htmlspecialchars($formData['name']); ?>"
                                       placeholder="Enter department name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="code" class="font-weight-bold">Department Code *</label>
                                <input type="text" class="form-control" id="code" name="code" required
                                       value="<?php echo htmlspecialchars($formData['code']); ?>"
                                       placeholder="Enter unique code">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="head_of_department" class="font-weight-bold">Head of Department</label>
                                <input type="text" class="form-control" id="head_of_department" name="head_of_department"
                                       value="<?php echo htmlspecialchars($formData['head_of_department']); ?>"
                                       placeholder="Enter HOD name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="font-weight-bold">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                       value="<?php echo htmlspecialchars($formData['phone']); ?>"
                                       placeholder="Enter phone number">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="font-weight-bold">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="<?php echo htmlspecialchars($formData['email']); ?>"
                               placeholder="Enter department email">
                    </div>
                    <div class="form-group">
                        <label for="description" class="font-weight-bold">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"
                                  placeholder="Enter department description"><?php echo htmlspecialchars($formData['description']); ?></textarea>
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
                    <button type="submit" class="btn btn-primary">Add Department</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteDepartmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete department "<strong id="deleteDepartmentName"></strong>"?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="#" id="confirmDepartmentDelete" class="btn btn-danger">Delete Department</a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#departmentsTable').DataTable({
        "pageLength": 10,
        "order": [[0, 'asc']],
        "language": {
            "search": "Search departments:",
            "lengthMenu": "Show _MENU_ departments per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ departments"
        }
    });

    // Delete confirmation
    $('.delete-department').on('click', function() {
        const departmentId = $(this).data('id');
        const departmentName = $(this).data('name');
        
        $('#deleteDepartmentName').text(departmentName);
        $('#confirmDepartmentDelete').attr('href', '<?php echo BASE_URL; ?>/institutes/departments/delete?id=' + departmentId);
        $('#deleteDepartmentModal').modal('show');
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