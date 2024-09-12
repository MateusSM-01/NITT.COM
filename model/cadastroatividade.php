<?php
include("conexao.php");

function adicionarAtividade(
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
) {
    // Sua lógica de conexão com o banco de dados
    // Adicione a consulta SQL para inserir os dados na tabela `atividades`
    $sql = "INSERT INTO atividades 
            (nome, descricao, data_entrega, motivo, responsavel, tipo_atividade, quantidade, viavel, prioridade, prazo, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare a consulta usando a conexão com o banco de dados
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param(
        "ssssssisiis",
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
        $status
    );

    // Execute a consulta e verifique por erros
    if ($stmt->execute()) {
        echo "Atividade adicionada com sucesso!";
    } else {
        echo "Erro ao adicionar atividade: " . $stmt->error;
    }

    $stmt->close();
    $conexao->close();
}

?>
