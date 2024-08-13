<?php
include("../model/cadastroatividade.php");

session_start();
if (!isset($_SESSION["email"])) {
    header('Location: ../view/login.php?erro=Realize+o+login.');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["descricao"]) && isset($_POST["data_entrega"]) && isset($_POST["materia_id"])) {
        $descricao = $_POST["descricao"];
        $data_entrega = $_POST["data_entrega"];
        $materia_id = $_POST["materia_id"];
        $emailUsuario = $_SESSION["email"];
        
        // Chama a função do modelo para adicionar a atividade
        adicionarAtividade($descricao, $data_entrega, $materia_id, $emailUsuario);
    }
    header('Location: ../view/index.php');
    exit;
}
?>
