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

            <!-- Departments Content -->
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-sitemap mr-1"></i> Department Structure
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        Departments module allows you to manage academic and administrative departments within institutes.
                    </div>

                    <!-- Placeholder for departments tree/list -->
                    <div class="text-center py-5">
                        <i class="fas fa-building fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Departments Management</h5>
                        <p class="text-muted">This feature is under development.</p>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addDepartmentModal">
                            <i class="fas fa-plus-circle mr-1"></i> Add First Department
                        </button>
                    </div>
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
                                        Total Departments
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-building fa-2x text-gray-300"></i>
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
                                        Academic Departments
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
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
                                        Administrative
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users-cog fa-2x text-gray-300"></i>
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
                                        Support Departments
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-hands-helping fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
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
            <div class="modal-body">
                <form id="addDepartmentForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="departmentName" class="font-weight-bold">Department Name *</label>
                                <input type="text" class="form-control" id="departmentName" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="departmentCode" class="font-weight-bold">Department Code *</label>
                                <input type="text" class="form-control" id="departmentCode" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="departmentType" class="font-weight-bold">Department Type *</label>
                                <select class="form-control" id="departmentType" required>
                                    <option value="">Select Type</option>
                                    <option value="academic">Academic</option>
                                    <option value="administrative">Administrative</option>
                                    <option value="support">Support</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="instituteSelect" class="font-weight-bold">Institute *</label>
                                <select class="form-control" id="instituteSelect" required>
                                    <option value="">Select Institute</option>
                                    <!-- Institutes will be loaded dynamically -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="departmentDescription" class="font-weight-bold">Description</label>
                        <textarea class="form-control" id="departmentDescription" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Add Department</button>
            </div>
        </div>
    </div>
</div>