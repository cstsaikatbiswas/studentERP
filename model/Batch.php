<?php
class Batch
{
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

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create new batch
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET program_id=?, batch_year=?, batch_code=?, batch_name=?, 
                      start_date=?, end_date=?, current_semester=?, max_capacity=?, 
                      class_teacher_id=?, fee_structure=?, admission_criteria=?, 
                      status=?, created_by=?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            return false;
        }

        // Sanitize input
        $this->program_id = htmlspecialchars(strip_tags($this->program_id));
        $this->batch_year = htmlspecialchars(strip_tags($this->batch_year));
        $this->batch_code = htmlspecialchars(strip_tags($this->batch_code));
        $this->batch_name = htmlspecialchars(strip_tags($this->batch_name));
        $this->start_date = htmlspecialchars(strip_tags($this->start_date));
        $this->end_date = htmlspecialchars(strip_tags($this->end_date));
        $this->current_semester = htmlspecialchars(strip_tags($this->current_semester));
        $this->max_capacity = htmlspecialchars(strip_tags($this->max_capacity));
        $this->class_teacher_id = htmlspecialchars(strip_tags($this->class_teacher_id));
        $this->fee_structure = htmlspecialchars(strip_tags($this->fee_structure));
        $this->admission_criteria = htmlspecialchars(strip_tags($this->admission_criteria));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->created_by = htmlspecialchars(strip_tags($this->created_by));

        // Bind parameters
        $stmt->bind_param(
            "iissssiisssssi",
            $this->program_id,
            $this->batch_year,
            $this->batch_code,
            $this->batch_name,
            $this->start_date,
            $this->end_date,
            $this->current_semester,
            $this->max_capacity,
            $this->class_teacher_id,
            $this->fee_structure,
            $this->admission_criteria,
            $this->status,
            $this->created_by
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

    // Get total students in batch
    public function getTotalStudents()
    {
        $query = "SELECT COUNT(*) as total_students 
              FROM students 
              WHERE batch_id = ? AND status = 'active'";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            return 0;
        }

        $stmt->bind_param("i", $this->id);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();

        return $data['total_students'] ?? 0;
    }

    // Update batch student count
    public function updateStudentCount()
    {
        $total_students = $this->getTotalStudents();

        $query = "UPDATE " . $this->table_name . " 
              SET total_students = ?, updated_at = NOW() 
              WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ii", $total_students, $this->id);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }

    // Get batch students
    public function getBatchStudents($limit = null)
    {
        $query = "SELECT s.*, u.email as user_email 
              FROM students s 
              LEFT JOIN users u ON s.user_id = u.id 
              WHERE s.batch_id = ? AND s.status = 'active' 
              ORDER BY s.roll_number ASC";

        if ($limit) {
            $query .= " LIMIT ?";
        }

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            return false;
        }

        if ($limit) {
            $stmt->bind_param("ii", $this->id, $limit);
        } else {
            $stmt->bind_param("i", $this->id);
        }

        $stmt->execute();

        $result = $stmt->get_result();
        $students = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $students;
    }

    // Check if batch code already exists for program
    public function codeExists()
    {
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
    public function readAll($filters = [])
    {
        $where_clause = "";
        $params = [];
        $types = "";

        // Build filter conditions
        if (!empty($filters)) {
            $conditions = [];
            if (isset($filters['program_id']) && $filters['program_id']) {
                $conditions[] = "b.program_id = ?";
                $params[] = $filters['program_id'];
                $types .= "i";
            }
            if (isset($filters['batch_year']) && $filters['batch_year']) {
                $conditions[] = "b.batch_year = ?";
                $params[] = $filters['batch_year'];
                $types .= "s";
            }
            if (isset($filters['status']) && $filters['status']) {
                $conditions[] = "b.status = ?";
                $params[] = $filters['status'];
                $types .= "s";
            }
            if (isset($filters['department_id']) && $filters['department_id']) {
                $conditions[] = "p.department_id = ?";
                $params[] = $filters['department_id'];
                $types .= "i";
            }

            if (!empty($conditions)) {
                $where_clause = "WHERE " . implode(" AND ", $conditions);
            }
        }

        $query = "SELECT b.*, 
                         p.name as program_name, p.code as program_code,
                         d.name as department_name,
                         CONCAT(u.name) as class_teacher_name,
                         COUNT(s.id) as student_count
                  FROM " . $this->table_name . " b
                  LEFT JOIN academic_programs p ON b.program_id = p.id
                  LEFT JOIN departments d ON p.department_id = d.id
                  LEFT JOIN users u ON b.class_teacher_id = u.id
                  LEFT JOIN students s ON b.id = s.batch_id
                  $where_clause
                  GROUP BY b.id
                  ORDER BY b.batch_year DESC, b.created_at DESC";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            return false;
        }

        // Bind filter parameters if any
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
    public function readOne()
    {
        $query = "SELECT b.*, 
                         p.name as program_name, p.code as program_code, p.duration_years,
                         p.degree_type, p.total_semesters,
                         d.name as department_name, d.id as department_id,
                         CONCAT(u.name) as class_teacher_name,
                         u.email as class_teacher_email,
                         COUNT(s.id) as student_count
                  FROM " . $this->table_name . " b
                  LEFT JOIN academic_programs p ON b.program_id = p.id
                  LEFT JOIN departments d ON p.department_id = d.id
                  LEFT JOIN users u ON b.class_teacher_id = u.id
                  LEFT JOIN students s ON b.id = s.batch_id
                  WHERE b.id = ?
                  GROUP BY b.id
                  LIMIT 1";

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

    // Get batches by program
    public function readByProgram($program_id)
    {
        $query = "SELECT b.*, 
                         COUNT(s.id) as student_count
                  FROM " . $this->table_name . " b
                  LEFT JOIN students s ON b.id = s.batch_id
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

    // Update batch
    public function update()
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET batch_year=?, batch_code=?, batch_name=?, 
                      start_date=?, end_date=?, current_semester=?, 
                      max_capacity=?, class_teacher_id=?, fee_structure=?, 
                      admission_criteria=?, status=?, updated_at=NOW()
                  WHERE id=?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            return false;
        }

        // Sanitize input
        $this->batch_year = htmlspecialchars(strip_tags($this->batch_year));
        $this->batch_code = htmlspecialchars(strip_tags($this->batch_code));
        $this->batch_name = htmlspecialchars(strip_tags($this->batch_name));
        $this->start_date = htmlspecialchars(strip_tags($this->start_date));
        $this->end_date = htmlspecialchars(strip_tags($this->end_date));
        $this->current_semester = htmlspecialchars(strip_tags($this->current_semester));
        $this->max_capacity = htmlspecialchars(strip_tags($this->max_capacity));
        $this->class_teacher_id = htmlspecialchars(strip_tags($this->class_teacher_id));
        $this->fee_structure = htmlspecialchars(strip_tags($this->fee_structure));
        $this->admission_criteria = htmlspecialchars(strip_tags($this->admission_criteria));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind parameters
        $stmt->bind_param(
            "sssssiissssi",
            $this->batch_year,
            $this->batch_code,
            $this->batch_name,
            $this->start_date,
            $this->end_date,
            $this->current_semester,
            $this->max_capacity,
            $this->class_teacher_id,
            $this->fee_structure,
            $this->admission_criteria,
            $this->status,
            $this->id
        );

        // Execute query
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }

    // Delete batch
    public function delete()
    {
        // Check if batch has students
        $check_query = "SELECT COUNT(*) as student_count FROM students WHERE batch_id = ?";
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
            return true;
        }

        $stmt->close();
        return false;
    }

    // Get batch statistics
    public function getStatistics()
    {
        $query = "SELECT 
                    COUNT(*) as total_batches,
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_batches,
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_batches,
                    SUM(CASE WHEN status = 'upcoming' THEN 1 ELSE 0 END) as upcoming_batches,
                    SUM(total_students) as total_students,
                    SUM(max_capacity) as total_capacity,
                    AVG(total_students) as avg_batch_size,
                    MIN(batch_year) as earliest_year,
                    MAX(batch_year) as latest_year
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


    // Get upcoming batches
    public function getUpcomingBatches($limit = 5)
    {
        $current_date = date('Y-m-d');
        $query = "SELECT b.*, p.name as program_name 
                  FROM " . $this->table_name . " b
                  LEFT JOIN academic_programs p ON b.program_id = p.id
                  WHERE b.start_date > ? AND b.status = 'upcoming'
                  ORDER BY b.start_date ASC
                  LIMIT ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("si", $current_date, $limit);
        $stmt->execute();

        $result = $stmt->get_result();
        $batches = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $batches;
    }

    // Get batch years for filter
    public function getBatchYears()
    {
        $query = "SELECT DISTINCT batch_year 
                  FROM " . $this->table_name . " 
                  ORDER BY batch_year DESC";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            return false;
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $years = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $years;
    }
}
