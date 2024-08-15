<?php
    include("../model/conexao.php");
    include("useful/footermat.php");
    include("useful/header.php");

    session_start();
    if (!isset($_SESSION["email"])) {
        header('Location: ../view/login.php?erro=Realize+o+login.');
        exit;
    }

    // Obtém o email do usuário atualmente logado
    $emailUsuario = $_SESSION["email"];

    // Consulta SQL para selecionar as matérias associadas ao usuário atual
    $query = "SELECT * FROM materias WHERE usuario_id = (
                SELECT id FROM usuarios WHERE email = ?
              )";
              
    // Prepara a consulta
    $stmt = mysqli_prepare($con, $query);
    
    // Vincula o parâmetro de email
    mysqli_stmt_bind_param($stmt, "s", $emailUsuario);
    
    // Executa a consulta
    mysqli_stmt_execute($stmt);
    
    // Obtém o resultado da consulta
    $result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materias</title>
    
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">
    <link href="../css/cssmetas.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="bg-dark">

    <div class="container-fluid px-4">
        <h1 class="mt-4 text-primary m-4"> Aqui estão suas matérias! </h1>
        <div class="row">
            <?php
                // Verifica se há matérias retornadas pela consulta
                if (mysqli_num_rows($result) > 0) {
                    // Loop através de cada linha de dados
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col">';
                        echo '<div class="card mb-3">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $row["nome"] . '</h5>';
                        echo '<div class="meta-item">';
                        echo '<div class="meta-value-edit">';
                        echo '<a href="editmateria.php?id='. $row["id"].'" class="btn btn-secondary">Editar</a>';            
                        echo '</div>';
                        echo '</div>' ;   
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="col">';
                    echo '<div class="alert alert-info" role="alert">Nenhuma matéria encontrada.</div>';
                    echo '</div>';
                }
            ?>
        </div>
    </div>
</body>
</html>
