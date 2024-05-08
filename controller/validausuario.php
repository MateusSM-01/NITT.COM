<?php
    // Inclua o arquivo de conexão
    include("../model/conexao.php");

    // Inclua o arquivo do modelo de usuários
    include("../model/cadastrousuario.php");

    // Se o formulário de registro foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recupere os dados do formulário
        $primeiroNome = $_POST["primeiroNome"];
        $sobrenome = $_POST["sobrenome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        
        // Verifique se o email já existe
        if (!emailExiste($email)) {
            // Se o email não existe, insira o novo usuário no banco de dados
            if (cadastrarUsuario($primeiroNome, $sobrenome, $email, $senha)) {
                // Redirecione para a página de login ou outra página
                header("Location: login.html");
                exit();
            } else {
                echo "Erro ao cadastrar o usuário.";
            }
        } else {
            echo "Este email já está em uso.";
        }
    }
?>
