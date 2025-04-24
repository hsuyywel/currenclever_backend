<?php
// ✅ Enable error reporting for development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ✅ CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// ✅ Handle OPTIONS preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(204);
  exit;
}

// ✅ JSON header
header("Content-Type: application/json");

// ✅ Include DB connection
include("database.php");

// ✅ Decode incoming JSON payload
$data = json_decode(file_get_contents("php://input"), true);
$email = $data["email"] ?? null;

if (!$email) {
  echo json_encode(["success" => false, "error" => "Email is required"]);
  exit;
}

try {
  if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $id = $data["id"] ?? null;
    $amount = $data["amount"] ?? null;
    $currency = $data["currency"] ?? null;
    $date = $data["date"] ?? null;
    $note = $data["note"] ?? "";
    $category = $data["category"] ?? "";

    // ✅ Fetch request
    if (!$amount && !$id) {
      $stmt = $pdo->prepare("SELECT id, amount, currency, date, category, note FROM expenses WHERE user_email = ? ORDER BY date ASC");
      $stmt->execute([$email]);
      $expenses = $stmt->fetchAll();

      echo json_encode(["success" => true, "expenses" => $expenses]);
      exit;
    }

    // ✅ Required field validation
    if (!$amount || !$currency || !$date || !$category) {
      echo json_encode(["success" => false, "error" => "Amount, currency, date, and category are required."]);
      exit;
    }

    // ✅ Update record
    if ($id) {
      $stmt = $pdo->prepare("UPDATE expenses SET amount = ?, currency = ?, date = ?, category = ?, note = ? WHERE id = ? AND user_email = ?");
      $stmt->execute([$amount, $currency, $date, $category, $note, $id, $email]);

      echo json_encode([
        "success" => $stmt->rowCount() > 0,
        "message" => $stmt->rowCount() > 0 ? "Expense updated successfully" : "No changes made"
      ]);
      exit;
    }

    // ✅ Insert new record
    $stmt = $pdo->prepare("INSERT INTO expenses (user_email, amount, currency, date, category, note) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$email, $amount, $currency, $date, $category, $note]);

    echo json_encode([
      "success" => $stmt->rowCount() > 0,
      "message" => $stmt->rowCount() > 0 ? "Expense added successfully." : "Failed to add expense."
    ]);
    exit;
  } else {
    echo json_encode(["success" => false, "error" => "Invalid request method"]);
    exit;
  }
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode([
    "success" => false,
    "error" => "Database error",
    "details" => $e->getMessage() 
  ]);
  exit;
}
?>
