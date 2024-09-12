<?php
/*
session_start();

// Verifique se a sessão de usuário está definida
if (isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] === true) {
    // O usuário está logado, redirecione para a página home.php
    header("Location: /pages/home.php");
    exit();
} else {
    // O usuário não está logado, redirecione para a página login.php
    header("Location: /pages/login.php");
    exit();
}
*/
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Css/stylesIndex.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Taskify - Gerenciamento de Tarefas</title>
</head>

<body>
    <canvas class="background"></canvas>

    <header class="taskify-header text-center">
        <div class="container">
            <h1>Taskify</h1>
            <p class="lead">O Futuro do Gerenciamento de Tarefas</p>
            <a href="#features" class="btn btn-primary btn-glow">Acesse-já  </a>
        </div>
    </header>

    <div class="cursor-dot" data-cursor-dot></div>
    <div class="cursor-outline" data-cursor-outline></div>

    <section id="features" class="taskify-section text-center">
        <div class="container">
            <h2>Funcionalidades</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-tasks"></i>
                        <h3>Gerenciamento de Tarefas</h3>
                        <p>Crie, edite e organize suas tarefas com facilidade.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-calendar-check"></i>
                        <h3>Alertas e Lembretes</h3>
                        <p>Receba notificações para nunca mais perder um prazo.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-chart-line"></i>
                        <h3>Relatórios de Progresso</h3>
                        <p>Acompanhe seu desempenho ao longo do tempo.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

<section id="testimonials" class="taskify-section text-center">
    <div class="container">
        <h2>O que nossos usuários dizem</h2>
        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="d-flex justify-content-around">
                        <div class="card">
                            <div class="card-body">
                                <p>"O Taskify revolucionou a maneira como eu organizo minhas tarefas."</p>
                                <footer>João Silva</footer>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <p>"Nunca mais perdi um prazo desde que comecei a usar o Taskify!"</p>
                                <footer>Maria Fernandes</footer>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <p>"O melhor aplicativo de gerenciamento de tarefas que já usei."</p>
                                <footer>Carlos Santos</footer>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="d-flex justify-content-around">
                        <div class="card">
                            <div class="card-body">
                                <p>"Excelente ferramenta para organização e produtividade."</p>
                                <footer>Ana Costa</footer>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <p>"Muito útil para manter minhas tarefas em ordem."</p>
                                <footer>Ricardo Oliveira</footer>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <p>"Ótima interface e funcionalidades."</p>
                                <footer>Fernanda Lima</footer>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Adicione mais slides conforme necessário -->
                <!-- Exemplo de Slide 3 -->
                <div class="carousel-item">
                    <div class="d-flex justify-content-around">
                        <div class="card">
                            <div class="card-body">
                                <p>"Simplesmente incrível. Mudou a forma como trabalho."</p>
                                <footer>Lucas Pereira</footer>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <p>"Facilita a organização do meu dia a dia."</p>
                                <footer>Paula Mendes</footer>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <p>"Muito eficiente e fácil de usar."</p>
                                <footer>Eduardo Martins</footer>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





    <!-- Call to Action -->
    <section id="cta" class="taskify-cta text-center">
        <div class="container">
            <h2>Pronto para revolucionar sua produtividade?</h2>
            <p>Inscreva-se agora e comece a usar o Taskify gratuitamente!</p>
            <a href="Pages/cadastro.php" class="btn btn-primary btn-glow">Inscreva-se</a>
        </div>
    </section>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particlesjs/2.2.3/particles.min.js"></script>
    <script src="Script/cursor.js"></script>
    <script>
        window.onload = function() {
            Particles.init({
                selector: '.background',
                color: ['#151019', '#6088b0'],
                connectParticles: true
            });
        }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>