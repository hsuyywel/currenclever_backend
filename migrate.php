<?php
require_once __DIR__ . '/database.php';

try {
    // Read the SQL file
    $sql = file_get_contents(__DIR__ . '/sql/create_tables.sql');
    
    // Split SQL file into individual statements
    $statements = array_filter(
        array_map(
            'trim',
            explode(';', $sql)
        )
    );
    
    // Execute each statement
    foreach ($statements as $statement) {
        if (!empty($statement)) {
            $pdo->exec($statement);
            echo "Executed: " . substr($statement, 0, 50) . "...\n";
        }
    }
    
    echo "\nDatabase migration completed successfully!\n";
    
} catch (PDOException $e) {
    die("Migration failed: " . $e->getMessage() . "\n");
}