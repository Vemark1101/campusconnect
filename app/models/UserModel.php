<?php
require_once __DIR__ . '/../../config/database.php';

class UserModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function register($username, $password, $full_name) {
        $query = "INSERT INTO users (username, password, full_name) 
                  VALUES (:username, :password, :full_name)";
        
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':username' => $username,
            ':password' => $password,
            ':full_name' => $full_name
        ]);
    }

    public function findByUsername($username) {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id, $full_name, $bio) {
        $query = "UPDATE users SET full_name = :full_name, bio = :bio WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':full_name' => $full_name,
            ':bio' => $bio,
            ':id' => $id
        ]);
    }

    // ✅ SAVE PROFILE PIC
    public function updateProfilePic($id, $filename) {
        $query = "UPDATE users SET profile_pic = :pic WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':pic' => $filename,
            ':id' => $id
        ]);
    }

    public function updateLastActive($id) {
        $query = "UPDATE users SET last_active = NOW() WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);
    }

    public function search($keyword) {
        $query = "SELECT id, username, full_name 
                  FROM users 
                  WHERE username LIKE :keyword 
                  OR full_name LIKE :keyword";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':keyword' => "%$keyword%"
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllUsersExcept($userId) {
        $stmt = $this->conn->prepare("SELECT id, username, last_active FROM users WHERE id != ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}