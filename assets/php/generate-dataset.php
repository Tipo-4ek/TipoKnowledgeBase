<?php
require_once 'db.php';  // Указанный путь к файлу с подключением к базе данных

header('Content-Type: text/plain');

$query = "SELECT problem, solution, rating, user_name FROM knowledge WHERE isValid = 1 AND used = 0";

// Подготовка и выполнение запроса
$stmt = $conn->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Создание файла
$fileName = 'dataset_new.jsonl';
$file = fopen($fileName, 'w'); 

// Формирование данных в формате JSON Lines и запись в файл
foreach ($results as $row) {
    $data = [
        "messages" => [
            ["role" => "system", "content" => "Чат-бот помогает отвечать пользователям от имени сервиса на отзывы о мобильном приложении. Пользователя зовут ".$row['user_name'].", он поставил нам оценку ".$row['rating']],
            ["role" => "user", "content" => $row['problem']],
            ["role" => "assistant", "content" => $row['solution']]
        ]
    ];
    fwrite($file, json_encode($data, JSON_UNESCAPED_UNICODE) . "\n");
}
fclose($file);

$query = "UPDATE knowledge  SET used=1 WHERE isValid = 1 AND used = 0";

// Подготовка и выполнение запроса
$stmt = $conn->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Отправка файла пользователю
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($fileName).'"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($fileName));
readfile($fileName);

// Удаление файла после скачивания
unlink($fileName);
?>
