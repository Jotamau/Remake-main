<?php
include('../DB/conexao.php');
session_start(); // Inicia a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id']; // ID do usuário logado

// Adicionar tarefa
if (isset($_POST['add_tarefa'])) {
    $text = $_POST['text'];
    $stmt = $pdo->prepare("INSERT INTO tarefas (text, done, usuario_id) VALUES (:text, 0, :usuario_id)");
    $stmt->execute(['text' => $text, 'usuario_id' => $usuario_id]);
    header("Location: tarefas.php");
    exit();
}

// Marcar tarefa como concluída
if (isset($_POST['update_tarefa'])) {
    $id = $_POST['id'];
    $done = $_POST['done'] == 0 ? 1 : 0; // Alterna entre concluído e não concluído
    $stmt = $pdo->prepare("UPDATE tarefas SET done = :done WHERE id = :id AND usuario_id = :usuario_id");
    $stmt->execute(['done' => $done, 'id' => $id, 'usuario_id' => $usuario_id]);
    header("Location: tarefas.php");
    exit();
}

// Excluir tarefa
if (isset($_POST['delete_tarefa'])) {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM tarefas WHERE id = :id AND usuario_id = :usuario_id");
    $stmt->execute(['id' => $id, 'usuario_id' => $usuario_id]);
    header("Location: tarefas.php");
    exit();
}

// Editar tarefa
if (isset($_POST['edit_tarefa'])) {
    $id = $_POST['id'];
    $new_text = $_POST['new_text'];
    $stmt = $pdo->prepare("UPDATE tarefas SET text = :text WHERE id = :id AND usuario_id = :usuario_id");
    $stmt->execute(['text' => $new_text, 'id' => $id, 'usuario_id' => $usuario_id]);
    header("Location: tarefas.php");
    exit();
}

// Buscar todas as tarefas do usuário logado
$stmt = $pdo->prepare("SELECT * FROM tarefas WHERE usuario_id = :usuario_id ORDER BY id DESC");
$stmt->execute(['usuario_id' => $usuario_id]);
$tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/stylesHome.css">
    <link rel="stylesheet" href="../Css/stylesTaskMng.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Tarefas</title>
</head>
<body>
    <!-- Cursor personalizado -->
    <div data-cursor-dot class="cursor-dot"></div>
    <div data-cursor-outline class="cursor-outline"></div>
    <canvas id="particles-js"></canvas>

    <!-- Script do Particle.js -->
    <script src="../node_modules/particlesjs/dist/particles.js"></script>
    <script>
        const particlesSettings = {
            selector: '#particles-js',
            maxParticles: 100,
            speed: 0.5,
            color: '#ffffff',
            connectParticles: true,
            minDistance: 120,
        };

        Particles.init(particlesSettings);
    </script>

    <div class="main-container">
        <!-- Sidebar -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-auto min-vh-100 sidebar px-3 d-flex flex-column">
                    <div class="pt-4 pb-2 px-4">
                        <a href="../index.php" class="text-decoration-none text-white d-flex align-items-center">
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
            </div>
            <!-- Conteúdo principal -->
            <div id="dashboard" class="col main-content">
                <div class="container-right">
                    <div class="todo-container">
                        <h1>To do task</h1>

                        <!-- Formulário de Adicionar Tarefa -->
                        <form action="tarefas.php" method="POST">
                            <div class="form-control">
                                <input type="text" name="text" placeholder="O que você vai fazer?" required>
                                <button type="submit" name="add_tarefa"><i class="fa-thin fa-plus"></i></button>
                            </div>
                        </form>

                        <!-- Listar Tarefas -->
                        <div id="todo-list">
                            <?php foreach ($tarefas as $tarefa): ?>
                                <div class="todo-item <?= $tarefa['done'] ? 'completed' : '' ?>">
                                    <h3><?= htmlspecialchars($tarefa['text']) ?></h3>

                                    <!-- Marcar como concluído -->
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $tarefa['id'] ?>">
                                        <input type="hidden" name="done" value="<?= $tarefa['done'] ?>">
                                        <button type="submit" name="update_tarefa" class="finish-todo">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </form>

                                    <!-- Excluir tarefa -->
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $tarefa['id'] ?>">
                                        <button type="submit" name="delete_tarefa" class="remove-todo">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </form>

                                    <!-- Editar tarefa -->
                                    <button class="edit-todo" onclick="document.getElementById('edit-<?= $tarefa['id'] ?>').style.display = 'block';">
                                        <i class="fa-solid fa-pencil"></i>
                                    </button>

                                    <!-- Formulário de Edição (inicialmente escondido) -->
                                    <form id="edit-<?= $tarefa['id'] ?>" action="tarefas.php" method="POST" style="display:none;">
                                        <input type="hidden" name="id" value="<?= $tarefa['id'] ?>">
                                        <input type="text" name="new_text" value="<?= htmlspecialchars($tarefa['text']) ?>" required>
                                        <button type="submit" name="edit_tarefa">Salvar</button>
                                    </form>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../Script/cursor.js"></script>
    <script src="../Script/home.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        particlesJS.load('particles-js', 'path/to/particles.json', function() {
            console.log('callback - particles.js config loaded');
        });
    </script>
</body>
</html>
