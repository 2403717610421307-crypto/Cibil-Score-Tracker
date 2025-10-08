<?php
require_once '../config.php';

session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Simulate random score and insert into DB
$score = rand(600, 900);
$sql = "INSERT INTO score_history (user_id, score) VALUES (:user_id, :score)";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $_SESSION["id"], 'score' => $score]);

echo json_encode(['score' => $score]);
?>