<?php
class Department {
    private $conn;
    private $table_name = "departments";

    public $id;
    public $institute_id;
    public $name;
    public $code;
    public $type;
    public $head_of_department;
    public $email;
    public $phone;
    public $description;
    public $status;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create new department
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET institute_id=?, name=?, code=?, type=?, head_of_department=?, 
                      email=?, phone=?, description=?, status=?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        // Sanitize input
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->code = htmlspecialchars(strip_tags($this->code));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->head_of_department = htmlspecialchars(strip_tags($this->head_of_department));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind parameters
        $stmt->bind_param("issssssss", 
            $this->institute_id, $this->name, $this->code, $this->type,
            $this->head_of_department, $this->email, $this->phone,
            $this->description, $this->status
        );

        // Execute query
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }

    // Check if department code already exists for institute
    public function codeExists() {
        $query = "SELECT id FROM " . $this->table_name . " 
                  WHERE institute_id = ? AND code = ? LIMIT 1";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $this->code = htmlspecialchars(strip_tags($this->code));
        $stmt->bind_param("is", $this->institute_id, $this->code);

        $stmt->execute();
        $stmt->store_result();

        $exists = $stmt->num_rows > 0;
        $stmt->close();

        return $exists;
    }

    // Get all departments with institute info
    public function readAll() {
        $query = "SELECT d.*, i.name as institute_name, i.code as institute_code 
                  FROM " . $this->table_name . " d 
                  LEFT JOIN institutes i ON d.institute_id = i.id 
                  ORDER BY d.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $departments = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $departments;
    }

    // Get departments by institute
    public function readByInstitute($institute_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE institute_id = ? 
                  ORDER BY name ASC";
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $institute_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $departments = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $departments;
    }

    // Get department by ID
    public function readOne() {
        $query = "SELECT d.*, i.name as institute_name, i.code as institute_code 
                  FROM " . $this->table_name . " d 
                  LEFT JOIN institutes i ON d.institute_id = i.id 
                  WHERE d.id = ? LIMIT 1";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $department = $result->fetch_assoc();
        $stmt->close();

        return $department;
    }

    // Update department
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET name=?, code=?, type=?, head_of_department=?, 
                      email=?, phone=?, description=?, status=?, updated_at=NOW()
                  WHERE id=?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        // Sanitize input
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->code = htmlspecialchars(strip_tags($this->code));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->head_of_department = htmlspecialchars(strip_tags($this->head_of_department));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind parameters
        $stmt->bind_param("ssssssssi", 
            $this->name, $this->code, $this->type, $this->head_of_department,
            $this->email, $this->phone, $this->description, $this->status, $this->id
        );

        // Execute query
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }

    // Delete department
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

    // Get department statistics
    public function getStatistics() {
        $query = "SELECT 
                    COUNT(*) as total_departments,
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_departments,
                    SUM(CASE WHEN type = 'academic' THEN 1 ELSE 0 END) as academic_departments,
                    SUM(CASE WHEN type = 'administrative' THEN 1 ELSE 0 END) as administrative_departments,
                    SUM(CASE WHEN type = 'support' THEN 1 ELSE 0 END) as support_departments
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
}