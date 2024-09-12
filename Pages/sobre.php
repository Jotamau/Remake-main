<?php
// Inicia a sessão
session_start(); 

// Verifique se o usuário está logado
// Substitua esta lógica conforme a sua implementação de autenticação
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/stylesIndex.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>Sobre - Taskify</title>
</head>

<body>
    <canvas class="background"></canvas>
    <div class="cursor-dot" data-cursor-dot></div>
    <div class="cursor-outline" data-cursor-outline></div>

    <header class="taskify-header text-center">
        <div class="container">
            <h1>Sobre o Taskify</h1>
            <p class="lead">Conheça mais sobre nossa missão e equipe</p>
            <a href="<?php echo $is_logged_in ? '/Pages/home.php' : '/Pages/login.php'; ?>" class="btn btn-primary btn-glow">Acesse já</a>
        </div>
    </header>

    <section id="about" class="taskify-section text-center">
        <div class="container">
            <h2>Quem Somos</h2>
            <p class="text-white">O Taskify é uma plataforma inovadora projetada para ajudar você a gerenciar suas tarefas e aumentar sua produtividade. Nossa missão é fornecer ferramentas eficazes para que você possa se concentrar no que realmente importa.</p>
        </div>
    </section>

    <section id="team" class="taskify-section text-center bg-light">
        <div class="container">
            <h2>Nossa Equipe</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="team-card">
                        <img src="../Assets/bomricio.jpeg" alt="Equipe 1" class="img-fluid rounded-circle mb-3">
                        <h3>João Bomricio</h3>
                        <p>CEO e Fundador</p>
                        <p>Bomricio lidera nossa equipe com uma visão clara e paixão por inovação.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-card">
                        <img src="../Assets/geovani.jpeg" alt="Equipe 2" class="img-fluid rounded-circle mb-3">
                        <h3>Geovani França</h3>
                        <p>CTO</p>
                        <p>Geovani é a mente por trás da nossa tecnologia, garantindo uma plataforma robusta e segura.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-card">
                        <img src="../Assets/jv.jpeg" alt="Equipe 3" class="img-fluid rounded-circle mb-3">
                        <h3>João Bundowski</h3>
                        <p>Designer</p>
                        <p>Bundowski cuida do design e da experiência do usuário, garantindo uma interface amigável.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-card">
                        <img src="../Assets/breno.jpeg" alt="Equipe 3" class="img-fluid rounded-circle mb-3">
                        <h3>Breno Xavier</h3>
                        <p>Designer</p>
                        <p>Breno cuida do theo.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="taskify-section text-center">
        <div class="container">
            <h2>Contato</h2>
            <p class="text-white">Se você tiver alguma dúvida ou feedback, entre em contato conosco!</p>
            <a href="mailto:contato@taskify.com" class="btn btn-primary btn-glow">Enviar E-mail</a>
        </div>
    </section>

    <!-- Call to Action -->
    <section id="cta" class="taskify-cta text-center">
        <div class="container">
            <h2>Pronto para revolucionar sua produtividade?</h2>
            <p>Inscreva-se agora e comece a usar o Taskify gratuitamente!</p>
            <a href="#" class="btn btn-primary btn-glow">Inscreva-se</a>
        </div>
    </section>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particlesjs/2.2.3/particles.min.js"></script>
    <script src="../Script/cursor.js"></script>
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