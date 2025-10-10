<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET name=?, email=?, password=?";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        // Sanitize input
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // Hash password
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

        // Bind parameters
        $stmt->bind_param("sss", $this->name, $this->email, $hashed_password);

        // Execute query
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }

    public function emailExists() {
        $query = "SELECT id, name, password 
                  FROM " . $this->table_name . " 
                  WHERE email = ? 
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        // Sanitize and bind email parameter
        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bind_param("s", $this->email);

        // Execute query
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Bind result variables
            $stmt->bind_result($this->id, $this->name, $this->password);
            $stmt->fetch();
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }
}