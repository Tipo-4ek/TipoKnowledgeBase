<?php
include 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM knowledge WHERE id = ?");
        
        // Выполнение запроса с подстановкой значений
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Нет такой записи.']);
        }
    } catch (PDOException $e) {        
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {    
    echo json_encode(['success' => false, 'error' => 'Некорректный запрос.']);
}
?>