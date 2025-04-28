<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../services/AuthService.php';

class AuthController extends Controller {
    private $authService;

    public function __construct() {
        $this->authService = new AuthService();
    }

    public function login() {
        $data = $this->getRequestData();
        
        if (!isset($data['email']) || !isset($data['password'])) {
            return $this->errorResponse("Email and password are required");
        }

        try {
            $result = $this->authService->login($data['email'], $data['password']);
            return $this->jsonResponse($result);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function signup() {
        $data = $this->getRequestData();
        
        if (!isset($data['name']) || !isset($data['email']) || !isset($data['password'])) {
            return $this->errorResponse("Name, email and password are required");
        }

        try {
            $result = $this->authService->signup($data);
            return $this->jsonResponse($result);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function getUser() {
        $data = $this->getRequestData();
        
        if (!isset($data['email'])) {
            return $this->errorResponse("Email is required");
        }

        try {
            $user = $this->authService->getUserByEmail($data['email']);
            return $this->jsonResponse([
                "success" => true,
                "user" => $user
            ]);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}