<?php
include("../model/conexao.php");
session_start();
if (!isset($_SESSION["email"])) {
    header('Location: ../view/login.php?erro=Realize+o+login.');
    exit;
}

// Consulta SQL para buscar as matérias do usuário logado
$emailUsuario = $_SESSION["email"];
$queryMat = "SELECT id, nome FROM materias WHERE usuario_id = (
                SELECT id FROM usuarios WHERE email = ?
            )";
$stmtMat = mysqli_prepare($con, $queryMat);
mysqli_stmt_bind_param($stmtMat, "s", $emailUsuario);
mysqli_stmt_execute($stmtMat);
$resultMat = mysqli_stmt_get_result($stmtMat);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Atividade</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">
    <link href="../css/cssmetas.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Adicionar Nova Atividade</h1>
        
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post" action="../controller/validaatividade.php">
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição da Atividade</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="data_entrega" class="form-label">Data de Entrega</label>
                        <input type="date" class="form-control" id="data_entrega" name="data_entrega" required>
                    </div>
                    <div class="mb-3">
                        <label for="materia_id" class="form-label">Matéria</label>
                        <select class="form-select" id="materia_id" name="materia_id" required>
                            <?php
                                // Loop através das matérias retornadas pela consulta e cria as opções para o menu suspenso
                                while ($row = mysqli_fetch_assoc($resultMat)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Adicionar Atividade</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
