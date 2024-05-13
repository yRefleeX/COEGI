<?php
include_once("conexao.php");

if (!$conn) {
  die("Conexão falhou: " . mysqli_connect_error());
}

if (isset($_POST["search"])) {
  $searchTerm = mysqli_real_escape_string($conn, $_POST["search"]);

  // Consulta SQL (adapte de acordo com sua estrutura de banco de dados)
  $sql = "SELECT * FROM motorista WHERE nome LIKE '%$searchTerm%' OR sobrenome LIKE '%$searchTerm%'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="Mot"><div class="ImgM"><img style="display: inline-block;  height: 100; width: 80px; z-index: -1;" src="http://servicosweb.cnpq.br/wspessoa/servletrecuperafoto?tipo=1&id=K4216967Y1"></div><div class="desc">';			 
        echo '<h3>'. $row['nome']. ' ' .$row['sobrenome'].'</h3>';
        echo'<p >'. 'Rotas:  ' .$row['rotas']. '</p>';
        echo'<p >'. 'Periodo:  '.$row['periodo'].'</p>';
        echo'<p >'. 'telefone:  ' .$row['telefone'].'</p>';
        echo'<input type="hidden" name="idMot" id="idMot" value="'.$row['motorista_id'].'"><button type="button" id="salvar" name="salvar">Saiba Mais</button></div></div>';
    }
  } else {
    echo "<p>Nenhum motorista encontrado.</p>";
  }
}

mysqli_close($conn);
?>