<?php
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

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $geojsonData = $_POST['geojson'];
    $motorista_id = $_POST['motorista_id'];
    $rotasVal = $_POST['valoresRota'];

    if($rotasVal === 'tarde'){
        $sql = "UPDATE rotas SET pontos_rota = ? WHERE motorista_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $geojsonData, $motorista_id);
    }
    elseif($rotasVal === 'manha'){
        $sql = "UPDATE rotas SET pontos_rota_manha = ? WHERE motorista_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $geojsonData, $motorista_id);
    }
    else{
        $sql = "UPDATE rotas SET pontos_rota_noite = ? WHERE motorista_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $geojsonData, $motorista_id);
    }

    if ($stmt->execute()) {
        echo json_encode(['status' => 'sucesso', 'mensagem' => 'Rota atualizada com sucesso!']);
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao atualizar rota: ' . $stmt->error]);
    }
    
    $stmt->close();
}
else{
    echo json_encode(['status' => 'erro', 'mensagem' => 'Dados inválidos.']);
}