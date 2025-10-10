<?php
$page_title = "Student ERP - Profile";
include BASE_PATH . '/view/layout/header.php';
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0"><i class="fas fa-user-cog"></i> Profile Settings</h4>
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

                    <form method="POST" action="profile">
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">Full Name</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" id="name" name="name" required 
                                       value="<?php echo htmlspecialchars($userData['name']); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="font-weight-bold">Email Address</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" class="form-control" id="email" name="email" required
                                       value="<?php echo htmlspecialchars($userData['email']); ?>">
                            </div>
                        </div>

                        <hr class="my-4">
                        <h5 class="text-info">Change Password</h5>
                        <p class="text-muted small">Leave these fields blank if you don't want to change your password.</p>

                        <div class="form-group">
                            <label for="current_password" class="font-weight-bold">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password"
                                   placeholder="Enter current password">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="new_password" class="font-weight-bold">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password"
                                       placeholder="Enter new password">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="confirm_password" class="font-weight-bold">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                       placeholder="Confirm new password">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info btn-lg">
                            <i class="fas fa-save"></i> Update Profile
                        </button>
                        <a href="dashboard" class="btn btn-outline-secondary btn-lg ml-2">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/view/layout/footer.php'; ?>