<?php
file_put_contents("signup_log.txt", file_get_contents("php://input"));

// database.php should establish a connection to your MySQL database
require 'database.php';
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

// Retrieve JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);

// Extract individual fields
$name = $data['name'];
$phone = $data['phone'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);
$dob = $data['dob'] ?? null;
$occupation = $data['occupation'];
$university = $data['university'] ?? null;
$company = $data['company'] ?? null;

try {
    // Prepare and execute the SQL statement
    $stmt = $pdo->prepare("INSERT INTO users (name, phone, email, password, dob, occupation, university, company) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $phone, $email, $password, $dob, $occupation, $university, $company]);

    echo json_encode(["success" => true]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
