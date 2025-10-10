<?php
$page_title = "Student ERP - Home";
include BASE_PATH . '/view/layout/header.php';
?>

<!-- Hero Section -->
<section class="hero bg-success text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 font-weight-bold">Welcome to Student ERP</h1>
                <p class="lead">Comprehensive student management system for educational institutions</p>
                <?php if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']): ?>
                    <div class="mt-4">
                        <a href="register" class="btn btn-light btn-lg mr-3">Get Started</a>
                        <a href="login" class="btn btn-outline-light btn-lg">Login</a>
                    </div>
                <?php else: ?>
                    <div class="mt-4">
                        <a href="dashboard" class="btn btn-light btn-lg">Go to Dashboard</a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-graduation-cap display-1"></i>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="font-weight-bold">Key Features</h2>
            <p class="lead text-muted">Everything you need to manage student information efficiently</p>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-user-graduate fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Student Management</h5>
                        <p class="card-text text-muted">Comprehensive student profiles and information management</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-book fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Course Management</h5>
                        <p class="card-text text-muted">Efficient course enrollment and curriculum management</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-line fa-3x text-info mb-3"></i>
                        <h5 class="card-title">Performance Tracking</h5>
                        <p class="card-text text-muted">Monitor and analyze student academic performance</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-3">
                <h3 class="font-weight-bold text-primary">500+</h3>
                <p class="text-muted">Students</p>
            </div>
            <div class="col-md-3 mb-3">
                <h3 class="font-weight-bold text-success">50+</h3>
                <p class="text-muted">Courses</p>
            </div>
            <div class="col-md-3 mb-3">
                <h3 class="font-weight-bold text-info">25+</h3>
                <p class="text-muted">Faculty</p>
            </div>
            <div class="col-md-3 mb-3">
                <h3 class="font-weight-bold text-warning">99%</h3>
                <p class="text-muted">Satisfaction</p>
            </div>
        </div>
    </div>
</section>

<?php include BASE_PATH . '/view/layout/footer.php'; ?>