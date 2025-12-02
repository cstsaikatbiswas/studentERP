<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include BASE_PATH . '/view/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-users mr-2"></i>Batch Details
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo BASE_URL; ?>/academic/batches" class="btn btn-secondary mr-2">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Batches
                    </a>
                    <a href="<?php echo BASE_URL; ?>/academic/batches/edit?id=<?php echo $batch['id']; ?>" class="btn btn-primary">
                        <i class="fas fa-edit mr-1"></i> Edit Batch
                    </a>
                </div>
            </div>

            <!-- Batch Summary -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    <i class="fas fa-info-circle mr-1"></i> Batch Information
                                </h6>
                                <span class="badge badge-<?php 
                                    echo $batch['status'] == 'active' ? 'success' : 
                                          ($batch['status'] == 'completed' ? 'secondary' : 
                                          ($batch['status'] == 'upcoming' ? 'warning' : 'danger'));
                                ?> badge-pill">
                                    <?php echo ucfirst($batch['status']); ?>
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="40%"><strong>Batch Code:</strong></td>
                                            <td><span class="badge badge-info"><?php echo $batch['batch_code']; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Batch Name:</strong></td>
                                            <td><?php echo $batch['batch_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Program:</strong></td>
                                            <td><?php echo $batch['program_name']; ?> (<?php echo $batch['program_code']; ?>)</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Department:</strong></td>
                                            <td><?php echo $batch['department_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Batch Year:</strong></td>
                                            <td><span class="badge badge-secondary"><?php echo $batch['batch_year']; ?></span></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="40%"><strong>Start Date:</strong></td>
                                            <td><?php echo date('F j, Y', strtotime($batch['start_date'])); ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>End Date:</strong></td>
                                            <td><?php echo $batch['end_date'] ? date('F j, Y', strtotime($batch['end_date'])) : 'Not specified'; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Current Semester:</strong></td>
                                            <td><span class="badge badge-primary">Semester <?php echo $batch['current_semester']; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Class Teacher:</strong></td>
                                            <td>
                                                <?php if ($batch['class_teacher_name']): ?>
                                                    <?php echo $batch['class_teacher_name']; ?>
                                                    <?php if ($batch['class_teacher_email']): ?>
                                                        <br><small class="text-muted"><?php echo $batch['class_teacher_email']; ?></small>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="text-muted">Not assigned</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Card -->
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-chart-bar mr-1"></i> Statistics
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 mb-3">
                                    <div class="border rounded p-3">
                                        <h3 class="text-primary mb-0"><?php echo $batch['student_count']; ?></h3>
                                        <small>Enrolled Students</small>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="border rounded p-3">
                                        <h3 class="text-success mb-0"><?php echo $batch['max_capacity']; ?></h3>
                                        <small>Maximum Capacity</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="progress" style="height: 25px;">
                                <?php 
                                    $capacity_percentage = ($batch['student_count'] / $batch['max_capacity']) * 100;
                                    $progress_class = $capacity_percentage >= 90 ? 'bg-danger' : 
                                                     ($capacity_percentage >= 75 ? 'bg-warning' : 'bg-success');
                                ?>
                                <div class="progress-bar <?php echo $progress_class; ?>" 
                                     role="progressbar" 
                                     style="width: <?php echo min($capacity_percentage, 100); ?>%"
                                     aria-valuenow="<?php echo $batch['student_count']; ?>" 
                                     aria-valuemin="0" 
                                     aria-valuemax="<?php echo $batch['max_capacity']; ?>">
                                    <?php echo round($capacity_percentage, 1); ?>% Full
                                </div>
                            </div>
                            
                            <?php if ($batch['max_capacity'] > 0): ?>
                                <div class="mt-2 text-center">
                                    <small class="text-muted">
                                        <?php echo $batch['max_capacity'] - $batch['student_count']; ?> seats available
                                    </small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="row">
                <!-- Admission Criteria -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-graduation-cap mr-1"></i> Admission Criteria
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if ($batch['admission_criteria']): ?>
                                <div class="border rounded p-3 bg-light">
                                    <?php echo nl2br(htmlspecialchars($batch['admission_criteria'])); ?>
                                </div>
                            <?php else: ?>
                                <p class="text-muted text-center py-3">No admission criteria specified</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Fee Structure -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header bg-warning text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-money-bill-wave mr-1"></i> Fee Structure
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if ($batch['fee_structure']): ?>
                                <?php 
                                    $fee_structure = json_decode($batch['fee_structure'], true);
                                    if ($fee_structure && is_array($fee_structure)):
                                ?>
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Fee Type</th>
                                                <th class="text-right">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $total_fees = 0;
                                                foreach ($fee_structure as $fee_type => $amount): 
                                                    $total_fees += $amount;
                                            ?>
                                                <tr>
                                                    <td><?php echo ucfirst(str_replace('_', ' ', $fee_type)); ?></td>
                                                    <td class="text-right">₹<?php echo number_format($amount, 2); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr class="font-weight-bold">
                                                <td>Total Fees</td>
                                                <td class="text-right">₹<?php echo number_format($total_fees, 2); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                <?php else: ?>
                                    <pre class="border rounded p-3 bg-light"><?php echo htmlspecialchars($batch['fee_structure']); ?></pre>
                                <?php endif; ?>
                            <?php else: ?>
                                <p class="text-muted text-center py-3">No fee structure specified</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline and Progress -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-history mr-1"></i> Academic Progress
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <?php 
                                    $start_date = new DateTime($batch['start_date']);
                                    $end_date = $batch['end_date'] ? new DateTime($batch['end_date']) : null;
                                    $duration_years = $batch['duration_years'];
                                    $total_semesters = $batch['total_semesters'];
                                    
                                    for ($sem = 1; $sem <= $total_semesters; $sem++):
                                        $is_current = $sem == $batch['current_semester'];
                                        $is_completed = $sem < $batch['current_semester'];
                                        $is_future = $sem > $batch['current_semester'];
                                ?>
                                    <div class="timeline-item">
                                        <div class="timeline-marker <?php echo $is_current ? 'bg-primary' : ($is_completed ? 'bg-success' : 'bg-light'); ?>"></div>
                                        <div class="timeline-content">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">
                                                    Semester <?php echo $sem; ?>
                                                    <?php if ($is_current): ?>
                                                        <span class="badge badge-primary ml-2">Current</span>
                                                    <?php elseif ($is_completed): ?>
                                                        <span class="badge badge-success ml-2">Completed</span>
                                                    <?php endif; ?>
                                                </h6>
                                                <?php if ($is_current || $is_completed): ?>
                                                    <a href="<?php echo BASE_URL; ?>/academic/semester?batch_id=<?php echo $batch['id']; ?>&semester=<?php echo $sem; ?>" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        View Details
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                            <p class="text-muted mb-0 small">
                                                <?php 
                                                    $semester_date = clone $start_date;
                                                    $semester_date->modify('+' . (($sem - 1) * 6) . ' months');
                                                    echo $semester_date->format('F Y');
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Batch Actions -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header bg-light">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-cogs mr-1"></i> Batch Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php if ($batch['student_count'] > 0): ?>
                                    <div class="col-md-3 mb-3">
                                        <a href="<?php echo BASE_URL; ?>/students?batch_id=<?php echo $batch['id']; ?>" 
                                           class="btn btn-success btn-block">
                                            <i class="fas fa-user-graduate mr-1"></i> Manage Students
                                            <span class="badge badge-light"><?php echo $batch['student_count']; ?></span>
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="<?php echo BASE_URL; ?>/academic/attendance?batch_id=<?php echo $batch['id']; ?>" 
                                           class="btn btn-info btn-block">
                                            <i class="fas fa-clipboard-check mr-1"></i> Attendance
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <a href="<?php echo BASE_URL; ?>/academic/exams?batch_id=<?php echo $batch['id']; ?>" 
                                           class="btn btn-warning btn-block">
                                            <i class="fas fa-file-alt mr-1"></i> Exams
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="col-md-3 mb-3">
                                    <a href="<?php echo BASE_URL; ?>/academic/batches/edit?id=<?php echo $batch['id']; ?>" 
                                       class="btn btn-primary btn-block">
                                        <i class="fas fa-edit mr-1"></i> Edit Batch
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 25px;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 3px #dee2e6;
}

.timeline-content {
    padding: 10px 15px;
    background-color: #f8f9fa;
    border-radius: 6px;
    border-left: 3px solid #dee2e6;
}

.timeline-item:hover .timeline-content {
    background-color: #e9ecef;
}
</style>
