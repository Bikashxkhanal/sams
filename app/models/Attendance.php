<?php
class Attendance {
    private $db;
    public function __construct() {
        $this->db = Database::connect();
    }

   public function mark($studentId, $subjectId, $status) {
    // Check if attendance already exists for today
    $stmt = $this->db->prepare("
        SELECT id FROM attendance 
        WHERE student_id = ? AND subject_id = ? AND DATE(date) = CURDATE()
    ");
    $stmt->execute([$studentId, $subjectId]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        // Update existing record instead of inserting duplicate
        $stmt = $this->db->prepare("
            UPDATE attendance SET status = ?, date = NOW() WHERE id = ?
        ");
        return $stmt->execute([$status, $existing['id']]);
    } else {
        // Insert new record
        $stmt = $this->db->prepare("
            INSERT INTO attendance (student_id, subject_id, status, date) 
            VALUES (?, ?, ?, NOW())
        ");
        return $stmt->execute([$studentId, $subjectId, $status]);
    }
}


    public function report($studentId) {
        $stmt = $this->db->prepare("
            SELECT a.*, s.name as subject_name
            FROM attendance a
            JOIN subjects s ON a.subject_id = s.id
            WHERE a.student_id = ?
            ORDER BY a.date DESC
        ");
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function getByTeacher($teacherId) {
    $stmt = $this->db->prepare("
        SELECT 
            a.id AS attendance_id,
            a.date,
            a.status,
            s.id AS subject_id,
            s.name AS subject_name,
            u.id AS student_id,
            u.name AS student_name
        FROM attendance a
        JOIN subjects s ON a.subject_id = s.id
        JOIN teacher_subjects ts ON s.id = ts.subject_id
        JOIN users u ON a.student_id = u.id
        WHERE ts.teacher_id = ?
        ORDER BY s.semester_id, s.name, u.name, a.date DESC
    ");
    $stmt->execute([$teacherId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Attendance.php
    public function getTodayCountsBySubject($subjectId) {
        $stmt = $this->db->prepare("
            SELECT status, COUNT(*) AS count
            FROM attendance
            WHERE subject_id = ? AND DATE(date) = CURDATE()
            GROUP BY status
        ");
        $stmt->execute([$subjectId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = ['PRESENT'=>0,'ABSENT'=>0];
        foreach($results as $r){
            $data[$r['status']] = $r['count'];
        }
        return $data;
    }

    // Get attendance counts between two dates
    public function getCountsByDateRange($subjectId, $from, $to) {
        $stmt = $this->db->prepare("
            SELECT DATE(date) as day, status, COUNT(*) as count
            FROM attendance
            WHERE subject_id = ? AND DATE(date) BETWEEN ? AND ?
            GROUP BY day, status
            ORDER BY day
        ");
        $stmt->execute([$subjectId, $from, $to]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Format as [date => ['PRESENT'=>x,'ABSENT'=>y]]
        $data = [];
        foreach($results as $r){
            $day = $r['day'];
            if(!isset($data[$day])) $data[$day] = ['PRESENT'=>0,'ABSENT'=>0];
            $data[$day][$r['status']] = $r['count'];
        }
        return $data;
    }

    // Get total students for a subject
 public function getTotalStudents($subjectId) {
    // Get semester of this subject
    $stmt = $this->db->prepare("SELECT semester_id FROM subjects WHERE id = ?");
    $stmt->execute([$subjectId]);
    $semesterId = $stmt->fetch(PDO::FETCH_ASSOC)['semester_id'] ?? null;

    if(!$semesterId) return 0;

    // Map semester_id to email prefix (example: CSIT1 -> csit1_)
    $prefixMap = [
        1 => 'csit1_',
        2 => 'csit2_',
        3 => 'bba1_'
    ];

    $prefix = $prefixMap[$semesterId] ?? '';

    if(!$prefix) return 0;

    // Count students whose email matches the prefix
    $stmt2 = $this->db->prepare("SELECT COUNT(*) as total 
                                 FROM users 
                                 WHERE role='STUDENT' AND email LIKE ?");
    $stmt2->execute([$prefix.'%']);
    return $stmt2->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
}

 public function getTodayAttendance($subjectId) {
        $stmt = $this->db->prepare("
            SELECT a.student_id, u.name AS student_name, a.status
            FROM attendance a
            JOIN users u ON a.student_id = u.id
            WHERE a.subject_id = ? AND a.date = CURDATE()
        ");
        $stmt->execute([$subjectId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get students for a subject
    public function getStudentsBySubject($subjectId) {
    $stmt = $this->db->prepare("
        SELECT u.id, u.name
        FROM users u
        JOIN subjects s ON u.semester_id = s.semester_id
        WHERE s.id = ?
        AND u.role = 'STUDENT'
    ");
    $stmt->execute([$subjectId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getTodayBySubject($subjectId, $date)
{
    $stmt = $this->db->prepare("
        SELECT a.status, u.name AS student_name
        FROM attendance a
        JOIN users u ON u.id = a.student_id
        WHERE a.subject_id = ?
          AND a.date = ?
    ");
    $stmt->execute([$subjectId, $date]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

  public function getTodaySummary() {
        $today = date('Y-m-d');

        $stmt = $this->db->prepare("
            SELECT status, COUNT(*) as count
            FROM attendance
            WHERE date = ?
            GROUP BY status
        ");
        $stmt->execute([$today]);

        $result = ['PRESENT'=>0, 'ABSENT'=>0];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[$row['status']] = (int)$row['count'];
        }

        return $result;
    }

    /**
     * Get attendance summary by date range
     * Returns array keyed by date: ['2026-01-01'=>['PRESENT'=>x,'ABSENT'=>y], ...]
     */
    public function getSummaryByDate($from=null, $to=null) {
        $from = $from ?? date('Y-m-d', strtotime('-7 days'));
        $to   = $to ?? date('Y-m-d');

        $stmt = $this->db->prepare("
            SELECT date,
                   SUM(CASE WHEN status='PRESENT' THEN 1 ELSE 0 END) AS PRESENT,
                   SUM(CASE WHEN status='ABSENT' THEN 1 ELSE 0 END) AS ABSENT
            FROM attendance
            WHERE date BETWEEN ? AND ?
            GROUP BY date
            ORDER BY date ASC
        ");
        $stmt->execute([$from, $to]);

        $summary = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $summary[$row['date']] = [
                'PRESENT' => (int)$row['PRESENT'],
                'ABSENT'  => (int)$row['ABSENT']
            ];
        }

        return $summary;
    }


    // Mark attendance}
}


