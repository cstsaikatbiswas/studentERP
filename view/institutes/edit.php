<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include BASE_PATH . '/view/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-edit mr-2"></i>Edit Institute
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="institutes/manage" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back to List
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

            <!-- Edit Institute Form -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle mr-1"></i> Edit Institute Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="institutes/edit?id=<?php echo $institute['id']; ?>" id="editInstituteForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="font-weight-bold">Institute Name *</label>
                                            <input type="text" class="form-control" id="name" name="name" 
                                                   value="<?php echo htmlspecialchars($formData['name']); ?>"
                                                   required placeholder="Enter institute name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code" class="font-weight-bold">Institute Code *</label>
                                            <input type="text" class="form-control" id="code" name="code"
                                                   value="<?php echo htmlspecialchars($formData['code']); ?>"
                                                   required placeholder="Enter unique code">
                                            <small class="form-text text-muted">Unique identifier for the institute</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type" class="font-weight-bold">Institute Type *</label>
                                            <select class="form-control" id="type" name="type" required>
                                                <option value="">Select Type</option>
                                                <option value="university" <?php echo $formData['type'] == 'university' ? 'selected' : ''; ?>>University</option>
                                                <option value="college" <?php echo $formData['type'] == 'college' ? 'selected' : ''; ?>>College</option>
                                                <option value="school" <?php echo $formData['type'] == 'school' ? 'selected' : ''; ?>>School</option>
                                                <option value="institute" <?php echo $formData['type'] == 'institute' ? 'selected' : ''; ?>>Institute</option>
                                                <option value="training_center" <?php echo $formData['type'] == 'training_center' ? 'selected' : ''; ?>>Training Center</option>
                                                <option value="research_center" <?php echo $formData['type'] == 'research_center' ? 'selected' : ''; ?>>Research Center</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="established_year" class="font-weight-bold">Established Year</label>
                                            <input type="number" class="form-control" id="established_year" 
                                                   name="established_year" 
                                                   value="<?php echo htmlspecialchars($formData['established_year']); ?>"
                                                   min="1800" max="<?php echo date('Y'); ?>" 
                                                   placeholder="e.g., 1990">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="font-weight-bold">Email Address</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                   value="<?php echo htmlspecialchars($formData['email']); ?>"
                                                   placeholder="Enter official email">
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
                                    <label for="address" class="font-weight-bold">Address</label>
                                    <textarea class="form-control" id="address" name="address" 
                                              rows="3" placeholder="Enter full address"><?php echo htmlspecialchars($formData['address']); ?></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="city" class="font-weight-bold">City</label>
                                            <input type="text" class="form-control" id="city" name="city"
                                                   value="<?php echo htmlspecialchars($formData['city']); ?>"
                                                   placeholder="Enter city">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="state" class="font-weight-bold">State</label>
                                            <input type="text" class="form-control" id="state" name="state"
                                                   value="<?php echo htmlspecialchars($formData['state']); ?>"
                                                   placeholder="Enter state">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="pincode" class="font-weight-bold">Pincode</label>
                                            <input type="text" class="form-control" id="pincode" name="pincode"
                                                   value="<?php echo htmlspecialchars($formData['pincode']); ?>"
                                                   placeholder="Enter pincode">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="country" class="font-weight-bold">Country</label>
                                            <input type="text" class="form-control" id="country" name="country"
                                                   value="<?php echo !empty($formData['country']) ? htmlspecialchars($formData['country']) : 'India'; ?>"
                                                   placeholder="Enter country">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="website" class="font-weight-bold">Website</label>
                                            <input type="url" class="form-control" id="website" name="website"
                                                   value="<?php echo htmlspecialchars($formData['website']); ?>"
                                                   placeholder="https://example.com">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description" class="font-weight-bold">Description</label>
                                    <textarea class="form-control" id="description" name="description" 
                                              rows="4" placeholder="Enter institute description"><?php echo htmlspecialchars($formData['description']); ?></textarea>
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
                                        <i class="fas fa-save mr-1"></i> Update Institute
                                    </button>
                                    <a href="institutes/manage" class="btn btn-outline-secondary btn-lg">
                                        <i class="fas fa-times mr-1"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Institute Information Card -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-history mr-1"></i> Institute Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Created:</strong> <?php echo date('F j, Y, g:i a', strtotime($institute['created_at'])); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Last Updated:</strong> <?php echo date('F j, Y, g:i a', strtotime($institute['updated_at'])); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>