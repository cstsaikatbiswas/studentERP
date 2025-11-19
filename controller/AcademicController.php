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

    public function viewSubject($id = null) {
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

        $page_title = "View Subject - " . $subject['name'];
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/academic/subjects/view.php';
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

    // Curriculum Management Methods
    public function curriculum() {
        AuthController::requireLogin();
        
        $program_id = isset($_GET['program_id']) ? $_GET['program_id'] : null;
        
        if (!$program_id) {
            $_SESSION['error_message'] = 'Program ID is required.';
            header('Location: ' . BASE_URL . '/academic/programs');
            exit();
        }

        // Get program details
        $this->programModel->id = $program_id;
        $program = $this->programModel->readOne();
        
        if (!$program) {
            $_SESSION['error_message'] = 'Program not found.';
            header('Location: ' . BASE_URL . '/academic/programs');
            exit();
        }

        // Get curriculum data (subjects by semester)
        $curriculum = $this->getProgramCurriculum($program_id);
        
        // Get available subjects for adding
        $availableSubjects = $this->subjectModel->readAll();
        
        // Get departments for filter
        $departments = $this->departmentModel->readAll();

        $page_title = "Curriculum Management - " . $program['name'];
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/academic/curriculum/manage.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    public function addSubjectToCurriculum() {
        AuthController::requireLogin();
        
        $program_id = isset($_GET['program_id']) ? $_GET['program_id'] : null;
        
        if (!$program_id) {
            $_SESSION['error_message'] = 'Program ID is required.';
            header('Location: ' . BASE_URL . '/academic/programs');
            exit();
        }

        // Get program details
        $this->programModel->id = $program_id;
        $program = $this->programModel->readOne();
        
        if (!$program) {
            $_SESSION['error_message'] = 'Program not found.';
            header('Location: ' . BASE_URL . '/academic/programs');
            exit();
        }

        $error = '';
        $success = '';
        $formData = [
            'subject_id' => '',
            'semester' => 1,
            'is_optional' => false,
            'min_credits' => '',
            'max_credits' => '',
            'course_code' => '',
            'course_type' => 'mandatory',
            'teaching_methodology' => '',
            'assessment_pattern' => '{}'
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formData = array_map([$this, 'sanitizeInput'], $_POST);
            $formData['is_optional'] = isset($_POST['is_optional']) ? true : false;
            
            $validationError = $this->validateCurriculumSubjectData($formData, $program_id);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                $this->programSubjectModel->program_id = $program_id;
                $this->programSubjectModel->subject_id = $formData['subject_id'];
                $this->programSubjectModel->semester = $formData['semester'];
                $this->programSubjectModel->is_optional = $formData['is_optional'];
                $this->programSubjectModel->min_credits = $formData['min_credits'];
                $this->programSubjectModel->max_credits = $formData['max_credits'];
                $this->programSubjectModel->course_code = $formData['course_code'];
                $this->programSubjectModel->course_type = $formData['course_type'];
                $this->programSubjectModel->teaching_methodology = $formData['teaching_methodology'];
                $this->programSubjectModel->assessment_pattern = $formData['assessment_pattern'];
                $this->programSubjectModel->status = 'active';

                if ($this->programSubjectModel->create()) {
                    $success = 'Subject added to curriculum successfully!';
                    $formData = [
                        'subject_id' => '',
                        'semester' => 1,
                        'is_optional' => false,
                        'min_credits' => '',
                        'max_credits' => '',
                        'course_code' => '',
                        'course_type' => 'mandatory',
                        'teaching_methodology' => '',
                        'assessment_pattern' => '{}'
                    ];
                } else {
                    $error = 'Failed to add subject to curriculum. Please try again.';
                }
            }
        }

        $availableSubjects = $this->subjectModel->readAll();
        $semesters = range(1, $program['total_semesters']);

        $page_title = "Add Subject to Curriculum - " . $program['name'];
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/academic/curriculum/add_subject.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    public function semesterView() {
        AuthController::requireLogin();
        
        $program_id = isset($_GET['program_id']) ? $_GET['program_id'] : null;
        $semester = isset($_GET['semester']) ? $_GET['semester'] : 1;
        
        if (!$program_id) {
            $_SESSION['error_message'] = 'Program ID is required.';
            header('Location: ' . BASE_URL . '/academic/programs');
            exit();
        }

        // Get program details
        $this->programModel->id = $program_id;
        $program = $this->programModel->readOne();
        
        if (!$program) {
            $_SESSION['error_message'] = 'Program not found.';
            header('Location: ' . BASE_URL . '/academic/programs');
            exit();
        }

        // Get subjects for the specific semester
        $semesterSubjects = $this->getSemesterSubjects($program_id, $semester);
        $semesters = range(1, $program['total_semesters']);

        // Calculate semester statistics
        $semesterStats = $this->calculateSemesterStats($semesterSubjects);

        $page_title = "Semester " . $semester . " - " . $program['name'];
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/academic/curriculum/semester_view.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    public function removeSubjectFromCurriculum() {
        AuthController::requireLogin();
        
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $program_id = isset($_GET['program_id']) ? $_GET['program_id'] : null;
        
        if (!$id || !$program_id) {
            $_SESSION['error_message'] = 'Subject mapping ID and Program ID are required.';
            header('Location: ' . BASE_URL . '/academic/programs');
            exit();
        }

        $this->programSubjectModel->id = $id;
        
        if ($this->programSubjectModel->delete()) {
            $_SESSION['success_message'] = 'Subject removed from curriculum successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to remove subject from curriculum. Please try again.';
        }

        header('Location: ' . BASE_URL . '/academic/curriculum?program_id=' . $program_id);
        exit();
    }

    public function updateCurriculumSubject() {
        AuthController::requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $program_id = isset($_POST['program_id']) ? $_POST['program_id'] : null;
            
            if (!$id || !$program_id) {
                $_SESSION['error_message'] = 'Required parameters missing.';
                header('Location: ' . BASE_URL . '/academic/programs');
                exit();
            }

            $formData = array_map([$this, 'sanitizeInput'], $_POST);
            $formData['is_optional'] = isset($_POST['is_optional']) ? true : false;
            
            $validationError = $this->validateCurriculumSubjectData($formData, $program_id, $id);
            
            if ($validationError) {
                $_SESSION['error_message'] = $validationError;
            } else {
                $this->programSubjectModel->id = $id;
                $this->programSubjectModel->semester = $formData['semester'];
                $this->programSubjectModel->is_optional = $formData['is_optional'];
                $this->programSubjectModel->min_credits = $formData['min_credits'];
                $this->programSubjectModel->max_credits = $formData['max_credits'];
                $this->programSubjectModel->course_code = $formData['course_code'];
                $this->programSubjectModel->course_type = $formData['course_type'];
                $this->programSubjectModel->teaching_methodology = $formData['teaching_methodology'];
                $this->programSubjectModel->assessment_pattern = $formData['assessment_pattern'];

                if ($this->programSubjectModel->update()) {
                    $_SESSION['success_message'] = 'Subject updated successfully!';
                } else {
                    $_SESSION['error_message'] = 'Failed to update subject. Please try again.';
                }
            }

            header('Location: ' . BASE_URL . '/academic/curriculum?program_id=' . $program_id);
            exit();
        }
    }

    // Helper Methods
    private function getProgramCurriculum($program_id) {
        $query = "SELECT ps.*, s.name as subject_name, s.code as subject_code, 
                        s.credit_hours, s.subject_type, s.difficulty_level,
                        d.name as department_name
                FROM program_subjects ps
                LEFT JOIN subjects s ON ps.subject_id = s.id
                LEFT JOIN departments d ON s.department_id = d.id
                WHERE ps.program_id = ?
                ORDER BY ps.semester ASC, ps.course_type DESC, s.name ASC";
        
        $stmt = $this->db->prepare($query);
        
        if (!$stmt) {
            return [];
        }

        $stmt->bind_param("i", $program_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $subjects = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        // Group by semester
        $curriculum = [];
        foreach ($subjects as $subject) {
            $semester = $subject['semester'];
            if (!isset($curriculum[$semester])) {
                $curriculum[$semester] = [];
            }
            $curriculum[$semester][] = $subject;
        }

        return $curriculum;
    }

    private function getSemesterSubjects($program_id, $semester) {
        $query = "SELECT ps.*, s.name as subject_name, s.code as subject_code, 
                        s.credit_hours, s.theory_hours, s.practical_hours,
                        s.subject_type, s.difficulty_level, s.description,
                        s.learning_outcomes, d.name as department_name
                FROM program_subjects ps
                LEFT JOIN subjects s ON ps.subject_id = s.id
                LEFT JOIN departments d ON s.department_id = d.id
                WHERE ps.program_id = ? AND ps.semester = ?
                ORDER BY ps.course_type DESC, s.name ASC";
        
        $stmt = $this->db->prepare($query);
        
        if (!$stmt) {
            return [];
        }

        $stmt->bind_param("ii", $program_id, $semester);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $subjects = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $subjects;
    }

    private function calculateSemesterStats($subjects) {
        $stats = [
            'total_subjects' => count($subjects),
            'total_credits' => 0,
            'theory_hours' => 0,
            'practical_hours' => 0,
            'core_subjects' => 0,
            'elective_subjects' => 0,
            'mandatory_courses' => 0,
            'optional_courses' => 0
        ];

        foreach ($subjects as $subject) {
            $stats['total_credits'] += $subject['credit_hours'];
            $stats['theory_hours'] += $subject['theory_hours'];
            $stats['practical_hours'] += $subject['practical_hours'];
            
            if ($subject['subject_type'] == 'core') {
                $stats['core_subjects']++;
            } elseif ($subject['subject_type'] == 'elective') {
                $stats['elective_subjects']++;
            }
            
            if ($subject['course_type'] == 'mandatory') {
                $stats['mandatory_courses']++;
            } else {
                $stats['optional_courses']++;
            }
        }

        return $stats;
    }

    private function validateCurriculumSubjectData($data, $program_id, $id = null) {
        if (empty($data['subject_id']) || empty($data['semester'])) {
            return 'Subject and Semester are required fields.';
        }

        if (!is_numeric($data['semester']) || $data['semester'] < 1) {
            return 'Semester must be a positive number.';
        }

        // Check if subject already exists in the same semester for this program
        $query = "SELECT id FROM program_subjects 
                WHERE program_id = ? AND subject_id = ? AND semester = ?";
        
        if ($id) {
            $query .= " AND id != ?";
        }

        $stmt = $this->db->prepare($query);
        
        if (!$stmt) {
            return 'Database error. Please try again.';
        }

        if ($id) {
            $stmt->bind_param("iiii", $program_id, $data['subject_id'], $data['semester'], $id);
        } else {
            $stmt->bind_param("iii", $program_id, $data['subject_id'], $data['semester']);
        }

        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->close();
            return 'This subject is already added to the same semester in this program.';
        }

        $stmt->close();
        return null;
    }
    public function editSubjectForm($id) {
        AuthController::requireLogin();
        
        if (!$id) {
            echo '<div class="alert alert-danger">Subject mapping ID is required.</div>';
            return;
        }

        $this->programSubjectModel->id = $id;
        $subjectMapping = $this->programSubjectModel->readOne();
        
        if (!$subjectMapping) {
            echo '<div class="alert alert-danger">Subject mapping not found.</div>';
            return;
        }

        // Get program details for semester range
        $this->programModel->id = $subjectMapping['program_id'];
        $program = $this->programModel->readOne();
        $semesters = range(1, $program['total_semesters']);

        // Generate the edit form
        echo '
        <input type="hidden" name="id" value="' . $subjectMapping['id'] . '">
        <input type="hidden" name="program_id" value="' . $subjectMapping['program_id'] . '">
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="edit_semester" class="font-weight-bold">Semester *</label>
                    <select class="form-control" id="edit_semester" name="semester" required>';
        
        foreach ($semesters as $sem) {
            $selected = $subjectMapping['semester'] == $sem ? 'selected' : '';
            echo '<option value="' . $sem . '" ' . $selected . '>Semester ' . $sem . '</option>';
        }
        
        echo '</select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="edit_course_type" class="font-weight-bold">Course Type *</label>
                    <select class="form-control" id="edit_course_type" name="course_type" required>
                        <option value="mandatory" ' . ($subjectMapping['course_type'] == 'mandatory' ? 'selected' : '') . '>Mandatory</option>
                        <option value="elective" ' . ($subjectMapping['course_type'] == 'elective' ? 'selected' : '') . '>Elective</option>
                        <option value="audit" ' . ($subjectMapping['course_type'] == 'audit' ? 'selected' : '') . '>Audit</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="edit_course_code" class="font-weight-bold">Course Code</label>
                    <input type="text" class="form-control" id="edit_course_code" name="course_code"
                        value="' . htmlspecialchars($subjectMapping['course_code']) . '"
                        placeholder="Enter course code">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="form-check mt-4">
                        <input type="checkbox" class="form-check-input" id="edit_is_optional" name="is_optional"
                            ' . ($subjectMapping['is_optional'] ? 'checked' : '') . '>
                        <label class="form-check-label font-weight-bold" for="edit_is_optional">
                            Optional Subject
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="edit_min_credits" class="font-weight-bold">Minimum Credits</label>
                    <input type="number" class="form-control" id="edit_min_credits" name="min_credits"
                        value="' . htmlspecialchars($subjectMapping['min_credits']) . '"
                        step="0.5" min="0" max="10">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="edit_max_credits" class="font-weight-bold">Maximum Credits</label>
                    <input type="number" class="form-control" id="edit_max_credits" name="max_credits"
                        value="' . htmlspecialchars($subjectMapping['max_credits']) . '"
                        step="0.5" min="0" max="10">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="edit_teaching_methodology" class="font-weight-bold">Teaching Methodology</label>
            <textarea class="form-control" id="edit_teaching_methodology" name="teaching_methodology" 
                    rows="3">' . htmlspecialchars($subjectMapping['teaching_methodology']) . '</textarea>
        </div>

        <div class="form-group">
            <label for="edit_assessment_pattern" class="font-weight-bold">Assessment Pattern</label>
            <textarea class="form-control" id="edit_assessment_pattern" name="assessment_pattern" 
                    rows="3">' . htmlspecialchars($subjectMapping['assessment_pattern']) . '</textarea>
            <small class="form-text text-muted">Enter assessment pattern in JSON format</small>
        </div>';
    }
}