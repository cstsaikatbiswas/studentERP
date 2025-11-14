<?php
class Batch {
    private $conn;
    private $table_name = "academic_batches";

    public $id;
    public $program_id;
    public $batch_year;
    public $batch_code;
    public $batch_name;
    public $start_date;
    public $end_date;
    public $current_semester;
    public $total_students;
    public $max_capacity;
    public $class_teacher_id;
    public $fee_structure;
    public $admission_criteria;
    public $status;
    public $created_by;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create new batch
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET program_id=?, batch_year=?, batch_code=?, batch_name=?, 
                      start_date=?, end_date=?, current_semester=?, 
                      total_students=?, max_capacity=?, class_teacher_id=?, 
                      fee_structure=?, admission_criteria=?, status=?, created_by=?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        // Sanitize input
        $this->program_id = (int)$this->program_id;
        $this->batch_year = (int)$this->batch_year;
        $this->batch_code = htmlspecialchars(strip_tags($this->batch_code));
        $this->batch_name = htmlspecialchars(strip_tags($this->batch_name));
        $this->start_date = htmlspecialchars(strip_tags($this->start_date));
        $this->end_date = htmlspecialchars(strip_tags($this->end_date));
        $this->current_semester = (int)$this->current_semester;
        $this->total_students = (int)$this->total_students;
        $this->max_capacity = (int)$this->max_capacity;
        $this->class_teacher_id = $this->class_teacher_id ? (int)$this->class_teacher_id : null;
        $this->fee_structure = $this->fee_structure ? $this->conn->real_escape_string(json_encode($this->fee_structure)) : null;
        $this->admission_criteria = htmlspecialchars(strip_tags($this->admission_criteria));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->created_by = (int)$this->created_by;

        // Bind parameters
        $stmt->bind_param("iissssiiiisssi",
            $this->program_id, $this->batch_year, $this->batch_code, $this->batch_name,
            $this->start_date, $this->end_date, $this->current_semester,
            $this->total_students, $this->max_capacity, $this->class_teacher_id,
            $this->fee_structure, $this->admission_criteria, $this->status, $this->created_by
        );

        // Execute query
        if ($stmt->execute()) {
            $this->id = $stmt->insert_id;
            $stmt->close();
            
            // Update program student count
            $this->updateProgramStudentCount();
            
            return true;
        }

        $stmt->close();
        return false;
    }

    // Check if batch code already exists for program
    public function codeExists() {
        $query = "SELECT id FROM " . $this->table_name . " 
                  WHERE program_id = ? AND batch_code = ? LIMIT 1";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $this->batch_code = htmlspecialchars(strip_tags($this->batch_code));
        $stmt->bind_param("is", $this->program_id, $this->batch_code);

        $stmt->execute();
        $stmt->store_result();

        $exists = $stmt->num_rows > 0;
        $stmt->close();

        return $exists;
    }

    // Get all batches with program info
    public function readAll($filters = []) {
        $query = "SELECT b.*, p.name as program_name, p.code as program_code,
                         d.name as department_name, i.name as institute_name,
                         u.name as class_teacher_name, COUNT(sb.student_id) as student_count
                  FROM " . $this->table_name . " b
                  LEFT JOIN academic_programs p ON b.program_id = p.id
                  LEFT JOIN departments d ON p.department_id = d.id
                  LEFT JOIN institutes i ON d.institute_id = i.id
                  LEFT JOIN users u ON b.class_teacher_id = u.id
                  LEFT JOIN student_batches sb ON b.id = sb.batch_id AND sb.status = 'active'";

        $whereConditions = [];
        $params = [];
        $types = "";

        // Apply filters
        if (!empty($filters['program_id'])) {
            $whereConditions[] = "b.program_id = ?";
            $params[] = $filters['program_id'];
            $types .= "i";
        }

        if (!empty($filters['status'])) {
            $whereConditions[] = "b.status = ?";
            $params[] = $filters['status'];
            $types .= "s";
        }

        if (!empty($filters['batch_year'])) {
            $whereConditions[] = "b.batch_year = ?";
            $params[] = $filters['batch_year'];
            $types .= "i";
        }

        if (!empty($whereConditions)) {
            $query .= " WHERE " . implode(" AND ", $whereConditions);
        }

        $query .= " GROUP BY b.id ORDER BY b.batch_year DESC, b.created_at DESC";

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
        $batches = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $batches;
    }

    // Get batch by ID
    public function readOne() {
        $query = "SELECT b.*, p.name as program_name, p.code as program_code,
                         p.department_id, d.name as department_name, 
                         i.name as institute_name, u.name as class_teacher_name,
                         uc.name as created_by_name
                  FROM " . $this->table_name . " b
                  LEFT JOIN academic_programs p ON b.program_id = p.id
                  LEFT JOIN departments d ON p.department_id = d.id
                  LEFT JOIN institutes i ON d.institute_id = i.id
                  LEFT JOIN users u ON b.class_teacher_id = u.id
                  LEFT JOIN users uc ON b.created_by = uc.id
                  WHERE b.id = ? LIMIT 1";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $batch = $result->fetch_assoc();
        $stmt->close();

        return $batch;
    }

    // Update batch
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET batch_year=?, batch_code=?, batch_name=?, 
                      start_date=?, end_date=?, current_semester=?, 
                      total_students=?, max_capacity=?, class_teacher_id=?, 
                      fee_structure=?, admission_criteria=?, status=?, updated_at=NOW()
                  WHERE id=?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        // Sanitize input
        $this->batch_year = (int)$this->batch_year;
        $this->batch_code = htmlspecialchars(strip_tags($this->batch_code));
        $this->batch_name = htmlspecialchars(strip_tags($this->batch_name));
        $this->start_date = htmlspecialchars(strip_tags($this->start_date));
        $this->end_date = htmlspecialchars(strip_tags($this->end_date));
        $this->current_semester = (int)$this->current_semester;
        $this->total_students = (int)$this->total_students;
        $this->max_capacity = (int)$this->max_capacity;
        $this->class_teacher_id = $this->class_teacher_id ? (int)$this->class_teacher_id : null;
        $this->fee_structure = $this->fee_structure ? $this->conn->real_escape_string(json_encode($this->fee_structure)) : null;
        $this->admission_criteria = htmlspecialchars(strip_tags($this->admission_criteria));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind parameters
        $stmt->bind_param("issssiiiissi",
            $this->batch_year, $this->batch_code, $this->batch_name,
            $this->start_date, $this->end_date, $this->current_semester,
            $this->total_students, $this->max_capacity, $this->class_teacher_id,
            $this->fee_structure, $this->admission_criteria, $this->status, $this->id
        );

        // Execute query
        if ($stmt->execute()) {
            $stmt->close();
            
            // Update program student count
            $this->updateProgramStudentCount();
            
            return true;
        }

        $stmt->close();
        return false;
    }

    // Delete batch
    public function delete() {
        // Check if batch has any students
        $check_query = "SELECT COUNT(*) as student_count FROM student_batches WHERE batch_id = ?";
        $check_stmt = $this->conn->prepare($check_query);
        
        if (!$check_stmt) {
            return false;
        }

        $check_stmt->bind_param("i", $this->id);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        $data = $result->fetch_assoc();
        $check_stmt->close();

        if ($data['student_count'] > 0) {
            return false; // Cannot delete batch with students
        }

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $this->id);
        
        if ($stmt->execute()) {
            $stmt->close();
            
            // Update program student count
            $this->updateProgramStudentCount();
            
            return true;
        }

        $stmt->close();
        return false;
    }

    // Get batch statistics
    public function getStatistics() {
        $query = "SELECT 
                    COUNT(*) as total_batches,
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_batches,
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_batches,
                    SUM(CASE WHEN status = 'upcoming' THEN 1 ELSE 0 END) as upcoming_batches,
                    SUM(total_students) as total_students,
                    COUNT(DISTINCT program_id) as programs_with_batches,
                    MAX(batch_year) as latest_batch_year,
                    MIN(batch_year) as earliest_batch_year
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

    // Get batches by program
    public function readByProgram($program_id) {
        $query = "SELECT b.*, COUNT(sb.student_id) as student_count
                  FROM " . $this->table_name . " b
                  LEFT JOIN student_batches sb ON b.id = sb.batch_id AND sb.status = 'active'
                  WHERE b.program_id = ?
                  GROUP BY b.id
                  ORDER BY b.batch_year DESC, b.batch_code ASC";
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $program_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $batches = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $batches;
    }

    // Update student count for batch
    public function updateStudentCount() {
        $query = "UPDATE " . $this->table_name . " 
                  SET total_students = (
                      SELECT COUNT(*) 
                      FROM student_batches 
                      WHERE batch_id = ? AND status = 'active'
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

    // Update program student count
    private function updateProgramStudentCount() {
        $batch = $this->readOne();
        if ($batch) {
            $program = new Program($this->conn);
            $program->id = $batch['program_id'];
            $program->updateStudentCount();
        }
    }

    // Get batch progress (semester-wise)
    public function getBatchProgress() {
        $query = "SELECT 
                    current_semester,
                    COUNT(*) as batch_count
                  FROM " . $this->table_name . " 
                  WHERE status = 'active'
                  GROUP BY current_semester
                  ORDER BY current_semester ASC";
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $progress = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $progress;
    }

    // Search batches
    public function search($search_term, $filters = []) {
        $query = "SELECT b.*, p.name as program_name, d.name as department_name
                  FROM " . $this->table_name . " b
                  LEFT JOIN academic_programs p ON b.program_id = p.id
                  LEFT JOIN departments d ON p.department_id = d.id
                  WHERE (b.batch_code LIKE ? OR b.batch_name LIKE ? OR p.name LIKE ?)";

        $params = ["%$search_term%", "%$search_term%", "%$search_term%"];
        $types = "sss";

        // Apply filters
        if (!empty($filters['program_id'])) {
            $query .= " AND b.program_id = ?";
            $params[] = $filters['program_id'];
            $types .= "i";
        }

        if (!empty($filters['status'])) {
            $query .= " AND b.status = ?";
            $params[] = $filters['status'];
            $types .= "s";
        }

        $query .= " ORDER BY b.batch_year DESC, b.batch_code ASC";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $batches = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $batches;
    }
}