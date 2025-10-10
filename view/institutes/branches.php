<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include BASE_PATH . '/view/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-code-branch mr-2"></i>Branches
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addBranchModal">
                        <i class="fas fa-plus-circle mr-1"></i> Add Branch
                    </button>
                </div>
            </div>

            <!-- Branches Content -->
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-network-wired mr-1"></i> Institute Branches
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        Manage different branches and campuses of your institutes across multiple locations.
                    </div>

                    <!-- Branches Grid -->
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card branch-card">
                                <div class="card-body text-center">
                                    <i class="fas fa-university fa-3x text-primary mb-3"></i>
                                    <h5 class="card-title">Main Campus</h5>
                                    <p class="card-text text-muted">Primary institute location</p>
                                    <div class="branch-info">
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            City, State
                                        </small>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-sm btn-primary">Manage</button>
                                    <button class="btn btn-sm btn-outline-secondary">View</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card branch-card">
                                <div class="card-body text-center">
                                    <i class="fas fa-school fa-3x text-success mb-3"></i>
                                    <h5 class="card-title">North Campus</h5>
                                    <p class="card-text text-muted">Additional campus location</p>
                                    <div class="branch-info">
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            City, State
                                        </small>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-sm btn-primary">Manage</button>
                                    <button class="btn btn-sm btn-outline-secondary">View</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card branch-card">
                                <div class="card-body text-center">
                                    <i class="fas fa-laptop-house fa-3x text-info mb-3"></i>
                                    <h5 class="card-title">Extension Center</h5>
                                    <p class="card-text text-muted">Distance learning center</p>
                                    <div class="branch-info">
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            City, State
                                        </small>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-sm btn-primary">Manage</button>
                                    <button class="btn btn-sm btn-outline-secondary">View</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Branch Statistics -->
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Branches
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">3</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-code-branch fa-2x text-gray-300"></i>
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
                                        Active Branches
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">3</div>
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
                                        Cities Covered
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">2</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
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
                                        Total Students
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">1,254</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Add Branch Modal -->
<div class="modal fade" id="addBranchModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Branch</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addBranchForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="branchName" class="font-weight-bold">Branch Name *</label>
                                <input type="text" class="form-control" id="branchName" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="branchCode" class="font-weight-bold">Branch Code *</label>
                                <input type="text" class="form-control" id="branchCode" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parentInstitute" class="font-weight-bold">Parent Institute *</label>
                                <select class="form-control" id="parentInstitute" required>
                                    <option value="">Select Institute</option>
                                    <!-- Institutes will be loaded dynamically -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="branchType" class="font-weight-bold">Branch Type *</label>
                                <select class="form-control" id="branchType" required>
                                    <option value="">Select Type</option>
                                    <option value="main">Main Campus</option>
                                    <option value="branch">Branch Campus</option>
                                    <option value="extension">Extension Center</option>
                                    <option value="online">Online Campus</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="branchAddress" class="font-weight-bold">Address</label>
                        <textarea class="form-control" id="branchAddress" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="branchCity" class="font-weight-bold">City</label>
                                <input type="text" class="form-control" id="branchCity">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="branchState" class="font-weight-bold">State</label>
                                <input type="text" class="form-control" id="branchState">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="branchPincode" class="font-weight-bold">Pincode</label>
                                <input type="text" class="form-control" id="branchPincode">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Add Branch</button>
            </div>
        </div>
    </div>
</div>

<style>
.branch-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.branch-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.branch-info {
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #eee;
}
</style>