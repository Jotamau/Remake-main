<?php
// Incluir a conexão com o banco de dados
require_once '../DB/conexao.php';

// Função para buscar todas as tarefas
function fetchTarefas($pdo) {
    $stmt = $pdo->query("SELECT * FROM tarefas ORDER BY created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para adicionar uma nova tarefa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['text']) && !empty(trim($_POST['text']))) {
        $text = trim($_POST['text']);

        // Preparar e executar a inserção
        $stmt = $pdo->prepare("INSERT INTO tarefas (text) VALUES (:text)");
        $stmt->execute(['text' => $text]);
    }

    // Redirecionar para a página principal após a submissão
    header('Location: tarefas.php');
    exit;
}

// Função para marcar tarefa como feita ou não
if (isset($_POST['update_tarefa'])) {
    $id = $_POST['id'] ?? 0;
    $done = isset($_POST['done']) && $_POST['done'] ? 0 : 1;

    // Preparar e executar a atualização
    $stmt = $pdo->prepare("UPDATE tarefas SET done = :done WHERE id = :id");
    $stmt->execute(['done' => $done, 'id' => $id]);

    header('Location: tarefas.php');
    exit;
}

// Função para deletar uma tarefa
if (isset($_POST['delete_tarefa'])) {
    $id = $_POST['id'] ?? 0;

    // Preparar e executar a deleção
    $stmt = $pdo->prepare("DELETE FROM tarefas WHERE id = :id");
    $stmt->execute(['id' => $id]);

    header('Location: tarefas.php');
    exit;
}
// Verifica se um ID foi passado para edição
if (isset($_GET['id'])) {
  $id = $_GET['id'];

  // Busca a tarefa correspondente ao ID
  $stmt = $pdo->prepare("SELECT * FROM tarefas WHERE id = :id");
  $stmt->execute(['id' => $id]);
  $tarefaEdicao = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Pegar todas as tarefas para exibição
$tarefas = fetchTarefas($pdo);
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
            </div>

            <!-- Conteúdo principal -->
            <div id="dashboard" class="col main-content">
                <div class="container-right">
                    <div class="todo-container">
                        <div id="todo-topo">
                            <h1>To do task</h1>
                        </div>
                        <form id="todo-form" action="tarefas.php" method="POST">
                            <p>Adicione sua tarefa</p>
                            <div class="form-control">
                                <div class="form-control2">
                                    <input type="text" name="text" id="todo-input" placeholder="O que você vai fazer?" required />
                                    <button type="submit">
                                        <i class="fa-thin fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div id="toolbar">
                            <div id="search">
                                <h4>Pesquisar:</h4>
                                <input type="text" id="search-input" placeholder="Buscar..." />
                            </div>
                            <div id="filter">
                                <h4>Filtrar:</h4>
                                <select id="filter-select">
                                    <option value="all">Todos</option>
                                    <option value="done">Feitos</option>
                                    <option value="todo">A fazer</option>
                                </select>
                            </div>
                        </div>

                        <div id="todo-list">
                            <?php foreach ($tarefas as $tarefa): ?>
                                <div class="todo <?php echo $tarefa['done'] ? 'done' : ''; ?>">
                                    <h3><?php echo htmlspecialchars($tarefa['text'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($tarefa['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <input type="hidden" name="done" value="<?php echo htmlspecialchars($tarefa['done'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <button type="submit" name="update_tarefa" class="finish-todo">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </form>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($tarefa['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <button type="submit" name="delete_tarefa" class="remove-todo">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </form>
                                    <!-- Botão de Editar -->
                                    <form method="GET" action="tarefas.php" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($tarefa['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <button type="submit" class="edit-todo">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
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
    <script src="../Script/todo.js"></script>
    <script src="../Script/home.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        particlesJS.load('particles-js', 'path/to/particles.json', function() {
            console.log('callback - particles.js config loaded');
        });
    </script>
</body>

</html>
