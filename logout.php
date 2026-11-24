<?php
if (isset($_COOKIE['user_id'])) {
    setcookie('user_id', '', time() - 3600, '/');
    setcookie('user_login', '', time() - 3600, '/');
    setcookie('bg_color', '', time() - 3600, '/');
    setcookie('text_color', '', time() - 3600, '/');
}
header('Location: login.php');
exit;
?>