<?php
$page_title = "Student ERP - Dashboard";
include BASE_PATH . '/view/layout/header.php';
?>

<div class="container-fluid mt-4">
    <!-- Welcome Section -->
    <div class="row">
        <div class="col-12">
            <div class="welcome-card bg-gradient-primary text-white rounded-lg p-4 mb-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="mb-2">Welcome back, <?php echo $_SESSION['user_name']; ?>!</h2>
                        <p class="mb-0">Here's what's happening with your account today.</p>
                    </div>
                    <div class="col-md-4 text-md-right">
                        <i class="fas fa-user-graduate fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
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
                                Enrolled Courses
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
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
                                Assignments Due
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">3</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
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
                                Current GPA
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">3.75</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
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
                                Attendance
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">92%</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Quick Actions -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="courses" class="list-group-item list-group-item-action">
                            <i class="fas fa-book mr-2 text-primary"></i>My Courses
                        </a>
                        <a href="assignments" class="list-group-item list-group-item-action">
                            <i class="fas fa-tasks mr-2 text-success"></i>Assignments
                        </a>
                        <a href="grades" class="list-group-item list-group-item-action">
                            <i class="fas fa-chart-bar mr-2 text-info"></i>Grades
                        </a>
                        <a href="profile" class="list-group-item list-group-item-action">
                            <i class="fas fa-user mr-2 text-warning"></i>Profile Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Activity</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="font-weight-bold">Assignment Submitted</h6>
                                <p class="text-muted mb-1">Mathematics Assignment #3</p>
                                <small class="text-muted">2 hours ago</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="font-weight-bold">Grade Updated</h6>
                                <p class="text-muted mb-1">Physics Midterm: A</p>
                                <small class="text-muted">1 day ago</small>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="font-weight-bold">New Course Material</h6>
                                <p class="text-muted mb-1">Chemistry Chapter 5 slides uploaded</p>
                                <small class="text-muted">2 days ago</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/view/layout/footer.php'; ?>