<?php
$page_title = "Student ERP - Dashboard";
include BASE_PATH . '/view/layout/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="sidebar-sticky pt-3">
                <!-- User Profile Section -->
                <div class="user-info text-center p-3 border-bottom">
                    <div class="user-avatar mb-3">
                        <i class="fas fa-user-circle fa-3x text-primary"></i>
                    </div>
                    <h6 class="font-weight-bold"><?php echo $_SESSION['user_name']; ?></h6>
                    <p class="text-muted small"><?php echo $_SESSION['user_email']; ?></p>
                    <span class="badge badge-success">Student</span>
                </div>

                <!-- Navigation Menu -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard">
                            <i class="fas fa-tachometer-alt mr-2"></i>
                            Dashboard
                        </a>
                    </li>
                    
                    <!-- Institutes Module -->
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#institutesCollapse" role="button">
                            <i class="fas fa-university mr-2"></i>
                            Institutes
                            <i class="fas fa-chevron-down float-right mt-1"></i>
                        </a>
                        <div class="collapse show" id="institutesCollapse">
                            <ul class="nav flex-column pl-3">
                                <li class="nav-item">
                                    <a class="nav-link" href="institutes/manage">
                                        <i class="fas fa-list mr-2"></i>Manage Institutes
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="institutes/add">
                                        <i class="fas fa-plus-circle mr-2"></i>Add Institute
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="institutes/types">
                                        <i class="fas fa-tags mr-2"></i>Institute Types
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="institutes/departments">
                                        <i class="fas fa-building mr-2"></i>Departments
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="institutes/branches">
                                        <i class="fas fa-code-branch mr-2"></i>Branches
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Academic Module (Placeholder for future) -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-book mr-2"></i>
                            Academic
                        </a>
                    </li>

                    <!-- Students Module (Placeholder for future) -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-users mr-2"></i>
                            Students
                        </a>
                    </li>

                    <!-- Settings -->
                    <li class="nav-item">
                        <a class="nav-link" href="profile">
                            <i class="fas fa-cog mr-2"></i>
                            Settings
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Welcome Section -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                        <span data-feather="calendar"></span>
                        This week
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Institutes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalInstitutes">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-university fa-2x text-gray-300"></i>
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
                                        Active Institutes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="activeInstitutes">0</div>
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
                                        Departments
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalDepartments">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-building fa-2x text-gray-300"></i>
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
                                        Institute Types
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="instituteTypes">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tags fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <a href="institutes/add" class="btn btn-primary btn-block">
                                        <i class="fas fa-plus-circle mr-2"></i>Add Institute
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="institutes/manage" class="btn btn-success btn-block">
                                        <i class="fas fa-list mr-2"></i>Manage Institutes
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="institutes/departments" class="btn btn-info btn-block">
                                        <i class="fas fa-building mr-2"></i>Departments
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="institutes/types" class="btn btn-warning btn-block">
                                        <i class="fas fa-tags mr-2"></i>Institute Types
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Institute Activity</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="recentActivityTable">
                                    <thead>
                                        <tr>
                                            <th>Institute Name</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Last Updated</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="recentActivityBody">
                                        <!-- Data will be loaded via JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include BASE_PATH . '/view/layout/footer.php'; ?>