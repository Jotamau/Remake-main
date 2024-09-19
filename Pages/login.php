
<?php
// Incluindo a conexão com o banco de dados
include '../DB/conexao.php';

session_start(); // Inicia a sessão

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Verificar se os campos estão preenchidos
    if (empty($email) || empty($senha)) {
        echo "<script>alert('Preencha todos os campos!');</script>";
    } else {
        // Consulta no banco de dados pelo email
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Senha correta, inicia a sessão
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario'] = $usuario['usuario'];
            
            echo "<script>alert('Login bem-sucedido!');</script>";
            header("Location: tarefas.php"); 
            exit();
        } else {
            echo "<script>alert('E-mail ou senha incorretos!');</script>";
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
    <title>Login</title>
</head>
<body>
    <div class="main-login">
        <div class="left-login">
            <h1>Faça login <br> E continue sendo parte do time</h1>
            <img src="../Assets/log.svg" alt="Imagem Cadastro">
        </div>

        <div class="right-login">
            <div class="card-login">
                <h1>Login</h1>
                <form action="login.php" method="POST">   
                    <label for="email">E-mail</label>
                    <input type="email" name="email" placeholder="Endereço de E-mail" required>

                    <label for="senha">Senha</label>
                    <input type="password" name="senha" placeholder="Insira sua senha" required>

                    <button type="submit" class="btn-login">Entrar</button>
                </form>
                <br>
                <span><a href="cadastro.php">Ainda não tem uma conta? Clique aqui</a></span>
                <br>
                <span><a href="../index.php">Voltar</a></span>
            </div>
        </div>
    </div>
    <div class="cursor-dot" data-cursor-dot></div>
    <div class="cursor-outline" data-cursor-outline></div>
    <script src="../Script/cursor.js"></script>
</body>
</html>
