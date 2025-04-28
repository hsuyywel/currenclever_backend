<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../services/ExpenseService.php';

class ExpenseController extends Controller {
    private $expenseService;

    public function __construct() {
        $this->expenseService = new ExpenseService();
    }

    public function handleExpense() {
        $data = $this->getRequestData();
        
        if (!isset($data['email'])) {
            return $this->errorResponse("Email is required");
        }

        try {
            if (!isset($data['amount'])) {
                return $this->getExpenses($data['email']);
            }

            if (!$this->validateExpenseData($data)) {
                return $this->errorResponse("Amount, currency, date, and category are required.");
            }

            if (isset($data['id'])) {
                return $this->updateExpense($data);
            }

            return $this->createExpense($data);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    private function getExpenses($email) {
        $expenses = $this->expenseService->getExpensesByEmail($email);
        return $this->jsonResponse([
            "success" => true,
            "expenses" => $expenses
        ]);
    }

    private function createExpense($data) {
        $result = $this->expenseService->createExpense($data);
        return $this->jsonResponse([
            "success" => $result,
            "message" => $result ? "Expense added successfully." : "Failed to add expense."
        ]);
    }

    private function updateExpense($data) {
        $result = $this->expenseService->updateExpense($data);
        return $this->jsonResponse([
            "success" => $result,
            "message" => $result ? "Expense updated successfully" : "No changes made"
        ]);
    }

    private function validateExpenseData($data) {
        return isset($data['amount']) && 
               isset($data['currency']) && 
               isset($data['date']) && 
               isset($data['category']);
    }
}