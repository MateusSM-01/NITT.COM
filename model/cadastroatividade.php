<?php
include("conexao.php");

function adicionarAtividade($descricao, $data_entrega, $materia_id, $emailUsuario) {
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
        // Consulta SQL para inserir uma nova atividade
        $queryAtividade = "INSERT INTO atividades (descricao, data_entrega, materia_id, usuario_id) VALUES (?, ?, ?, ?)";
        $stmtAtividade = mysqli_prepare($con, $queryAtividade);

        mysqli_stmt_bind_param($stmtAtividade, "ssii", $descricao, $data_entrega, $materia_id, $usuario_id);
        mysqli_stmt_execute($stmtAtividade);
        mysqli_stmt_close($stmtAtividade);
    } else {
        header('Location: ../view/login.php?erro=Usuário+não+encontrado.');
        exit;
    }
}
?>
