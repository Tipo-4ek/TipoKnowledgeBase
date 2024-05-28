<?php

include ('db.php');

function makeChannelsChart() {
    try {
        global $conn;

        $stmt = $conn->prepare("SELECT DISTINCT knowledge_type FROM knowledge");
        $stmt->execute();
        $knowledge_types = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $colors = [
            'ML' => '#FF0000',  
            'Common' => '#0000FF',
            'TEST' => '#000'
        ];

        $data = [
            'labels' => [],
            'datasets' => [
                [
                    'data' => [],
                    'backgroundColor' => [],
                    'hoverBackgroundColor' => []
                ]
            ]
        ];

        foreach($knowledge_types as $knowledge_type){
            $data['labels'][] = $knowledge_type;

            $stmt = $conn->prepare("SELECT COUNT(*) FROM knowledge WHERE knowledge_type = ?");
            $stmt->execute([$knowledge_type]);

            $count = $stmt->fetchColumn();
            $data['datasets'][0]['data'][] = $count;

            if(array_key_exists($knowledge_type, $colors)){
                $color = $colors[$knowledge_type];
            } else {
                // Генерация случайного цвета
                $color = '#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            }

            $data['datasets'][0]['backgroundColor'][] = $color;
            // Добавляем то же самое цвет для hoverBackgroundColor
            $data['datasets'][0]['hoverBackgroundColor'][] = $color;
        }

        echo json_encode($data);

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

makeChannelsChart();