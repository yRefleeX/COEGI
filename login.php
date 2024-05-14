<?php
include_once("conexao.php");

if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}

$email = addslashes($_POST["emailLogin"]);
$senha = addslashes($_POST["senhaLogin"]);

if(!(empty($email) || empty($senha))){
    $query = mysqli_query($conn, "SELECT * FROM motorista WHERE email = '$email'");
    $usuario = mysqli_fetch_assoc($query);
    
    if(password_verify($senha, $usuario["senha"])){
        session_start();
        $_SESSION['motorista_id'] = $usuario['motorista_id'];
        echo "Usuário logado!";
    }
    else{
        echo "Falha ao logar! Senha ou e-mail incorretos.";
    }
}

header("location: index.php");
?>