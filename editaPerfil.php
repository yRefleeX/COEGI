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

// Obtém o ID do motorista da sessão
session_start();
$motorista_id = $_SESSION['motorista_id'];

// Função para verificar o número de telefone
function verificaTelefone($telefone) {
    // Remove caracteres não numéricos
    $telefone = preg_replace("/[^0-9]/", "", $telefone);
  
    // Verifica se o número tem 10 ou 11 dígitos e começa com 19
    if ((strlen($telefone) == 10 || strlen($telefone) == 11) && substr($telefone, 0, 2) === "19") {
      return true;
    } else {
      return false;
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST["nomeEdita"];
    $sobrenome = $_POST["sobrenomeEdita"];
    $cnh = $_POST["cnhEdita"];
    $preco = $_POST["precoEdita"];
    $rotas = $_POST["rotasEdita"];
    $telefone = $_POST["telefoneEdita"];
    $periodo= $_POST["periodoEdita"];
    $foto_2x2_1 = $_FILES["foto_2x2_1_edita"];

    // Consulta SQL para editar o perfil do motorista
    $sql = "UPDATE motorista SET ";

    // Array para armazenar os valores a serem vinculados
    $params = array();

    $types = "";

    // Verifica cada campo e adiciona à consulta apenas se não estiver vazio
    if (!empty($nome)) {
        $sql .= "nome = ?, ";
        $params[] = $nome;
        $types .= "s";
    }
    if (!empty($sobrenome)) {
        $sql .= "sobrenome = ?, ";
        $params[] = $sobrenome;
        $types .= "s";
    }
    if (!empty($cnh)) {
        $sql .= "cnh = ?, ";
        $params[] = $cnh;
        $types .= "s";
    }
    if (!empty($preco)) {
        $sql .= "preco = ?, ";
        $params[] = $preco;
        $types .= "d";
    }
    if (!empty($rotas)) {
        $sql .= "rotas = ?, ";
        $params[] = $rotas;
        $types .= "s";
    }
    if (!empty($telefone) && verificaTelefone($telefone)) {
        $sql .= "telefone = ?, ";
        $params[] = $telefone;
        $types .= "s";
    }
    if (!empty($periodo)) {
        $sql .= "periodo = ?, ";
        $params[] = $periodo;
        $types .= "s";
    }
    if($_FILES["foto_2x2_1_edita"]["error"] !== UPLOAD_ERR_NO_FILE){
        if($foto_2x2_1["error"]){
            die("Falha ao enviar as imagens!");
        }
        if($foto_2x2_1["size"] > 2097152){
            die("Imagem muito grande! Max: 2MB");
        }

        $pasta_2x2_1 = "imagens_2x2_1/";
     
        $nome_2x2_1 = $foto_2x2_1['name'];
     
        $novoNome_2x2_1 = uniqid();
     
        $extensao_2x2_1 = strtolower(pathinfo($nome_2x2_1, PATHINFO_EXTENSION));
     
        if($extensao_2x2_1 != 'jpg' && $extensao_2x2_1 != 'png'){
             die("Tipo de arquivo não aceito!");    
        }
     
        $path_2x2_1 = $pasta_2x2_1 . $novoNome_2x2_1 . "." . $extensao_2x2_1;

        // Remove a imagem antiga
        $sql_img_antiga = "SELECT path_2x2_1 FROM motorista WHERE motorista_id = ?";
        $stmt_img_antiga = $conn->prepare($sql_img_antiga);
        $stmt_img_antiga->bind_param("i", $motorista_id);
        $stmt_img_antiga->execute();
        $stmt_img_antiga->bind_result($imagem_antiga);
        $stmt_img_antiga->fetch();
        $stmt_img_antiga->close();
     
        if(!(move_uploaded_file($foto_2x2_1['tmp_name'], $path_2x2_1) && unlink($imagem_antiga))){
            die("Erro ao enviar o arquivo!");
        }

        $sql .= "path_2x2_1 = ?, ";
        $params[] = $path_2x2_1;
        $types .= "s";
    }

    // Remove a vírgula e o espaço extras do final da string SQL
    $sql = rtrim($sql, ', ');

    // Adiciona a cláusula WHERE para atualizar apenas o usuário logado
    $sql .= " WHERE motorista_id = ?";
    $params[] = $motorista_id;
    $types .= "i";

    // Prepara a declaração
    $stmt = $conn->prepare($sql);

    $stmt->bind_param($types, ...$params);

    // Executa a consulta
    if ($stmt->execute()) {
        echo "Dados atualizados com sucesso!";

        // Redireciona para a página principal
        header("Location: index.php");
    } else {
        echo "Erro ao atualizar dados: " . $stmt->error;
    }

    // Fecha a declaração
    $stmt->close();
}
?>