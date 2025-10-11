<?php
class Branch {
    private $conn;
    private $table_name = "branches";

    public $id;
    public $institute_id;
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
    public $total_students;
    public $total_faculty;
    public $description;
    public $status;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create new branch
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET institute_id=?, name=?, code=?, type=?, address=?, city=?, 
                      state=?, country=?, pincode=?, phone=?, email=?, website=?, 
                      established_year=?, total_students=?, total_faculty=?, 
                      description=?, status=?";

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
        $this->total_students = htmlspecialchars(strip_tags($this->total_students));
        $this->total_faculty = htmlspecialchars(strip_tags($this->total_faculty));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind parameters
        $stmt->bind_param("issssssssssssiiss", 
            $this->institute_id, $this->name, $this->code, $this->type,
            $this->address, $this->city, $this->state, $this->country,
            $this->pincode, $this->phone, $this->email, $this->website,
            $this->established_year, $this->total_students, $this->total_faculty,
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

    // Check if branch code already exists for institute
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

    // Get all branches with institute info
    public function readAll() {
        $query = "SELECT b.*, i.name as institute_name, i.code as institute_code 
                  FROM " . $this->table_name . " b 
                  LEFT JOIN institutes i ON b.institute_id = i.id 
                  ORDER BY b.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $branches = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $branches;
    }

    // Get branches by institute
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
        $branches = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $branches;
    }

    // Get branch by ID
    public function readOne() {
        $query = "SELECT b.*, i.name as institute_name, i.code as institute_code 
                  FROM " . $this->table_name . " b 
                  LEFT JOIN institutes i ON b.institute_id = i.id 
                  WHERE b.id = ? LIMIT 1";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $branch = $result->fetch_assoc();
        $stmt->close();

        return $branch;
    }

    // Update branch
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET name=?, code=?, type=?, address=?, city=?, state=?, 
                      country=?, pincode=?, phone=?, email=?, website=?, 
                      established_year=?, total_students=?, total_faculty=?, 
                      description=?, status=?, updated_at=NOW()
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
        $this->total_students = htmlspecialchars(strip_tags($this->total_students));
        $this->total_faculty = htmlspecialchars(strip_tags($this->total_faculty));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind parameters
        $stmt->bind_param("ssssssssssssiiisi", 
            $this->name, $this->code, $this->type, $this->address,
            $this->city, $this->state, $this->country, $this->pincode,
            $this->phone, $this->email, $this->website, $this->established_year,
            $this->total_students, $this->total_faculty, $this->description,
            $this->status, $this->id
        );

        // Execute query
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }

    // Delete branch
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

    // Get branch statistics
    public function getStatistics() {
        $query = "SELECT 
                    COUNT(*) as total_branches,
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_branches,
                    SUM(CASE WHEN type = 'main' THEN 1 ELSE 0 END) as main_branches,
                    SUM(CASE WHEN type = 'branch' THEN 1 ELSE 0 END) as branch_campuses,
                    SUM(CASE WHEN type = 'extension' THEN 1 ELSE 0 END) as extension_centers,
                    SUM(CASE WHEN type = 'online' THEN 1 ELSE 0 END) as online_campuses,
                    SUM(total_students) as total_students,
                    SUM(total_faculty) as total_faculty
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