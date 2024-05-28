<?php


include ("f-auth.php");
function suggestKnowledge($searchTerm, $userId) {
    global $conn;

    // Проверяем доступ к секциям для пользователя и осуществляем поиск только по тем знаниям, к которым у пользователя есть доступ
    $stmt = $conn->prepare("
        SELECT knowledge.* 
        FROM knowledge 
        JOIN user_sections ON knowledge.section_id = user_sections.section_id
        WHERE user_sections.user_id = ? AND knowledge.title LIKE ?
    ");
    $searchTerm = "%" . $searchTerm . "%";
    $stmt->execute([$userId, $searchTerm]);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

require_once 'f-common.php';

if ($auth_valid) {
    $data = json_decode(file_get_contents('php://input'), true);    
    if (isset($data['search']) && $userId) {
        $results = suggestKnowledge($data['search'], $userId);
        header('Content-Type: application/json');
        echo json_encode($results);
    } else {
        http_response_code(400);
    }
}
else {
    http_response_code(403);
    echo json_encode(["error" => "forbidden"]);
}


?>