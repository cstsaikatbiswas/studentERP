<?php
class StaffCategory {
    private $conn;
    private $table_name = "staff_categories";

    public $id;
    public $name;
    public $code;
    public $description;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all categories
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  ORDER BY name";
        
        $result = $this->conn->query($query);
        
        if (!$result) {
            return false;
        }

        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }

        return $categories;
    }

    // Get category by ID
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
        $category = $result->fetch_assoc();
        $stmt->close();

        return $category;
    }

    // Get category by code
    public function getByCode($code) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE code = ? LIMIT 1";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("s", $code);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $category = $result->fetch_assoc();
        $stmt->close();

        return $category;
    }

    // Create category
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
            $this->id = $stmt->insert_id;
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }

    // Update category
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET name=?, code=?, description=?, status=?
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
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // Delete category
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

    // Check if code exists
    public function codeExists() {
        $query = "SELECT id FROM " . $this->table_name . " 
                  WHERE code = ? AND id != ? LIMIT 1";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("si", $this->code, $this->id);
        $stmt->execute();
        $stmt->store_result();

        $exists = $stmt->num_rows > 0;
        $stmt->close();

        return $exists;
    }
}