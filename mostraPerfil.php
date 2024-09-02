<?php
include_once("conexao.php");

if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    // Quando entrar nessa condição, significa que o usuário tentou acessar o link diretamente    
    // Faça algo.
    die();        
}

// Obtém o ID do motorista da sessão
session_start();
$motorista_id = $_SESSION['motorista_id'];

// Consulta SQL para buscar os dados do motorista
$sql = "SELECT * FROM motorista WHERE motorista_id = '$motorista_id'";

$result = mysqli_query($conn, $sql);

// Verifica se a consulta retornou resultados
if (mysqli_num_rows($result) > 0) {
    // Obtém os dados do motorista
    $row = mysqli_fetch_assoc($result);

    // Retorna os dados como JSON
    echo json_encode($row);
} else {
    echo json_encode([]); // Retorna um array vazio se nenhum dado for encontrado
}

mysqli_close($conn);
?>