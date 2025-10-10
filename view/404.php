<?php
$page_title = "Page Not Found";
include BASE_PATH . '/view/layout/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="error-container">
                <i class="fas fa-exclamation-triangle fa-5x text-warning mb-4"></i>
                <h1 class="display-4 font-weight-bold text-gray-800">404</h1>
                <h2 class="h3 font-weight-normal text-muted mb-4">Page Not Found</h2>
                <p class="lead mb-4">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
                <div class="mt-4">
                    <a href="home" class="btn btn-primary btn-lg mr-3">
                        <i class="fas fa-home mr-2"></i>Go Home
                    </a>
                    <a href="dashboard" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/view/layout/footer.php'; ?>