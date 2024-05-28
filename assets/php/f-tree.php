<?php

require_once 'db.php';
$search_query = $_GET['search'] ?? ''; // Получаем поисковый запрос из GET-параметров

// Получаем дерево знаний
function isAccessible($userId, $sectionId) {
    global $conn;

    $accessStmt = $conn->prepare("SELECT 1 FROM user_sections WHERE user_id = ? AND section_id = ?");
    $accessStmt->execute([$userId, $sectionId]);

    if ($accessStmt->fetchColumn()) {
        // Если есть доступ к самому разделу
        return true;
    }

    // Проверяем подразделы
    $subSectionsStmt = $conn->prepare("SELECT id FROM sections WHERE parent_id = ?");
    $subSectionsStmt->execute([$sectionId]);
    $subSections = $subSectionsStmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($subSections as $subSection) {
        if (isAccessible($userId, $subSection['id'])) {
            return true;
        }
    }

    // Аксесса нет ни к самому разделу, ни к его подразделам
    return false;
}

function getKnowledgeTree($userId, $parentId = null) {
    global $conn;

    $sectionsStmt = $conn->prepare("SELECT * FROM sections WHERE parent_id" . ($parentId ? " = ?" : " IS NULL"));
    if ($parentId) $sectionsStmt->execute([$parentId]);
    else $sectionsStmt->execute();

    $sections = $sectionsStmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($sections as $key => &$section) {
        // Проверяем доступ
        if (!isAccessible($userId, $section['id'])) {
            unset($sections[$key]);
            continue;
        }

        $section['children'] = getKnowledgeTree($userId, $section['id']);

        $knowledgeStmt = $conn->prepare("SELECT * FROM knowledge WHERE section_id = ? ORDER BY popularity DESC");
        $knowledgeStmt->execute([$section['id']]);
        $section['knowledge'] = $knowledgeStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $sections;
}

function renderKnowledgeTree($knowledge_tree, $parentId = '') {
    $html = '';
    foreach ($knowledge_tree as $branch) {
        $id = $parentId . 'item-' . $branch['id'];
        
        if (!empty($branch['children']) || !empty($branch['knowledge'])) {
            $html .= '<li><a href="#'.$id.'" data-bs-toggle="collapse" aria-expanded="false" class="list-group-item"> <i class="fas fa-angle-right"></i><span> '.$branch['name'].'</span></a>';
            $html .= '<ul class="collapse list-unstyled" id="'.$id.'">';
            
            // Рекурсивно выводим дочерние разделы
            $html .= renderKnowledgeTree($branch['children'], $id.'-');
            
            // Выводим знания для данного раздела
            foreach ($branch['knowledge'] as $knowledge) {
                $html .= '<li><a href="knowledge.php?id='.$knowledge['id'].'">'.mb_strimwidth($knowledge['title'], 0, 100, '...') .'</a></li>';
            }
            $html .= '</ul></li>';
        } else {
            $html .= '<li><a href="#">'.$branch['name'].'</a></li>';
        }
    }

    return $html;
}