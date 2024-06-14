<?php
include_once("conexao.php");

if (!$conn) {
  die("Conexão falhou: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
  // Quando entrar nessa condição, significa que o usuário tentou acessar o link diretamente    
  // Faça algo.
  die();        
}

if (isset($_POST["search"])) {
  $searchTerm = addslashes(mysqli_real_escape_string($conn, $_POST["search"]));

  // Consulta SQL
  $sql = "SELECT * FROM motorista WHERE nome LIKE '%$searchTerm%' OR sobrenome LIKE '%$searchTerm%'";
  $result = mysqli_query($conn, $sql);

  // Se tiver algum motorista de acordo com a pesquisa, aparecerão seus dados. Se não, aparecerá a mensagem "Nenhum motorista encontrado."
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="Mot"><div class="ImgM"><img alt="imagemMotorista" style="display: inline-block;  height: 100; width: 80px; z-index: -1;" src="'. $row['path_2x2_1']. '"></div><div class="desc">';			 
        echo '<h3>'. $row['nome']. ' ' .$row['sobrenome'].'</h3>';
        echo'<p >'. 'Rotas:  ' .$row['rotas']. '</p>';
        echo'<p >'. 'Periodo:  '.$row['periodo'].'</p>';
        echo'<p >'. 'telefone:  ' .$row['telefone'].'</p>';
        echo'<input type="hidden" name="idMot" id="idMot" value="'.$row['motorista_id'].'"><button type="button" class="salvar" name="salvar">Saiba Mais</button></div></div>';
    }
  } else {
    echo "<p>Nenhum motorista encontrado.</p>";
  }
}

mysqli_close($conn);
?>