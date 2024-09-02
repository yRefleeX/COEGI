<?php
// Conexão com o banco de dados
include_once("conexao.php");

if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}

// Verifica o local de execução do script PHP
if ($_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    // Quando entrar nessa condição, significa que o usuário tentou acessar o link diretamente    
    // Faça algo.
    die();        
}

// Receba o idMot da solicitação AJAX
$idMot = $_POST['idMot'];

// Consulte o banco de dados para obter os detalhes do perueiro
$query = "SELECT * FROM motorista WHERE motorista_id = $idMot";
$resultado = mysqli_query($conn, $query);
$dados = mysqli_fetch_assoc($resultado);

// Converta os dados em JSON e envie a resposta
header('Content-Type: application/json');
echo json_encode($dados);
?>