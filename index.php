<?php
// Start session
session_start();

// Load global constants
require_once __DIR__ . '/config/Constants.php';

// Autoload classes
spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . '/controller/',
        BASE_PATH . '/model/',
        BASE_PATH . '/config/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Get the requested URL
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';

// Route the request
switch ($url) {
    case 'home':
        $controller = new HomeController();
        $controller->index();
        break;
    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;
    case 'forgot-password':
        $controller = new AuthController();
        $controller->forgotPassword();
        break;
    case 'register':
        $controller = new AuthController();
        $controller->register();
        break;
    case 'dashboard':
        $controller = new DashboardController();
        $controller->index();
        break;
    case 'profile':
        $controller = new AuthController();
        $controller->profile();
        break;
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;
    case 'institutes/manage':
        $controller = new InstituteController();
        $controller->manage();
        break;
    case 'institutes/add':
        $controller = new InstituteController();
        $controller->add();
        break;
    case 'institutes/edit':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controller = new InstituteController();
        $controller->edit($id);
        break;
    case 'institutes/delete':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controller = new InstituteController();
        $controller->delete($id);
        break;
    case 'institutes/types':
        $controller = new InstituteController();
        $controller->types();
        break;
    case 'institutes/departments':
        $controller = new InstituteController();
        $controller->departments();
        break;
    case 'institutes/branches':
        $controller = new InstituteController();
        $controller->branches();
        break;
    case 'institutes/api/statistics':
        $controller = new InstituteController();
        $controller->getStatistics();
        break;
    case 'institutes/api/recent':
        $controller = new InstituteController();
        $controller->getRecent();
        break;
    // Institute Types Routes
    case 'institutes/types/add':
        $controller = new InstituteController();
        $controller->types();
        break;

    case 'institutes/types/edit':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controller = new InstituteController();
        $controller->editType($id);
        break;

    case 'institutes/types/delete':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controller = new InstituteController();
        $controller->deleteType($id);
        break;

    // Departments Routes
    case 'institutes/departments/add':
        $controller = new InstituteController();
        $controller->departments();
        break;

    case 'institutes/departments/edit':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controller = new InstituteController();
        $controller->editDepartment($id);
        break;

    case 'institutes/departments/delete':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controller = new InstituteController();
        $controller->deleteDepartment($id);
        break;

    // Branches Routes
    case 'institutes/branches/add':
        $controller = new InstituteController();
        $controller->branches();
        break;

    case 'institutes/branches/edit':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controller = new InstituteController();
        $controller->editBranch($id);
        break;

    case 'institutes/branches/delete':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controller = new InstituteController();
        $controller->deleteBranch($id);
        break;
    // Academic Module Routes
    case 'academic/programs':
        $controller = new AcademicController();
        $controller->programs();
        break;

    case 'academic/programs/add':
        $controller = new AcademicController();
        $controller->addProgram();
        break;

    case 'academic/programs/edit':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controller = new AcademicController();
        $controller->editProgram($id);
        break;

    case 'academic/programs/view':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controller = new AcademicController();
        $controller->viewProgram($id);
        break;

    case 'academic/programs/delete':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controller = new AcademicController();
        $controller->deleteProgram($id);
        break;

    case 'academic/batches':
        $controller = new AcademicController();
        $controller->batches();
        break;

    case 'academic/batches/add':
        $controller = new AcademicController();
        $controller->addBatch();
        break;

    case 'academic/batches/edit':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $controller = new AcademicController();
        $controller->editBatch($id);
        break;

    case 'academic/subjects':
        $controller = new AcademicController();
        $controller->subjects();
        break;

    case 'academic/curriculum':
        $program_id = isset($_GET['program_id']) ? $_GET['program_id'] : null;
        $controller = new AcademicController();
        $controller->curriculum($program_id);
        break;

    // API Routes
    case 'academic/api/programs-by-department':
        $controller = new AcademicController();
        $controller->getProgramsByDepartment();
        break;

    case 'academic/api/batches-by-program':
        $controller = new AcademicController();
        $controller->getBatchesByProgram();
        break;

    // API Routes
    case 'institutes/api/departments-by-institute':
        $controller = new InstituteController();
        $controller->getDepartmentsByInstitute();
        break;

    case 'institutes/api/branches-by-institute':
        $controller = new InstituteController();
        $controller->getBranchesByInstitute();
        break;
    default:
        http_response_code(404);
        include BASE_PATH . '/view/404.php';
        break;
}