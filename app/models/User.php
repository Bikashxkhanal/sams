<?php
class User {
    private $db;
    public function __construct() {
        $this->db = Database::connect();
    }

    public function login($email, $password) {
    $q = $this->db->prepare("SELECT * FROM users WHERE email=?");
    $q->execute([$email]);
    $u = $q->fetch(PDO::FETCH_ASSOC);

    // Hash input with MD5 for comparison
    return ($u && md5($password) === $u['password']) ? $u : false;
}
public function getAllStudents() {
    $stmt = $this->db->prepare("SELECT id, name FROM users WHERE role = 'STUDENT' ORDER BY name");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

  public function create($data){
        $this->db->prepare("
            INSERT INTO users(name,email,password,role)
            VALUES(?,?,?,?)
        ")->execute([
            $data['name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['role']
        ]);
    }

      public function getByRole($role){
        $q = $this->db->prepare("SELECT * FROM users WHERE role=?");
        $q->execute([$role]);
        return $q->fetchAll();
    }

}
