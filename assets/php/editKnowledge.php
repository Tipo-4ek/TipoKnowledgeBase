<?php
require("db.php");
header('Content-Type: application/json');

$knowledgeId = $_POST['knowledgeId'];

$textToUpdate = '';
$columnToUpdate = '';

if (isset($_POST['problemText'])) {
    $columnToUpdate = 'problem';
    $textToUpdate = $_POST['problemText'];
} elseif (isset($_POST['solutionText'])) {
    $columnToUpdate = 'solution';
    $textToUpdate = $_POST['solutionText'];
}
// max len
if (strlen($textToUpdate) > 50000) {
    echo json_encode(['success' => false, 'error' => 'Текст не должен превышать 50,000 символов.']);
    exit;
}

// param exist
if (empty($knowledgeId) || !$columnToUpdate) {
    echo json_encode(['success' => false, 'error' => 'Не заданы обязательные поля.']);
    exit;
}

// update db
try {
    $sql = "UPDATE knowledge SET $columnToUpdate = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$textToUpdate, $knowledgeId]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Не удалось обновить данные или данные уже изменены.']);
    }
} catch(PDOException $e){
    echo json_encode(['success' => false, 'error' => 'Ошибка базы данных: ' . $e->getMessage()]);
}
?>
