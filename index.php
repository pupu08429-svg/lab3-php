<?php
require 'config.php';

// Автоматическая авторизация по cookie
if (!isset($_COOKIE['user_id']) && !isset($_POST['login'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_COOKIE['user_id'] ?? null;
$user_login = $_COOKIE['user_login'] ?? 'Гость';
$bg_color = $_COOKIE['bg_color'] ?? '#ffffff';
$text_color = $_COOKIE['text_color'] ?? '#000000';

// Обработка смены настроек
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_settings'])) {
    $new_bg = $_POST['bg_color'] ?? '#ffffff';
    $new_text = $_POST['text_color'] ?? '#000000';
    
    $stmt = $pdo->prepare("UPDATE users SET bg_color = :bg, text_color = :text WHERE id = :id");
    $stmt->execute([':bg' => $new_bg, ':text' => $new_text, ':id' => $user_id]);
    
    setcookie('bg_color', $new_bg, time() + 30*24*60*60, '/');
    setcookie('text_color', $new_text, time() + 30*24*60*60, '/');
    
    $bg_color = $new_bg;
    $text_color = $new_text;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Личный кабинет</title>
    <style>
        body { background-color: <?= $bg_color ?>; color: <?= $text_color ?>; font-family: Arial; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; }
        form.settings { margin-top: 30px; padding: 15px; border: 1px solid #ccc; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Привет, <?= htmlspecialchars($user_login) ?>!</h2>
            <a href="logout.php">Выйти</a>
        </div>
        
        <p>Вы успешно авторизованы. Данные сохранены в cookies.</p>
        
        <form class="settings" method="POST">
            <h3>Настройки оформления</h3>
            <label>Цвет фона: <input type="color" name="bg_color" value="<?= $bg_color ?>"></label><br><br>
            <label>Цвет текста: <input type="color" name="text_color" value="<?= $text_color ?>"></label><br><br>
            <button type="submit" name="save_settings">Сохранить настройки</button>
        </form>
    </div>
</body>
</html>