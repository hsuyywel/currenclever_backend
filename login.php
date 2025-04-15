<?php
require 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'];
$password = $data['password'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
  echo json_encode(["success" => true, "user" => $user["name"]]);
} else {
  echo json_encode(["success" => false, "message" => "Invalid login"]);
}
?>
