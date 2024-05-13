<?php
include_once("conexao.php");

if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}

$email = $_POST["emailLogin"];
$senha = $_POST["senhaLogin"];

if(!(empty($email) || empty($senha))){
    $query = mysqli_query($conn, "SELECT * FROM motorista WHERE email = '$email'");
    $usuario = mysqli_fetch_assoc($query);
    
    if(password_verify($senha, $usuario["senha"])){
        echo "Usuário logado!";
    }
    else{
        echo "Falha ao logar! Senha ou e-mail incorretos.";
    }
}

header("location: index.php");
?>