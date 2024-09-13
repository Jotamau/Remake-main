<?php
$host = 'localhost';
$db = 'taskify'; // Nome do banco de dados
$user = 'root'; // Usuário do banco de dados
$pass = ''; // Senha do banco de dados

try {
    // Define o charset para evitar problemas com caracteres especiais
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Tratar erros de conexão
    die("Erro de conexão: " . $e->getMessage());
}
?>
