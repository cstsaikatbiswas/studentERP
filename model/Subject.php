<?php
class Subject {
    private $conn;
    private $table_name = "subjects";

    public $id;
    public $name;
    public $code;
    public $description;
    public $credit_hours;
    public $theory_hours;
    public $practical_hours;
    public $subject_type;
    public $difficulty_level;
    public $department_id;
    public $prerequisites;
    public $learning_outcomes;
    public $status;
    public $created_by;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create new subject
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET name=?, code=?, description=?, credit_hours=?, 
                      theory_hours=?, practical_hours=?, subject_type=?, 
                      difficulty_level=?, department_id=?, prerequisites=?, 
                      learning_outcomes=?, status=?, created_by=?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        // Sanitize input
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->code = htmlspecialchars(strip_tags($this->code));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->credit_hours = (float)$this->credit_hours;
        $this->theory_hours = (int)$this->theory_hours;
        $this->practical_hours = (int)$this->practical_hours;
        $this->subject_type = htmlspecialchars(strip_tags($this->subject_type));
        $this->difficulty_level = htmlspecialchars(strip_tags($this->difficulty_level));
        $this->department_id = $this->department_id ? (int)$this->department_id : null;
        $this->prerequisites = htmlspecialchars(strip_tags($this->prerequisites));
        $this->learning_outcomes = htmlspecialchars(strip_tags($this->learning_outcomes));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->created_by = (int)$this->created_by;

        // Bind parameters
        $stmt->bind_param("sssdiissssssi",
            $this->name, $this->code, $this->description, $this->credit_hours,
            $this->theory_hours, $this->practical_hours, $this->subject_type,
            $this->difficulty_level, $this->department_id, $this->prerequisites,
            $this->learning_outcomes, $this->status, $this->created_by
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

    // Check if subject code already exists
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

    // Get all subjects with department info
    public function readAll($filters = []) {
        $query = "SELECT s.*, d.name as department_name, d.code as department_code,
                         i.name as institute_name, COUNT(ps.program_id) as program_count
                  FROM " . $this->table_name . " s
                  LEFT JOIN departments d ON s.department_id = d.id
                  LEFT JOIN institutes i ON d.institute_id = i.id
                  LEFT JOIN program_subjects ps ON s.id = ps.subject_id AND ps.status = 'active'";

        $whereConditions = [];
        $params = [];
        $types = "";

        // Apply filters
        if (!empty($filters['department_id'])) {
            $whereConditions[] = "s.department_id = ?";
            $params[] = $filters['department_id'];
            $types .= "i";
        }

        if (!empty($filters['subject_type'])) {
            $whereConditions[] = "s.subject_type = ?";
            $params[] = $filters['subject_type'];
            $types .= "s";
        }

        if (!empty($filters['difficulty_level'])) {
            $whereConditions[] = "s.difficulty_level = ?";
            $params[] = $filters['difficulty_level'];
            $types .= "s";
        }

        if (!empty($filters['status'])) {
            $whereConditions[] = "s.status = ?";
            $params[] = $filters['status'];
            $types .= "s";
        }

        if (!empty($whereConditions)) {
            $query .= " WHERE " . implode(" AND ", $whereConditions);
        }

        $query .= " GROUP BY s.id ORDER BY s.name ASC";

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
        $subjects = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $subjects;
    }

    // Get subject by ID
    public function readOne() {
        $query = "SELECT s.*, d.name as department_name, d.code as department_code,
                         i.name as institute_name, u.name as created_by_name
                  FROM " . $this->table_name . " s
                  LEFT JOIN departments d ON s.department_id = d.id
                  LEFT JOIN institutes i ON d.institute_id = i.id
                  LEFT JOIN users u ON s.created_by = u.id
                  WHERE s.id = ? LIMIT 1";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $subject = $result->fetch_assoc();
        $stmt->close();

        return $subject;
    }

    // Update subject
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET name=?, code=?, description=?, credit_hours=?, 
                      theory_hours=?, practical_hours=?, subject_type=?, 
                      difficulty_level=?, department_id=?, prerequisites=?, 
                      learning_outcomes=?, status=?, updated_at=NOW()
                  WHERE id=?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        // Sanitize input
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->code = htmlspecialchars(strip_tags($this->code));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->credit_hours = (float)$this->credit_hours;
        $this->theory_hours = (int)$this->theory_hours;
        $this->practical_hours = (int)$this->practical_hours;
        $this->subject_type = htmlspecialchars(strip_tags($this->subject_type));
        $this->difficulty_level = htmlspecialchars(strip_tags($this->difficulty_level));
        $this->department_id = $this->department_id ? (int)$this->department_id : null;
        $this->prerequisites = htmlspecialchars(strip_tags($this->prerequisites));
        $this->learning_outcomes = htmlspecialchars(strip_tags($this->learning_outcomes));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind parameters
        $stmt->bind_param("sssdiissssssi",
            $this->name, $this->code, $this->description, $this->credit_hours,
            $this->theory_hours, $this->practical_hours, $this->subject_type,
            $this->difficulty_level, $this->department_id, $this->prerequisites,
            $this->learning_outcomes, $this->status, $this->id
        );

        // Execute query
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }

    // Delete subject
    public function delete() {
        // Check if subject is used in any program
        $check_query = "SELECT COUNT(*) as program_count FROM program_subjects WHERE subject_id = ?";
        $check_stmt = $this->conn->prepare($check_query);
        
        if (!$check_stmt) {
            return false;
        }

        $check_stmt->bind_param("i", $this->id);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        $data = $result->fetch_assoc();
        $check_stmt->close();

        if ($data['program_count'] > 0) {
            return false; // Cannot delete subject used in programs
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

    // Get subject statistics
    public function getStatistics() {
        $query = "SELECT 
                    COUNT(*) as total_subjects,
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_subjects,
                    SUM(CASE WHEN subject_type = 'core' THEN 1 ELSE 0 END) as core_subjects,
                    SUM(CASE WHEN subject_type = 'elective' THEN 1 ELSE 0 END) as elective_subjects,
                    SUM(CASE WHEN subject_type = 'lab' THEN 1 ELSE 0 END) as lab_subjects,
                    COUNT(DISTINCT department_id) as departments_with_subjects,
                    AVG(credit_hours) as avg_credit_hours
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

    // Get subjects by department
    public function readByDepartment($department_id) {
        $query = "SELECT s.*, COUNT(ps.program_id) as program_count
                  FROM " . $this->table_name . " s
                  LEFT JOIN program_subjects ps ON s.id = ps.subject_id AND ps.status = 'active'
                  WHERE s.department_id = ? AND s.status = 'active'
                  GROUP BY s.id
                  ORDER BY s.name ASC";
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $department_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $subjects = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $subjects;
    }

    // Search subjects
    public function search($search_term, $filters = []) {
        $query = "SELECT s.*, d.name as department_name, i.name as institute_name
                  FROM " . $this->table_name . " s
                  LEFT JOIN departments d ON s.department_id = d.id
                  LEFT JOIN institutes i ON d.institute_id = i.id
                  WHERE (s.name LIKE ? OR s.code LIKE ? OR s.description LIKE ?)";

        $params = ["%$search_term%", "%$search_term%", "%$search_term%"];
        $types = "sss";

        // Apply filters
        if (!empty($filters['department_id'])) {
            $query .= " AND s.department_id = ?";
            $params[] = $filters['department_id'];
            $types .= "i";
        }

        if (!empty($filters['subject_type'])) {
            $query .= " AND s.subject_type = ?";
            $params[] = $filters['subject_type'];
            $types .= "s";
        }

        if (!empty($filters['status'])) {
            $query .= " AND s.status = ?";
            $params[] = $filters['status'];
            $types .= "s";
        }

        $query .= " ORDER BY s.name ASC";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $subjects = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $subjects;
    }

    // Get subject usage across programs
    public function getProgramUsage() {
        $query = "SELECT p.name as program_name, p.code as program_code,
                         d.name as department_name, ps.semester, ps.course_type
                  FROM program_subjects ps
                  LEFT JOIN academic_programs p ON ps.program_id = p.id
                  LEFT JOIN departments d ON p.department_id = d.id
                  WHERE ps.subject_id = ? AND ps.status = 'active'
                  ORDER BY p.name ASC, ps.semester ASC";
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $usage = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $usage;
    }
}