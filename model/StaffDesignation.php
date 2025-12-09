<?php
class StaffDesignation {
    private $conn;
    private $table_name = "staff_designations";

    public $id;
    public $category_id;
    public $name;
    public $code;
    public $level;
    public $description;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all designations
    public function readAll($category_id = null) {
        $query = "SELECT sd.*, sc.name as category_name 
                  FROM " . $this->table_name . " sd
                  LEFT JOIN staff_categories sc ON sd.category_id = sc.id
                  WHERE 1=1";
        
        if ($category_id) {
            $query .= " AND sd.category_id = ?";
        }
        
        $query .= " ORDER BY sd.level, sd.name";

        if ($category_id) {
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                return false;
            }
            $stmt->bind_param("i", $category_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $designations = [];
            while ($row = $result->fetch_assoc()) {
                $designations[] = $row;
            }
            $stmt->close();
        } else {
            $result = $this->conn->query($query);
            if (!$result) {
                return false;
            }
            $designations = [];
            while ($row = $result->fetch_assoc()) {
                $designations[] = $row;
            }
        }

        return $designations;
    }

    // Get designation by ID
    public function readOne() {
        $query = "SELECT sd.*, sc.name as category_name 
                  FROM " . $this->table_name . " sd
                  LEFT JOIN staff_categories sc ON sd.category_id = sc.id
                  WHERE sd.id = ? LIMIT 1";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $designation = $result->fetch_assoc();
        $stmt->close();

        return $designation;
    }

    // Create designation
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET category_id=?, name=?, code=?, level=?, description=?, status=?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        // Sanitize input
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->code = htmlspecialchars(strip_tags($this->code));
        $this->level = htmlspecialchars(strip_tags($this->level));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind parameters
        $stmt->bind_param("ississ", 
            $this->category_id, $this->name, $this->code, 
            $this->level, $this->description, $this->status
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

    // Update designation
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET category_id=?, name=?, code=?, level=?, description=?, status=?
                  WHERE id=?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        // Sanitize input
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->code = htmlspecialchars(strip_tags($this->code));
        $this->level = htmlspecialchars(strip_tags($this->level));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind parameters
        $stmt->bind_param("ississi", 
            $this->category_id, $this->name, $this->code, 
            $this->level, $this->description, $this->status, $this->id
        );

        // Execute query
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // Delete designation
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

    // Get designations by category
    public function getByCategory($category_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE category_id = ? AND status = 'active'
                  ORDER BY level, name";
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $designations = [];
        while ($row = $result->fetch_assoc()) {
            $designations[] = $row;
        }
        $stmt->close();

        return $designations;
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