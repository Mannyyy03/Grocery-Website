<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
    $userQuery = trim($_POST["sql_query"]);

    // Ensure the query starts with SELECT
    if (!preg_match('/^\s*SELECT\b/i', $userQuery)) {
        die("<p style='color:red;'>Only SELECT statements are allowed.</p>");
    }

    // Allow only one statement (1 semicolon max, only at the end if present)
    if (
        substr_count($userQuery, ';') > 1 ||
        (strpos($userQuery, ';') !== false && trim(substr($userQuery, -1)) !== ';' && strpos($userQuery, ';') < strlen($userQuery) - 1)
    ) {
        die("<p style='color:red;'>Only one SELECT statement is allowed.</p>");
    }

    // Disallow dangerous keywords within the query
    if (preg_match('/\b(UPDATE|DELETE|DROP|ALTER|TRUNCATE|REPLACE|GRANT|REVOKE|CREATE|CALL|DESCRIBE|EXPLAIN)\b/i', $userQuery)) {
        die("<p style='color:red;'>Only safe SELECT statements are allowed.</p>");
    }

    try {
        $stmt = $conn->prepare($userQuery);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($rows) > 0) {
            echo "<table border='1'><tr>";
            foreach (array_keys($rows[0]) as $col) {
                echo "<th>" . htmlspecialchars($col) . "</th>";
            }
            echo "</tr>";

            foreach ($rows as $row) {
                echo "<tr>";
                foreach ($row as $val) {
                    echo "<td>" . htmlspecialchars($val) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No rows returned.</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Query failed: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p>No query submitted.</p>";
}
?>
