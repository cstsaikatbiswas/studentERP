<?php
class Program {
    private $conn;
    private $table_name = "academic_programs";

    public $id;
    public $name;
    public $code;
    public $description;
    public $duration_years;
    public $total_credits;
    public $department_id;
    public $degree_type;
    public $program_level;
    public $accreditation_status;
    public $start_date;
    public $end_date;
    public $total_semesters;
    public $max_students;
    public $current_students;
    public $program_fee;
    public $status;
    public $created_by;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create new program
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET name=?, code=?, description=?, duration_years=?, 
                      total_credits=?, department_id=?, degree_type=?, 
                      program_level=?, accreditation_status=?, start_date=?, 
                      end_date=?, total_semesters=?, max_students=?, 
                      current_students=?, program_fee=?, status=?, created_by=?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        // Sanitize input
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->code = htmlspecialchars(strip_tags($this->code));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->duration_years = (int)$this->duration_years;
        $this->total_credits = (int)$this->total_credits;
        $this->department_id = (int)$this->department_id;
        $this->degree_type = htmlspecialchars(strip_tags($this->degree_type));
        $this->program_level = htmlspecialchars(strip_tags($this->program_level));
        $this->accreditation_status = htmlspecialchars(strip_tags($this->accreditation_status));
        $this->start_date = htmlspecialchars(strip_tags($this->start_date));
        $this->end_date = htmlspecialchars(strip_tags($this->end_date));
        $this->total_semesters = (int)$this->total_semesters;
        $this->max_students = (int)$this->max_students;
        $this->current_students = (int)$this->current_students;
        $this->program_fee = (float)$this->program_fee;
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->created_by = (int)$this->created_by;

        // Bind parameters
        $stmt->bind_param("sssiiisssssiiiids",
            $this->name, $this->code, $this->description, $this->duration_years,
            $this->total_credits, $this->department_id, $this->degree_type,
            $this->program_level, $this->accreditation_status, $this->start_date,
            $this->end_date, $this->total_semesters, $this->max_students,
            $this->current_students, $this->program_fee, $this->status, $this->created_by
        );

        // Execute query
        if ($stmt->execute()) {
            $this->id = $stmt->insert_id;
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }

    // Check if program code already exists
    public function codeExists() {
        $query = "SELECT id FROM " . $this->table_name . " 
                  WHERE code = ? LIMIT 1";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $this->code = htmlspecialchars(strip_tags($this->code));
        $stmt->bind_param("s", $this->code);

        $stmt->execute();
        $stmt->store_result();

        $exists = $stmt->num_rows > 0;
        $stmt->close();

        return $exists;
    }

    // Get all programs with department info
    public function readAll($filters = []) {
        $query = "SELECT p.*, d.name as department_name, d.code as department_code,
                         i.name as institute_name, COUNT(b.id) as batch_count
                  FROM " . $this->table_name . " p
                  LEFT JOIN departments d ON p.department_id = d.id
                  LEFT JOIN institutes i ON d.institute_id = i.id
                  LEFT JOIN academic_batches b ON p.id = b.program_id";

        $whereConditions = [];
        $params = [];
        $types = "";

        // Apply filters
        if (!empty($filters['department_id'])) {
            $whereConditions[] = "p.department_id = ?";
            $params[] = $filters['department_id'];
            $types .= "i";
        }

        if (!empty($filters['status'])) {
            $whereConditions[] = "p.status = ?";
            $params[] = $filters['status'];
            $types .= "s";
        }

        if (!empty($filters['degree_type'])) {
            $whereConditions[] = "p.degree_type = ?";
            $params[] = $filters['degree_type'];
            $types .= "s";
        }

        if (!empty($whereConditions)) {
            $query .= " WHERE " . implode(" AND ", $whereConditions);
        }

        $query .= " GROUP BY p.id ORDER BY p.created_at DESC";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        // Bind parameters if any
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $programs = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $programs;
    }

    // Get program by ID
    public function readOne() {
        $query = "SELECT p.*, d.name as department_name, d.code as department_code,
                         i.name as institute_name, i.id as institute_id,
                         u.name as created_by_name
                  FROM " . $this->table_name . " p
                  LEFT JOIN departments d ON p.department_id = d.id
                  LEFT JOIN institutes i ON d.institute_id = i.id
                  LEFT JOIN users u ON p.created_by = u.id
                  WHERE p.id = ? LIMIT 1";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $program = $result->fetch_assoc();
        $stmt->close();

        return $program;
    }

    // Update program
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET name=?, code=?, description=?, duration_years=?, 
                      total_credits=?, department_id=?, degree_type=?, 
                      program_level=?, accreditation_status=?, start_date=?, 
                      end_date=?, total_semesters=?, max_students=?, 
                      current_students=?, program_fee=?, status=?, updated_at=NOW()
                  WHERE id=?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        // Sanitize input
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->code = htmlspecialchars(strip_tags($this->code));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->duration_years = (int)$this->duration_years;
        $this->total_credits = (int)$this->total_credits;
        $this->department_id = (int)$this->department_id;
        $this->degree_type = htmlspecialchars(strip_tags($this->degree_type));
        $this->program_level = htmlspecialchars(strip_tags($this->program_level));
        $this->accreditation_status = htmlspecialchars(strip_tags($this->accreditation_status));
        $this->start_date = htmlspecialchars(strip_tags($this->start_date));
        $this->end_date = htmlspecialchars(strip_tags($this->end_date));
        $this->total_semesters = (int)$this->total_semesters;
        $this->max_students = (int)$this->max_students;
        $this->current_students = (int)$this->current_students;
        $this->program_fee = (float)$this->program_fee;
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind parameters
        $stmt->bind_param("sssiiisssssiiiidisi",
            $this->name, $this->code, $this->description, $this->duration_years,
            $this->total_credits, $this->department_id, $this->degree_type,
            $this->program_level, $this->accreditation_status, $this->start_date,
            $this->end_date, $this->total_semesters, $this->max_students,
            $this->current_students, $this->program_fee, $this->status, $this->id
        );

        // Execute query
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }

    // Delete program
    public function delete() {
        // Check if program has any batches
        $check_query = "SELECT COUNT(*) as batch_count FROM academic_batches WHERE program_id = ?";
        $check_stmt = $this->conn->prepare($check_query);
        
        if (!$check_stmt) {
            return false;
        }

        $check_stmt->bind_param("i", $this->id);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        $data = $result->fetch_assoc();
        $check_stmt->close();

        if ($data['batch_count'] > 0) {
            return false; // Cannot delete program with batches
        }

        // Delete program subjects first
        $delete_subjects_query = "DELETE FROM program_subjects WHERE program_id = ?";
        $delete_subjects_stmt = $this->conn->prepare($delete_subjects_query);
        
        if ($delete_subjects_stmt) {
            $delete_subjects_stmt->bind_param("i", $this->id);
            $delete_subjects_stmt->execute();
            $delete_subjects_stmt->close();
        }

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $this->id);
        
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }

    // Get program statistics
    public function getStatistics() {
        $query = "SELECT 
                    COUNT(*) as total_programs,
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_programs,
                    SUM(CASE WHEN accreditation_status = 'accredited' THEN 1 ELSE 0 END) as accredited_programs,
                    SUM(current_students) as total_students,
                    COUNT(DISTINCT degree_type) as degree_types,
                    COUNT(DISTINCT department_id) as departments_with_programs
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

    // Get programs by department
    public function readByDepartment($department_id) {
        $query = "SELECT p.*, COUNT(b.id) as batch_count
                  FROM " . $this->table_name . " p
                  LEFT JOIN academic_batches b ON p.id = b.program_id
                  WHERE p.department_id = ? AND p.status = 'active'
                  GROUP BY p.id
                  ORDER BY p.name ASC";
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $department_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $programs = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $programs;
    }

    // Update student count
    public function updateStudentCount() {
        $query = "UPDATE " . $this->table_name . " 
                  SET current_students = (
                      SELECT COUNT(DISTINCT student_id) 
                      FROM student_batches 
                      WHERE batch_id IN (
                          SELECT id FROM academic_batches WHERE program_id = ?
                      ) AND status = 'active'
                  )
                  WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ii", $this->id, $this->id);
        
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }

    // Search programs
    public function search($search_term, $filters = []) {
        $query = "SELECT p.*, d.name as department_name, i.name as institute_name
                  FROM " . $this->table_name . " p
                  LEFT JOIN departments d ON p.department_id = d.id
                  LEFT JOIN institutes i ON d.institute_id = i.id
                  WHERE (p.name LIKE ? OR p.code LIKE ? OR p.description LIKE ?)";

        $params = ["%$search_term%", "%$search_term%", "%$search_term%"];
        $types = "sss";

        // Apply filters
        if (!empty($filters['department_id'])) {
            $query .= " AND p.department_id = ?";
            $params[] = $filters['department_id'];
            $types .= "i";
        }

        if (!empty($filters['status'])) {
            $query .= " AND p.status = ?";
            $params[] = $filters['status'];
            $types .= "s";
        }

        if (!empty($filters['degree_type'])) {
            $query .= " AND p.degree_type = ?";
            $params[] = $filters['degree_type'];
            $types .= "s";
        }

        $query .= " ORDER BY p.name ASC";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $programs = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $programs;
    }
}