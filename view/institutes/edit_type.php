<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include BASE_PATH . '/view/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-edit mr-2"></i>Edit Institute Type
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo BASE_URL; ?>/institutes/types" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Types
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

            <!-- Edit Type Form -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle mr-1"></i> Edit Institute Type
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo BASE_URL; ?>/institutes/types/edit?id=<?php echo $instituteType['id']; ?>">
                                <div class="form-group">
                                    <label for="name" class="font-weight-bold">Type Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" required
                                           value="<?php echo htmlspecialchars($formData['name']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="code" class="font-weight-bold">Type Code *</label>
                                    <input type="text" class="form-control" id="code" name="code" required
                                           value="<?php echo htmlspecialchars($formData['code']); ?>">
                                    <small class="form-text text-muted">Unique identifier for the type</small>
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
                                        <i class="fas fa-save mr-1"></i> Update Type
                                    </button>
                                    <a href="<?php echo BASE_URL; ?>/institutes/types" class="btn btn-outline-secondary btn-lg">
                                        <i class="fas fa-times mr-1"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Type Information -->
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle mr-1"></i> Type Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Created:</strong> <?php echo date('F j, Y, g:i a', strtotime($instituteType['created_at'])); ?></p>
                            <p><strong>Last Updated:</strong> <?php echo date('F j, Y, g:i a', strtotime($instituteType['updated_at'])); ?></p>
                            <p><strong>Total Institutes:</strong> <span class="badge badge-primary"><?php echo $instituteType['institute_count'] ?? 0; ?></span></p>
                            
                            <?php if ($instituteType['institute_count'] > 0): ?>
                                <div class="alert alert-warning mt-3">
                                    <small>
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        This type is currently used by <?php echo $instituteType['institute_count']; ?> institute(s). 
                                        It cannot be deleted until all institutes are reassigned to other types.
                                    </small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>