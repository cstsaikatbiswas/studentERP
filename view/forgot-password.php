<?php
$page_title = "Student ERP - Forgot Password";
include BASE_PATH . '/view/layout/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-key"></i> Reset Password</h4>
                </div>
                <div class="card-body p-4">
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

                    <p class="text-muted mb-4">Enter your email address and we'll send you a link to reset your password.</p>

                    <form method="POST" action="forgot-password">
                        <div class="form-group">
                            <label for="email" class="font-weight-bold">Email Address</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" class="form-control" id="email" name="email" required
                                       value="<?php echo htmlspecialchars($formData['email']); ?>"
                                       placeholder="Enter your registered email">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            <i class="fas fa-paper-plane"></i> Send Reset Link
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="mb-0">
                            <a href="login" class="font-weight-bold"><i class="fas fa-arrow-left"></i> Back to Login</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/view/layout/footer.php'; ?>