<?php
    include_once("conexao.php");


    if (!$conn) {
        die("Conexão falhou: " . mysqli_connect_error());
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
            // Recupere os dados do usuário da sessão
            $nome = $_SESSION['dados_motorista']['nome'];
            $sobrenome = $_SESSION['dados_motorista']['sobrenome'];
            $rg = $_SESSION['dados_motorista']['rg'];
            $cpf = $_SESSION['dados_motorista']['cpf'];
            $cnh = $_SESSION['dados_motorista']['cnh'];
            $preco = $_SESSION['dados_motorista']['preco'];
            $rotas = $_SESSION['dados_motorista']['rotas'];
            $periodo = $_SESSION['dados_motorista']['periodo'];
            $telefone = $_SESSION['dados_motorista']['telefone'];
            $senha = $_SESSION['dados_motorista']['senha'];
            $pathRes = $_SESSION['dados_motorista']['pathRes'];
            $path_2x2_1 = $_SESSION['dados_motorista']['path_2x2_1'];
            $path_2x2_2 = $_SESSION['dados_motorista']['path_2x2_2'];
            $pathCrlv = $_SESSION['dados_motorista']['pathCrlv'];
            
            $res = $_SESSION['dados_motorista']['res'];
            $foto_2x2_1 = $_SESSION['dados_motorista']['foto_2x2_1'];
            $foto_2x2_2 = $_SESSION['dados_motorista']['foto_2x2_2'];
            $crlv = $_SESSION['dados_motorista']['crlv'];

            $stmt->close(); // Fecha o statement da consulta SELECT 

            $deu_certoRes = move_uploaded_file($res['tmp_name'], $pathRes);
            $deu_certo_2x2_1 = move_uploaded_file($foto_2x2_1['tmp_name'], $path_2x2_1);
            $deu_certo_2x2_2 = move_uploaded_file($foto_2x2_2['tmp_name'], $path_2x2_2);
            $deu_certoCrlv = move_uploaded_file($crlv['tmp_name'], $pathCrlv);

            $sql = "insert into motorista(nome,sobrenome,rg,cpf,cnh,preco,rotas,telefone,periodo,email,senha,pathRes,path_2x2_1,path_2x2_2,pathCrlv)values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssdsssssssss", $nome, $sobrenome, $rg, $cpf, $cnh, $preco, $rotas, $telefone, $periodo, $email, $senha, $pathRes, $path_2x2_1, $path_2x2_2, $pathCrlv);


            // DEU ERRO AQUI - AJUSTAR PARA VER O QUE ESTÁ ACONTECENDO (o erro está em: "&& ($deu_certoRes && $deu_certo_2x2_1 && $deu_certo_2x2_2 && $deu_certoCrlv")
            // Não está armazenando as imagens nas pastas!
            if (($stmt->execute()) && ($deu_certoRes && $deu_certo_2x2_1 && $deu_certo_2x2_2 && $deu_certoCrlv)) {
                // Remove o código da tabela 'verificacao_email'
                $sql = "DELETE FROM verificacao_email WHERE email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $email);
                $stmt->execute();
    
                // Destrói as variáveis de sessão 
                unset($_SESSION['email_verificacao']);
                unset($_SESSION['dados_motorista']);
    
                echo 'Usuário cadastrado e email verificado com sucesso!';
                
                // Redirecione para a página de login ou outra página de sua preferência
                header("Location: index.php");
                exit();
    
            } else {
                echo "Erro ao cadastrar o usuário: " . $stmt->error;
            }
        } else {
            echo "Código de verificação inválido ou expirado.";
        }

        $stmt->close();
    }
?>