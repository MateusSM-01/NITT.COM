<?php

include("../model/materias.php");

session_start();
if (!isset($_SESSION["email"])) {
    header('Location: ../view/login.php?erro=Realize+o+login.');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nome"])) {
        $nome = $_POST["nome"];
        $emailUsuario = $_SESSION["email"];
        
        // Chama a função do modelo para adicionar a matéria
        adicionarMateria($nome, $emailUsuario);
    }
    header('Location: ../view/materias.php');
    exit;
}
?>