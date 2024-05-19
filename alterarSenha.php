<?php
include_once("conexao.php");


if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $token = $_POST['token'];
  $novaSenha = $_POST['novaSenha'];
  $confirmaSenha = $_POST['confirmaSenha'];

  // Validação da senha
  if ($novaSenha !== $confirmaSenha) {
    echo "As senhas não coincidem.";
    exit();
  }

  // Validação do token
  $sql = "SELECT * FROM redsenha_email WHERE token = ? AND data_expiracao > NOW() AND email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $token, $email);
  $stmt->execute();

  if ($stmt->fetch()) {
    $stmt->close();
    // Atualiza a senha no banco de dados
    $novaSenhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
    $sql = "UPDATE motorista SET senha = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $novaSenhaHash, $email);
    $stmt->execute();
    $stmt->close();

    // Remove o token do banco de dados
    $sql = "DELETE FROM redsenha_email WHERE token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->close();

    echo "Senha alterada com sucesso!";
  } else {
    echo "Token inválido ou expirado.";
  }
} else {
  echo "Dados inválidos.";
}
?>