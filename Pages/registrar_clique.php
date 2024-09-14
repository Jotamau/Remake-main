<?php
session_start();
require_once '../DB/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['error' => 'Usuário não autenticado.']);
    exit();
}

$userId = $_SESSION['usuario_id'];

// Verifica se o usuário já clicou hoje
$stmt = $pdo->prepare("SELECT COUNT(*) AS clicks FROM clicks_diarios WHERE usuario_id = :usuario_id AND data = CURDATE()");
$stmt->execute(['usuario_id' => $userId]);
$clickHoje = $stmt->fetchColumn();

if ($clickHoje == 0) {
    // Registra o clique
    $stmt = $pdo->prepare("INSERT INTO clicks_diarios (usuario_id, data) VALUES (:usuario_id, CURDATE())");
    $stmt->execute(['usuario_id' => $userId]);

    // Conta o total de dias em que o usuário clicou
    $stmt = $pdo->prepare("SELECT COUNT(DISTINCT data) AS dias_registrados FROM clicks_diarios WHERE usuario_id = :usuario_id");
    $stmt->execute(['usuario_id' => $userId]);
    $diasRegistrados = $stmt->fetchColumn();

    echo json_encode(['success' => 'Clique registrado com sucesso!', 'diasRegistrados' => $diasRegistrados]);
} else {
    echo json_encode(['error' => 'Você já clicou hoje.']);
}
?>
