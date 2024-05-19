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

    // Validação do token
    if (isset($_GET['token'])) {
        $token = $_GET['token'];

        $sql = "SELECT rs.email, rs.token, rs.data_expiracao
        FROM redsenha_email rs
        WHERE rs.token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();

        $emailResult = null;
        $tokenResult = null;
        $dataExpiracaoResult = null;


        $stmt->bind_result($emailResult, $tokenResult, $dataExpiracaoResult);

        if ($stmt->fetch()) {
            if(strtotime($dataExpiracaoResult) > time()){
                // Exibe o formulário para a nova senha
                ?>
                <!DOCTYPE html>
                <html>
                <head>
                <meta charset="utf-8">
                <title>COEGI - Redefinir Senha</title>
                </head>
                <body>
                <h2>Redefinição de Senha</h2>
                <p>Digite a nova senha para sua conta:</p>
                <form method="POST" action="alterarSenha.php">
                    <input type="hidden" name="email" value="<?php echo $emailResult; ?>">
                    <input type="hidden" name="token" value="<?php echo $tokenResult; ?>">
                    <input type="password" name="novaSenha" placeholder="Nova Senha"><br>
                    <input type="password" name="confirmaSenha" placeholder="Confirme a Nova Senha"><br>
                    <button type="submit">Alterar Senha</button>
                </form>
                </body>
                </html>
                <?php
            }
            else{
                echo "Token expirado.";
            }
        } else {
            echo "Token inválido.";
        }

        $stmt->close();
    } else {
        echo "Token não encontrado.";
    }
?>