<?php
require_once __DIR__ . '/../database.php';

class AuthService {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function login($email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return ["success" => true, "name" => $user['name']];
        }
        return ["success" => false, "error" => "Invalid credentials"];
    }

    public function signup($data) {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, phone, email, password, dob, occupation, university, company) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $success = $stmt->execute([
            $data['name'],
            $data['phone'] ?? null,
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['dob'] ?? null,
            $data['occupation'] ?? null,
            $data['university'] ?? null,
            $data['company'] ?? null
        ]);
        return ["success" => $success];
    }

    public function getUserByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT name, phone, email, dob, occupation, university, company FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
}