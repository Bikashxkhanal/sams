<?php
session_start();

/* ======================
   CORE INCLUDES
====================== */
require "../app/config/Database.php";
require "../app/core/Auth.php";
require "../app/core/Validator.php";
require "../app/core/Controller.php";

/* ======================
   AUTOLOADER
====================== */
spl_autoload_register(function ($class) {
    foreach (["models", "controllers", "core"] as $dir) {
        $path = "../app/$dir/$class.php";
        if (file_exists($path)) {
            require $path;
            return;
        }
    }
});

/* ======================
   URI PARSING
====================== */
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

/* ======================
   ENTRY POINT
====================== */
if ($uri === '' || $uri === 'index.php') {

    if (!Auth::check()) {
        header("Location: /login");
        exit;
    }

    $role = Auth::user()['role'];

    if ($role === 'ADMIN') {
        header("Location: /admin");
    } elseif ($role === 'TEACHER') {
        header("Location: /teacher");
    } elseif ($role === 'STUDENT') {
        header("Location: /student");
    }
    exit;
}

/* ======================
   ROUTES
====================== */
switch ($uri) {

    /* AUTH */
    case 'login':
        (new AuthController)->login();
        break;

    case 'logout':
        (new AuthController)->logout();
        break;

    /* ADMIN */
    case 'admin':
        (new AdminController)->dashboard();
        break;

    case 'admin/program/create':
        (new AdminController)->createProgram();
        break;

    case 'admin/semester/create':
        (new AdminController)->createSemester();
        break;

    case 'admin/subject/create':
        (new AdminController)->createSubject();
        break;

    case 'admin/user/create':
        (new AdminController)->createUser();
        break;

    /* TEACHER */
    case 'teacher':
        (new TeacherController)->dashboard();
        break;

    case 'teacher/attendance':
        (new TeacherController)->attendance();
        break;

    /* STUDENT */
    case 'student':
        (new StudentController)->dashboard();
        break;

    default:
        http_response_code(404);
        echo "404 - Page Not Found";
}
