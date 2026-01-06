<?php
class TeacherController {
 // Teacher Dashboard
 public function dashboard() {
    Auth::role('TEACHER') || die("Unauthorized");

    $user = Auth::user();
    $subjects = (new Subject())->getByTeacher($user['id']);
    $attendanceModel = new Attendance();

    // Default date range: last 7 days
    $from = $_GET['from'] ?? date('Y-m-d', strtotime('-7 days'));
    $to   = $_GET['to']   ?? date('Y-m-d');

    $todayData = [];
    $lineChartData = [];

    // Attach total students for each subject
    foreach($subjects as &$sub){  // use reference so changes persist
        $sub['total_students'] = $attendanceModel->getTotalStudents($sub['id']);

        // Today's pie chart data
        $todayData[$sub['id']] = $attendanceModel->getTodayCountsBySubject($sub['id']);

        // Line chart data
        $lineChartData[$sub['id']] = $attendanceModel->getCountsByDateRange($sub['id'], $from, $to);
    }
    unset($sub); // break reference

    require "../app/views/teacher/dashboard.php";
}


    // Mark Attendance
    // Attendance marking page
   public function attendance()
{
    // 🔐 Only teacher can access
    Auth::role('TEACHER') || die('Unauthorized');

    $user = Auth::user();
    $attendanceModel = new Attendance();
    $subjectModel = new Subject();

    // Get subjects taught by this teacher
    $subjects = $subjectModel->getByTeacher($user['id']);

    // Selected subject (GET for switching, POST for saving)
    $subjectId = $_POST['subject_id'] ?? $_GET['subject_id'] ?? null;

    $today = date('Y-m-d');
    $todayAttendance = [];
    $students = [];

    // 📌 If subject selected → check today's attendance for THAT subject
    if ($subjectId) {
        $todayAttendance = $attendanceModel->getTodayBySubject($subjectId, $today);
    }

    // 📝 Save attendance (ONLY if not already done)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $subjectId && empty($todayAttendance)) {

        if (!empty($_POST['attendance'])) {
            foreach ($_POST['attendance'] as $studentId => $status) {
                $attendanceModel->mark(
                    $studentId,
                    $subjectId,
                    $status,
                    $today
                );
            }
        }

        // Reload after saving to prevent resubmission
        header("Location: teacher/attendance&subject_id={$subjectId}");
        exit;
    }

    // 👨‍🎓 Load students ONLY if attendance not done yet
    if ($subjectId && empty($todayAttendance)) {
        $students = $attendanceModel->getStudentsBySubject($subjectId);
    }

    require_once __DIR__ . '/../views/teacher/mark_attendance.php';
}




    // Logout
    public function logout() {
        session_destroy();
        header("Location: /login");
        exit;
    }
}
