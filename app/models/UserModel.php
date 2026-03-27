<?php
require_once __DIR__ . '/../../config/database.php';

class UserModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function register($username, $password, $fullName) {
        $query = "INSERT INTO users (username, password, full_name)
                  VALUES (:username, :password, :full_name)";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':username' => $username,
            ':password' => $password,
            ':full_name' => $fullName
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

    public function updateProfile($id, $fullName, $bio) {
        $query = "UPDATE users
                  SET full_name = :full_name, bio = :bio
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':full_name' => $fullName,
            ':bio' => $bio,
            ':id' => $id
        ]);
    }

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
        $query = "SELECT id, username, full_name, profile_pic, bio, last_active
                  FROM users
                  WHERE username LIKE :keyword OR full_name LIKE :keyword
                  ORDER BY full_name ASC, username ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':keyword' => '%' . $keyword . '%'
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllUsersExcept($userId) {
        $query = "SELECT id, username, full_name, profile_pic, last_active
                  FROM users
                  WHERE id != :user_id
                  ORDER BY last_active DESC, username ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':user_id' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
