<?php
class Enrollment extends Model {
    public function studentsBySemester($semesterId) {
        $q = $this->db->prepare(
            "SELECT u.id,u.name FROM users u
             JOIN enrollments e ON e.student_id=u.id
             WHERE e.semester_id=?"
        );
        $q->execute([$semesterId]);
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }
}
