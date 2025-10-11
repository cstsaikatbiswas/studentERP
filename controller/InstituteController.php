<?php
class InstituteController {
    private $instituteModel;
    private $instituteTypeModel;
    private $departmentModel;
    private $branchModel;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->instituteModel = new Institute($this->db);
        $this->instituteTypeModel = new InstituteType($this->db);
        $this->departmentModel = new Department($this->db);
        $this->branchModel = new Branch($this->db);
    }

    // Manage Institutes - List all institutes
    public function manage() {
        AuthController::requireLogin();

        $institutes = $this->instituteModel->readAll();
        $page_title = "Manage Institutes";
        
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/institutes/manage.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    // Add Institute Form
    public function add() {
        AuthController::requireLogin();

        $error = '';
        $success = '';
        $formData = [
            'name' => '', 'code' => '', 'type' => '', 'address' => '',
            'city' => '', 'state' => '', 'country' => '', 'pincode' => '',
            'phone' => '', 'email' => '', 'website' => '', 
            'established_year' => '', 'description' => '', 'status' => 'active'
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize input data
            $formData = array_map([$this, 'sanitizeInput'], $_POST);
            
            // Validate inputs
            $validationError = $this->validateInstituteData($formData);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                // Set model properties
                $this->instituteModel->name = $formData['name'];
                $this->instituteModel->code = $formData['code'];
                $this->instituteModel->type = $formData['type'];
                $this->instituteModel->address = $formData['address'];
                $this->instituteModel->city = $formData['city'];
                $this->instituteModel->state = $formData['state'];
                $this->instituteModel->country = $formData['country'];
                $this->instituteModel->pincode = $formData['pincode'];
                $this->instituteModel->phone = $formData['phone'];
                $this->instituteModel->email = $formData['email'];
                $this->instituteModel->website = $formData['website'];
                $this->instituteModel->established_year = $formData['established_year'];
                $this->instituteModel->description = $formData['description'];
                $this->instituteModel->status = $formData['status'];

                // Check if code already exists
                if ($this->instituteModel->codeExists()) {
                    $error = 'Institute code already exists. Please use a different code.';
                } else {
                    // Attempt to create institute
                    if ($this->instituteModel->create()) {
                        $success = 'Institute added successfully!';
                        // Reset form data
                        $formData = [
                            'name' => '', 'code' => '', 'type' => '', 'address' => '',
                            'city' => '', 'state' => '', 'country' => '', 'pincode' => '',
                            'phone' => '', 'email' => '', 'website' => '', 
                            'established_year' => '', 'description' => '', 'status' => 'active'
                        ];
                    } else {
                        $error = 'Failed to add institute. Please try again.';
                    }
                }
            }
        }

        $page_title = "Add Institute";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/institutes/add.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    // Edit Institute
    public function edit($id = null) {
        AuthController::requireLogin();

        if (!$id) {
            header('Location: manage');
            exit();
        }

        $this->instituteModel->id = $id;
        $institute = $this->instituteModel->readOne();

        if (!$institute) {
            $_SESSION['error_message'] = 'Institute not found.';
            header('Location: manage');
            exit();
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formData = array_map([$this, 'sanitizeInput'], $_POST);
            
            $validationError = $this->validateInstituteData($formData, $id);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                // Update model properties
                $this->instituteModel->name = $formData['name'];
                $this->instituteModel->code = $formData['code'];
                $this->instituteModel->type = $formData['type'];
                $this->instituteModel->address = $formData['address'];
                $this->instituteModel->city = $formData['city'];
                $this->instituteModel->state = $formData['state'];
                $this->instituteModel->country = $formData['country'];
                $this->instituteModel->pincode = $formData['pincode'];
                $this->instituteModel->phone = $formData['phone'];
                $this->instituteModel->email = $formData['email'];
                $this->instituteModel->website = $formData['website'];
                $this->instituteModel->established_year = $formData['established_year'];
                $this->instituteModel->description = $formData['description'];
                $this->instituteModel->status = $formData['status'];

                if ($this->instituteModel->update()) {
                    $success = 'Institute updated successfully!';
                    $institute = $this->instituteModel->readOne(); // Refresh data
                } else {
                    $error = 'Failed to update institute. Please try again.';
                }
            }
        } else {
            $formData = $institute;
        }

        $page_title = "Edit Institute";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/institutes/edit.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    // Delete Institute
    public function delete($id = null) {
        AuthController::requireLogin();

        if (!$id) {
            $_SESSION['error_message'] = 'Institute ID is required.';
            header('Location: manage');
            exit();
        }

        $this->instituteModel->id = $id;
        
        if ($this->instituteModel->delete()) {
            $_SESSION['success_message'] = 'Institute deleted successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to delete institute. Please try again.';
        }

        header('Location: manage');
        exit();
    }


    private function validateInstituteData($data, $id = null) {
        if (empty($data['name']) || empty($data['code']) || empty($data['type'])) {
            return 'Name, Code, and Type are required fields.';
        }

        if (strlen($data['name']) < 2 || strlen($data['name']) > 255) {
            return 'Name must be between 2 and 255 characters.';
        }

        if (strlen($data['code']) < 2 || strlen($data['code']) > 50) {
            return 'Code must be between 2 and 50 characters.';
        }

        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return 'Please enter a valid email address.';
        }

        if (!empty($data['website']) && !filter_var($data['website'], FILTER_VALIDATE_URL)) {
            return 'Please enter a valid website URL.';
        }

        if (!empty($data['established_year']) && 
            ($data['established_year'] < 1800 || $data['established_year'] > date('Y'))) {
            return 'Please enter a valid establishment year.';
        }

        return null;
    }

        // Institute Types Management
    public function types() {
        AuthController::requireLogin();

        $error = '';
        $success = '';
        $formData = [
            'name' => '', 'code' => '', 'description' => '', 'status' => 'active'
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formData = array_map([$this, 'sanitizeInput'], $_POST);
            
            $validationError = $this->validateInstituteTypeData($formData);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                $this->instituteTypeModel->name = $formData['name'];
                $this->instituteTypeModel->code = $formData['code'];
                $this->instituteTypeModel->description = $formData['description'];
                $this->instituteTypeModel->status = $formData['status'];

                if ($this->instituteTypeModel->codeExists()) {
                    $error = 'Institute type code already exists. Please use a different code.';
                } else {
                    if ($this->instituteTypeModel->create()) {
                        $success = 'Institute type added successfully!';
                        $formData = ['name' => '', 'code' => '', 'description' => '', 'status' => 'active'];
                    } else {
                        $error = 'Failed to add institute type. Please try again.';
                    }
                }
            }
        }

        $instituteTypes = $this->instituteTypeModel->readAll();
        $typeStats = $this->instituteTypeModel->getStatistics();

        $page_title = "Institute Types";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/institutes/types.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    // Edit Institute Type
    public function editType($id = null) {
        AuthController::requireLogin();

        if (!$id) {
            header('Location: ' . BASE_URL . '/institutes/types');
            exit();
        }

        $this->instituteTypeModel->id = $id;
        $instituteType = $this->instituteTypeModel->readOne();

        if (!$instituteType) {
            $_SESSION['error_message'] = 'Institute type not found.';
            header('Location: ' . BASE_URL . '/institutes/types');
            exit();
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formData = array_map([$this, 'sanitizeInput'], $_POST);
            
            $validationError = $this->validateInstituteTypeData($formData, $id);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                $this->instituteTypeModel->name = $formData['name'];
                $this->instituteTypeModel->code = $formData['code'];
                $this->instituteTypeModel->description = $formData['description'];
                $this->instituteTypeModel->status = $formData['status'];

                if ($this->instituteTypeModel->update()) {
                    $success = 'Institute type updated successfully!';
                    $instituteType = $this->instituteTypeModel->readOne();
                } else {
                    $error = 'Failed to update institute type. Please try again.';
                }
            }
        } else {
            $formData = $instituteType;
        }

        $page_title = "Edit Institute Type";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/institutes/edit_type.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    // Delete Institute Type
    public function deleteType($id = null) {
        AuthController::requireLogin();

        if (!$id) {
            $_SESSION['error_message'] = 'Institute type ID is required.';
            header('Location: ' . BASE_URL . '/institutes/types');
            exit();
        }

        $this->instituteTypeModel->id = $id;
        
        if ($this->instituteTypeModel->delete()) {
            $_SESSION['success_message'] = 'Institute type deleted successfully!';
        } else {
            $_SESSION['error_message'] = 'Cannot delete institute type. It might be in use by some institutes.';
        }

        header('Location: ' . BASE_URL . '/institutes/types');
        exit();
    }

    // Departments Management
    public function departments() {
        AuthController::requireLogin();

        $error = '';
        $success = '';
        $formData = [
            'institute_id' => '', 'name' => '', 'code' => '', 'type' => 'academic',
            'head_of_department' => '', 'email' => '', 'phone' => '', 
            'description' => '', 'status' => 'active'
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formData = array_map([$this, 'sanitizeInput'], $_POST);
            
            $validationError = $this->validateDepartmentData($formData);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                $this->departmentModel->institute_id = $formData['institute_id'];
                $this->departmentModel->name = $formData['name'];
                $this->departmentModel->code = $formData['code'];
                $this->departmentModel->type = $formData['type'];
                $this->departmentModel->head_of_department = $formData['head_of_department'];
                $this->departmentModel->email = $formData['email'];
                $this->departmentModel->phone = $formData['phone'];
                $this->departmentModel->description = $formData['description'];
                $this->departmentModel->status = $formData['status'];

                if ($this->departmentModel->codeExists()) {
                    $error = 'Department code already exists for this institute. Please use a different code.';
                } else {
                    if ($this->departmentModel->create()) {
                        $success = 'Department added successfully!';
                        $formData = [
                            'institute_id' => '', 'name' => '', 'code' => '', 'type' => 'academic',
                            'head_of_department' => '', 'email' => '', 'phone' => '', 
                            'description' => '', 'status' => 'active'
                        ];
                    } else {
                        $error = 'Failed to add department. Please try again.';
                    }
                }
            }
        }

        $departments = $this->departmentModel->readAll();
        $departmentStats = $this->departmentModel->getStatistics();
        $institutes = $this->instituteModel->readAll();

        $page_title = "Departments";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/institutes/departments.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    // Edit Department
    public function editDepartment($id = null) {
        AuthController::requireLogin();

        if (!$id) {
            header('Location: ' . BASE_URL . '/institutes/departments');
            exit();
        }

        $this->departmentModel->id = $id;
        $department = $this->departmentModel->readOne();

        if (!$department) {
            $_SESSION['error_message'] = 'Department not found.';
            header('Location: ' . BASE_URL . '/institutes/departments');
            exit();
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formData = array_map([$this, 'sanitizeInput'], $_POST);
            
            $validationError = $this->validateDepartmentData($formData, $id);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                $this->departmentModel->name = $formData['name'];
                $this->departmentModel->code = $formData['code'];
                $this->departmentModel->type = $formData['type'];
                $this->departmentModel->head_of_department = $formData['head_of_department'];
                $this->departmentModel->email = $formData['email'];
                $this->departmentModel->phone = $formData['phone'];
                $this->departmentModel->description = $formData['description'];
                $this->departmentModel->status = $formData['status'];

                if ($this->departmentModel->update()) {
                    $success = 'Department updated successfully!';
                    $department = $this->departmentModel->readOne();
                } else {
                    $error = 'Failed to update department. Please try again.';
                }
            }
        } else {
            $formData = $department;
        }

        $institutes = $this->instituteModel->readAll();

        $page_title = "Edit Department";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/institutes/edit_department.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    // Delete Department
    public function deleteDepartment($id = null) {
        AuthController::requireLogin();

        if (!$id) {
            $_SESSION['error_message'] = 'Department ID is required.';
            header('Location: ' . BASE_URL . '/institutes/departments');
            exit();
        }

        $this->departmentModel->id = $id;
        
        if ($this->departmentModel->delete()) {
            $_SESSION['success_message'] = 'Department deleted successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to delete department. Please try again.';
        }

        header('Location: ' . BASE_URL . '/institutes/departments');
        exit();
    }

    // Branches Management
    public function branches() {
        AuthController::requireLogin();

        $error = '';
        $success = '';
        $formData = [
            'institute_id' => '', 'name' => '', 'code' => '', 'type' => 'branch',
            'address' => '', 'city' => '', 'state' => '', 'country' => 'India',
            'pincode' => '', 'phone' => '', 'email' => '', 'website' => '',
            'established_year' => '', 'total_students' => 0, 'total_faculty' => 0,
            'description' => '', 'status' => 'active'
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formData = array_map([$this, 'sanitizeInput'], $_POST);
            
            $validationError = $this->validateBranchData($formData);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                $this->branchModel->institute_id = $formData['institute_id'];
                $this->branchModel->name = $formData['name'];
                $this->branchModel->code = $formData['code'];
                $this->branchModel->type = $formData['type'];
                $this->branchModel->address = $formData['address'];
                $this->branchModel->city = $formData['city'];
                $this->branchModel->state = $formData['state'];
                $this->branchModel->country = $formData['country'];
                $this->branchModel->pincode = $formData['pincode'];
                $this->branchModel->phone = $formData['phone'];
                $this->branchModel->email = $formData['email'];
                $this->branchModel->website = $formData['website'];
                $this->branchModel->established_year = $formData['established_year'];
                $this->branchModel->total_students = $formData['total_students'];
                $this->branchModel->total_faculty = $formData['total_faculty'];
                $this->branchModel->description = $formData['description'];
                $this->branchModel->status = $formData['status'];

                if ($this->branchModel->codeExists()) {
                    $error = 'Branch code already exists for this institute. Please use a different code.';
                } else {
                    if ($this->branchModel->create()) {
                        $success = 'Branch added successfully!';
                        $formData = [
                            'institute_id' => '', 'name' => '', 'code' => '', 'type' => 'branch',
                            'address' => '', 'city' => '', 'state' => '', 'country' => 'India',
                            'pincode' => '', 'phone' => '', 'email' => '', 'website' => '',
                            'established_year' => '', 'total_students' => 0, 'total_faculty' => 0,
                            'description' => '', 'status' => 'active'
                        ];
                    } else {
                        $error = 'Failed to add branch. Please try again.';
                    }
                }
            }
        }

        $branches = $this->branchModel->readAll();
        $branchStats = $this->branchModel->getStatistics();
        $institutes = $this->instituteModel->readAll();

        $page_title = "Branches";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/institutes/branches.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    // Edit Branch
    public function editBranch($id = null) {
        AuthController::requireLogin();

        if (!$id) {
            header('Location: ' . BASE_URL . '/institutes/branches');
            exit();
        }

        $this->branchModel->id = $id;
        $branch = $this->branchModel->readOne();

        if (!$branch) {
            $_SESSION['error_message'] = 'Branch not found.';
            header('Location: ' . BASE_URL . '/institutes/branches');
            exit();
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formData = array_map([$this, 'sanitizeInput'], $_POST);
            
            $validationError = $this->validateBranchData($formData, $id);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                $this->branchModel->name = $formData['name'];
                $this->branchModel->code = $formData['code'];
                $this->branchModel->type = $formData['type'];
                $this->branchModel->address = $formData['address'];
                $this->branchModel->city = $formData['city'];
                $this->branchModel->state = $formData['state'];
                $this->branchModel->country = $formData['country'];
                $this->branchModel->pincode = $formData['pincode'];
                $this->branchModel->phone = $formData['phone'];
                $this->branchModel->email = $formData['email'];
                $this->branchModel->website = $formData['website'];
                $this->branchModel->established_year = $formData['established_year'];
                $this->branchModel->total_students = $formData['total_students'];
                $this->branchModel->total_faculty = $formData['total_faculty'];
                $this->branchModel->description = $formData['description'];
                $this->branchModel->status = $formData['status'];

                if ($this->branchModel->update()) {
                    $success = 'Branch updated successfully!';
                    $branch = $this->branchModel->readOne();
                } else {
                    $error = 'Failed to update branch. Please try again.';
                }
            }
        } else {
            $formData = $branch;
        }

        $institutes = $this->instituteModel->readAll();

        $page_title = "Edit Branch";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/institutes/edit_branch.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    // Delete Branch
    public function deleteBranch($id = null) {
        AuthController::requireLogin();

        if (!$id) {
            $_SESSION['error_message'] = 'Branch ID is required.';
            header('Location: ' . BASE_URL . '/institutes/branches');
            exit();
        }

        $this->branchModel->id = $id;
        
        if ($this->branchModel->delete()) {
            $_SESSION['success_message'] = 'Branch deleted successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to delete branch. Please try again.';
        }

        header('Location: ' . BASE_URL . '/institutes/branches');
        exit();
    }

    // Validation Methods
    private function validateInstituteTypeData($data, $id = null) {
        if (empty($data['name']) || empty($data['code'])) {
            return 'Name and Code are required fields.';
        }

        if (strlen($data['name']) < 2 || strlen($data['name']) > 100) {
            return 'Name must be between 2 and 100 characters.';
        }

        if (strlen($data['code']) < 2 || strlen($data['code']) > 50) {
            return 'Code must be between 2 and 50 characters.';
        }

        return null;
    }

    private function validateDepartmentData($data, $id = null) {
        if (empty($data['institute_id']) || empty($data['name']) || empty($data['code'])) {
            return 'Institute, Name, and Code are required fields.';
        }

        if (strlen($data['name']) < 2 || strlen($data['name']) > 100) {
            return 'Name must be between 2 and 100 characters.';
        }

        if (strlen($data['code']) < 2 || strlen($data['code']) > 50) {
            return 'Code must be between 2 and 50 characters.';
        }

        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return 'Please enter a valid email address.';
        }

        return null;
    }

    private function validateBranchData($data, $id = null) {
        if (empty($data['institute_id']) || empty($data['name']) || empty($data['code'])) {
            return 'Institute, Name, and Code are required fields.';
        }

        if (strlen($data['name']) < 2 || strlen($data['name']) > 100) {
            return 'Name must be between 2 and 100 characters.';
        }

        if (strlen($data['code']) < 2 || strlen($data['code']) > 50) {
            return 'Code must be between 2 and 50 characters.';
        }

        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return 'Please enter a valid email address.';
        }

        if (!empty($data['website']) && !filter_var($data['website'], FILTER_VALIDATE_URL)) {
            return 'Please enter a valid website URL.';
        }

        return null;
    }

    private function sanitizeInput($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    // API Methods
    public function getStatistics() {
        AuthController::requireLogin();

        $stats = $this->instituteModel->getStatistics();
        header('Content-Type: application/json');
        echo json_encode($stats);
    }

    public function getRecent() {
        AuthController::requireLogin();

        $institutes = $this->instituteModel->getRecent(5);
        header('Content-Type: application/json');
        echo json_encode($institutes);
    }

    // Get departments by institute (AJAX)
    public function getDepartmentsByInstitute() {
        AuthController::requireLogin();

        $institute_id = isset($_GET['institute_id']) ? $_GET['institute_id'] : null;
        
        if ($institute_id) {
            $departments = $this->departmentModel->readByInstitute($institute_id);
            header('Content-Type: application/json');
            echo json_encode($departments);
        } else {
            echo json_encode([]);
        }
    }

    // Get branches by institute (AJAX)
    public function getBranchesByInstitute() {
        AuthController::requireLogin();

        $institute_id = isset($_GET['institute_id']) ? $_GET['institute_id'] : null;
        
        if ($institute_id) {
            $branches = $this->branchModel->readByInstitute($institute_id);
            header('Content-Type: application/json');
            echo json_encode($branches);
        } else {
            echo json_encode([]);
        }
    }

}