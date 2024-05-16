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
    $foto_2x2_1 = $_FILES["2x2_1"];
    $foto_2x2_2 = $_FILES["2x2_2"];
    $crlv = $_FILES["crlv"];

    if($res["error"] || $foto_2x2_1["error"] || $foto_2x2_2["error"] || $crlv["error"]){
        die("Falha ao enviar as imagens!");
    }

    if($res["size"] > 2097152 || $foto_2x2_1["size"] > 2097152 || $foto_2x2_2["size"] > 2097152 || $crlv["size"] > 2097152){
        die("Imagens muito grandes! Max: 2MB");
    }

   $pastaRes = "imagensRes/";
   $pasta_2x2_1 = "imagens_2x2_1/";
   $pasta_2x2_2 = "imagens_2x2_2/";
   $pastaCrlv = "imagensCrlv/";

   $nomeRes = $res['name'];
   $nome_2x2_1 = $foto_2x2_1['name'];
   $nome_2x2_2 = $foto_2x2_2['name'];
   $nomeCrlv = $foto_2x2_1['crlv'];

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

   $pathRes = $pastaRes . $novoNomeRes . "." . $extensaoRes;
   $path_2x2_1 = $pasta_2x2_1 . $novoNome_2x2_1 . "." . $extensao_2x2_1;
   $path_2x2_2 = $pasta_2x2_2 . $novoNome_2x2_2 . "." . $extensao_2x2_2;
   $pathCrlv = $pastaCrlv . $novoNomeCrlv . "." . $extensaoCrlv;

    if(!(empty($nome) || empty($sobrenome) || empty($cpf) || empty($rg) || empty($cnh) || empty($preco) || empty($rotas) || empty($telefone) || empty($periodo) || empty($email) || empty($senha))){
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
            'senha' => $senha
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
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'andre.miiada@gmail.com';                     //SMTP username
                $mail->Password   = 'kzamisbnlwyicwve';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
                //Recipients
                $mail->setFrom('andre.miiada@gmail.com', 'COEGI');
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
}

?>