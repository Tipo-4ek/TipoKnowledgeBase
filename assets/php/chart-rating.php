<?php

include ('db.php');

function makeMonthlyRatingsChart() {
    try {
        global $conn;

        // Получить данные по месяцам и рейтингу
        $stmt = $conn->prepare("SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, rating, COUNT(*) as count FROM knowledge WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY month, rating ORDER BY month ASC");
        $stmt->execute();

        $ratings_data = $stmt->fetchAll(PDO::FETCH_GROUP);

        $data = [
            'labels' => [],
            'datasets' => [
                ['label' => '1', 'backgroundColor' => '#ff0000', 'data' => []],
                ['label' => '2', 'backgroundColor' => '#ff8000', 'data' => []],
                ['label' => '3', 'backgroundColor' => '#ffff00', 'data' => []],
                ['label' => '4', 'backgroundColor' => '#80ff00', 'data' => []],
                ['label' => '5', 'backgroundColor' => '#00ff00', 'data' => []],
            ]
        ];

        // Заполнить данные по оценкам и месяцам
        foreach ($ratings_data as $month => $ratings) {
            $data['labels'][] = $month;

            $monthly_ratings = array_column($ratings, 'count', 'rating');
            
            foreach ($data['datasets'] as $i => $dataset) {
                $rating = $dataset['label'];
                if (isset($monthly_ratings[$rating])) {
                    $data['datasets'][$i]['data'][] = $monthly_ratings[$rating];
                } else {
                    $data['datasets'][$i]['data'][] = 0;
                }
            }
        }

        echo json_encode($data);

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

makeMonthlyRatingsChart();
