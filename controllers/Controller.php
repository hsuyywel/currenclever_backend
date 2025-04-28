<?php
class Controller {
    protected function getRequestData() {
        return json_decode(file_get_contents("php://input"), true);
    }

    protected function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }

    protected function errorResponse($message, $statusCode = 400) {
        $this->jsonResponse([
            'success' => false,
            'error' => $message
        ], $statusCode);
    }
}