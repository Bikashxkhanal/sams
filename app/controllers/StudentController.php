<?php
class StudentController {
    public function dashboard() {
        // Ensure logged in and role is STUDENT
        Auth::role('STUDENT') || die("Unauthorized");

        $user = Auth::user();

        if (!$user) {
            die("User not logged in");
        }

        $report = (new Attendance())->report($user['id']);

        require __DIR__ . "/../views/student/dashboard.php";
    }

     public function logout() {
        session_destroy();
        header("Location: /login");
        exit;
    }
}
