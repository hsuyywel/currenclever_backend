<?php
// Enable error logging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', '/tmp/php-error.log');

// Log the error
error_log("502 Error occurred: " . print_r($_SERVER, true));

header('Content-Type: application/json');
http_response_code(502);
echo json_encode([
    'error' => 'Bad Gateway',
    'message' => 'The server encountered a temporary error and could not complete your request',
    'debug' => [
        'server' => $_SERVER['SERVER_SOFTWARE'] ?? 'unknown',
        'request_uri' => $_SERVER['REQUEST_URI'] ?? 'unknown',
        'request_method' => $_SERVER['REQUEST_METHOD'] ?? 'unknown'
    ]
]);