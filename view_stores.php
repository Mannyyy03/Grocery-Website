<?php
require_once 'config.php';

$stmt = $conn->query("SELECT * FROM Store");
$stores = $stmt->fetchAll(PDO::FETCH_ASSOC);

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Stores List</title>
    <style>
        table, th, td {
          border: 1px solid black;
          border-collapse: collapse;
          padding: 6px;
        }
        th {
          background-color: #ddd;
        }
    </style>
</head>
<body>

    <h1>Stores List</h1>

    <?php if ($stores): ?>
    <table>
        <thead>
            <tr>
                <th>storeID</th>
                <th>Name</th>
                <th>Yelp Rating</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Foot Traffic</th>
                <th>Address</th>
                <th>Phone Number</th>
                <th>Postal Code</th>
                <th>Hours</th>
                <th>Source Type</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stores as $store): ?>
            <tr>
                <td><?= htmlspecialchars($store['storeID'])?></td>
                <td><?= htmlspecialchars($store['name']) ?></td>
                <td><?= number_format($store['rating_yelp']) ?></td>
                <td><?= number_format($store['latitude'], 6) ?></td>
                <td><?= number_format($store['longitude'], 6) ?></td>
                <td><?= number_format($store['foot_traffic']) ?></td>
                <td><?= htmlspecialchars($store['Address']) ?></td>
                <td><?= number_format($store['phone_number']) ?></td>
                <td><?= number_format($store['Postal_code']) ?></td>
                <td><?= number_format($store['hours']) ?></td>
                <td><?= htmlspecialchars($store['Sourcetype']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No stores </p>
    <?php endif; ?>

</body>
</html>