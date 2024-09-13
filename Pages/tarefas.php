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

    <div class="main-container">
        <!-- side bar -->
        <div class="container-fluid">
            <div class="row">
                <!-- side bar -->
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



            
        <!-- main right -->

        <div id="dashboard" class="col main-content">
        <div class="container-right">

                <div class="todo-container">
      <div id="todo-topo">
        <h1>To do task</h1>
      </div>
      <form id="todo-form">
        <p>Adicione sua tarefa</p>
        <div class="form-control">

          <div class="form-control2">
          <input
            type="text"
            id="todo-input"
            placeholder="O que você vai fazer?"/>
          <button type="submit">
            <i class="fa-thin fa-plus"></i>
          </button>
          </div>

        </div>
      </form>
      <form id="edit-form" class="hide">
        <p>Edite sua tarefa</p>
        <div class="form-control">

          <div class="form-control2">
          <input type="text" id="edit-input" />
          <button type="submit">
            <i class="fa-solid fa-check-double"></i>
          </button>
          </div>
        </div>
        <button id="cancel-edit-btn">Cancelar</button>
      </form>

      <div id="toolbar">
        <div id="search">
          <h4>Pesquisar:</h4>
          <form>
            <input type="text" id="search-input" placeholder="Buscar..." />
            <button id="erase-button">
              <i class="fa-solid fa-delete-left"></i>
            </button>
          </form>
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
        window.onload = function () {
            Particles.init({
                selector: '.background',
                color: ['#4e6c8c', '#404B69', '#DBEDF3'],
                connectParticles: true
            });
        }
    </script>
    
    <script src="../Script/todo.js"></script>
    <script src="../Script/home.js"></script>
    <script src="../Script/cursor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particlesjs/2.2.3/particles.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>