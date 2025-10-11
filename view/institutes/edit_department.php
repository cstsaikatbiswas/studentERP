<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include BASE_PATH . '/view/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-edit mr-2"></i>Edit Department
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo BASE_URL; ?>/institutes/departments" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Departments
                    </a>
                </div>
            </div>

            <!-- Alerts -->
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

            <!-- Edit Department Form -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle mr-1"></i> Edit Department
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo BASE_URL; ?>/institutes/departments/edit?id=<?php echo $department['id']; ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="institute_id" class="font-weight-bold">Institute *</label>
                                            <select class="form-control" id="institute_id" name="institute_id" required disabled>
                                                <option value="">Select Institute</option>
                                                <?php foreach ($institutes as $inst): ?>
                                                    <option value="<?php echo $inst['id']; ?>" 
                                                        <?php echo $formData['institute_id'] == $inst['id'] ? 'selected' : ''; ?>>
                                                        <?php echo $inst['name']; ?> (<?php echo $inst['code']; ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <input type="hidden" name="institute_id" value="<?php echo $formData['institute_id']; ?>">
                                            <small class="form-text text-muted">Institute cannot be changed after creation</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type" class="font-weight-bold">Department Type *</label>
                                            <select class="form-control" id="type" name="type" required>
                                                <option value="academic" <?php echo $formData['type'] == 'academic' ? 'selected' : ''; ?>>Academic</option>
                                                <option value="administrative" <?php echo $formData['type'] == 'administrative' ? 'selected' : ''; ?>>Administrative</option>
                                                <option value="support" <?php echo $formData['type'] == 'support' ? 'selected' : ''; ?>>Support</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="font-weight-bold">Department Name *</label>
                                            <input type="text" class="form-control" id="name" name="name" required
                                                   value="<?php echo htmlspecialchars($formData['name']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code" class="font-weight-bold">Department Code *</label>
                                            <input type="text" class="form-control" id="code" name="code" required
                                                   value="<?php echo htmlspecialchars($formData['code']); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="head_of_department" class="font-weight-bold">Head of Department</label>
                                            <input type="text" class="form-control" id="head_of_department" name="head_of_department"
                                                   value="<?php echo htmlspecialchars($formData['head_of_department']); ?>"
                                                   placeholder="Enter HOD name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone" class="font-weight-bold">Phone Number</label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                   value="<?php echo htmlspecialchars($formData['phone']); ?>"
                                                   placeholder="Enter phone number">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="font-weight-bold">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="<?php echo htmlspecialchars($formData['email']); ?>"
                                           placeholder="Enter department email">
                                </div>

                                <div class="form-group">
                                    <label for="description" class="font-weight-bold">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($formData['description']); ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="status" class="font-weight-bold">Status *</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="active" <?php echo $formData['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?php echo $formData['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save mr-1"></i> Update Department
                                    </button>
                                    <a href="<?php echo BASE_URL; ?>/institutes/departments" class="btn btn-outline-secondary btn-lg">
                                        <i class="fas fa-times mr-1"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Department Information -->
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle mr-1"></i> Department Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Institute:</strong> <?php echo $department['institute_name']; ?></p>
                            <p><strong>Created:</strong> <?php echo date('F j, Y, g:i a', strtotime($department['created_at'])); ?></p>
                            <p><strong>Last Updated:</strong> <?php echo date('F j, Y, g:i a', strtotime($department['updated_at'])); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>