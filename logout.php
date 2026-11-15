
<?php
require __DIR__ . '/config.php';

// Clear login session
unset($_SESSION['user']);

// Regenerate session ID
session_regenerate_id(true);

// Redirect to homepage
header('Location: ' . url('index.php'));
exit;
