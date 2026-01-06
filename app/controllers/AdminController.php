<?php


    class AdminController extends Controller
{
    public function dashboard() {
        Auth::role('ADMIN') || die("Unauthorized");

        $attendanceModel = new Attendance();

        // Pie chart - today's attendance
        $todayData = $attendanceModel->getTodaySummary();

        // Line chart - filtered date range
        $from = $_GET['from'] ?? null;
        $to   = $_GET['to'] ?? null;
        $lineChartData = $attendanceModel->getSummaryByDate($from, $to);

        // Optional: other summary stats for admin
        // $totalStudents = (new User())->countByRole('STUDENT');
        // $totalTeachers = (new User())->countByRole('TEACHER');
        // $totalPrograms = (new Program())->countAll();

        // Render the dashboard view
        $this->view('admin/dashboard', compact(
            'todayData', 'lineChartData'
        ));
    }

    /* PROGRAM */
    public function createProgram()
    {
        Auth::role('ADMIN') || die("Unauthorized");

        if($_POST){
            (new Program())->create($_POST['name']);
            header("Location: /admin");
            exit;
        }

        $this->view('admin/program_create');
    }

    /* SEMESTER */
    public function createSemester()
    {
        Auth::role('ADMIN') || die("Unauthorized");

        $programs = (new Program())->all();

        if($_POST){
            (new Semester())->create($_POST['program_id'], $_POST['name']);
            header("Location: /admin");
            exit;
        }

        $this->view('admin/semester_create', compact('programs'));
    }

    /* SUBJECT */
    public function createSubject()
    {
        Auth::role('ADMIN') || die("Unauthorized");

        $semesters = (new Semester())->all();

        if($_POST){
            (new Subject())->create($_POST['semester_id'], $_POST['name']);
            header("Location: /admin");
            exit;
        }

        $this->view('admin/subject_create', compact('semesters'));
    }

    /* USER (Teacher / Student) */
    public function createUser()
    {
        Auth::role('ADMIN') || die("Unauthorized");

        $programs  = (new Program())->all();
        $semesters = (new Semester())->all();

        if($_POST){
            (new User())->create($_POST);
            header("Location: /admin");
            exit;
        }

        $this->view('admin/user_create', compact('programs','semesters'));
    }
}

