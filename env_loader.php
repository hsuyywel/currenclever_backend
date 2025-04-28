<?php
function loadEnv($path) {
    // If .env file exists, load it
    if(file_exists($path)) {
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '#') === 0) continue;
            
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            
            if (!array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
            }
        }
    }
    
    // Ensure required environment variables are set
    $required_vars = ['DB_HOST', 'DB_PORT', 'DB_NAME', 'DB_USER', 'DB_PASS', 'DB_CHARSET'];
    foreach ($required_vars as $var) {
        if (!isset($_ENV[$var]) && getenv($var)) {
            $_ENV[$var] = getenv($var);
        }
    }
}