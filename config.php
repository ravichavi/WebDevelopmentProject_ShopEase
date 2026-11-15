<?php
declare(strict_types=1);
session_start();

define('BASE_URL', '/ShopEase_Fresh');
define('DB_HOST', 'localhost');
define('DB_NAME', 'shopease');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $pdo = new PDO(
        'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    http_response_code(500);
    exit('Database connection failed. Import database.sql in phpMyAdmin and check config.php settings.');
}
function url(string $path=''): string { return BASE_URL . '/' . ltrim($path, '/'); }
function h(?string $value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function money(float|int|string $amount): string { return '₹' . number_format((float)$amount, 2); }
function go(string $path): never { header('Location: '.url($path)); exit; }
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function verify_csrf(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(419); exit('Session expired. Please go back and try again.');
    }
}
function current_user(): ?array { return $_SESSION['user'] ?? null; }
function require_login(): void { if (!current_user()) go('login.php'); }
function cart_count(): int { return array_sum($_SESSION['cart'] ?? []); }
