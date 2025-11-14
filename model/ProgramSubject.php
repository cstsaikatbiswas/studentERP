<?php
class ProgramSubject {
    private $conn;
    private $table_name = "program_subjects";

    public $id;
    public $program_id;
    public $subject_id;
    public $semester;
    public $is_optional;
    public $min_credits;
    public $max_credits;
    public $course_code;
    public $course_type;
    public $teaching_methodology;
    public $assessment_pattern;
    public $status;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Add subject to program
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET program_id=?, subject_id=?, semester=?, is_optional=?, 
                      min_credits=?, max_credits=?, course_code=?, course_type=?, 
                      teaching_methodology=?, assessment_pattern=?, status=?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        // Sanitize input
        $this->program_id = (int)$this->program_id;
        $this->subject_id = (int)$this->subject_id;
        $this->semester = (int)$this->semester;
        $this->is_optional = (bool)$this->is_optional;
        $this->min_credits = $this->min_credits ? (float)$this->min_credits : null;
        $this->max_credits = $this->max_credits ? (float)$this->max_credits : null;
        $this->course_code = htmlspecialchars(strip_tags($this->course_code));
        $this->course_type = htmlspecialchars(strip_tags($this->course_type));
        $this->teaching_methodology = htmlspecialchars(strip_tags($this->teaching_methodology));
        $this->assessment_pattern = $this->assessment_pattern ? $this->conn->real_escape_string(json_encode($this->assessment_pattern)) : null;
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind parameters
        $stmt->bind_param("iiiiddsssss",
            $this->program_id, $this->subject_id, $this->semester, $this->is_optional,
            $this->min_credits, $this->max_credits, $this->course_code, $this->course_type,
            $this->teaching_methodology, $this->assessment_pattern, $this->status
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

    // Check if subject already exists in program for semester
    public function existsInProgram() {
        $query = "SELECT id FROM " . $this->table_name . " 
                  WHERE program_id = ? AND subject_id = ? AND semester = ? LIMIT 1";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("iii", $this->program_id, $this->subject_id, $this->semester);

        $stmt->execute();
        $stmt->store_result();

        $exists = $stmt->num_rows > 0;
        $stmt->close();

        return $exists;
    }

    // Get program curriculum
    public function getProgramCurriculum($program_id) {
        $query = "SELECT ps.*, s.name as subject_name, s.code as subject_code,
                         s.credit_hours, s.subject_type, s.difficulty_level,
                         d.name as department_name
                  FROM " . $this->table_name . " ps
                  LEFT JOIN subjects s ON ps.subject_id = s.id
                  LEFT JOIN departments d ON s.department_id = d.id
                  WHERE ps.program_id = ? AND ps.status = 'active'
                  ORDER BY ps.semester ASC, ps.course_type DESC, s.name ASC";
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $program_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $curriculum = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $curriculum;
    }

    // Get semester-wise subjects for program
    public function getSemesterSubjects($program_id, $semester) {
        $query = "SELECT ps.*, s.name as subject_name, s.code as subject_code,
                         s.credit_hours, s.subject_type, s.description,
                         s.theory_hours, s.practical_hours
                  FROM " . $this->table_name . " ps
                  LEFT JOIN subjects s ON ps.subject_id = s.id
                  WHERE ps.program_id = ? AND ps.semester = ? AND ps.status = 'active'
                  ORDER BY ps.course_type DESC, s.name ASC";
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ii", $program_id, $semester);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $subjects = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $subjects;
    }

    // Update program subject
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET semester=?, is_optional=?, min_credits=?, max_credits=?, 
                      course_code=?, course_type=?, teaching_methodology=?, 
                      assessment_pattern=?, status=?, updated_at=NOW()
                  WHERE id=?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        // Sanitize input
        $this->semester = (int)$this->semester;
        $this->is_optional = (bool)$this->is_optional;
        $this->min_credits = $this->min_credits ? (float)$this->min_credits : null;
        $this->max_credits = $this->max_credits ? (float)$this->max_credits : null;
        $this->course_code = htmlspecialchars(strip_tags($this->course_code));
        $this->course_type = htmlspecialchars(strip_tags($this->course_type));
        $this->teaching_methodology = htmlspecialchars(strip_tags($this->teaching_methodology));
        $this->assessment_pattern = $this->assessment_pattern ? $this->conn->real_escape_string(json_encode($this->assessment_pattern)) : null;
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind parameters
        $stmt->bind_param("iiddsssssi",
            $this->semester, $this->is_optional, $this->min_credits, $this->max_credits,
            $this->course_code, $this->course_type, $this->teaching_methodology,
            $this->assessment_pattern, $this->status, $this->id
        );

        // Execute query
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }

    // Remove subject from program
    public function delete() {
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

    // Get program credit summary
    public function getCreditSummary($program_id) {
        $query = "SELECT 
                    ps.semester,
                    COUNT(ps.id) as total_subjects,
                    SUM(s.credit_hours) as total_credits,
                    SUM(CASE WHEN ps.course_type = 'mandatory' THEN s.credit_hours ELSE 0 END) as mandatory_credits,
                    SUM(CASE WHEN ps.course_type = 'elective' THEN s.credit_hours ELSE 0 END) as elective_credits,
                    SUM(CASE WHEN ps.is_optional = 1 THEN s.credit_hours ELSE 0 END) as optional_credits
                  FROM " . $this->table_name . " ps
                  LEFT JOIN subjects s ON ps.subject_id = s.id
                  WHERE ps.program_id = ? AND ps.status = 'active'
                  GROUP BY ps.semester
                  ORDER BY ps.semester ASC";
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $program_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $summary = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $summary;
    }

    // Check prerequisites for a subject in program
    public function checkPrerequisites($student_id, $subject_id, $program_id) {
        // This would typically check if student has completed prerequisite subjects
        // Implementation depends on your grade and student progress tracking
        return true; // Placeholder
    }

    // Get available electives for a program and semester
    public function getAvailableElectives($program_id, $semester) {
        $query = "SELECT ps.*, s.name as subject_name, s.code as subject_code,
                         s.credit_hours, s.description, s.difficulty_level
                  FROM " . $this->table_name . " ps
                  LEFT JOIN subjects s ON ps.subject_id = s.id
                  WHERE ps.program_id = ? AND ps.semester = ? 
                    AND ps.course_type = 'elective' AND ps.status = 'active'
                  ORDER BY s.name ASC";
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ii", $program_id, $semester);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $electives = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $electives;
    }
}