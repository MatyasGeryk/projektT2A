<?php
declare(strict_types=1);

session_start();

// Cesty
define('ROOT_DIR', dirname(__DIR__));
define('SRC_DIR', ROOT_DIR . '/src');
define('DATABASE_DIR', ROOT_DIR . '/database');

// Database configuration
define('DB_PATH', DATABASE_DIR . '/eshop.db');

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Initialize order data if not exists
if (!isset($_SESSION['order_data'])) {
    $_SESSION['order_data'] = [];
}

// Autoloader for classes
spl_autoload_register(function ($class) {
    $parts = explode('\\', $class);
    $file = SRC_DIR . '/' . implode('/', $parts) . '.php';
    
    if (file_exists($file)) {
        require_once $file;
    }
});

// Load database initialization
if (!file_exists(DB_PATH)) {
    require_once DATABASE_DIR . '/init.php';
    initDatabase();
}
?>
