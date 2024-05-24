<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

ini_set("display_errors", 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("conexao.php");


if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}

session_start();

function gerarCodigo($tamanho = 6) {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $codigo = '';
    for ($i = 0; $i < $tamanho; $i++) {
        $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $codigo;
}

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

function verificaEmail($email) {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return false;
    }

    $dominio = explode('@', $email)[1];
    return checkdnsrr($dominio, 'MX');
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST["nome"];
    $sobrenome = $_POST["sobrenome"];
    $cpf = $_POST["cpf"];
    $rg = $_POST["rg"];
    $cnh = $_POST["cnh"];
    $preco = $_POST["preco"];
    $rotas = $_POST["rotas"];
    $telefone = $_POST["telefone"];
    $periodo= $_POST["periodo"];
    $email = $_POST["email"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
    $res = $_FILES["res"];
    $foto_2x2_1 = $_FILES["foto_2x2_1"];
    $foto_2x2_2 = $_FILES["foto_2x2_2"];
    $crlv = $_FILES["crlv"];

    if($res["error"] || $foto_2x2_1["error"] || $foto_2x2_2["error"] || $crlv["error"]){
        die("Falha ao enviar as imagens!");
    }

    if($res["size"] > 2097152 || $foto_2x2_1["size"] > 2097152 || $foto_2x2_2["size"] > 2097152 || $crlv["size"] > 2097152){
        die("Imagens muito grandes! Max: 2MB");
    }

   $tempPastaRes = "tempRes/";
   $tempPasta_2x2_1 = "temp_2x2_1/";
   $tempPasta_2x2_2 = "temp_2x2_2/";
   $tempPastaCrlv = "tempCrlv/";

   $nomeRes = $res['name'];
   $nome_2x2_1 = $foto_2x2_1['name'];
   $nome_2x2_2 = $foto_2x2_2['name'];
   $nomeCrlv = $crlv['name'];

   $novoNomeRes = uniqid();
   $novoNome_2x2_1 = uniqid();
   $novoNome_2x2_2 = uniqid();
   $novoNomeCrlv = uniqid();

   $extensaoRes = strtolower(pathinfo($nomeRes, PATHINFO_EXTENSION));
   $extensao_2x2_1 = strtolower(pathinfo($nome_2x2_1, PATHINFO_EXTENSION));
   $extensao_2x2_2 = strtolower(pathinfo($nome_2x2_2, PATHINFO_EXTENSION));
   $extensaoCrlv = strtolower(pathinfo($nomeCrlv, PATHINFO_EXTENSION));

   if(($extensaoRes != 'jpg' && $extensaoRes != 'png') || ($extensao_2x2_1 != 'jpg' && $extensao_2x2_1 != 'png') || ($extensao_2x2_2 != 'jpg' && $extensao_2x2_2 != 'png') || ($extensaoCrlv != 'jpg' && $extensaoCrlv != 'png')){
        die("Tipo de arquivo não aceito!");    
   }

   $tempPathRes = $tempPastaRes . $novoNomeRes . "." . $extensaoRes;
   $tempPath_2x2_1 = $tempPasta_2x2_1 . $novoNome_2x2_1 . "." . $extensao_2x2_1;
   $tempPath_2x2_2 = $tempPasta_2x2_2 . $novoNome_2x2_2 . "." . $extensao_2x2_2;
   $tempPathCrlv = $tempPastaCrlv . $novoNomeCrlv . "." . $extensaoCrlv;

   move_uploaded_file($res['tmp_name'], $tempPathRes);
   move_uploaded_file($foto_2x2_1['tmp_name'], $tempPath_2x2_1);
   move_uploaded_file($foto_2x2_2['tmp_name'], $tempPath_2x2_2);
   move_uploaded_file($crlv['tmp_name'], $tempPathCrlv);

    if(!(empty($nome) || empty($sobrenome) || empty($cpf) || empty($rg) || empty($cnh) || empty($preco) || empty($rotas) || empty($periodo) || empty($email) || empty($senha))){

        if(verificaTelefone($telefone) && verificaEmail($email)){
            // Gere um código de 6 caracteres
            $codigoVerificacao = gerarCodigo();

            $_SESSION['dados_motorista'] = [
                'nome' => $nome,
                'sobrenome' => $sobrenome,
                'rg' => $rg,
                'cpf' => $cpf,
                'cnh' => $cnh,
                'preco' => $preco,
                'rotas' => $rotas,
                'telefone' => $telefone,
                'periodo' => $periodo,
                'email' => $email,
                'senha' => $senha,
                'tempPathRes' => $tempPathRes,
                'tempPath_2x2_1' => $tempPath_2x2_1,
                'tempPath_2x2_2' => $tempPath_2x2_2,
                'tempPathCrlv' => $tempPathCrlv
            ];

            $dataExpiracao = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $sql = "INSERT INTO verificacao_email (email, codigo_verificacao, data_expiracao) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $email, $codigoVerificacao, $dataExpiracao);

            if($stmt->execute()){
                $_SESSION['email_verificacao'] = $email;

                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'no-reply@coegi.com.br';                     //SMTP username
                    $mail->Password   = '972356noreplyCoegi,';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('no-reply@coegi.com.br', 'COEGI');
                    $mail->addAddress($email);
            
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Confirmação de email';
                    $mail->Body    = "Seu código de verificação é: <b>$codigoVerificacao</b><br>
                                    Clique aqui para verificar seu email: <a href='localhost/COEGI/verificar_email.php'>Verificar Email</a>";
            
                    if($mail->send()) {
                        // Redireciona para verificar_email.php 
                        header("Location: verificar_email.php");
                        exit(); 
                    } else {
                        echo "Erro ao enviar email: " . $mail->ErrorInfo;
                    }
                }
                catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
            else {
                echo "Erro ao cadastrar o usuário: " . $stmt->error;
            }
        }
        else{
            if(!verificaTelefone($telefone)){
                echo "<p class='error-message'>Telefone inválido.</p>";
            }
            if (!verificaEmail($email)) {
                echo "<p class='error-message'>Email inválido.</p>";
            }
        }
    }
    else{
        echo "<p class='error-message'>Preencha todos os campos</p>";
    }
}

?>