<?php
include '../DB/conexao.php'; 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirma_senha = $_POST['confirma_senha'] ?? ''; 
    if (empty($usuario) || empty($email) || empty($senha) || empty($confirma_senha)) {
        echo "<script>alert('Todos os campos são obrigatórios!');</script>";
    } elseif ($senha !== $confirma_senha) {
        echo "<script>alert('As senhas não coincidem!');</script>";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->rowCount() > 0) {
            echo "<script>alert('E-mail já cadastrado!');</script>";
        } else {
            $hash_senha = password_hash($senha, PASSWORD_DEFAULT); 
            $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, email, senha) VALUES (:usuario, :email, :senha)");
            $stmt->execute([
                'usuario' => $usuario,
                'email' => $email,
                'senha' => $hash_senha
            ]);
            echo "<script>alert('Cadastro realizado com sucesso!');</script>";
            header("Location: login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/stylesCadLog.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Cadastro</title>
</head>
<body>
    <div class="main-login">
        <div class="left-login">
            <h1>Cadastre-se <br> E entre para o nosso time</h1>
            <img src="../Assets/cad.svg" alt="Imagem Cadastro">
        </div>

        <div class="right-login">
            <div class="card-login">
                <h1>Cadastre-se</h1>
                <form action="cadastro.php" method="POST">
                    <label for="usuario">Usuário</label>
                    <input type="text" name="usuario" placeholder="Nome de usuário" required>    
    
                    <label for="email">E-mail</label>
                    <input type="email" name="email" placeholder="Endereço de E-mail" required>

                    <label for="senha">Senha</label>
                    <input type="password" name="senha" placeholder="Crie uma senha" required>

                    <label for="confirma_senha">Confirme a senha</label>
                    <input type="password" name="confirma_senha" placeholder="Confirme a senha" required>

                    <button type="submit" class="btn-login">Cadastrar</button>
                </form>
                <span><a href="login.php"> Já tem uma conta ? clique aqui </a></span>
            </div>
        </div>
    </div>
    <div class="cursor-dot" data-cursor-dot></div>
    <div class="cursor-outline" data-cursor-outline></div>
    <script src="../Script/cursor.js"></script>
    
</body>
</html>
