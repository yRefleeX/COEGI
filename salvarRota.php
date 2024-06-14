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

// Verifica se houve requisição POST e se os dados da rota foram enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['geojson'])) {
    session_start();
    // Extraia o ID do motorista da sessão ou de algum lugar seguro
    $motorista_id = $_SESSION['motorista_id'] ?? 'Motorista Desconhecido';
    
    // Verifica se o motorista já possui uma rota
    $sqlVerificaRota = "SELECT id FROM rotas WHERE motorista_id = ?";
    $stmtVerifica = $conn->prepare($sqlVerificaRota);
    $stmtVerifica->bind_param("i", $motorista_id);
    $stmtVerifica->execute();
    $stmtVerifica->store_result();

    if ($stmtVerifica->num_rows > 0) {
        // O motorista já possui uma rota, retorna erro
        echo json_encode(['status' => 'erro', 'mensagem' => 'Você já possui uma rota cadastrada.']);
        $stmtVerifica->close();
    }
    else{
        $stmtVerifica->close();
        // Obtém os dados da rota (em formato GeoJSON) enviados via AJAX
        $geojsonData = $_POST['geojson'];
    
        // Converte o GeoJSON (string) para um objeto PHP
        $geojson = json_decode($geojsonData);

        // Consulta SQL para inserir a rota no banco de dados
        $sql = "INSERT INTO rotas (motorista_id, pontos_rota) VALUES (?, ?)";
        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("is", $motorista_id, $geojsonData);

        if ($stmt->execute()){
            echo json_encode(['status' => 'sucesso', 'mensagem' => 'Rota salva com sucesso!']);
        }
        else{
            echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao salvar rota: ' . $stmt->error]);
        }

        $stmt->close();
    }
}
else{
    echo json_encode(['status' => 'erro', 'mensagem' => 'Requisição inválida.']);
}

$conn->close();
?>