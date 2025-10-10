<?php
class DashboardController {
    public function index() {
        if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
            header('Location: login');
            exit();
        }
        include BASE_PATH . '/view/dashboard.php';
    }
}

?>