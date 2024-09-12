<?php
include("../model/cadastroatividade.php");

session_start();
if (!isset($_SESSION["email"])) {
    header('Location: ../view/login.php?erro=Realize+o+login.');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos necessários foram enviados pelo formulário
    if (
        isset($_POST["nome"]) &&
        isset($_POST["descricao"]) &&
        isset($_POST["data_entrega"]) &&
        isset($_POST["motivo"]) &&
        isset($_POST["responsavel"]) &&
        isset($_POST["tipo_atividade"]) &&
        isset($_POST["quantidade"]) &&
        isset($_POST["viavel"]) &&
        isset($_POST["prioridade"]) &&
        isset($_POST["prazo"]) &&
        isset($_POST["status"])
    ) {
        // Captura os dados do formulário
        $nome = $_POST["nome"];
        $descricao = $_POST["descricao"];
        $data_entrega = $_POST["data_entrega"];
        $motivo = $_POST["motivo"];
        $responsavel = $_POST["responsavel"];
        $tipo_atividade = $_POST["tipo_atividade"];
        $quantidade = $_POST["quantidade"];
        $viavel = $_POST["viavel"];
        $prioridade = $_POST["prioridade"];
        $prazo = $_POST["prazo"];
        $status = $_POST["status"];
        $emailUsuario = $_SESSION["email"]; // Presumindo que o e-mail do usuário é necessário para alguma lógica

        // Chama a função do modelo para adicionar a atividade
        adicionarAtividade(
            $nome,
            $descricao,
            $data_entrega,
            $motivo,
            $responsavel,
            $tipo_atividade,
            $quantidade,
            $viavel,
            $prioridade,
            $prazo,
            $status,
            $emailUsuario
        );
    }
    header('Location: ../view/index.php');
    exit;
}
?>
