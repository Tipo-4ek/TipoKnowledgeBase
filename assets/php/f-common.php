<?php

require("db.php");

function print_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function searchKnowledge($searchTerm) {
    global $conn;  

    $stmt = $conn->prepare("
        SELECT *, MATCH(title, problem, solution) AGAINST(? IN NATURAL LANGUAGE MODE) as relevance 
        FROM knowledge 
        WHERE MATCH(title, problem, solution) AGAINST(? IN NATURAL LANGUAGE MODE) 
        ORDER BY (popularity > 0) DESC, relevance DESC
    ");

    $stmt->bindValue(1, $searchTerm);
    $stmt->bindValue(2, $searchTerm);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// function suggestKnowledge($searchTerm) {
//     global $conn;  

//     $stmt = $conn->prepare("
//         SELECT id, title, MATCH(title, problem, solution) AGAINST(? IN NATURAL LANGUAGE MODE) as relevance 
//         FROM knowledge 
//         WHERE MATCH(title, problem, solution) AGAINST(? IN NATURAL LANGUAGE MODE) 
//         ORDER BY (popularity > 0) DESC, relevance DESC
//         LIMIT 5
//     ");
//     $stmt->bindValue(1, $searchTerm);
//     $stmt->bindValue(2, $searchTerm);
//     $stmt->execute();

//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }