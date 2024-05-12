<?php
include("../model/conexao.php");

session_start();
if (!isset($_SESSION["email"])) {
    header('Location: ../view/login.php?erro=Realize+o+login.');
    exit;
}else{

// Consulta SQL para buscar as atividades do usuário logado
$emailUsuario = $_SESSION["email"];
$queryAtividades = "SELECT * FROM atividades WHERE usuario_id = (
                    SELECT id FROM usuarios WHERE email = ?
                    )";
$stmtAtividades = mysqli_prepare($con, $queryAtividades);
mysqli_stmt_bind_param($stmtAtividades, "s", $emailUsuario);
mysqli_stmt_execute($stmtAtividades);
$resultAtividades = mysqli_stmt_get_result($stmtAtividades);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>NITT</title>
    <link href="../css/styles.css" rel="stylesheet">
    <link href="../css/cssmetas.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body>

    <div id="layoutSidenav_content">
        <main>
        <form action="../controller/logout.php" method="post">
            <button type="submit" class="btn btn-primary">Sair</button>
        </form>

            <div class="container-fluid px-4">
                <h1 class="mt-4"> Aqui estão seus à fazeres ! </h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">FRASE MOTIVACIONAL</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        ORGANIZE OS SEUS ESTUDOS
                    </div>
                    <?php while ($row = mysqli_fetch_assoc($resultAtividades)) { ?>
                    <div class="card-body mb-4">
                        <div class="meta">
                            <div class="meta-item">
                                <div class="meta-value-large"><?php echo $row['descricao']; ?></div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-value-medium">Matéria: <?php echo $row['materia_id']; ?></div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-value-small">Data de Entrega: <?php echo $row['data_entrega']; ?></div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-value-small-bold">Iniciar</div> <div class="meta-value-play"><a href="#"></a></div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </main>
        
        <div class="fixed-bottom mb-4 d-flex justify-content-around">
                    <div class="col text-center">
                        <a href="../view/index.php"><button type="button" class="btn btn-primary">Home</button></a>
                    </div>
                    <div class="col text-center">
                        <a href="../view/addatividade.php"><button type="button" class="btn btn-primary">Adicionar Atividade</button></a>
                    </div>
                    <div class="col text-center">
                        <a href="../view/materias.php"><button type="button" class="btn btn-primary">Matérias</button></a>
                    </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>
