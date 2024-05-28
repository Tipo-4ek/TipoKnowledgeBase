<?php

require("db.php");
$auth_valid = null;
$secretKey = 'secret_key';
$userId = $_COOKIE['user_id'] ?? null;
$signature = $_COOKIE['signature'] ?? null;
if ($userId && $signature) {
    $auth_valid = hash_equals(hash_hmac('sha256', $userId, $secretKey), $signature);
}

if ($auth_valid) {
    // Пользователь авторизован
    $stmt = $conn->prepare('SELECT avatar_path, username, id FROM users WHERE id = :id');
    $stmt->execute(['id' => $userId]);
    $user = $stmt->fetch();
    $userId = $user['id'];
    $username = $user['username'];
    $avatar_path = $user['avatar_path'];
} else {
    // Пользователь не авторизован
    $username = 'Guest';
    $avatar_path = '/assets/img/avatars/default.jpg';
}

?>