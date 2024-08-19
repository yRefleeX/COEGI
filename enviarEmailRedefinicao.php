<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require 'vendor/autoload.php';

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

    $email = $_POST['email'];

    $mail = new PHPMailer(true);

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
    $mail->Subject = 'Redefinição de Senha';

    do{
        $token = bin2hex(random_bytes(32));
        $sql = "SELECT 1 FROM redsenha_email WHERE token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = mysqli_stmt_get_result($stmt);
        $token_exists = mysqli_num_rows($result);
    }
    while($token_exists > 0);

    $dataExpiracao = date('Y-m-d H:i:s', strtotime('+1 hour'));
    $sql = "INSERT INTO redsenha_email (email, token, data_expiracao) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $email, $token, $dataExpiracao);
    $stmt->execute();
    $stmt->close();

    $mail->Body = "<p>Olá, você solicitou a redefinição de senha para sua conta COEGI.</p>" .
    "<p>Clique no link abaixo para definir uma nova senha:</p>" .
    "<a href='localhost/COEGI/redefinirSenha.php?token=". $token . "'>Redefinir senha</a>" .
    "<p>Este link expira em 1 hora.</p>" .
    "<p>Atenciosamente,</p>" .
    "<p>COEGI</p>";

    if($mail->send()) {
        echo "Um email com instruções para redefinir a senha foi enviado para seu endereço de email.";
    } else {
        echo "Erro ao enviar email: " . $mail->ErrorInfo;
    }
?>