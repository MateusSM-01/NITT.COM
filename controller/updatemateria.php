<?php
include("../model/conexao.php");

session_start();
if (!isset($_SESSION["email"])) {
    header('Location: ../view/login.php?erro=Realize+o+login.');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['nome'])) {
    $idMateria = intval($_POST['id']);
    $nomeMateria = trim($_POST['nome']);
    $emailUsuario = $_SESSION["email"];

    // Atualizar a matéria no banco de dados
    $queryUpdate = "UPDATE materias SET nome = ? WHERE id = ? AND usuario_id = (
                        SELECT id FROM usuarios WHERE email = ?
                    )";
    $stmtUpdate = mysqli_prepare($con, $queryUpdate);
    mysqli_stmt_bind_param($stmtUpdate, "sis", $nomeMateria, $idMateria, $emailUsuario);

    if (mysqli_stmt_execute($stmtUpdate)) {
        header('Location: ../view/materias.php?sucesso=Materia+atualizada+com+sucesso.');
        exit;
    } else {
        header('Location: ../view/editMateria.php?id=' . $idMateria . '&erro=Falha+ao+atualizar+matéria.');
        exit;
    }
} else {
    header('Location: ../view/index.php?erro=Dados+inválidos.');
    exit;
}
