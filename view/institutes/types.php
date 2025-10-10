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

            <!-- Institute Types Cards -->
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card border-left-primary shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Universities
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">12</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card border-left-success shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Colleges
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">45</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-school fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card border-left-info shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Schools
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">78</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
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
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="typesTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Type Name</th>
                                    <th>Description</th>
                                    <th>Total Institutes</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <strong>University</strong>
                                        <br><small class="text-muted">UNIV</small>
                                    </td>
                                    <td>Higher education and research institution</td>
                                    <td><span class="badge badge-primary">12</span></td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>
                                        <strong>College</strong>
                                        <br><small class="text-muted">COL</small>
                                    </td>
                                    <td>Educational institution or constituent part</td>
                                    <td><span class="badge badge-primary">45</span></td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>
                                        <strong>School</strong>
                                        <br><small class="text-muted">SCH</small>
                                    </td>
                                    <td>Primary or secondary educational institution</td>
                                    <td><span class="badge badge-primary">78</span></td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
            <div class="modal-body">
                <form id="addTypeForm">
                    <div class="form-group">
                        <label for="typeName" class="font-weight-bold">Type Name *</label>
                        <input type="text" class="form-control" id="typeName" required>
                    </div>
                    <div class="form-group">
                        <label for="typeCode" class="font-weight-bold">Type Code *</label>
                        <input type="text" class="form-control" id="typeCode" required>
                    </div>
                    <div class="form-group">
                        <label for="typeDescription" class="font-weight-bold">Description</label>
                        <textarea class="form-control" id="typeDescription" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Add Type</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#typesTable').DataTable({
        "pageLength": 10,
        "order": [[0, 'asc']]
    });
});
</script>