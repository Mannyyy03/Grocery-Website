<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Spring 2020 Sale Items</title>
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
            width: 60%;
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
        <br><br>
    <a href="index.php">
        <button style="padding: 10px 20px; font-size: 16px; cursor: pointer;">
            ⬅ Back to Home
        </button>
    </a>

    <h1>Items on Sale in Spring 2020</h1>

    <pre>
SELECT I.itemID, S.season, I.name 
FROM Item I, Sale S, Go_On_Sale G 
WHERE I.itemID = G.itemID 
AND G.saleID = S.saleID 
AND S.season = 'Spring2020'
    </pre>

    <?php
    try {
        $sql = "
            SELECT I.itemID, S.season, I.name 
            FROM Item I, Sale S, Go_On_Sale G 
            WHERE I.itemID = G.itemID 
            AND G.saleID = S.saleID 
            AND S.season = 'Spring2020'
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($results) > 0) {
            echo "<table>";
            echo "<tr><th>Item ID</th><th>Season</th><th>Item Name</th></tr>";
            foreach ($results as $row) {
                echo "<tr><td>{$row['itemID']}</td><td>{$row['season']}</td><td>{$row['name']}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No items found for Spring 2020.</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Query failed: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    ?>
</body>
</html>
