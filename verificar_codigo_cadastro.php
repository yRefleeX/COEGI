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

    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $codigoInserido = $_POST['codigo'];
        $email = $_POST['email'];
    
        // Consulta o banco de dados
        $sql = "SELECT ve.codigo_verificacao, ve.data_expiracao, ve.email
                FROM verificacao_email ve
                WHERE ve.email = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($codigoSalvo, $dataExpiracao, $emailSalvo);
        $stmt->fetch();
    
        // Verifica se o código existe e se não expirou
        if ($codigoInserido === $codigoSalvo && strtotime($dataExpiracao) > time() && $emailSalvo === $email) {
            // Recupera os dados do usuário da sessão
            $nome = $_SESSION['dados_motorista']['nome'];
            $sobrenome = $_SESSION['dados_motorista']['sobrenome'];
            $cotac = $_SESSION['dados_motorista']['cotac'];
            $preco = $_SESSION['dados_motorista']['preco'];
            $rotas = $_SESSION['dados_motorista']['rotas'];
            $periodo = $_SESSION['dados_motorista']['periodo'];
            $telefone = $_SESSION['dados_motorista']['telefone'];
            $senha = $_SESSION['dados_motorista']['senha'];
            $tempPath_2x2_1 = $_SESSION['dados_motorista']['tempPath_2x2_1'];
            $tempPath_2x2_2 = $_SESSION['dados_motorista']['tempPath_2x2_2'];
            $tempPathCrlv = $_SESSION['dados_motorista']['tempPathCrlv'];

            $pasta_2x2_1 = "imagens_2x2_1/";
            $pasta_2x2_2 = "imagens_2x2_2/";
            $pastaCrlv = "imagensCrlv/";

            $stmt->close(); // Fecha o statement da consulta SELECT 

            $nome_2x2_1 = basename($tempPath_2x2_1);
            $nome_2x2_2 = basename($tempPath_2x2_2);
            $nomeCrlv = basename($tempPathCrlv);

            $path_2x2_1 = $pasta_2x2_1 . $nome_2x2_1;
            $path_2x2_2 = $pasta_2x2_2 . $nome_2x2_2;
            $pathCrlv = $pastaCrlv . $nomeCrlv;

            if(copy($tempPath_2x2_1, $path_2x2_1) && copy($tempPath_2x2_2, $path_2x2_2) && copy($tempPathCrlv, $pathCrlv)){
                // Cria uma data de expiração para verificar o motorista
                $dataExpiracaoMot = date('Y-m-d H:i:s', strtotime('+1 month'));
                $verificacao = 0;

                $sql = "insert into motorista(verificacao,data_expiracao,nome,sobrenome,cotac,preco,rotas,telefone,periodo,email,senha,path_2x2_1,path_2x2_2,pathCrlv)values(?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("issssdsssssssss", $verificacao, $dataExpiracaoMot, $nome, $sobrenome, $placa, $cotac, $preco, $rotas, $telefone, $periodo, $email, $senha, $path_2x2_1, $path_2x2_2, $pathCrlv);

                if (($stmt->execute())) {
                    // Remove o código da tabela 'verificacao_email'
                    $sql = "DELETE FROM verificacao_email WHERE email = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
        
                    // Destrói as variáveis de sessão 
                    unset($_SESSION['email_verificacao']);
                    unset($_SESSION['dados_motorista']);

                    unlink($tempPath_2x2_1);
                    unlink($tempPath_2x2_2);
                    unlink($tempPathCrlv);
        
                    echo 'Usuário cadastrado e email verificado com sucesso!';
                    
                    // Redireciona para a página principal
                    header("Location: index.php");
                    exit();
        
                } else {
                    echo "Erro ao cadastrar o usuário: " . $stmt->error;
                }

                $stmt->close();
            }
            else{
                echo "ERRO AO ARMAZENAR O ARQUIVO";
            }
        }
        else {
            echo "Código de verificação inválido ou expirado.";
        }
    }
?>