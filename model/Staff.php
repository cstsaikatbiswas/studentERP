<?php
class Staff {
    private $conn;
    private $table_name = "staff";

    public $id;
    public $staff_id;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $gender;
    public $date_of_birth;
    public $email;
    public $phone;
    public $alternate_phone;
    public $address;
    public $city;
    public $state;
    public $pincode;
    public $emergency_contact_name;
    public $emergency_contact_phone;
    public $category_id;
    public $designation_id;
    public $qualification;
    public $experience_years;
    public $joining_date;
    public $salary;
    public $bank_name;
    public $bank_account_number;
    public $ifsc_code;
    public $pan_number;
    public $aadhaar_number;
    public $profile_image;
    public $status;
    public $notes;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Generate unique staff ID
    private function generateStaffId($category_code, $designation_code) {
        $year = date('Y');
        $month = date('m');
        $prefix = substr($category_code, 0, 1) . substr($designation_code, 0, 3);
        
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " 
                  WHERE YEAR(created_at) = ? AND staff_id LIKE ?";
        
        $stmt = $this->conn->prepare($query);
        $like_pattern = $prefix . $year . $month . '%';
        $stmt->bind_param("is", $year, $like_pattern);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'] + 1;
        $stmt->close();

        return $prefix . $year . $month . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    // Create new staff
    public function create() {
        // Get category and designation codes for staff ID generation
        $category_code = $this->getCategoryCode($this->category_id);
        $designation_code = $this->getDesignationCode($this->designation_id);
        
        if (!$category_code || !$designation_code) {
            return false;
        }

        // Generate staff ID
        $this->staff_id = $this->generateStaffId($category_code, $designation_code);

        $query = "INSERT INTO " . $this->table_name . " 
                  SET staff_id=?, first_name=?, middle_name=?, last_name=?, gender=?, 
                      date_of_birth=?, email=?, phone=?, alternate_phone=?, address=?, 
                      city=?, state=?, pincode=?, emergency_contact_name=?, 
                      emergency_contact_phone=?, category_id=?, designation_id=?, 
                      qualification=?, experience_years=?, joining_date=?, salary=?, 
                      bank_name=?, bank_account_number=?, ifsc_code=?, pan_number=?, 
                      aadhaar_number=?, profile_image=?, status=?, notes=?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        // Sanitize input
        $this->sanitizeProperties();

        // Bind parameters
        $stmt->bind_param("sssssssssssssssiisissssssssss",
            $this->staff_id, $this->first_name, $this->middle_name, $this->last_name,
            $this->gender, $this->date_of_birth, $this->email, $this->phone,
            $this->alternate_phone, $this->address, $this->city, $this->state,
            $this->pincode, $this->emergency_contact_name, $this->emergency_contact_phone,
            $this->category_id, $this->designation_id, $this->qualification,
            $this->experience_years, $this->joining_date, $this->salary,
            $this->bank_name, $this->bank_account_number, $this->ifsc_code,
            $this->pan_number, $this->aadhaar_number, $this->profile_image,
            $this->status, $this->notes
        );

        // Execute query
        if ($stmt->execute()) {
            $this->id = $stmt->insert_id;
            
            // Initialize leave balance for current year
            $this->initializeLeaveBalance($this->id);
            
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }

    // Get staff by ID
    public function readOne() {
        $query = "SELECT s.*, sc.name as category_name, sc.code as category_code,
                         sd.name as designation_name, sd.code as designation_code
                  FROM " . $this->table_name . " s
                  LEFT JOIN staff_categories sc ON s.category_id = sc.id
                  LEFT JOIN staff_designations sd ON s.designation_id = sd.id
                  WHERE s.id = ? LIMIT 1";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $staff = $result->fetch_assoc();
        $stmt->close();

        return $staff;
    }

    // Get all staff with filters
    public function readAll($filters = []) {
        $where_clause = "1=1";
        $params = [];
        $types = "";
        
        if (!empty($filters['category_id'])) {
            $where_clause .= " AND s.category_id = ?";
            $params[] = $filters['category_id'];
            $types .= "i";
        }
        
        if (!empty($filters['designation_id'])) {
            $where_clause .= " AND s.designation_id = ?";
            $params[] = $filters['designation_id'];
            $types .= "i";
        }
        
        if (!empty($filters['status'])) {
            $where_clause .= " AND s.status = ?";
            $params[] = $filters['status'];
            $types .= "s";
        }
        
        if (!empty($filters['institute_id'])) {
            $where_clause .= " AND EXISTS (SELECT 1 FROM staff_allocations sa 
                                          WHERE sa.staff_id = s.id AND sa.institute_id = ? 
                                          AND sa.status = 'active')";
            $params[] = $filters['institute_id'];
            $types .= "i";
        }

        $query = "SELECT s.*, sc.name as category_name, sc.code as category_code,
                         sd.name as designation_name, sd.code as designation_code,
                         GROUP_CONCAT(DISTINCT sa.institute_id) as institute_ids
                  FROM " . $this->table_name . " s
                  LEFT JOIN staff_categories sc ON s.category_id = sc.id
                  LEFT JOIN staff_designations sd ON s.designation_id = sd.id
                  LEFT JOIN staff_allocations sa ON s.id = sa.staff_id AND sa.status = 'active'
                  WHERE $where_clause
                  GROUP BY s.id
                  ORDER BY s.first_name, s.last_name";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $staff_list = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $staff_list;
    }

    // Update staff
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET first_name=?, middle_name=?, last_name=?, gender=?, 
                      date_of_birth=?, email=?, phone=?, alternate_phone=?, address=?, 
                      city=?, state=?, pincode=?, emergency_contact_name=?, 
                      emergency_contact_phone=?, category_id=?, designation_id=?, 
                      qualification=?, experience_years=?, joining_date=?, salary=?, 
                      bank_name=?, bank_account_number=?, ifsc_code=?, pan_number=?, 
                      aadhaar_number=?, profile_image=?, status=?, notes=?
                  WHERE id=?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        // Sanitize input
        $this->sanitizeProperties();

        // Bind parameters
        $stmt->bind_param("ssssssssssssssiisissssssssssi",
            $this->first_name, $this->middle_name, $this->last_name,
            $this->gender, $this->date_of_birth, $this->email, $this->phone,
            $this->alternate_phone, $this->address, $this->city, $this->state,
            $this->pincode, $this->emergency_contact_name, $this->emergency_contact_phone,
            $this->category_id, $this->designation_id, $this->qualification,
            $this->experience_years, $this->joining_date, $this->salary,
            $this->bank_name, $this->bank_account_number, $this->ifsc_code,
            $this->pan_number, $this->aadhaar_number, $this->profile_image,
            $this->status, $this->notes, $this->id
        );

        // Execute query
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // Delete staff
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $this->id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // Get staff statistics
    public function getStatistics() {
        $query = "SELECT 
                    COUNT(*) as total_staff,
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_staff,
                    SUM(CASE WHEN category_id = 1 THEN 1 ELSE 0 END) as teaching_staff,
                    SUM(CASE WHEN category_id = 2 THEN 1 ELSE 0 END) as non_teaching_staff
                  FROM " . $this->table_name;
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $stats = $result->fetch_assoc();
        $stmt->close();

        return $stats;
    }

    // Check if email exists
    public function emailExists() {
        $query = "SELECT id FROM " . $this->table_name . " 
                  WHERE email = ? AND id != ? LIMIT 1";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bind_param("si", $this->email, $this->id);
        $stmt->execute();
        $stmt->store_result();

        $exists = $stmt->num_rows > 0;
        $stmt->close();

        return $exists;
    }

    // Get staff allocations
    public function getAllocations() {
        $query = "SELECT sa.*, i.name as institute_name, i.code as institute_code,
                         d.name as department_name, d.code as department_code,
                         r.first_name as reporting_first_name, r.last_name as reporting_last_name
                  FROM staff_allocations sa
                  LEFT JOIN institutes i ON sa.institute_id = i.id
                  LEFT JOIN departments d ON sa.department_id = d.id
                  LEFT JOIN staff r ON sa.reporting_to = r.id
                  WHERE sa.staff_id = ?
                  ORDER BY sa.start_date DESC";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $allocations = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $allocations;
    }

    // Add allocation
    public function addAllocation($allocation_data) {
        $query = "INSERT INTO staff_allocations 
                  SET staff_id=?, institute_id=?, department_id=?, allocation_type=?,
                      start_date=?, end_date=?, reporting_to=?, responsibilities=?,
                      workload_hours=?, status=?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("iiissssisi",
            $allocation_data['staff_id'],
            $allocation_data['institute_id'],
            $allocation_data['department_id'],
            $allocation_data['allocation_type'],
            $allocation_data['start_date'],
            $allocation_data['end_date'],
            $allocation_data['reporting_to'],
            $allocation_data['responsibilities'],
            $allocation_data['workload_hours'],
            $allocation_data['status']
        );

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // Get leave balance
    public function getLeaveBalance($year = null) {
        if (!$year) {
            $year = date('Y');
        }

        $query = "SELECT * FROM staff_leave_balance 
                  WHERE staff_id = ? AND leave_year = ?";
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ii", $this->id, $year);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $balance = $result->fetch_assoc();
        $stmt->close();

        if (!$balance) {
            // Initialize if not exists
            $balance = $this->initializeLeaveBalance($this->id, $year);
        }

        return $balance;
    }

    // Initialize leave balance
    private function initializeLeaveBalance($staff_id, $year = null) {
        if (!$year) {
            $year = date('Y');
        }

        $query = "INSERT INTO staff_leave_balance 
                  SET staff_id=?, leave_year=?, casual_leave=12, sick_leave=12,
                      earned_leave=15, maternity_leave=180, paternity_leave=15";
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ii", $staff_id, $year);
        $stmt->execute();
        $stmt->close();

        return [
            'staff_id' => $staff_id,
            'leave_year' => $year,
            'casual_leave' => 12,
            'sick_leave' => 12,
            'earned_leave' => 15,
            'maternity_leave' => 180,
            'paternity_leave' => 15,
            'other_leave' => 0
        ];
    }

   // Get category code - Add this method to the Staff class
    private function getCategoryCode($category_id) {
        $query = "SELECT code FROM staff_categories WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            return null;
        }
        
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row ? $row['code'] : null;
    }

    // Get designation code - Add this method to the Staff class
    private function getDesignationCode($designation_id) {
        $query = "SELECT code FROM staff_designations WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            return null;
        }
        
        $stmt->bind_param("i", $designation_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row ? $row['code'] : null;
    }
    // Sanitize properties
    private function sanitizeProperties() {
        $this->staff_id = htmlspecialchars(strip_tags($this->staff_id));
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->middle_name = htmlspecialchars(strip_tags($this->middle_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->gender = htmlspecialchars(strip_tags($this->gender));
        $this->date_of_birth = htmlspecialchars(strip_tags($this->date_of_birth));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->alternate_phone = htmlspecialchars(strip_tags($this->alternate_phone));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->state = htmlspecialchars(strip_tags($this->state));
        $this->pincode = htmlspecialchars(strip_tags($this->pincode));
        $this->emergency_contact_name = htmlspecialchars(strip_tags($this->emergency_contact_name));
        $this->emergency_contact_phone = htmlspecialchars(strip_tags($this->emergency_contact_phone));
        $this->qualification = htmlspecialchars(strip_tags($this->qualification));
        $this->joining_date = htmlspecialchars(strip_tags($this->joining_date));
        $this->bank_name = htmlspecialchars(strip_tags($this->bank_name));
        $this->bank_account_number = htmlspecialchars(strip_tags($this->bank_account_number));
        $this->ifsc_code = htmlspecialchars(strip_tags($this->ifsc_code));
        $this->pan_number = htmlspecialchars(strip_tags($this->pan_number));
        $this->aadhaar_number = htmlspecialchars(strip_tags($this->aadhaar_number));
        $this->notes = htmlspecialchars(strip_tags($this->notes));
    }
}