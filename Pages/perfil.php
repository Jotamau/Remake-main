<?php
session_start();
require_once '../DB/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    echo 'Usuário não autenticado.';
    exit();
}

$userId = $_SESSION['usuario_id'];

// Consulta ao banco de dados para obter as informações do perfil
$stmt = $pdo->prepare("SELECT nome, email, imagem_perfil, idade, sexo FROM usuarios WHERE id = :id");
$stmt->execute(['id' => $userId]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo 'Usuário não encontrado.';
    exit();
}

// Determina o caminho da imagem de perfil
$imagemPerfil = $usuario['imagem_perfil'] ? htmlspecialchars($usuario['imagem_perfil']) : '../Assets/default-avatar.png';
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
                <div class="col-auto min-vh-100 sidebar px-3 d-flex flex-column" id="sidebar">
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
                    <div class="profile-container">
                        <div class="profile-card">
                            <div class="profile-header">
                                <img id="profile-image" src="<?php echo $imagemPerfil; ?>" alt="Imagem de Perfil">
                                
                                <div class="btn-pro">

                                    <div class="btn-justify">
                                        <button id="edit-image-btn" class="btn-custom">foto</button>
                                        <input type="file" id="image-upload" style="display: none;">
                                        <button id="edit-name-btn" class="btn-custom">Nome</button>
                                        <button id="edit-age-btn" class="btn-custom">Idade</button>
                                        <button id="edit-gender-btn" class="btn-custom">Sexo</button>
                                    </div>        

                                </div>
                            </div>
                            <div class="profile-details">
                                <p><strong>Email:</strong> <span id="profile-email"><?php echo htmlspecialchars($usuario['email']); ?></span></p>
                                <p><strong>Nome:</strong> <span id="profile-name"><?php echo htmlspecialchars($usuario['nome']); ?></span></p>
                                <p><strong>Idade:</strong> <span id="profile-age"><?php echo htmlspecialchars($usuario['idade']); ?></span></p>
                                <p><strong>Sexo:</strong> <span id="profile-gender"><?php echo htmlspecialchars($usuario['sexo']); ?></span></p>
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
            const editImageBtn = document.getElementById('edit-image-btn');
            const imageUpload = document.getElementById('image-upload');
            const profileImage = document.getElementById('profile-image');

            editImageBtn.addEventListener('click', () => {
                imageUpload.click();
            });

            imageUpload.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = () => {
                        profileImage.src = reader.result;
                        updateProfile({ imagem_perfil: reader.result });
                    };
                    reader.readAsDataURL(file);
                }
            });

            const editNameBtn = document.getElementById('edit-name-btn');
            const editAgeBtn = document.getElementById('edit-age-btn');
            const editGenderBtn = document.getElementById('edit-gender-btn');

            editNameBtn.addEventListener('click', () => {
                const newName = prompt('Digite o novo nome:');
                if (newName) {
                    document.getElementById('profile-name').textContent = newName;
                    updateProfile({ nome: newName });
                }
            });

            editAgeBtn.addEventListener('click', () => {
                const newAge = prompt('Digite a nova idade:');
                if (newAge) {
                    document.getElementById('profile-age').textContent = newAge;
                    updateProfile({ idade: newAge });
                }
            });

            editGenderBtn.addEventListener('click', () => {
                const newGender = prompt('Digite o novo sexo (Masculino, Feminino, Outro):');
                if (newGender) {
                    document.getElementById('profile-gender').textContent = newGender;
                    updateProfile({ sexo: newGender });
                }
            });

            function updateProfile(data) {
                fetch('perfil_actions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams(data),
                })
                .then(response => response.json())
                .then(result => {
                    if (result.error) {
                        alert(result.error);
                    } else {
                        alert(result.success);
                    }
                })
                .catch(error => console.error('Erro ao atualizar perfil:', error));
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
