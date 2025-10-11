<?php
class InstituteType {
    private $conn;
    private $table_name = "institute_types";

    public $id;
    public $name;
    public $code;
    public $description;
    public $status;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create new institute type
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET name=?, code=?, description=?, status=?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        // Sanitize input
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->code = htmlspecialchars(strip_tags($this->code));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind parameters
        $stmt->bind_param("ssss", 
            $this->name, $this->code, $this->description, $this->status
        );

        // Execute query
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }

    // Check if type code already exists
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

    // Get all institute types
    public function readAll() {
        $query = "SELECT it.*, 
                         COUNT(i.id) as institute_count 
                  FROM " . $this->table_name . " it 
                  LEFT JOIN institutes i ON it.id = i.type 
                  GROUP BY it.id 
                  ORDER BY it.name ASC";
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $types = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $types;
    }

    // Get institute type by ID
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE id = ? LIMIT 1";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $type = $result->fetch_assoc();
        $stmt->close();

        return $type;
    }

    // Update institute type
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET name=?, code=?, description=?, status=?, updated_at=NOW()
                  WHERE id=?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        // Sanitize input
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->code = htmlspecialchars(strip_tags($this->code));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind parameters
        $stmt->bind_param("ssssi", 
            $this->name, $this->code, $this->description, $this->status, $this->id
        );

        // Execute query
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }

    // Delete institute type
    public function delete() {
        // Check if any institutes are using this type
        $check_query = "SELECT COUNT(*) as institute_count FROM institutes WHERE type = ?";
        $check_stmt = $this->conn->prepare($check_query);
        
        if (!$check_stmt) {
            return false;
        }

        $check_stmt->bind_param("i", $this->id);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        $data = $result->fetch_assoc();
        $check_stmt->close();

        if ($data['institute_count'] > 0) {
            return false; // Cannot delete type that is in use
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

    // Get institute type statistics
    public function getStatistics() {
        $query = "SELECT 
                    COUNT(*) as total_types,
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_types
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