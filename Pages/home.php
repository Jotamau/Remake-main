<?php 
session_start();
require_once '../DB/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    echo 'Usuário não autenticado.';
    exit();
}

$userId = $_SESSION['usuario_id'];

// Consulta ao banco de dados para obter as informações do perfil
$stmt = $pdo->prepare("SELECT nome, email, idade, sexo, imagem_perfil FROM usuarios WHERE id = :id");
$stmt->execute(['id' => $userId]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo 'Usuário não encontrado.';
    exit();
}

// Determina o caminho da imagem de perfil
$imagemPerfil = $usuario['imagem_perfil'] ? htmlspecialchars($usuario['imagem_perfil']) : '../Assets/default-avatar.png';

$nome = htmlspecialchars($usuario['nome']);
$email = htmlspecialchars($usuario['email']);
$idade = htmlspecialchars($usuario['idade']);
$sexo = htmlspecialchars($usuario['sexo']);

// Verifica se o usuário já clicou hoje
$stmt = $pdo->prepare("SELECT COUNT(*) AS clicks FROM clicks_diarios WHERE usuario_id = :usuario_id AND data = CURDATE()");
$stmt->execute(['usuario_id' => $userId]);
$clickHoje = $stmt->fetchColumn();

$podeClicar = $clickHoje == 0;

// Conta o total de dias em que o usuário clicou
$stmt = $pdo->prepare("SELECT COUNT(DISTINCT data) AS dias_registrados FROM clicks_diarios WHERE usuario_id = :usuario_id");
$stmt->execute(['usuario_id' => $userId]);
$diasRegistrados = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/stylesHome.css">
    <link rel="stylesheet" href="../Css/stylesProfile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Perfil do Usuário</title>
</head>
<body>
    <div class="main-container">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-auto min-vh-100 sidebar px-3 d-flex flex-column">
                    <div class="pt-4 pb-2 px-4">
                        <a href="" class="text-decoration-none text-white d-flex align-items-center">
                            <img src="../Assets/logo.svg" alt="" style="width: 50px; height: 50px;">
                            <span class="fs-3 d-none d-sm-inline ms-2">Taskify</span>
                        </a>
                    </div>
                    <hr class="text-white mb-5">
                    <ul class="nav nav-pills flex-column mb-auto d-flex d-sm-block">
                        <li class="nav-item mb-4 d-flex justify-content-center d-sm-block">
                            <a href="home.php" class="nav-link text-white d-flex align-items-center">
                                <img class="link-icon" src="../Assets/dashboard.svg" alt="">
                                <span class="d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item mb-4 d-flex justify-content-center d-sm-block">
                            <a href="tarefas.php" class="nav-link text-white d-flex align-items-center">
                                <img class="link-icon" src="../Assets/task.svg" alt="">
                                <span class="d-none d-sm-inline">Tarefas</span>
                            </a>
                        </li>
                        <li class="nav-item d-flex justify-content-center d-sm-block">
                            <a href="perfil.php" class="nav-link text-white d-flex align-items-center">
                                <img class="link-icon" src="../Assets/profile.svg" alt="">
                                <span class="d-none d-sm-inline">Perfil</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Main right -->
                <div id="dashboard" class="col main-content">
                    <div class="profile-container2">
                        <div class="profile-card2">
                            <div class="profile-header2">
                                <img id="profile-image2" src="<?php echo $imagemPerfil; ?>" alt="Imagem de Perfil">
                            </div>
                            <div class="profile-details">
                                <p><strong>Nome:</strong> <span id="profile-name"><?php echo $nome; ?></span></p>
                                <p><strong>Email:</strong> <?php echo $email; ?></p>
                                <p><strong>Idade:</strong> <?php echo $idade; ?></p>
                                <p><strong>Sexo:</strong> <?php echo $sexo; ?></p>
                                <p><strong>Dias Registrados:</strong> <span id="dias-registrados"><?php echo $diasRegistrados; ?></span></p>
                                
                                <?php if ($podeClicar): ?>
                                    <button id="click-button" class="btn btn-primary">Registrar Sequência</button>
                                <?php else: ?>
                                    <p>Siga firme e forte!</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <canvas class="background"></canvas>
    <div class="cursor-dot" data-cursor-dot></div>
    <div class="cursor-outline" data-cursor-outline></div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const clickButton = document.getElementById('click-button');

            if (clickButton) {
                clickButton.addEventListener('click', () => {
                    fetch('registrar_clique.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({ action: 'registrar' }),
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            alert('Clique registrado com sucesso!');
                            document.getElementById('dias-registrados').textContent = result.diasRegistrados;
                            clickButton.style.display = 'none';
                        } else {
                            alert(result.error);
                        }
                    })
                    .catch(error => console.error('Erro ao registrar clique:', error));
                });
            }
        });
    </script>
    <script>
        window.onload = function () {
            Particles.init({
                selector: '.background',
                color: ['#4e6c8c', '#404B69', '#DBEDF3'],
                connectParticles: true
            });
        }
    </script>
    <script src="../Script/home.js"></script>
    <script src="../Script/cursor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particlesjs/2.2.3/particles.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
