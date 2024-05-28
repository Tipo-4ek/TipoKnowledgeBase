<?php

function getKnowledgeCount() {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(id) as count FROM knowledge");
    $stmt->execute([]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]["count"];
    return ($result);
}

function getKnowledgeTypePercentage() { # ml / common
    global $conn;

    $stmt = $conn->prepare(
        "SELECT 
            (SELECT COUNT(*) FROM knowledge WHERE knowledge_type = \"ML\") AS ml_knowledge,
            (SELECT COUNT(*) FROM knowledge WHERE knowledge_type = \"COMMON\") AS common_knowledge 
        FROM DUAL"
    );

    $stmt->execute([]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $ml_knowledge = $row['ml_knowledge'];
        $common_knowledge = $row['common_knowledge'];

        if ($common_knowledge == 0) {
            return 0; 
        }  

        $percentage = ($ml_knowledge / $common_knowledge) * 100;

        return round($percentage, 2);
    } else { return 0; }
}
