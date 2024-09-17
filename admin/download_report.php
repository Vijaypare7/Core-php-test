<?php
session_start();
require 'includes/db.php';
$pdo = getDB();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    die('You must be an admin to download the report.');
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=tasks_report.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['Start Time', 'Stop Time', 'Notes', 'Description']);

try {

    $stmt = $pdo->query('SELECT start_time, stop_time, notes, description FROM tasks');

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, $row);
    }
} catch (PDOException $e) {
    fclose($output);
    die('Database error: ' . htmlspecialchars($e->getMessage()));
}

fclose($output);
?>
