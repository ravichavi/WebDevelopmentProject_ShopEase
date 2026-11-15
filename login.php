
<?php
require __DIR__ . '/config.php';

if (current_user()) {
    go('account.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    $u = $stmt->fetch();

    if ($u && password_verify($password, $u['password'])) {

        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id' => $u['id'],
            'name' => $u['name'],
            'email' => $u['email'],
            'role' => $u['role']
        ];

        go('account.php');

    } else {
        $error = 'Email or password is incorrect.';
    }
}

$pageTitle = 'Sign in';

require __DIR__ . '/includes/header.php';
?>

<div class="auth">

    <span class="eyebrow">GOOD TO SEE YOU</span>

    <h1>Sign in to ShopEase</h1>

    <?php if ($error): ?>
        <div class="notice"><?= h($error) ?></div>
    <?php endif; ?>

    <form method="post">

        <input type="hidden" name="csrf"
               value="<?= csrf_token() ?>">

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button class="btn full" type="submit">
            Sign in
        </button>

    </form>

    <p>
        New to ShopEase?
        <a href="<?= url('register.php') ?>">Create an account</a>
    </p>

</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
