<?php
include("../model/conexao.php");
include("useful/footeratv.php");
include("useful/header.php");

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

// Consulta SQL para buscar uma frase motivacional aleatória
$queryFraseMotivacional = "SELECT Frase FROM FrasesMotivac ORDER BY RAND() LIMIT 1";
$resultFraseMotivacional = mysqli_query($con, $queryFraseMotivacional);
$fraseMotivacional = mysqli_fetch_assoc($resultFraseMotivacional)['Frase'];
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
    <title>Suas atividades</title>
    <link rel="shortcut icon" href="../imgs/nittlogo.png" />
    <link href="../css/styles.css" rel="stylesheet">
    <link href="../css/cssmetas.css" rel="stylesheet">
</head>
<body class="bg-dark"> 
    <main >
        <div class=" container-fluid px-4">
            <h1 class="mt-4 text-primary mx-4"> Aqui estão seus à fazeres ! </h1>
            <ol class="breadcrumb mb-4 mx-4">
                <li class="breadcrumb-item active"><?php echo $fraseMotivacional; ?></li>
            </ol>
            <div class="card mb-4">
                <?php while ($row = mysqli_fetch_assoc($resultAtividades)) { ?>
                <div class="card-body mb-4 mx-5">
                    <div class="meta ">
                        <div class="meta-item ">
                            <div class="meta-value-large"><?php print_r($row['nome']); ?></div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>
