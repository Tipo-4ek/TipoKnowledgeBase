<?php

require('db.php');

// проверяем, была ли отправлена форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $password_repeat = $_POST['password_repeat'];

  // Проверяем, совпадают ли пароли
  if ($password != $password_repeat) {
    echo 'Пароли не совпадают';
  } else if ((strlen($password) < 3) or (strlen($username) < 3)) {
    echo 'Логин или пароль содержит менее 3 символов';
  } else {
    // хэшируем пароль
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // подготавливаем запрос и выполняем его
    try {
      $stmt = $conn->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
      $stmt->execute(['username' => $username, 'password' => $hashed_password]);
      echo "Новый пользователь успешно зарегистрирован";
    } catch(PDOException $e) {
      # echo 'Ошибка при регистрации: ' . $e->getMessage();
      echo 'Ошибка при регистрации';
    }
  }
}
?>