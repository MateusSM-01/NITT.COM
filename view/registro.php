<?php
    include("../model/conexao.php");
    // Verifica se há uma mensagem de erro na URL
    if (isset($_GET['erro'])) {
        // Exibe a mensagem de erro
        $mensagemErro = urldecode($_GET['erro']);
        echo '<div class="alert alert-danger" role="alert">';
        echo $mensagemErro;
        echo '</div>';
}
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
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="bg-dark">
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header">
                            <h3 class="text-center font-weight-light my-4 text-primary">Cadastre-se no NITT</h3> 
                            <div class="card-body">
                                <form method="post" action="../controller/validausuario.php">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" name="primeiroNome" id="inputFirstName" type="text" placeholder="Enter your first name" />
                                                <label for="inputFirstName">Primeiro nome</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input class="form-control" name="sobrenome" id="inputLastName" type="text" placeholder="Enter your last name" />
                                                <label for="inputLastName">Sobrenome</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" name="email" id="inputEmail" type="email" placeholder="name@example.com" />
                                        <label for="inputEmail">Email</label>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" name="senha" id="inputPassword" type="password" placeholder="Create a password" />
                                                <label for="inputPassword">Senha</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" name="confirmaSenha" type="password" placeholder="Confirm password" />
                                                <label for="inputPasswordConfirm">Confirme sua senha</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 mb-0">
                                        <div class="d-grid"><button type="submit" class="btn btn-primary btn-block">Criar uma conta</button></div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center py-3">
                                <div class="small"><a href="login.php">Ter uma conta? Ir para login</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <div id="layoutAuthentication_footer">
        <footer class="py-4 bg-light mt-auto">
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
</body>
</html>
