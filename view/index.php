<?php
    include("../model/conexao.php");
    session_start();
    if (isset($_SESSION["email"])) {
        // O usuário está autenticado, continue com a lógica da aplicação
?>   
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>NITT</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <link href="../css/cssmetas.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body>

            <div id="layoutSidenav_content">
                <main>
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
                            <div class="card">
                                <div class="card-body">
                                  <div class="meta">
                                    <div class="meta-item">
                                      <div class="meta-value-large">DESENVOLVIMENTO DE UM SITE</div>
                                    </div>
                                    <div class="meta-item">
                                      <div class="meta-value-medium">Matéria : WEB</div>
                                      <div class="meta-value-medium">Prof. : RODRIGO</div>
                                    </div>
                                    <div class="meta-item">
                                      <div class="meta-value-small">Tempo definido</div>
                                      <div class="meta-value-small-bold">23/03/2024</div>
                                    </div>
                                    <div class="meta-item">
                                        <div class="meta-value-small-bold">Iniciar</div> <div class="meta-value-play"><a href="#"></a></div>
                                    </div>
                                  </div>
                                </div>
                              </div>            
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mb-1">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">NITT&copy;2024</div>
                            <div>
                                <a href="#">Politica de Privacidade</a>
                                &middot;
                                <a href="#">
                                    Termos &amp; Condições</a>
                            </div>
                        </div>
                    </div>
                </footer>
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
<?php
} else {
    header('Location: ../view/login.php?erro=Realize+o+login.');
    exit;
}
?>