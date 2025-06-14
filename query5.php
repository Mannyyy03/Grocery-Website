<?php
// Enable error reporting
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
    <title>Unique Postal Codes and Source Types</title>
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
            width: 50%;
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
    <h1>Unique Postal Codes and Store Source Types</h1>

    <pre>
SELECT DISTINCT Postal_code, Sourcetype
FROM Store
    </pre>

    <?php
    try {
        $sql = "
            SELECT DISTINCT Postal_code, Sourcetype
            FROM Store
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($results) > 0) {
            echo "<table>";
            echo "<tr><th>Postal Code</th><th>Source Type</th></tr>";
            foreach ($results as $row) {
                // Convert keys to lowercase if necessary
                $postalCode = $row['Postal_code'] ?? $row['postal_code'];
                $sourceType = $row['Sourcetype'] ?? $row['sourcetype'];
                echo "<tr><td>" . htmlspecialchars($postalCode) . "</td><td>" . htmlspecialchars($sourceType) . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No results found.</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Query failed: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    ?>
</body>
</html>
