
<?php
require __DIR__ . '/config.php';

// If user is already logged in
if (current_user()) {
    go('account.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    verify_csrf();

    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $pass = $_POST['password'] ?? '';

    // Validate input
    if (
        $name === '' ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        strlen($pass) < 8
    ) {
        $error = 'Enter your name, a valid email and a password of at least 8 characters.';

    } else {

        try {

            // Insert new customer
            $stmt = $pdo->prepare(
                "INSERT INTO users (name, email, password)
                 VALUES (?, ?, ?)"
            );

            $stmt->execute([
                $name,
                $email,
                password_hash($pass, PASSWORD_DEFAULT)
            ]);

            // Create user session
            $_SESSION['user'] = [
                'id' => (int)$pdo->lastInsertId(),
                'name' => $name,
                'email' => $email,
                'role' => 'customer'
            ];

            // Redirect to account page
            go('account.php');

        } catch (PDOException $e) {

            $error = 'This email may already be registered.';
        }
    }
}

$pageTitle = 'Create account';

require __DIR__ . '/includes/header.php';
?>

<div class="auth">

    <span class="eyebrow">WELCOME TO SHOEASE</span>

    <h1>Create your account</h1>

    <?php if ($error): ?>
        <div class="notice">
            <?= h($error) ?>
        </div>
    <?php endif; ?>

    <form method="post">

        <input
            type="hidden"
            name="csrf"
            value="<?= csrf_token() ?>"
        >

        <label>Full name</label>

        <input
            type="text"
            name="name"
            placeholder="Enter your full name"
            required
        >

        <label>Email</label>

        <input
            type="email"
            name="email"
            placeholder="Enter your email"
            required
        >

        <label>Password</label>

        <input
            type="password"
            name="password"
            placeholder="Minimum 8 characters"
            minlength="8"
            required
        >

        <button class="btn full" type="submit">
            Create account
        </button>

    </form>

    <p>
        Already have an account?
        <a href="<?= url('login.php') ?>">Sign in</a>
    </p>

</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
