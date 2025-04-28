<?php
require_once __DIR__ . '/../database.php';

class IncomeService {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function getIncomeByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT id, amount, currency, date, note FROM income WHERE user_email = ? ORDER BY date ASC");
        $stmt->execute([$email]);
        return $stmt->fetchAll();
    }

    public function createIncome($data) {
        $stmt = $this->pdo->prepare("INSERT INTO income (user_email, amount, currency, date, note) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['email'],
            $data['amount'],
            $data['currency'],
            $data['date'],
            $data['note'] ?? ''
        ]);
        return $stmt->rowCount() > 0;
    }

    public function updateIncome($data) {
        $stmt = $this->pdo->prepare("UPDATE income SET amount = ?, currency = ?, date = ?, note = ? WHERE id = ? AND user_email = ?");
        $stmt->execute([
            $data['amount'],
            $data['currency'],
            $data['date'],
            $data['note'] ?? '',
            $data['id'],
            $data['email']
        ]);
        return $stmt->rowCount() > 0;
    }
}