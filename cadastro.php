<?php


ini_set("display_errors", 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("conexao.php");


if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}
echo "Conexão feita com sucesso";

$nome = $_POST["nome"];
$sobrenome = $_POST["sobrenome"];
$rg = $_POST["rg"];
$cpf = $_POST["cpf"];
$cnh = $_POST["cnh"];
$preco = $_POST["preco"];
$rotas = $_POST["rotas"];
$telefone = $_POST["telefone"];
$periodo= $_POST["periodo"];
$email = $_POST["email"];
$senha = $_POST["senha"];

$query = mysqli_query($conn, "insert into motorista(nome,sobrenome,rg,cpf,cnh,preco,rotas,telefone,periodo,email,senha)values('$nome','$sobrenome','$rg','$cpf','$cnh','$preco','$rotas','$telefone','$periodo','$email','$senha')"); // Cadastra o Motorista no Banco de dados.

header("location: index.php");

?>