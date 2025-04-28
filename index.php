<?php
require_once __DIR__ . '/env_loader.php';
require_once __DIR__ . '/database.php';
$router = require_once __DIR__ . '/routes/api.php';

// Enable error reporting for development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Server information logging
$startTime = date('Y-m-d H:i:s');
error_log("🚀 Server started at: $startTime");
error_log("📡 Port: " . ($_ENV['PORT'] ?: '8000'));
error_log("📦 PHP v" . phpversion());

// CORS and content type headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Handle OPTIONS preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Handle routing
$request_uri = strtok($_SERVER['REQUEST_URI'], '?');
$router->handleRequest($request_uri, $_SERVER['REQUEST_METHOD']);