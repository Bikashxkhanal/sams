<?php 
class Program extends Model {
    public function all(){
        return $this->db->query("SELECT * FROM programs")->fetchAll();
    }
    public function create($name){
        $this->db->prepare("INSERT INTO programs(name) VALUES(?)")
                 ->execute([$name]);
    }
}
