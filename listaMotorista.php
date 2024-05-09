<?php


include_once("conexao.php");


if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}


$query = mysqli_query($conn, "select * from motorista");



?>