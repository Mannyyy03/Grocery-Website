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
    <title>Average Deli Item Price</title>
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
    <h1>Average Price of Deli Items</h1>

    <pre>
SELECT AVG(I.price) AS avg_deli_item_price
FROM Item I, Deli D
WHERE I.itemID = D.itemID
    </pre>

    <?php
    try {
        $sql = "
            SELECT AVG(I.price) AS avg_deli_item_price
            FROM Item I, Deli D
            WHERE I.itemID = D.itemID
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['avg_deli_item_price'] !== null) {
            $avgPrice = number_format($result['avg_deli_item_price'], 2);
            echo "<table>";
            echo "<tr><th>Average Deli Item Price</th></tr>";
            echo "<tr><td>\${$avgPrice}</td></tr>";
            echo "</table>";
        } else {
            echo "<p>No deli items found.</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Query failed: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    ?>
</body>
</html>
