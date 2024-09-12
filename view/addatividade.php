<?php
include("../model/conexao.php");
include("useful/header2.php");
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
<body class="bg-dark">
<div class="container mt-5 ">
    <h1 class="text-center mb-4 text-white-75">Adicionar Nova Meta</h1>
    <div class="d-flex justify-content-center align-items-center">
        <div class="col-md-6">
            <form method="post" action="../controller/validaatividade.php" class="text-center">
                <div class="mb-3">
                    <label for="nome" class="form-label text-white-50">Nome da Atividade:</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="mb-3">
                    <label for="descricao" class="form-label text-white-50">Descrição da Atividade:</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="motivo" class="form-label text-white-50">Motivo:</label>
                    <textarea class="form-control" id="motivo" name="motivo" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label for="responsavel" class="form-label text-white-50">Responsável:</label>
                    <input type="text" class="form-control" id="responsavel" name="responsavel">
                </div>
                <div class="mb-3">
                    <label for="tipo_atividade" class="form-label text-white-50">Tipo de Atividade:</label>
                    <select class="form-select form-control" id="tipo_atividade" name="tipo_atividade" required>
                        <option value="Horas">Horas</option>
                        <option value="Lista de Exercício">Lista de Exercício</option>
                        <option value="Documento">Documento</option>
                        <option value="Projeto">Projeto</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="quantidade" class="form-label text-white-50">Quantidade:</label>
                    <input type="number" class="form-control" id="quantidade" name="quantidade" min="0">
                </div>
                <div class="mb-3">
                    <label for="viavel" class="form-label text-white-50">Viável:</label>
                    <select class="form-select form-control" id="viavel" name="viavel">
                        <option value="Sim">Sim</option>
                        <option value="Não">Não</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="prioridade" class="form-label text-white-50">Prioridade:</label>
                    <input type="number" class="form-control" id="prioridade" name="prioridade" min="1">
                </div>
                <div class="mb-3">
                    <label for="prazo" class="form-label text-white-50">Prazo:</label>
                    <input type="date" class="form-control" id="prazo" name="prazo">
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label text-white-50">Status:</label>
                    <input type="text" class="form-control" id="status" name="status">
                </div>
                <div class="mb-3">
                    <label for="data_entrega" class="form-label text-white-50">Data de Entrega:</label>
                    <input type="date" class="form-control" id="data_entrega" name="data_entrega" required>
                </div>
                <div class="mb-3">
                    <label for="materia_id" class="form-label text-white-50">Matéria:</label>
                    <select class="form-select form-control" id="materia_id" name="materia_id" required>
                        <?php
                            // Loop através das matérias retornadas pela consulta e cria as opções para o menu suspenso
                            while ($row = mysqli_fetch_assoc($resultMat)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                            }
                        ?>
                    </select>
                </div>
               
                <button type="submit" class="btn btn-primary my-4">Adicionar Atividade</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
