<?php
require_once __DIR__ . '/../database.php';

class ExpenseService {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function getExpensesByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT id, amount, currency, date, category, note FROM expenses WHERE user_email = ? ORDER BY date ASC");
        $stmt->execute([$email]);
        return $stmt->fetchAll();
    }

    public function createExpense($data) {
        $stmt = $this->pdo->prepare("INSERT INTO expenses (user_email, amount, currency, date, category, note) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['email'],
            $data['amount'],
            $data['currency'],
            $data['date'],
            $data['category'],
            $data['note'] ?? ''
        ]);
        return $stmt->rowCount() > 0;
    }

    public function updateExpense($data) {
        $stmt = $this->pdo->prepare("UPDATE expenses SET amount = ?, currency = ?, date = ?, category = ?, note = ? WHERE id = ? AND user_email = ?");
        $stmt->execute([
            $data['amount'],
            $data['currency'],
            $data['date'],
            $data['category'],
            $data['note'] ?? '',
            $data['id'],
            $data['email']
        ]);
        return $stmt->rowCount() > 0;
    }
}