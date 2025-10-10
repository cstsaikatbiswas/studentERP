<?php
class InstituteController {
    private $instituteModel;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->instituteModel = new Institute($this->db);
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

    // Institute Types Management
    public function types() {
        AuthController::requireLogin();

        $page_title = "Institute Types";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/institutes/types.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    // Departments Management
    public function departments() {
        AuthController::requireLogin();

        $page_title = "Departments";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/institutes/departments.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    // Branches Management
    public function branches() {
        AuthController::requireLogin();

        $page_title = "Branches";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/institutes/branches.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    // API: Get institute statistics
    public function getStatistics() {
        AuthController::requireLogin();

        $stats = $this->instituteModel->getStatistics();
        header('Content-Type: application/json');
        echo json_encode($stats);
    }

    // API: Get recent institutes
    public function getRecent() {
        AuthController::requireLogin();

        $institutes = $this->instituteModel->getRecent(5);
        header('Content-Type: application/json');
        echo json_encode($institutes);
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

    private function sanitizeInput($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }
}