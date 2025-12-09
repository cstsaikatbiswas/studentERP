<?php
class StaffController {
    private $staffModel;
    private $categoryModel;
    private $designationModel;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->staffModel = new Staff($this->db);
        $this->categoryModel = new StaffCategory($this->db);
        $this->designationModel = new StaffDesignation($this->db);
    }

    // Manage Staff - List all staff
    public function manage() {
        AuthController::requireLogin();

        // Get filters
        $filters = [
            'category_id' => isset($_GET['category_id']) ? $_GET['category_id'] : null,
            'designation_id' => isset($_GET['designation_id']) ? $_GET['designation_id'] : null,
            'status' => isset($_GET['status']) ? $_GET['status'] : null,
            'institute_id' => isset($_GET['institute_id']) ? $_GET['institute_id'] : null
        ];

        $staff_list = $this->staffModel->readAll($filters);
        $categories = $this->categoryModel->readAll();
        $designations = $this->designationModel->readAll();

        // Get institutes for filter
        $instituteModel = new Institute($this->db);
        $institutes = $instituteModel->readAll();

        $page_title = "Manage Staff";
        
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/staff/manage.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    // Add Staff Form
    public function add() {
        AuthController::requireLogin();

        $error = '';
        $success = '';
        $formData = $this->getEmptyFormData();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form data
            $formData = array_map([$this, 'sanitizeInput'], $_POST);
            
            // Validate inputs
            $validationError = $this->validateStaffData($formData);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                // Set model properties
                $this->setStaffProperties($formData);
                
                // Check if email exists
                if ($this->staffModel->emailExists()) {
                    $error = 'Email already exists. Please use a different email address.';
                } else {
                    // Attempt to create staff
                    if ($this->staffModel->create()) {
                        $success = 'Staff added successfully!';
                        $formData = $this->getEmptyFormData();
                    } else {
                        $error = 'Failed to add staff. Please try again.';
                    }
                }
            }
        }

        // Get categories and designations for dropdowns
        $categories = $this->categoryModel->readAll();
        $designations = $this->designationModel->readAll();

        $page_title = "Add Staff";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/staff/add.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    // Edit Staff
    public function edit($id = null) {
        AuthController::requireLogin();

        if (!$id) {
            header('Location: ' . BASE_URL . '/staff/manage');
            exit();
        }

        $this->staffModel->id = $id;
        $staff = $this->staffModel->readOne();

        if (!$staff) {
            $_SESSION['error_message'] = 'Staff not found.';
            header('Location: ' . BASE_URL . '/staff/manage');
            exit();
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formData = array_map([$this, 'sanitizeInput'], $_POST);
            
            $validationError = $this->validateStaffData($formData, $id);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                // Update model properties
                $this->setStaffProperties($formData);
                $this->staffModel->id = $id;
                
                // Check if email exists (excluding current staff)
                $this->staffModel->email = $formData['email'];
                if ($this->staffModel->emailExists()) {
                    $error = 'Email already exists. Please use a different email address.';
                } else {
                    if ($this->staffModel->update()) {
                        $success = 'Staff updated successfully!';
                        $staff = $this->staffModel->readOne(); // Refresh data
                    } else {
                        $error = 'Failed to update staff. Please try again.';
                    }
                }
            }
        } else {
            $formData = $staff;
        }

        // Get categories and designations for dropdowns
        $categories = $this->categoryModel->readAll();
        $designations = $this->designationModel->readAll();

        $page_title = "Edit Staff";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/staff/edit.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    // View Staff Details
    public function view($id = null) {
        AuthController::requireLogin();

        if (!$id) {
            header('Location: ' . BASE_URL . '/staff/manage');
            exit();
        }

        $this->staffModel->id = $id;
        $staff = $this->staffModel->readOne();

        if (!$staff) {
            $_SESSION['error_message'] = 'Staff not found.';
            header('Location: ' . BASE_URL . '/staff/manage');
            exit();
        }

        // Get staff allocations
        $allocations = $this->staffModel->getAllocations();
        
        // Get leave balance
        $leave_balance = $this->staffModel->getLeaveBalance();

        $page_title = "Staff Details";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/staff/view.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    // Delete Staff
    public function delete($id = null) {
        AuthController::requireLogin();

        if (!$id) {
            $_SESSION['error_message'] = 'Staff ID is required.';
            header('Location: ' . BASE_URL . '/staff/manage');
            exit();
        }

        $this->staffModel->id = $id;
        
        if ($this->staffModel->delete()) {
            $_SESSION['success_message'] = 'Staff deleted successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to delete staff. Please try again.';
        }

        header('Location: ' . BASE_URL . '/staff/manage');
        exit();
    }

    // Staff Allocation
    public function allocation($staff_id = null) {
        AuthController::requireLogin();

        if (!$staff_id) {
            header('Location: ' . BASE_URL . '/staff/manage');
            exit();
        }

        $this->staffModel->id = $staff_id;
        $staff = $this->staffModel->readOne();

        if (!$staff) {
            $_SESSION['error_message'] = 'Staff not found.';
            header('Location: ' . BASE_URL . '/staff/manage');
            exit();
        }

        $error = '';
        $success = '';
        $formData = [
            'institute_id' => '',
            'department_id' => '',
            'allocation_type' => 'primary',
            'start_date' => date('Y-m-d'),
            'end_date' => '',
            'reporting_to' => '',
            'responsibilities' => '',
            'workload_hours' => 40,
            'status' => 'active'
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formData = array_map([$this, 'sanitizeInput'], $_POST);
            
            $validationError = $this->validateAllocationData($formData);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                $allocation_data = [
                    'staff_id' => $staff_id,
                    'institute_id' => $formData['institute_id'],
                    'department_id' => $formData['department_id'],
                    'allocation_type' => $formData['allocation_type'],
                    'start_date' => $formData['start_date'],
                    'end_date' => $formData['end_date'],
                    'reporting_to' => $formData['reporting_to'],
                    'responsibilities' => $formData['responsibilities'],
                    'workload_hours' => $formData['workload_hours'],
                    'status' => $formData['status']
                ];

                if ($this->staffModel->addAllocation($allocation_data)) {
                    $success = 'Staff allocated successfully!';
                    $formData = [
                        'institute_id' => '',
                        'department_id' => '',
                        'allocation_type' => 'primary',
                        'start_date' => date('Y-m-d'),
                        'end_date' => '',
                        'reporting_to' => '',
                        'responsibilities' => '',
                        'workload_hours' => 40,
                        'status' => 'active'
                    ];
                } else {
                    $error = 'Failed to allocate staff. Please try again.';
                }
            }
        }

        // Get existing allocations
        $allocations = $this->staffModel->getAllocations();
        
        // Get institutes and departments for dropdowns
        $instituteModel = new Institute($this->db);
        $institutes = $instituteModel->readAll();
        
        // Get staff for reporting to dropdown
        $staff_list = $this->staffModel->readAll();

        $page_title = "Staff Allocation";
        include BASE_PATH . '/view/layout/header.php';
        include BASE_PATH . '/view/staff/allocation.php';
        include BASE_PATH . '/view/layout/footer.php';
    }

    // Update allocation status
    public function updateAllocationStatus() {
        AuthController::requireLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $allocation_id = isset($_POST['allocation_id']) ? $_POST['allocation_id'] : null;
            $status = isset($_POST['status']) ? $_POST['status'] : null;
            
            if (!$allocation_id || !$status) {
                echo json_encode(['success' => false, 'message' => 'Invalid request']);
                exit();
            }

            $query = "UPDATE staff_allocations SET status = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            
            if ($stmt) {
                $stmt->bind_param("si", $status, $allocation_id);
                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Status updated']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Update failed']);
                }
                $stmt->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Database error']);
            }
        }
    }

    // API: Get staff statistics
    public function getStatistics() {
        AuthController::requireLogin();

        $stats = $this->staffModel->getStatistics();
        header('Content-Type: application/json');
        echo json_encode($stats);
    }

    // API: Get departments by institute
    public function getDepartmentsByInstitute($institute_id) {
        AuthController::requireLogin();

        $query = "SELECT id, name, code FROM departments 
                  WHERE institute_id = ? AND status = 'active'
                  ORDER BY name";
        
        $stmt = $this->db->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param("i", $institute_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $departments = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            
            header('Content-Type: application/json');
            echo json_encode($departments);
        }
    }

    private function validateStaffData($data, $id = null) {
        if (empty($data['first_name']) || empty($data['last_name']) || 
            empty($data['gender']) || empty($data['category_id']) || 
            empty($data['designation_id'])) {
            return 'Required fields are missing.';
        }

        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return 'Please enter a valid email address.';
        }

        if (!empty($data['date_of_birth'])) {
            $dob = new DateTime($data['date_of_birth']);
            $today = new DateTime();
            if ($dob > $today) {
                return 'Date of birth cannot be in the future.';
            }
        }

        if (!empty($data['joining_date'])) {
            $join_date = new DateTime($data['joining_date']);
            $today = new DateTime();
            if ($join_date > $today) {
                return 'Joining date cannot be in the future.';
            }
        }

        if (!empty($data['phone']) && !preg_match('/^[0-9]{10}$/', $data['phone'])) {
            return 'Please enter a valid 10-digit phone number.';
        }

        return null;
    }

    private function validateAllocationData($data) {
        if (empty($data['institute_id']) || empty($data['start_date'])) {
            return 'Institute and start date are required.';
        }

        if (!empty($data['end_date']) && $data['end_date'] < $data['start_date']) {
            return 'End date cannot be before start date.';
        }

        return null;
    }

    private function sanitizeInput($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    private function getEmptyFormData() {
        return [
            'first_name' => '',
            'middle_name' => '',
            'last_name' => '',
            'gender' => 'male',
            'date_of_birth' => '',
            'email' => '',
            'phone' => '',
            'alternate_phone' => '',
            'address' => '',
            'city' => '',
            'state' => '',
            'pincode' => '',
            'emergency_contact_name' => '',
            'emergency_contact_phone' => '',
            'category_id' => '',
            'designation_id' => '',
            'qualification' => '',
            'experience_years' => '0',
            'joining_date' => date('Y-m-d'),
            'salary' => '',
            'bank_name' => '',
            'bank_account_number' => '',
            'ifsc_code' => '',
            'pan_number' => '',
            'aadhaar_number' => '',
            'status' => 'active',
            'notes' => ''
        ];
    }

    private function setStaffProperties($data) {
        $this->staffModel->first_name = $data['first_name'];
        $this->staffModel->middle_name = $data['middle_name'];
        $this->staffModel->last_name = $data['last_name'];
        $this->staffModel->gender = $data['gender'];
        $this->staffModel->date_of_birth = $data['date_of_birth'];
        $this->staffModel->email = $data['email'];
        $this->staffModel->phone = $data['phone'];
        $this->staffModel->alternate_phone = $data['alternate_phone'];
        $this->staffModel->address = $data['address'];
        $this->staffModel->city = $data['city'];
        $this->staffModel->state = $data['state'];
        $this->staffModel->pincode = $data['pincode'];
        $this->staffModel->emergency_contact_name = $data['emergency_contact_name'];
        $this->staffModel->emergency_contact_phone = $data['emergency_contact_phone'];
        $this->staffModel->category_id = $data['category_id'];
        $this->staffModel->designation_id = $data['designation_id'];
        $this->staffModel->qualification = $data['qualification'];
        $this->staffModel->experience_years = $data['experience_years'];
        $this->staffModel->joining_date = $data['joining_date'];
        $this->staffModel->salary = $data['salary'];
        $this->staffModel->bank_name = $data['bank_name'];
        $this->staffModel->bank_account_number = $data['bank_account_number'];
        $this->staffModel->ifsc_code = $data['ifsc_code'];
        $this->staffModel->pan_number = $data['pan_number'];
        $this->staffModel->aadhaar_number = $data['aadhaar_number'];
        $this->staffModel->status = $data['status'];
        $this->staffModel->notes = $data['notes'];
    }
}