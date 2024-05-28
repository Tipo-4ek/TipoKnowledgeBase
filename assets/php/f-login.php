<?php
require('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Препарируем и выполняем запрос к БД
    try {
        $stmt = $conn->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);

        $user = $stmt->fetch();

        // Проверяем существует ли пользователь и является ли пароль верным
        if ($user && password_verify($password, $user['password'])) {
            // Если все верное, создаем куки и сохраняем ID пользователя и подпись.
            $secretKey = 'secret_key';
            $userId = $user['id'];
            $signature = hash_hmac('sha256', $userId, $secretKey);
            setcookie('user_id', $userId, time() + 3600, '/', '', true, true);
            setcookie('signature', $signature, time() + 3600, '/', '', true, true);
            echo '200';
        } else {
            echo '403';
        }

    } catch(PDOException $e) {
        echo '403';
    }
}
?>