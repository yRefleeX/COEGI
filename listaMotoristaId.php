<?php
// Conexão com o banco de dados
include_once("conexao.php");

if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
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