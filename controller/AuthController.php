<?php
class AuthController {
    private $userModel;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->userModel = new User($this->db);
    }

    public function register() {
        // Redirect if already logged in
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            header('Location: dashboard');
            exit();
        }

        $error = '';
        $formData = [
            'name' => '',
            'email' => ''
        ];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize input data
            $name = $this->sanitizeInput($_POST['name']);
            $email = $this->sanitizeInput($_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Store form data for repopulation
            $formData = [
                'name' => $name,
                'email' => $email
            ];

            // Validate inputs
            $validationError = $this->validateRegistration($name, $email, $password, $confirm_password);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                $this->userModel->name = $name;
                $this->userModel->email = $email;
                $this->userModel->password = $password;

                // Check if email already exists
                if ($this->userModel->emailExists()) {
                    $error = 'Email already exists. Please use a different email address.';
                } else {
                    // Attempt to create user
                    if ($this->userModel->create()) {
                        $_SESSION['success_message'] = 'Registration successful! Please login to continue.';
                        header('Location: login');
                        exit();
                    } else {
                        $error = 'Registration failed. Please try again later.';
                    }
                }
            }
        }

        // Pass form data to view for repopulation
        include BASE_PATH . '/view/register.php';
    }

    public function login() {
        // Redirect if already logged in
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            header('Location: dashboard');
            exit();
        }

        $error = '';
        $formData = [
            'email' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $this->sanitizeInput($_POST['email']);
            $password = $_POST['password'];
            $remember = isset($_POST['remember']) ? true : false;

            // Store email for repopulation
            $formData['email'] = $email;

            // Validate inputs
            $validationError = $this->validateLogin($email, $password);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                $this->userModel->email = $email;
                
                if ($this->userModel->emailExists()) {
                    if (password_verify($password, $this->userModel->password)) {
                        // Set session variables
                        $_SESSION['user_id'] = $this->userModel->id;
                        $_SESSION['user_name'] = $this->userModel->name;
                        $_SESSION['user_email'] = $this->userModel->email;
                        $_SESSION['logged_in'] = true;

                        // Set remember me cookie if requested
                        if ($remember) {
                            $this->setRememberMeCookie($this->userModel->id);
                        }

                        // Log login activity
                        $this->logLoginActivity($this->userModel->id);

                        $_SESSION['success_message'] = 'Welcome back, ' . $this->userModel->name . '!';
                        header('Location: dashboard');
                        exit();
                    } else {
                        $error = 'Invalid password. Please try again.';
                    }
                } else {
                    $error = 'Email address not found. Please check your email or register for a new account.';
                }
            }
        }

        // Check for success message from registration
        if (isset($_SESSION['success_message'])) {
            $success_message = $_SESSION['success_message'];
            unset($_SESSION['success_message']);
        } else {
            $success_message = '';
        }

        include BASE_PATH . '/view/login.php';
    }

    public function logout() {
        // Unset all session variables
        $_SESSION = array();

        // Destroy the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destroy the session
        session_destroy();

        // Clear remember me cookie
        $this->clearRememberMeCookie();

        $_SESSION['success_message'] = 'You have been successfully logged out.';
        header('Location: login');
        exit();
    }

    public function forgotPassword() {
        $error = '';
        $success = '';
        $formData = ['email' => ''];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $this->sanitizeInput($_POST['email']);
            $formData['email'] = $email;

            if (empty($email)) {
                $error = 'Please enter your email address.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Please enter a valid email address.';
            } else {
                $this->userModel->email = $email;
                
                if ($this->userModel->emailExists()) {
                    // Generate reset token (in a real application)
                    $reset_token = bin2hex(random_bytes(32));
                    // Here you would typically save the token to the database and send an email
                    
                    $success = 'If an account with that email exists, we have sent a password reset link.';
                } else {
                    // For security, don't reveal whether email exists
                    $success = 'If an account with that email exists, we have sent a password reset link.';
                }
            }
        }

        include BASE_PATH . '/view/forgot-password.php';
    }

    public function profile() {
        // Check if user is logged in
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            $_SESSION['error_message'] = 'Please login to access your profile.';
            header('Location: login');
            exit();
        }

        $error = '';
        $success = '';
        $userData = [
            'name' => $_SESSION['user_name'],
            'email' => $_SESSION['user_email']
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $this->sanitizeInput($_POST['name']);
            $email = $this->sanitizeInput($_POST['email']);
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            // Validate profile update
            $validationError = $this->validateProfileUpdate($name, $email, $current_password, $new_password, $confirm_password);
            
            if ($validationError) {
                $error = $validationError;
            } else {
                // Update user profile
                if ($this->updateUserProfile($_SESSION['user_id'], $name, $email, $new_password)) {
                    // Update session data
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_email'] = $email;
                    $userData['name'] = $name;
                    $userData['email'] = $email;
                    
                    $success = 'Profile updated successfully!';
                } else {
                    $error = 'Failed to update profile. Please try again.';
                }
            }
        }

        include BASE_PATH . '/view/profile.php';
    }

    private function validateRegistration($name, $email, $password, $confirm_password) {
        if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
            return 'All fields are required.';
        }

        if (strlen($name) < 2 || strlen($name) > 100) {
            return 'Name must be between 2 and 100 characters.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Please enter a valid email address.';
        }

        if (strlen($password) < 8) {
            return 'Password must be at least 8 characters long.';
        }

        if ($password !== $confirm_password) {
            return 'Passwords do not match.';
        }

        if (!preg_match('/[A-Z]/', $password)) {
            return 'Password must contain at least one uppercase letter.';
        }

        if (!preg_match('/[a-z]/', $password)) {
            return 'Password must contain at least one lowercase letter.';
        }

        if (!preg_match('/[0-9]/', $password)) {
            return 'Password must contain at least one number.';
        }

        return null;
    }

    private function validateLogin($email, $password) {
        if (empty($email) || empty($password)) {
            return 'Both email and password are required.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Please enter a valid email address.';
        }

        return null;
    }

    private function validateProfileUpdate($name, $email, $current_password, $new_password, $confirm_password) {
        if (empty($name) || empty($email)) {
            return 'Name and email are required.';
        }

        if (strlen($name) < 2 || strlen($name) > 100) {
            return 'Name must be between 2 and 100 characters.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Please enter a valid email address.';
        }

        // Check if password is being changed
        if (!empty($new_password)) {
            if (empty($current_password)) {
                return 'Current password is required to change your password.';
            }

            if (strlen($new_password) < 8) {
                return 'New password must be at least 8 characters long.';
            }

            if ($new_password !== $confirm_password) {
                return 'New passwords do not match.';
            }

            if (!preg_match('/[A-Z]/', $new_password)) {
                return 'New password must contain at least one uppercase letter.';
            }

            if (!preg_match('/[a-z]/', $new_password)) {
                return 'New password must contain at least one lowercase letter.';
            }

            if (!preg_match('/[0-9]/', $new_password)) {
                return 'New password must contain at least one number.';
            }

            // Verify current password
            $this->userModel->email = $_SESSION['user_email'];
            if (!$this->userModel->emailExists() || !password_verify($current_password, $this->userModel->password)) {
                return 'Current password is incorrect.';
            }
        }

        return null;
    }

    private function sanitizeInput($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    private function setRememberMeCookie($user_id) {
        $token = bin2hex(random_bytes(32));
        $expiry = time() + (30 * 24 * 60 * 60); // 30 days
        
        // In a real application, you would store this token in the database
        setcookie('remember_me', $token, $expiry, '/', '', false, true);
    }

    private function clearRememberMeCookie() {
        setcookie('remember_me', '', time() - 3600, '/', '', false, true);
    }

    private function logLoginActivity($user_id) {
        // In a real application, you would log this to a database table
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
        $timestamp = date('Y-m-d H:i:s');

        // Example logging (you would typically save to a database)
        error_log("User $user_id logged in from $ip_address at $timestamp");
    }

    private function updateUserProfile($user_id, $name, $email, $new_password = null) {
        $query = "UPDATE users SET name = ?, email = ?";
        $params = [$name, $email];
        $types = "ss";

        if ($new_password) {
            $query .= ", password = ?";
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $params[] = $hashed_password;
            $types .= "s";
        }

        $query .= " WHERE id = ?";
        $params[] = $user_id;
        $types .= "i";

        $stmt = $this->db->prepare($query);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param($types, ...$params);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    // Method to check if user is logged in (can be used in other controllers)
    public static function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
    }

    // Method to require login (can be used in other controllers)
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            $_SESSION['error_message'] = 'Please login to access this page.';
            header('Location: login');
            exit();
        }
    }

    // Method to get current user ID
    public static function getCurrentUserId() {
        return $_SESSION['user_id'] ?? null;
    }

    // Method to get current user name
    public static function getCurrentUserName() {
        return $_SESSION['user_name'] ?? null;
    }
}