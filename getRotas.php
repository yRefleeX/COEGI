<?php
include_once("conexao.php");

if (!$conn) {
  die("Conexão falhou: " . mysqli_connect_error());
}

// Consulta para obter as rotas
$sql = "SELECT * FROM rotas";
$result = $conn->query($sql);

$rotas = [];

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $rotas[] = array(
      'motorista_id' => $row['motorista_id'], // Adapte o nome da coluna se necessário
      'geojson' => json_decode($row['pontos_rota'], true) // Decodifica o GeoJSON da rota
    );
  }
} 

$conn->close();

// Retorna as rotas como JSON
header('Content-Type: application/json');
echo json_encode($rotas);
?>