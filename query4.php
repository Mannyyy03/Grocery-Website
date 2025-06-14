<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include PDO config
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recipe Ratings Count</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            padding: 40px;
        }
        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 40%;
            background-color: #fff;
        }
        th, td {
            padding: 10px;
            border: 1px solid #999;
        }
        th {
            background-color: #e0e0e0;
        }
        pre {
            background-color: #f0f0f0;
            text-align: left;
            display: inline-block;
            padding: 15px;
            border: 1px solid #ccc;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <h1>Number of Recipes by Rating</h1>

    <pre>
SELECT R.Rating, COUNT(*) AS rating_count
FROM Recipe R
GROUP BY R.Rating
    </pre>

    <?php
    try {
        $sql = "
            SELECT R.Rating, COUNT(*) AS rating_count
            FROM Recipe R
            GROUP BY R.Rating
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($results) > 0) {
            echo "<table>";
            echo "<tr><th>Rating</th><th>Number of Recipes</th></tr>";
            foreach ($results as $row) {
                echo "<tr><td>" . htmlspecialchars($row['Rating']) . "</td><td>" . htmlspecialchars($row['rating_count']) . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No recipe ratings found.</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Query failed: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    ?>
</body>
</html>
