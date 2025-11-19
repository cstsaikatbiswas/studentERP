<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include BASE_PATH . '/view/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-book mr-2"></i>Subject Details
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo BASE_URL; ?>/academic/subjects/edit?id=<?php echo $subject['id']; ?>" class="btn btn-primary mr-2">
                        <i class="fas fa-edit mr-1"></i> Edit Subject
                    </a>
                    <a href="<?php echo BASE_URL; ?>/academic/subjects" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Subjects
                    </a>
                </div>
            </div>

            <!-- Subject Details -->
            <div class="row">
                <div class="col-md-8">
                    <!-- Basic Information Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle mr-1"></i> Basic Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="40%" class="font-weight-bold">Subject Name:</td>
                                            <td><?php echo $subject['name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Subject Code:</td>
                                            <td><span class="badge badge-info"><?php echo $subject['code']; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Department:</td>
                                            <td>
                                                <?php if ($subject['department_name']): ?>
                                                    <strong><?php echo $subject['department_name']; ?></strong>
                                                    <br><small class="text-muted"><?php echo $subject['department_code']; ?></small>
                                                <?php else: ?>
                                                    <span class="text-muted">Not assigned</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Subject Type:</td>
                                            <td>
                                                <span class="badge badge-<?php 
                                                    echo $subject['subject_type'] == 'core' ? 'primary' : 
                                                          ($subject['subject_type'] == 'elective' ? 'success' : 
                                                          ($subject['subject_type'] == 'lab' ? 'danger' : 'warning')); 
                                                ?>">
                                                    <?php echo ucfirst($subject['subject_type']); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="40%" class="font-weight-bold">Credit Hours:</td>
                                            <td><span class="badge badge-light"><?php echo $subject['credit_hours']; ?> Credits</span></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Theory Hours:</td>
                                            <td><?php echo $subject['theory_hours']; ?> hours/week</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Practical Hours:</td>
                                            <td><?php echo $subject['practical_hours']; ?> hours/week</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Difficulty Level:</td>
                                            <td>
                                                <span class="badge badge-<?php 
                                                    echo $subject['difficulty_level'] == 'basic' ? 'success' : 
                                                          ($subject['difficulty_level'] == 'intermediate' ? 'warning' : 'danger'); 
                                                ?>">
                                                    <?php echo ucfirst($subject['difficulty_level']); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Status:</td>
                                            <td>
                                                <span class="badge badge-<?php echo $subject['status'] == 'active' ? 'success' : 'secondary'; ?>">
                                                    <?php echo ucfirst($subject['status']); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <?php if ($subject['description']): ?>
                                <div class="mt-3">
                                    <h6 class="font-weight-bold">Description</h6>
                                    <div class="border rounded p-3 bg-light">
                                        <?php echo nl2br(htmlspecialchars($subject['description'])); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Additional Information Cards -->
                    <?php if ($subject['prerequisites']): ?>
                    <div class="card shadow mb-4">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-clipboard-check mr-1"></i> Prerequisites
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php echo nl2br(htmlspecialchars($subject['prerequisites'])); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($subject['learning_outcomes']): ?>
                    <div class="card shadow mb-4">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-graduation-cap mr-1"></i> Learning Outcomes
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php echo nl2br(htmlspecialchars($subject['learning_outcomes'])); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Sidebar Information -->
                <div class="col-md-4">
                    <!-- Timeline Card -->
                    <div class="card shadow">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-history mr-1"></i> Timeline
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="timeline-content">
                                        <h6 class="font-weight-bold">Created</h6>
                                        <p class="text-muted mb-1"><?php echo date('F j, Y', strtotime($subject['created_at'])); ?></p>
                                        <small class="text-muted"><?php echo date('g:i a', strtotime($subject['created_at'])); ?></small>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-success"></div>
                                    <div class="timeline-content">
                                        <h6 class="font-weight-bold">Last Updated</h6>
                                        <p class="text-muted mb-1"><?php echo date('F j, Y', strtotime($subject['updated_at'])); ?></p>
                                        <small class="text-muted"><?php echo date('g:i a', strtotime($subject['updated_at'])); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="card shadow mt-4">
                        <div class="card-header bg-warning text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-bolt mr-1"></i> Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <a href="<?php echo BASE_URL; ?>/academic/subjects/edit?id=<?php echo $subject['id']; ?>" 
                                   class="list-group-item list-group-item-action">
                                    <i class="fas fa-edit mr-2 text-primary"></i>Edit Subject
                                </a>
                                <a href="<?php echo BASE_URL; ?>/academic/curriculum?program_id=&subject_id=<?php echo $subject['id']; ?>" 
                                   class="list-group-item list-group-item-action">
                                    <i class="fas fa-project-diagram mr-2 text-success"></i>Add to Program
                                </a>
                                <button class="list-group-item list-group-item-action text-danger delete-subject-btn"
                                        data-id="<?php echo $subject['id']; ?>"
                                        data-name="<?php echo $subject['name']; ?>">
                                    <i class="fas fa-trash mr-2"></i>Delete Subject
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Card -->
                    <div class="card shadow mt-4">
                        <div class="card-header bg-dark text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-chart-bar mr-1"></i> Summary
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <div class="border rounded p-3">
                                            <h4 class="text-primary mb-0"><?php echo $subject['credit_hours']; ?></h4>
                                            <small>Credits</small>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="border rounded p-3">
                                            <h4 class="text-success mb-0"><?php echo ($subject['theory_hours'] + $subject['practical_hours']); ?></h4>
                                            <small>Total Hours</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="border rounded p-3 bg-light">
                                            <small class="text-muted">
                                                <strong>Type:</strong> <?php echo ucfirst($subject['subject_type']); ?><br>
                                                <strong>Level:</strong> <?php echo ucfirst($subject['difficulty_level']); ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteSubjectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete subject "<strong id="deleteSubjectName"></strong>"?</p>
                <p class="text-danger"><small>This action cannot be undone. If this subject is used in any programs, it cannot be deleted.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="#" id="confirmSubjectDelete" class="btn btn-danger">Delete Subject</a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Delete confirmation
    $('.delete-subject-btn').on('click', function() {
        const subjectId = $(this).data('id');
        const subjectName = $(this).data('name');
        
        $('#deleteSubjectName').text(subjectName);
        $('#confirmSubjectDelete').attr('href', '<?php echo BASE_URL; ?>/academic/subjects/delete?id=' + subjectId);
        $('#deleteSubjectModal').modal('show');
    });
});
</script>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.timeline-content {
    padding: 5px 0;
}
</style>