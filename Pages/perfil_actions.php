<?php
session_start();
require_once '../DB/conexao.php'; // Inclua a conexão com o banco de dados

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['error' => 'Usuário não autenticado.']);
    exit();
}

$userId = $_SESSION['usuario_id'];
$dados = [];
parse_str(file_get_contents("php://input"), $dados);

if (isset($dados['nome'])) {
    $nome = $dados['nome'];
    $stmt = $pdo->prepare("UPDATE usuarios SET nome = :nome WHERE id = :id");
    $stmt->execute(['nome' => $nome, 'id' => $userId]);
}

if (isset($dados['imagem_perfil'])) {
    $imagemPerfil = $dados['imagem_perfil'];
    $stmt = $pdo->prepare("UPDATE usuarios SET imagem_perfil = :imagem_perfil WHERE id = :id");
    $stmt->execute(['imagem_perfil' => $imagemPerfil, 'id' => $userId]);
}

echo json_encode(['success' => 'Perfil atualizado com sucesso.']);
?>
