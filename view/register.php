<?php
$page_title = "Student ERP - Register";
include BASE_PATH . '/view/layout/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0"><i class="fas fa-user-plus"></i> Create Account</h4>
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

                    <form method="POST" action="register" id="registerForm">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name" class="font-weight-bold">Full Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="name" name="name" required 
                                           value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"
                                           placeholder="Enter your full name">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email" class="font-weight-bold">Email Address</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" class="form-control" id="email" name="email" required
                                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                           placeholder="Enter your email">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="password" class="font-weight-bold">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" id="password" name="password" required
                                           placeholder="Create a password">
                                </div>
                                <small class="form-text text-muted">Minimum 8 characters</small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="confirm_password" class="font-weight-bold">Confirm Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required
                                           placeholder="Confirm your password">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" data-toggle="modal" data-target="#termsModal">Terms and Conditions</a>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info btn-lg btn-block">
                            <i class="fas fa-user-plus"></i> Create Account
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="mb-0">Already have an account? <a href="login" class="font-weight-bold">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Terms and Conditions</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Please read these terms and conditions carefully before using our service.</p>
                <!-- Add your terms and conditions here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/view/layout/footer.php'; ?>