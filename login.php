<?php
require 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :login");
    $stmt->execute([':login' => $login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        // Устанавливаем cookies на 30 дней
        setcookie('user_id', $user['id'], time() + 30*24*60*60, '/');
        setcookie('user_login', $user['login'], time() + 30*24*60*60, '/');
        setcookie('bg_color', $user['bg_color'], time() + 30*24*60*60, '/');
        setcookie('text_color', $user['text_color'], time() + 30*24*60*60, '/');
        header('Location: index.php');
        exit;
    } else {
        $error = "Неверный логин или пароль";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Вход</title></head>
<body>
    <h2>Вход в систему</h2>
    <?php if ($error): ?><p style="color:red"><?= $error ?></p><?php endif; ?>
    <form method="POST">
        <label>Логин: <input type="text" name="login" required></label><br><br>
        <label>Пароль: <input type="password" name="password" required></label><br><br>
        <button type="submit">Войти</button>
    </form>
    <p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
</body>
</html>