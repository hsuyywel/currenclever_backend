<?php
// ✅ Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ✅ CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(204);
  exit;
}

header("Content-Type: application/json");
include("database.php"); // ✅ this defines $pdo (not $conn)

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), true);

// Validate email
$user_email = $data["email"] ?? null;
if (!$user_email) {
  echo json_encode(["success" => false, "error" => "Email is required"]);
  exit;
}

if ($method === "POST") {
  $id = $data["id"] ?? null;
  $amount = $data["amount"] ?? null;
  $currency = $data["currency"] ?? null;
  $date = $data["date"] ?? null;
  $note = $data["note"] ?? "";

  if (!$amount && !$id) {
    // ✅ FETCH income
    $stmt = $pdo->prepare("SELECT id, amount, currency, date, note FROM income WHERE user_email = ? ORDER BY date ASC");
    $stmt->execute([$user_email]);
    $income = $stmt->fetchAll();
    echo json_encode(["success" => true, "income" => $income]);
    exit;
  }

  if (!$amount || !$currency || !$date) {
    echo json_encode(["success" => false, "error" => "Amount, currency and date are required."]);
    exit;
  }

  if ($id) {
    // ✅ UPDATE income
    $stmt = $pdo->prepare("UPDATE income SET amount = ?, currency = ?, date = ?, note = ? WHERE id = ? AND user_email = ?");
    $success = $stmt->execute([$amount, $currency, $date, $note, $id, $user_email]);
    echo json_encode([
      "success" => $success,
      "message" => $success ? "Income updated successfully" : "No changes made"
    ]);
    exit;
  } else {
    // ✅ INSERT income
    $stmt = $pdo->prepare("INSERT INTO income (user_email, amount, currency, date, note) VALUES (?, ?, ?, ?, ?)");
    $success = $stmt->execute([$user_email, $amount, $currency, $date, $note]);
    echo json_encode([
      "success" => $success,
      "message" => $success ? "Income added successfully" : "Failed to add income"
    ]);
    exit;
  }
} else {
  echo json_encode(["success" => false, "error" => "Invalid request method"]);
  exit;
}
?>
