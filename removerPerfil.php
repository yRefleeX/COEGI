<?php
include_once("conexao.php");


if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}

// Obtém o ID do motorista da sessão
session_start();
$motorista_id = $_SESSION['motorista_id'];

$sqlRotaId = "SELECT id FROM rotas WHERE motorista_id = ?";
$stmtRota = $conn->prepare($sqlRotaId);
$stmtRota->bind_param("i", $motorista_id);
$stmtRota->execute();
$stmtRota->store_result();

if($stmtRota->num_rows > 0){
    // Consulta SQL para remover a rota
    $sqlRota = "DELETE FROM rotas WHERE motorista_id = '$motorista_id'";

    if(!mysqli_query($conn, $sqlRota)){
        die("Erro ao deletar o motorista.");
    }
}

// Consulta SQL para remover o motorista
$sqlMotorista = "DELETE FROM motorista WHERE motorista_id = '$motorista_id'";

// Remove as imagens das pastas

$sql_path_2x2_1 = "SELECT path_2x2_1 FROM motorista WHERE motorista_id = ?";
$stmt_path_2x2_1 = $conn->prepare($sql_path_2x2_1);
$stmt_path_2x2_1->bind_param("i", $motorista_id);
$stmt_path_2x2_1->execute();
$stmt_path_2x2_1->bind_result($path_2x2_1);
$stmt_path_2x2_1->fetch();
$stmt_path_2x2_1->close();

$sql_path_2x2_2 = "SELECT path_2x2_2 FROM motorista WHERE motorista_id = ?";
$stmt_path_2x2_2 = $conn->prepare($sql_path_2x2_2);
$stmt_path_2x2_2->bind_param("i", $motorista_id);
$stmt_path_2x2_2->execute();
$stmt_path_2x2_2->bind_result($path_2x2_2);
$stmt_path_2x2_2->fetch();
$stmt_path_2x2_2->close();

$sqlPathCrlv = "SELECT pathCrlv FROM motorista WHERE motorista_id = ?";
$stmtPathCrlv = $conn->prepare($sqlPathCrlv);
$stmtPathCrlv->bind_param("i", $motorista_id);
$stmtPathCrlv->execute();
$stmtPathCrlv->bind_result($pathCrlv);
$stmtPathCrlv->fetch();
$stmtPathCrlv->close();

if(!(mysqli_query($conn, $sqlMotorista) && unlink($path_2x2_1) && unlink($path_2x2_2) && unlink($pathCrlv))){
    die("Erro ao deletar o motorista.");
}

// Faz logout da sessão
session_destroy();
header("location: index.php");
?>