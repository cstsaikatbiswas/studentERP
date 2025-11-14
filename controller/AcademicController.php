<?php
class AcademicController {
    private $programModel;
    private $batchModel;
    private $subjectModel;
    private $programSubjectModel;
    private $departmentModel;
    private $userModel;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->programModel = new Program($this->db);
        $this->batchModel = new Batch($this->db);
        $this->subjectModel = new Subject($this->db);
        $this->programSubjectModel = new ProgramSubject($this->db);
        $this->departmentModel = new Department($this->db);
        
        // We'll create a simple User model for created_by references
        $this->userModel = new stdClass();
    }

    // Programs Management
    public function programs() {
        AuthController::requireLogin();

        $filters = [];
        if (isset($_GET['department_id']) && !empty($_GET['department_id'])) {
            $filters['department_id'] = (int)$_GET['department_id'];
        }
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            $filters['status'] = $_GET['status'];
        }
        if (isset($_GET['degree_type']) && !empty($_GET['degree_type'])) {
            $filters['degree_type'] = $_GET['degree_type'];
        }

        $programs = $this->programModel->readAll($filters);
        $departments = $this->departmentModel->readAll();
        $programStats = $this->programModel->getStatistics();

        $page_title = "Academic Programs";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/academic/programs/manage.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    public function addProgram() {
        AuthController::requireLogin();

        $error = '';
        $success = '';
        $formData = [
            'name' => '', 'code' => '', 'description' => '', 'duration_years' => 4,
            'total_credits' => 120, 'department_id' => '', 'degree_type' => 'undergraduate',
            'program_level' => 'bachelor', 'accreditation_status' => 'pending',
            'start_date' => '', 'end_date' => '', 'total_semesters' => 8,
            'max_students' => 100, 'current_students' => 0, 'program_fee' => 0.00,
            'status' => 'active'
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formData = array_map([$this, 'sanitizeInput'], $_POST);
            $formData['created_by'] = $_SESSION['user_id'];

            $validationError = $this->validateProgramData($formData);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                // Set model properties
                $this->programModel->name = $formData['name'];
                $this->programModel->code = $formData['code'];
                $this->programModel->description = $formData['description'];
                $this->programModel->duration_years = $formData['duration_years'];
                $this->programModel->total_credits = $formData['total_credits'];
                $this->programModel->department_id = $formData['department_id'];
                $this->programModel->degree_type = $formData['degree_type'];
                $this->programModel->program_level = $formData['program_level'];
                $this->programModel->accreditation_status = $formData['accreditation_status'];
                $this->programModel->start_date = $formData['start_date'];
                $this->programModel->end_date = $formData['end_date'];
                $this->programModel->total_semesters = $formData['total_semesters'];
                $this->programModel->max_students = $formData['max_students'];
                $this->programModel->current_students = $formData['current_students'];
                $this->programModel->program_fee = $formData['program_fee'];
                $this->programModel->status = $formData['status'];
                $this->programModel->created_by = $formData['created_by'];

                if ($this->programModel->codeExists()) {
                    $error = 'Program code already exists. Please use a different code.';
                } else {
                    if ($this->programModel->create()) {
                        $_SESSION['success_message'] = 'Program added successfully!';
                        header('Location: ' . BASE_URL . '/academic/programs');
                        exit();
                    } else {
                        $error = 'Failed to add program. Please try again.';
                    }
                }
            }
        }

        $departments = $this->departmentModel->readAll();

        $page_title = "Add Academic Program";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/academic/programs/add.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    public function editProgram($id = null) {
        AuthController::requireLogin();

        if (!$id) {
            header('Location: ' . BASE_URL . '/academic/programs');
            exit();
        }

        $this->programModel->id = $id;
        $program = $this->programModel->readOne();

        if (!$program) {
            $_SESSION['error_message'] = 'Program not found.';
            header('Location: ' . BASE_URL . '/academic/programs');
            exit();
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formData = array_map([$this, 'sanitizeInput'], $_POST);
            
            $validationError = $this->validateProgramData($formData, $id);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                $this->programModel->name = $formData['name'];
                $this->programModel->code = $formData['code'];
                $this->programModel->description = $formData['description'];
                $this->programModel->duration_years = $formData['duration_years'];
                $this->programModel->total_credits = $formData['total_credits'];
                $this->programModel->department_id = $formData['department_id'];
                $this->programModel->degree_type = $formData['degree_type'];
                $this->programModel->program_level = $formData['program_level'];
                $this->programModel->accreditation_status = $formData['accreditation_status'];
                $this->programModel->start_date = $formData['start_date'];
                $this->programModel->end_date = $formData['end_date'];
                $this->programModel->total_semesters = $formData['total_semesters'];
                $this->programModel->max_students = $formData['max_students'];
                $this->programModel->current_students = $formData['current_students'];
                $this->programModel->program_fee = $formData['program_fee'];
                $this->programModel->status = $formData['status'];

                if ($this->programModel->update()) {
                    $success = 'Program updated successfully!';
                    $program = $this->programModel->readOne(); // Refresh data
                } else {
                    $error = 'Failed to update program. Please try again.';
                }
            }
        } else {
            $formData = $program;
        }

        $departments = $this->departmentModel->readAll();

        $page_title = "Edit Academic Program";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/academic/programs/edit.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    public function viewProgram($id = null) {
        AuthController::requireLogin();

        if (!$id) {
            header('Location: ' . BASE_URL . '/academic/programs');
            exit();
        }

        $this->programModel->id = $id;
        $program = $this->programModel->readOne();

        if (!$program) {
            $_SESSION['error_message'] = 'Program not found.';
            header('Location: ' . BASE_URL . '/academic/programs');
            exit();
        }

        // Get program batches
        $batches = $this->batchModel->readByProgram($id);
        
        // Get program curriculum
        $curriculum = $this->programSubjectModel->getProgramCurriculum($id);
        
        // Get credit summary
        $creditSummary = $this->programSubjectModel->getCreditSummary($id);

        $page_title = "View Program: " . $program['name'];
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/academic/programs/view.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    public function deleteProgram($id = null) {
        AuthController::requireLogin();

        if (!$id) {
            $_SESSION['error_message'] = 'Program ID is required.';
            header('Location: ' . BASE_URL . '/academic/programs');
            exit();
        }

        $this->programModel->id = $id;
        
        if ($this->programModel->delete()) {
            $_SESSION['success_message'] = 'Program deleted successfully!';
        } else {
            $_SESSION['error_message'] = 'Cannot delete program. It may have active batches or other dependencies.';
        }

        header('Location: ' . BASE_URL . '/academic/programs');
        exit();
    }

    // Batch Management
    public function batches() {
        AuthController::requireLogin();

        $filters = [];
        if (isset($_GET['program_id']) && !empty($_GET['program_id'])) {
            $filters['program_id'] = (int)$_GET['program_id'];
        }
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            $filters['status'] = $_GET['status'];
        }
        if (isset($_GET['batch_year']) && !empty($_GET['batch_year'])) {
            $filters['batch_year'] = (int)$_GET['batch_year'];
        }

        $batches = $this->batchModel->readAll($filters);
        $programs = $this->programModel->readAll();
        $batchStats = $this->batchModel->getStatistics();

        $page_title = "Academic Batches";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/academic/batches/manage.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    public function addBatch() {
        AuthController::requireLogin();

        $error = '';
        $success = '';
        $formData = [
            'program_id' => '', 'batch_year' => date('Y'), 'batch_code' => '',
            'batch_name' => '', 'start_date' => '', 'end_date' => '',
            'current_semester' => 1, 'total_students' => 0, 'max_capacity' => 60,
            'class_teacher_id' => '', 'fee_structure' => '', 'admission_criteria' => '',
            'status' => 'active'
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formData = array_map([$this, 'sanitizeInput'], $_POST);
            $formData['created_by'] = $_SESSION['user_id'];

            $validationError = $this->validateBatchData($formData);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                $this->batchModel->program_id = $formData['program_id'];
                $this->batchModel->batch_year = $formData['batch_year'];
                $this->batchModel->batch_code = $formData['batch_code'];
                $this->batchModel->batch_name = $formData['batch_name'];
                $this->batchModel->start_date = $formData['start_date'];
                $this->batchModel->end_date = $formData['end_date'];
                $this->batchModel->current_semester = $formData['current_semester'];
                $this->batchModel->total_students = $formData['total_students'];
                $this->batchModel->max_capacity = $formData['max_capacity'];
                $this->batchModel->class_teacher_id = $formData['class_teacher_id'];
                $this->batchModel->fee_structure = $formData['fee_structure'];
                $this->batchModel->admission_criteria = $formData['admission_criteria'];
                $this->batchModel->status = $formData['status'];
                $this->batchModel->created_by = $formData['created_by'];

                if ($this->batchModel->codeExists()) {
                    $error = 'Batch code already exists for this program. Please use a different code.';
                } else {
                    if ($this->batchModel->create()) {
                        $_SESSION['success_message'] = 'Batch added successfully!';
                        header('Location: ' . BASE_URL . '/academic/batches');
                        exit();
                    } else {
                        $error = 'Failed to add batch. Please try again.';
                    }
                }
            }
        }

        $programs = $this->programModel->readAll();

        $page_title = "Add Academic Batch";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/academic/batches/add.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    public function editBatch($id = null) {
        AuthController::requireLogin();

        if (!$id) {
            header('Location: ' . BASE_URL . '/academic/batches');
            exit();
        }

        $this->batchModel->id = $id;
        $batch = $this->batchModel->readOne();

        if (!$batch) {
            $_SESSION['error_message'] = 'Batch not found.';
            header('Location: ' . BASE_URL . '/academic/batches');
            exit();
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formData = array_map([$this, 'sanitizeInput'], $_POST);
            
            $validationError = $this->validateBatchData($formData, $id);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                $this->batchModel->batch_year = $formData['batch_year'];
                $this->batchModel->batch_code = $formData['batch_code'];
                $this->batchModel->batch_name = $formData['batch_name'];
                $this->batchModel->start_date = $formData['start_date'];
                $this->batchModel->end_date = $formData['end_date'];
                $this->batchModel->current_semester = $formData['current_semester'];
                $this->batchModel->total_students = $formData['total_students'];
                $this->batchModel->max_capacity = $formData['max_capacity'];
                $this->batchModel->class_teacher_id = $formData['class_teacher_id'];
                $this->batchModel->fee_structure = $formData['fee_structure'];
                $this->batchModel->admission_criteria = $formData['admission_criteria'];
                $this->batchModel->status = $formData['status'];

                if ($this->batchModel->update()) {
                    $success = 'Batch updated successfully!';
                    $batch = $this->batchModel->readOne(); // Refresh data
                } else {
                    $error = 'Failed to update batch. Please try again.';
                }
            }
        } else {
            $formData = $batch;
        }

        $programs = $this->programModel->readAll();

        $page_title = "Edit Academic Batch";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/academic/batches/edit.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    public function viewBatch($id = null) {
        AuthController::requireLogin();

        if (!$id) {
            header('Location: ' . BASE_URL . '/academic/batches');
            exit();
        }

        $this->batchModel->id = $id;
        $batch = $this->batchModel->readOne();

        if (!$batch) {
            $_SESSION['error_message'] = 'Batch not found.';
            header('Location: ' . BASE_URL . '/academic/batches');
            exit();
        }

        // Get batch progress (would typically get from student progress)
        $batchProgress = $this->batchModel->getBatchProgress();

        $page_title = "View Batch: " . $batch['batch_name'];
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/academic/batches/view.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    public function deleteBatch($id = null) {
        AuthController::requireLogin();

        if (!$id) {
            $_SESSION['error_message'] = 'Batch ID is required.';
            header('Location: ' . BASE_URL . '/academic/batches');
            exit();
        }

        $this->batchModel->id = $id;
        
        if ($this->batchModel->delete()) {
            $_SESSION['success_message'] = 'Batch deleted successfully!';
        } else {
            $_SESSION['error_message'] = 'Cannot delete batch. It may have enrolled students.';
        }

        header('Location: ' . BASE_URL . '/academic/batches');
        exit();
    }

    // Subject Management
    public function subjects() {
        AuthController::requireLogin();

        $filters = [];
        if (isset($_GET['department_id']) && !empty($_GET['department_id'])) {
            $filters['department_id'] = (int)$_GET['department_id'];
        }
        if (isset($_GET['subject_type']) && !empty($_GET['subject_type'])) {
            $filters['subject_type'] = $_GET['subject_type'];
        }
        if (isset($_GET['difficulty_level']) && !empty($_GET['difficulty_level'])) {
            $filters['difficulty_level'] = $_GET['difficulty_level'];
        }
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            $filters['status'] = $_GET['status'];
        }

        $subjects = $this->subjectModel->readAll($filters);
        $departments = $this->departmentModel->readAll();
        $subjectStats = $this->subjectModel->getStatistics();

        $page_title = "Subjects";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/academic/subjects/manage.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    public function addSubject() {
        AuthController::requireLogin();

        $error = '';
        $success = '';
        $formData = [
            'name' => '', 'code' => '', 'description' => '', 'credit_hours' => 3.00,
            'theory_hours' => 0, 'practical_hours' => 0, 'subject_type' => 'core',
            'difficulty_level' => 'intermediate', 'department_id' => '',
            'prerequisites' => '', 'learning_outcomes' => '', 'status' => 'active'
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formData = array_map([$this, 'sanitizeInput'], $_POST);
            $formData['created_by'] = $_SESSION['user_id'];

            $validationError = $this->validateSubjectData($formData);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                $this->subjectModel->name = $formData['name'];
                $this->subjectModel->code = $formData['code'];
                $this->subjectModel->description = $formData['description'];
                $this->subjectModel->credit_hours = $formData['credit_hours'];
                $this->subjectModel->theory_hours = $formData['theory_hours'];
                $this->subjectModel->practical_hours = $formData['practical_hours'];
                $this->subjectModel->subject_type = $formData['subject_type'];
                $this->subjectModel->difficulty_level = $formData['difficulty_level'];
                $this->subjectModel->department_id = $formData['department_id'];
                $this->subjectModel->prerequisites = $formData['prerequisites'];
                $this->subjectModel->learning_outcomes = $formData['learning_outcomes'];
                $this->subjectModel->status = $formData['status'];
                $this->subjectModel->created_by = $formData['created_by'];

                if ($this->subjectModel->codeExists()) {
                    $error = 'Subject code already exists. Please use a different code.';
                } else {
                    if ($this->subjectModel->create()) {
                        $_SESSION['success_message'] = 'Subject added successfully!';
                        header('Location: ' . BASE_URL . '/academic/subjects');
                        exit();
                    } else {
                        $error = 'Failed to add subject. Please try again.';
                    }
                }
            }
        }

        $departments = $this->departmentModel->readAll();

        $page_title = "Add Subject";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/academic/subjects/add.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    public function editSubject($id = null) {
        AuthController::requireLogin();

        if (!$id) {
            header('Location: ' . BASE_URL . '/academic/subjects');
            exit();
        }

        $this->subjectModel->id = $id;
        $subject = $this->subjectModel->readOne();

        if (!$subject) {
            $_SESSION['error_message'] = 'Subject not found.';
            header('Location: ' . BASE_URL . '/academic/subjects');
            exit();
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formData = array_map([$this, 'sanitizeInput'], $_POST);
            
            $validationError = $this->validateSubjectData($formData, $id);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                $this->subjectModel->name = $formData['name'];
                $this->subjectModel->code = $formData['code'];
                $this->subjectModel->description = $formData['description'];
                $this->subjectModel->credit_hours = $formData['credit_hours'];
                $this->subjectModel->theory_hours = $formData['theory_hours'];
                $this->subjectModel->practical_hours = $formData['practical_hours'];
                $this->subjectModel->subject_type = $formData['subject_type'];
                $this->subjectModel->difficulty_level = $formData['difficulty_level'];
                $this->subjectModel->department_id = $formData['department_id'];
                $this->subjectModel->prerequisites = $formData['prerequisites'];
                $this->subjectModel->learning_outcomes = $formData['learning_outcomes'];
                $this->subjectModel->status = $formData['status'];

                if ($this->subjectModel->update()) {
                    $success = 'Subject updated successfully!';
                    $subject = $this->subjectModel->readOne(); // Refresh data
                } else {
                    $error = 'Failed to update subject. Please try again.';
                }
            }
        } else {
            $formData = $subject;
        }

        $departments = $this->departmentModel->readAll();

        $page_title = "Edit Subject";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/academic/subjects/edit.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    public function deleteSubject($id = null) {
        AuthController::requireLogin();

        if (!$id) {
            $_SESSION['error_message'] = 'Subject ID is required.';
            header('Location: ' . BASE_URL . '/academic/subjects');
            exit();
        }

        $this->subjectModel->id = $id;
        
        if ($this->subjectModel->delete()) {
            $_SESSION['success_message'] = 'Subject deleted successfully!';
        } else {
            $_SESSION['error_message'] = 'Cannot delete subject. It may be used in program curriculums.';
        }

        header('Location: ' . BASE_URL . '/academic/subjects');
        exit();
    }

    // Curriculum Management
    public function curriculum($program_id = null) {
        AuthController::requireLogin();

        if (!$program_id) {
            header('Location: ' . BASE_URL . '/academic/programs');
            exit();
        }

        $this->programModel->id = $program_id;
        $program = $this->programModel->readOne();

        if (!$program) {
            $_SESSION['error_message'] = 'Program not found.';
            header('Location: ' . BASE_URL . '/academic/programs');
            exit();
        }

        $curriculum = $this->programSubjectModel->getProgramCurriculum($program_id);
        $subjects = $this->subjectModel->readAll();
        $creditSummary = $this->programSubjectModel->getCreditSummary($program_id);

        $page_title = "Curriculum: " . $program['name'];
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/academic/curriculum/manage.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    public function addSubjectToProgram() {
        AuthController::requireLogin();

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formData = array_map([$this, 'sanitizeInput'], $_POST);
            
            $validationError = $this->validateProgramSubjectData($formData);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                $this->programSubjectModel->program_id = $formData['program_id'];
                $this->programSubjectModel->subject_id = $formData['subject_id'];
                $this->programSubjectModel->semester = $formData['semester'];
                $this->programSubjectModel->is_optional = $formData['is_optional'] ?? 0;
                $this->programSubjectModel->min_credits = $formData['min_credits'];
                $this->programSubjectModel->max_credits = $formData['max_credits'];
                $this->programSubjectModel->course_code = $formData['course_code'];
                $this->programSubjectModel->course_type = $formData['course_type'];
                $this->programSubjectModel->teaching_methodology = $formData['teaching_methodology'];
                $this->programSubjectModel->assessment_pattern = $formData['assessment_pattern'];
                $this->programSubjectModel->status = 'active';

                if ($this->programSubjectModel->existsInProgram()) {
                    $error = 'This subject is already added to the program for the selected semester.';
                } else {
                    if ($this->programSubjectModel->create()) {
                        $success = 'Subject added to program successfully!';
                    } else {
                        $error = 'Failed to add subject to program. Please try again.';
                    }
                }
            }
        }

        if ($error) {
            $_SESSION['error_message'] = $error;
        } elseif ($success) {
            $_SESSION['success_message'] = $success;
        }

        header('Location: ' . BASE_URL . '/academic/curriculum?program_id=' . $formData['program_id']);
        exit();
    }

    public function removeSubjectFromProgram($id = null) {
        AuthController::requireLogin();

        if (!$id) {
            $_SESSION['error_message'] = 'Curriculum entry ID is required.';
            header('Location: ' . BASE_URL . '/academic/programs');
            exit();
        }

        $this->programSubjectModel->id = $id;
        
        // Get program_id before deletion for redirect
        $curriculumEntry = $this->getCurriculumEntry($id);
        $program_id = $curriculumEntry ? $curriculumEntry['program_id'] : null;

        if ($this->programSubjectModel->delete()) {
            $_SESSION['success_message'] = 'Subject removed from program successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to remove subject from program.';
        }

        if ($program_id) {
            header('Location: ' . BASE_URL . '/academic/curriculum?program_id=' . $program_id);
        } else {
            header('Location: ' . BASE_URL . '/academic/programs');
        }
        exit();
    }

    // API Methods
    public function getProgramsByDepartment() {
        AuthController::requireLogin();

        $department_id = isset($_GET['department_id']) ? (int)$_GET['department_id'] : null;
        
        if ($department_id) {
            $programs = $this->programModel->readByDepartment($department_id);
            header('Content-Type: application/json');
            echo json_encode($programs);
        } else {
            echo json_encode([]);
        }
    }

    public function getBatchesByProgram() {
        AuthController::requireLogin();

        $program_id = isset($_GET['program_id']) ? (int)$_GET['program_id'] : null;
        
        if ($program_id) {
            $batches = $this->batchModel->readByProgram($program_id);
            header('Content-Type: application/json');
            echo json_encode($batches);
        } else {
            echo json_encode([]);
        }
    }

    public function getProgramStatistics() {
        AuthController::requireLogin();

        $stats = $this->programModel->getStatistics();
        header('Content-Type: application/json');
        echo json_encode($stats);
    }

    public function getSubjectUsage() {
        AuthController::requireLogin();

        $subject_id = isset($_GET['subject_id']) ? (int)$_GET['subject_id'] : null;
        
        if ($subject_id) {
            $this->subjectModel->id = $subject_id;
            $usage = $this->subjectModel->getProgramUsage();
            header('Content-Type: application/json');
            echo json_encode($usage);
        } else {
            echo json_encode([]);
        }
    }

    // Validation Methods
    private function validateProgramData($data, $id = null) {
        if (empty($data['name']) || empty($data['code']) || empty($data['department_id'])) {
            return 'Name, Code, and Department are required fields.';
        }

        if (strlen($data['name']) < 2 || strlen($data['name']) > 255) {
            return 'Name must be between 2 and 255 characters.';
        }

        if (strlen($data['code']) < 2 || strlen($data['code']) > 50) {
            return 'Code must be between 2 and 50 characters.';
        }

        if ($data['duration_years'] < 1 || $data['duration_years'] > 10) {
            return 'Duration must be between 1 and 10 years.';
        }

        if ($data['total_credits'] < 1 || $data['total_credits'] > 500) {
            return 'Total credits must be between 1 and 500.';
        }

        if (!empty($data['start_date']) && !empty($data['end_date'])) {
            if (strtotime($data['start_date']) > strtotime($data['end_date'])) {
                return 'Start date cannot be after end date.';
            }
        }

        return null;
    }

    private function validateBatchData($data, $id = null) {
        if (empty($data['program_id']) || empty($data['batch_year']) || empty($data['batch_code'])) {
            return 'Program, Batch Year, and Batch Code are required fields.';
        }

        if ($data['batch_year'] < 2000 || $data['batch_year'] > 2030) {
            return 'Batch year must be between 2000 and 2030.';
        }

        if (strlen($data['batch_code']) < 2 || strlen($data['batch_code']) > 50) {
            return 'Batch code must be between 2 and 50 characters.';
        }

        if (!empty($data['start_date']) && !empty($data['end_date'])) {
            if (strtotime($data['start_date']) > strtotime($data['end_date'])) {
                return 'Start date cannot be after end date.';
            }
        }

        if ($data['max_capacity'] < 1 || $data['max_capacity'] > 1000) {
            return 'Maximum capacity must be between 1 and 1000.';
        }

        if ($data['current_semester'] < 1 || $data['current_semester'] > 20) {
            return 'Current semester must be between 1 and 20.';
        }

        return null;
    }

    private function validateSubjectData($data, $id = null) {
        if (empty($data['name']) || empty($data['code'])) {
            return 'Name and Code are required fields.';
        }

        if (strlen($data['name']) < 2 || strlen($data['name']) > 255) {
            return 'Name must be between 2 and 255 characters.';
        }

        if (strlen($data['code']) < 2 || strlen($data['code']) > 50) {
            return 'Code must be between 2 and 50 characters.';
        }

        if ($data['credit_hours'] < 0 || $data['credit_hours'] > 50) {
            return 'Credit hours must be between 0 and 50.';
        }

        if ($data['theory_hours'] < 0 || $data['theory_hours'] > 100) {
            return 'Theory hours must be between 0 and 100.';
        }

        if ($data['practical_hours'] < 0 || $data['practical_hours'] > 100) {
            return 'Practical hours must be between 0 and 100.';
        }

        return null;
    }

    private function validateProgramSubjectData($data) {
        if (empty($data['program_id']) || empty($data['subject_id']) || empty($data['semester'])) {
            return 'Program, Subject, and Semester are required fields.';
        }

        if ($data['semester'] < 1 || $data['semester'] > 20) {
            return 'Semester must be between 1 and 20.';
        }

        if (!empty($data['min_credits']) && !empty($data['max_credits'])) {
            if ($data['min_credits'] > $data['max_credits']) {
                return 'Minimum credits cannot be greater than maximum credits.';
            }
        }

        return null;
    }

    private function sanitizeInput($data) {
        if (is_array($data)) {
            return array_map([$this, 'sanitizeInput'], $data);
        }
        return htmlspecialchars(strip_tags(trim($data)));
    }

    // Helper method to get curriculum entry
    private function getCurriculumEntry($id) {
        $query = "SELECT * FROM program_subjects WHERE id = ? LIMIT 1";
        $stmt = $this->db->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $entry = $result->fetch_assoc();
        $stmt->close();

        return $entry;
    }
}