<?php
require 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (strlen($login) < 3 || strlen($password) < 3) {
        $error = "Логин и пароль должны быть не короче 3 символов";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (login, password) VALUES (:login, :password)");
            $stmt->execute([
                ':login' => $login,
                ':password' => password_hash($password, PASSWORD_DEFAULT)
            ]);
            $success = "Регистрация успешна! <a href='login.php'>Войти</a>";
        } catch (PDOException $e) {
            $error = "Пользователь с таким логином уже существует";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Регистрация</title></head>
<body>
    <h2>Регистрация</h2>
    <?php if ($error): ?><p style="color:red"><?= $error ?></p><?php endif; ?>
    <?php if ($success): ?><p style="color:green"><?= $success ?></p><?php endif; ?>
    <form method="POST">
        <label>Логин: <input type="text" name="login" required></label><br><br>
        <label>Пароль: <input type="password" name="password" required></label><br><br>
        <button type="submit">Зарегистрироваться</button>
    </form>
    <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
</body>
</html>