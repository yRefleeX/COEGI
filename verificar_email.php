<?php session_start(); 
    if(!isset($_SESSION['email_verificacao'])) {
        header("Location: index.php");
        exit();
    }
?>

<h2>Verificar Email</h2>
<form method="post" action="verificar_codigo_cadastro.php">
  <label for="codigo">Código de Verificação:</label><br>
  <input type="text" id="codigo" name="codigo" required><br><br>
  <input type="hidden" name="email" value="<?php echo $_SESSION['email_verificacao']; ?>">
  <input type="submit" value="Verificar">
</form>