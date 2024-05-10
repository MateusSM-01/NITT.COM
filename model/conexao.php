<?php
$servidor='localhost';
$usuario='root';
$senha='';
$db='DADOSNITT';

$con=mysqli_connect($servidor, $usuario, $senha,$db);

if(!$con){
    print("Ocorreu um erro durante a conexão com MYSQL!");
    print("Erro: ".mysqli_connect_error());
    exit;
}else{
    print("Conexão bem sucedida!");
}
?>