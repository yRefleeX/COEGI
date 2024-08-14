<?php
include_once("conexao.php");

if (!$conn) {
  die("Conexão falhou: " . mysqli_connect_error());
}

// Obtém o ID do motorista da requisição GET
$motoristaId = $_GET['motorista_id'];

if(isset($_GET['valoresRota'])){
  $rotasVal = $_GET['valoresRota'];
  
  // Consulta SQL para buscar a rota do motorista
  $sql = "SELECT pontos_rota_$rotasVal FROM rotas WHERE motorista_id = ?"; 
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $motoristaId);
  $stmt->execute();
  $stmt->bind_result($pontosRota); 
  $stmt->fetch();
  $stmt->close();
}
else{
  die();
}

// Formata a resposta como JSON
$rota = array(
  'motorista_id' => $motoristaId,
  'geojson' => json_decode($pontosRota, true) // Decodifica o GeoJSON
);

header('Content-Type: application/json');
echo json_encode($rota); 

$conn->close();
?>