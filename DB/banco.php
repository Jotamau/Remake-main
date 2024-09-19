<?php
session_start(); // Certifique-se de que a sessão está iniciada

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Configuração da conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "taskify";

    // Criando a conexão com o MySQL
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificando a conexão
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}
?>