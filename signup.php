<?php
require 'database.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Only process if it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit; // do nothing if accessed by browser or GET
}

$data = json_decode(file_get_contents("php://input"), true);

// Basic check to avoid null rows
if (!isset($data['name']) || !isset($data['email']) || !isset($data['password'])) {
    exit;
}

// DEBUG LOG
file_put_contents("debug_input.txt", json_encode($data));

try {
    $stmt = $pdo->prepare("INSERT INTO users (name, phone, email, password, dob, occupation, university, company) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['name'],
        $data['phone'],
        $data['email'],
        password_hash($data['password'], PASSWORD_DEFAULT),
        $data['dob'],
        $data['occupation'],
        $data['university'] ?? null,
        $data['company'] ?? null
    ]);

    echo json_encode(["success" => true]);
} catch (PDOException $e) {
    file_put_contents("signup_error.txt", $e->getMessage());
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
