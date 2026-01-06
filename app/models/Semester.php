<?php
class Semester extends Model {
    public function byProgram($programId) {
        $q = $this->db->prepare(
            "SELECT * FROM semesters WHERE program_id=?"
        );
        $q->execute([$programId]);
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }

   
    public function all(){
        return $this->db->query("SELECT * FROM semesters")->fetchAll();
    }
    public function create($programId,$name){
        $this->db->prepare(
            "INSERT INTO semesters(program_id,name) VALUES(?,?)"
        )->execute([$programId,$name]);
    }
}

