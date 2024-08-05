<?php
// Verifica o local de execução do script PHP
if ( realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    // Quando entrar nessa condição, significa que o usuário tentou acessar o link diretamente    
    // Faça algo.
    die();        
}

$severname = "localhost";
$username = "root";  
$password = "";
$dbName = "banco_coegi";
$porta = "3307";


$conn = mysqli_connect($severname,$username,$password,$dbName,$porta);
?>