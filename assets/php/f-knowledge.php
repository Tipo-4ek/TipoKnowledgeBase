<?php


#$knowledgeId = $_GET['id'] ?? '';

function getKnowledge($knowledgeId, $userId) {
    global $conn;
    
    // Выбираем section_id для переданного knowledgeId
    $stmt = $conn->prepare("SELECT section_id FROM knowledge WHERE id = ?");
    $stmt->execute([$knowledgeId]);
    $sectionId = $stmt->fetchColumn();
    
    if ($sectionId) {
        // Проверяем, есть ли у пользователя доступ к этой секции
        $accessStmt = $conn->prepare("SELECT 1 FROM user_sections WHERE user_id = ? AND section_id = ?");
        $accessStmt->execute([$userId, $sectionId]);
        $userAccess = $accessStmt->fetchColumn();
        
        if ($userAccess) {
            $stmt = $conn->prepare("SELECT * FROM knowledge WHERE id = ?");
            $stmt->execute([$knowledgeId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    
    // Если нет доступа или sectionId не найден, возвращаем пустой результат
    return [["title" => "Упс..Такое знание отсутсвует или у вас нет к нему доступа"]];
}
function generateBreadcrumbs($knowledgeId) {
    global $conn;
    
    // Начальный запрос для получения section_id для знания
    $stmt = $conn->prepare("SELECT section_id FROM knowledge WHERE id = ?");
    $stmt->execute([$knowledgeId]);
    $sectionId = $stmt->fetch(PDO::FETCH_ASSOC)['section_id'];
    
    $breadcrumbs = [];
    
    while($sectionId) {
        $stmt = $conn->prepare("SELECT id, name, parent_id FROM sections WHERE id = :sectionId");
        $stmt->execute(['sectionId' => $sectionId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        array_unshift($breadcrumbs, $result['name']);
        $sectionId = $result['parent_id'];
    }
    
    print_console(implode(" -> ", $breadcrumbs));
    return $breadcrumbs;
}
