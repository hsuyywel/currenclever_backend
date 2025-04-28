<?php
require_once __DIR__ . '/Router.php';
require_once __DIR__ . '/../controllers/ExpenseController.php';
require_once __DIR__ . '/../controllers/IncomeController.php';
require_once __DIR__ . '/../controllers/AuthController.php';

$router = new Router();

// Welcome route
$router->addRoute('GET', '/api', function() {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'message' => 'Welcome to CurrenClever API',
        'version' => '1.0.0'
    ]);
});

// Expense routes
$router->addRoute('POST', '/api/expenses', [ExpenseController::class, 'handleExpense']);

// Income routes
$router->addRoute('POST', '/api/income', [IncomeController::class, 'handleIncome']);

// Auth routes
$router->addRoute('POST', '/api/login', [AuthController::class, 'login']);
$router->addRoute('POST', '/api/signup', [AuthController::class, 'signup']);
$router->addRoute('POST', '/api/user', [AuthController::class, 'getUser']);
$router->addRoute('GET', '/api/expenses', [ExpenseController::class, 'getExpenses']);

// Export the router instance
return $router;