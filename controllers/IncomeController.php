<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../services/IncomeService.php';

class IncomeController extends Controller {
    private $incomeService;

    public function __construct() {
        $this->incomeService = new IncomeService();
    }

    public function handleIncome() {
        $data = $this->getRequestData();
        
        if (!isset($data['email'])) {
            return $this->errorResponse("Email is required");
        }

        try {
            if (!isset($data['amount'])) {
                return $this->getIncome($data['email']);
            }

            if (!$this->validateIncomeData($data)) {
                return $this->errorResponse("Amount, currency and date are required.");
            }

            if (isset($data['id'])) {
                return $this->updateIncome($data);
            }

            return $this->createIncome($data);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    private function getIncome($email) {
        $income = $this->incomeService->getIncomeByEmail($email);
        return $this->jsonResponse([
            "success" => true,
            "income" => $income
        ]);
    }

    private function createIncome($data) {
        $result = $this->incomeService->createIncome($data);
        return $this->jsonResponse([
            "success" => $result,
            "message" => $result ? "Income added successfully" : "Failed to add income"
        ]);
    }

    private function updateIncome($data) {
        $result = $this->incomeService->updateIncome($data);
        return $this->jsonResponse([
            "success" => $result,
            "message" => $result ? "Income updated successfully" : "No changes made"
        ]);
    }

    private function validateIncomeData($data) {
        return isset($data['amount']) && 
               isset($data['currency']) && 
               isset($data['date']);
    }
}