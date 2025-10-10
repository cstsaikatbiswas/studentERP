<?php
class Institute {
    private $conn;
    private $table_name = "institutes";

    public $id;
    public $name;
    public $code;
    public $type;
    public $address;
    public $city;
    public $state;
    public $country;
    public $pincode;
    public $phone;
    public $email;
    public $website;
    public $established_year;
    public $description;
    public $status;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create new institute
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET name=?, code=?, type=?, address=?, city=?, state=?, 
                      country=?, pincode=?, phone=?, email=?, website=?, 
                      established_year=?, description=?, status=?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        // Sanitize input
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->code = htmlspecialchars(strip_tags($this->code));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->state = htmlspecialchars(strip_tags($this->state));
        $this->country = htmlspecialchars(strip_tags($this->country));
        $this->pincode = htmlspecialchars(strip_tags($this->pincode));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->website = htmlspecialchars(strip_tags($this->website));
        $this->established_year = htmlspecialchars(strip_tags($this->established_year));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind parameters
        $stmt->bind_param("ssssssssssssss", 
            $this->name, $this->code, $this->type, $this->address, 
            $this->city, $this->state, $this->country, $this->pincode,
            $this->phone, $this->email, $this->website, $this->established_year,
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

    // Check if institute code already exists
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

    // Get all institutes
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  ORDER BY created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $institutes = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $institutes;
    }

    // Get institute by ID
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
        $institute = $result->fetch_assoc();
        $stmt->close();

        return $institute;
    }

    // Update institute
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET name=?, code=?, type=?, address=?, city=?, state=?, 
                      country=?, pincode=?, phone=?, email=?, website=?, 
                      established_year=?, description=?, status=?, updated_at=NOW()
                  WHERE id=?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        // Sanitize input
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->code = htmlspecialchars(strip_tags($this->code));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->state = htmlspecialchars(strip_tags($this->state));
        $this->country = htmlspecialchars(strip_tags($this->country));
        $this->pincode = htmlspecialchars(strip_tags($this->pincode));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->website = htmlspecialchars(strip_tags($this->website));
        $this->established_year = htmlspecialchars(strip_tags($this->established_year));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind parameters
        $stmt->bind_param("ssssssssssssssi", 
            $this->name, $this->code, $this->type, $this->address, 
            $this->city, $this->state, $this->country, $this->pincode,
            $this->phone, $this->email, $this->website, $this->established_year,
            $this->description, $this->status, $this->id
        );

        // Execute query
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }

    // Delete institute
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

    // Get institute statistics
    public function getStatistics() {
        $query = "SELECT 
                    COUNT(*) as total_institutes,
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_institutes,
                    COUNT(DISTINCT type) as institute_types
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

    // Get recent institutes
    public function getRecent($limit = 5) {
        $query = "SELECT id, name, code, type, status, updated_at 
                  FROM " . $this->table_name . " 
                  ORDER BY updated_at DESC 
                  LIMIT ?";
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $limit);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $institutes = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $institutes;
    }
}