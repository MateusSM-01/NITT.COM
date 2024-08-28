<?php
include("conexao.php");


session_start();
if (!isset($_SESSION["email"])) {
    header('Location: ../view/login.php?erro=Realize+o+login.');
    exit;
}

function adicionarMateria($nome, $emailUsuario) {
    global $con;

    // Consulta SQL para obter o ID do usuário com base no email
    $queryUsuario = "SELECT id FROM usuarios WHERE email = ?";
    $stmtUsuario = mysqli_prepare($con, $queryUsuario);
    mysqli_stmt_bind_param($stmtUsuario, "s", $emailUsuario);
    mysqli_stmt_execute($stmtUsuario);
    mysqli_stmt_bind_result($stmtUsuario, $usuario_id);
    mysqli_stmt_fetch($stmtUsuario);
    mysqli_stmt_close($stmtUsuario);

    // Verifica se o ID do usuário foi encontrado
    if ($usuario_id) {
        // Consulta SQL para inserir uma nova matéria
        $queryMateria = "INSERT INTO materias (nome, usuario_id) VALUES (?, ?)";
        $stmtMateria = mysqli_prepare($con, $queryMateria);

        mysqli_stmt_bind_param($stmtMateria, "si", $nome, $usuario_id);
        mysqli_stmt_execute($stmtMateria);
        mysqli_stmt_close($stmtMateria);
    } else {
        header('Location: ../view/login.php?erro=Usuário+não+encontrado.');
        exit;
    }
}

// Função no modelo para excluir a matéria
function excluirMateria($con, $idMateria, $emailUsuario) {
    $queryDelete = "DELETE FROM materias WHERE id = ? AND usuario_id = (
                        SELECT id FROM usuarios WHERE email = ?
                    )"; 
    $stmtDelete = mysqli_prepare($con, $queryDelete);
    mysqli_stmt_bind_param($stmtDelete, "is", $idMateria, $emailUsuario);

    return mysqli_stmt_execute($stmtDelete);
}

?>
