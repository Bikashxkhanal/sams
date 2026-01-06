<?php
class Subject extends Model {

     public function create($semesterId,$name){
        $this->db->prepare(
            "INSERT INTO subjects(semester_id,name) VALUES(?,?)"
        )->execute([$semesterId,$name]);
    }
    public function bySemester($semesterId) {
        $q = $this->db->prepare(
            "SELECT * FROM subjects WHERE semester_id=?"
        );
        $q->execute([$semesterId]);
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }

public function getByTeacher($teacherId) {
    $stmt = $this->db->prepare("
        SELECT s.id, s.name, s.semester_id
        FROM subjects s
        JOIN teacher_subjects ts ON s.id = ts.subject_id
        WHERE ts.teacher_id = ?
        ORDER BY s.semester_id, s.name
    ");
    $stmt->execute([$teacherId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



}
