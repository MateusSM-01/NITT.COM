<?php
include("../model/conexao.php");
include("../model/materias.php");

session_start();
if (!isset($_SESSION["email"])) {
    header('Location: ../view/login.php?erro=Realize+o+login.');
    exit;
}

if (isset($_GET['id'])) {
    $idMateria = intval($_GET['id']);
    $emailUsuario = $_SESSION["email"];

    // Tente excluir a matéria
    $resultado = excluirMateria($con, $idMateria, $emailUsuario);
    
    if ($resultado) {
        header('Location: ../view/materias.php?sucesso=Materia+excluida+com+sucesso.');
        exit;
    } else {
        header('Location: ../view/materias.php?erro=Falha+ao+excluir+matéria.');
        exit;
    }
} 
?>
