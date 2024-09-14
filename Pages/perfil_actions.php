<?php
session_start();
require_once '../DB/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['error' => 'Usuário não autenticado.']);
    exit();
}

$userId = $_SESSION['usuario_id'];
$data = $_POST;

// Inicializa variáveis para as atualizações
$fields = [];
$values = [];

// Processa a imagem do perfil
if (isset($data['imagem_perfil'])) {
    $imageData = $data['imagem_perfil'];
    // Verifica se é uma imagem base64
    if (preg_match('/^data:image\/(png|jpeg);base64,/', $imageData)) {
        // Remove o prefixo da imagem base64
        $imageData = preg_replace('/^data:image\/(png|jpeg);base64,/', '', $imageData);
        $imageData = base64_decode($imageData);

        // Define o caminho para salvar a imagem
        $imagePath = '../Assets/profile_images/' . uniqid() . '.png';
        file_put_contents($imagePath, $imageData);

        // Adiciona o caminho da imagem ao array de valores
        $data['imagem_perfil'] = $imagePath;
    } else {
        // Se não for uma imagem válida, define um valor padrão
        $data['imagem_perfil'] = '../Assets/default-avatar.png';
    }
}

// Adiciona os campos e valores para atualização
foreach ($data as $key => $value) {
    if ($key === 'imagem_perfil' && empty($value)) {
        continue; // Não atualiza se a imagem estiver vazia
    }
    $fields[] = "$key = :$key";
    $values[$key] = $value;
}
$values['id'] = $userId;

// Monta a consulta SQL
$sql = "UPDATE usuarios SET " . implode(', ', $fields) . " WHERE id = :id";
$stmt = $pdo->prepare($sql);

if ($stmt->execute($values)) {
    echo json_encode(['success' => 'Perfil atualizado com sucesso.']);
} else {
    echo json_encode(['error' => 'Erro ao atualizar perfil.']);
}
?>
