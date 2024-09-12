<?php
session_start(); // Inicia a sessão

require_once '../DB/conexao.php'; // Inclua a conexão com o banco de dados

if (!isset($_SESSION['usuario_id'])) {
    echo 'Usuário não autenticado.';
    exit();
}

$userId = $_SESSION['usuario_id'];

// Consulta ao banco de dados para obter as informações do perfil
$stmt = $pdo->prepare("SELECT nome, email, imagem_perfil FROM usuarios WHERE id = :id");
$stmt->execute(['id' => $userId]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo 'Usuário não encontrado.';
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/stylesHome.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Perfil do Usuário</title>
    <style>
        .profile-container {
            padding: 20px;
            max-width: 800px;
            margin: auto;
        }

        .profile-card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .profile-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
        }

        .profile-header button {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        .profile-header button:hover {
            background-color: #0056b3;
        }

        .profile-details p {
            font-size: 16px;
            color: #333;
        }

        .profile-details strong {
            color: #007bff;
        }

        .btn-custom {
            margin-top: 10px;
            background-color: #007bff;
            color: #fff;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .sidebar {
            background-color: #343a40;
            color: #fff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
        }

        .main-content {
            margin-left: 250px;
        }
    </style>
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
                            <a href="#" class="nav-link text-white d-flex align-items-center">
                                <img class="link-icon" src="../Assets/profile.svg" alt="">
                                <span class="d-none d-sm-inline">Perfil</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Main right -->
                <div id="dashboard" class="col main-content">
                    <div class="profile-container">
                        <h1>Perfil</h1>
                        <div class="profile-card">
                            <div class="profile-header">
                                <img id="profile-image" src="<?php echo $usuario['imagem_perfil'] ?: '../Assets/default-avatar.png'; ?>" alt="Imagem de Perfil">
                                <div>
                                    <button id="edit-image-btn" class="btn-custom">Alterar Imagem</button>
                                    <input type="file" id="image-upload" style="display: none;">
                                    <h2 id="profile-name"><?php echo htmlspecialchars($usuario['nome']); ?></h2>
                                    <button id="edit-name-btn" class="btn-custom">Alterar Nome</button>
                                </div>
                            </div>
                            <div class="profile-details">
                                <!-- CODIGO PARA MOSTRAR O EMAIL DO USUARIO QUE ESTA LOGADO -->
                                <p><strong>Email:</strong> <span id="profile-email"><?php echo htmlspecialchars($usuario['email']); ?></span></p>
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

            editNameBtn.addEventListener('click', () => {
                const newName = prompt('Digite o novo nome:');
                if (newName) {
                    document.getElementById('profile-name').textContent = newName;
                    updateProfile({ nome: newName });
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
