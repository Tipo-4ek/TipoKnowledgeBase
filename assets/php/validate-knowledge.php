<?php

require_once 'db.php';


if (isset($_POST['knowledgeId']) && is_numeric($_POST['knowledgeId'])) {
    $knowledgeId = $_POST['knowledgeId'];

    $sql = "UPDATE knowledge SET isValid = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);

    $stmt->execute([$knowledgeId]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Знание успешно одобрено.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка обновления или знание уже одобрено.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Некорректный идентификатор знания.']);
}
?>