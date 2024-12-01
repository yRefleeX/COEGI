<!DOCTYPE html>

<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <title>COEGI</title>
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link href="css/styleMap.css" rel="stylesheet" type="text/css" preload>
  <link href="css/styleMotorista.css" rel="stylesheet" type="text/css" preload>
  <link rel="img/icon" href="img/icon.webp" preload>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" preload/>
  <link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" preload/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="" defer></script>
  <script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js" defer></script>
  <script src="js/script.js" async></script>
  <script src="js/scriptButtons.js" async></script> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Página principal do site">
  <meta name="theme-color" content="#317EFB"/>

  <style>
    #logo{
      height: 90px;
      width: 252px;
    }
    .imgMLista{
      display: inline-block;
      height: 100;
      width: 80px;
      z-index: -1;
    }
    hr{
      border: 1px solid black;
    }
  </style>
</head>

<body>

  <!-- Div container -->
  <div class="container">

    <!-- Coluna da esquerda da página -->
    <div class="coluna1">

      <!-- Cabeçário da coluna -->
      <header>
        <div class="head">
          <img src="img/LogoIFSPCMP_moodle.webp" id="logo" alt="Logo IFSP">
          <svg id="menuBurger" onclick="buttonMenu()" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>
        </div>

        <!-- Menu da página (aqui aparecerão os botões, cada um com uma funcionalidade diferente do site) -->
        <div class="menu">
          <div class="botoes" id="botoes">
            <!-- Botão para abrir a lista dos motoristas -->
            <button type="submit" onclick="buttonMoto()">Motoristas</button>
            <?php

              // Verifica se o motorista está logado
              session_start();

              // Se o motorista estiver logado, aparecerá o botão de perfil, onde será possível ver seu perfil, editar os dados e fazer logout
              // Se não, apenas aparecerão os botões de "Cadastrar" e "Login"
              if (isset($_SESSION['motorista_id'])) {
                echo '<button type="submit" onclick="buttonPerfil()"> Perfil</button>';
              } else {
                echo '<button type="submit" onclick="buttonCadastra()"> Cadastrar</button>';
                echo '<button type="submit" onclick="buttonLogin()">Login</button>';
              }
            ?>
          </div>
        </div>
      </header>

      <!-- Div abaixo do menu -->
      <main>
        <div id="transportadores" class="transportadores">

          <!-- Seção para pesquisar motoristas -->
          <div class="pesquisar">
            <form method="POST">
              <input type="search" placeholder="Procurar..." id="searchInput">
              <input type="submit" value="Ok" id="botao">
            </form>
          </div>

          <!-- Div com a lista de motoristas cadastrados -->
          <div id="listMot">
            <?php

              // Inclui a função para dar um SELECT * FROM motoristas
              include_once("listaMotorista.php");
              
              // Enquanto tiver motorista na tabela, será dado um echo, mostrando a imagem de cada motorista e seus dados (nome e sobrenome, rotas, período e telefone)
              while (  $row = mysqli_fetch_assoc($query)) { 
                echo '<div class="Mot"><div class="ImgM"><img alt="imagemMotorista" class="imgMLista" src="'. $row['path_2x2_1']. '"></div><div class="desc">';			 
                echo '<h3>'. $row['nome']. ' ' .$row['sobrenome'].'</h3>';
                echo'<p >'. 'Rotas:  ' .$row['rotas']. '</p>';
                echo'<p >'. 'Periodo:  '.$row['periodo'].'</p>';
                echo'<p >'. 'telefone:  ' .$row['telefone'].'</p>';
                echo'<input type="hidden" name="idMot" id="idMot" value="'.$row['motorista_id'].'"><button type="button" class="salvar" name="salvar">Saiba Mais</button></div></div>';
              }
            ?>
          </div>
        </div>

        <!-- Div que aparecerá caso o motorista clicar no botão "Perfil" -->
        <div id="Perfil" class="Login">
          <p>PERFIL</p>
          <hr>

          <!-- Botões com as opções: Ver Perfil, Editar Perfil e Fazer Logout -->
          <div class="botoes" id="botoesPerfil">
            <button type="button" onclick="buttonVerPerfil()"> Ver Perfil</button>
            <input type="hidden" name="motorista_id" id="motorista_id" value="<?php echo $_SESSION['motorista_id']; ?>">
            <button type="button" onclick="buttonEdita()"> Editar Perfil</button>
            <button type="submit" onclick="buttonLogout()"> Fazer Logout</button>
          </div>
        </div>

        <!-- Tela de login -->
        <div id="Login" class="Login">
          <p>LOGIN</p>
          <hr>
          <p>Entre com a sua conta para ter acesso às ferramentas do motorista:</p>

          <div id="FormularioLogin">
            <img id="img" src="img/imgLogin.webp" alt="Ícone cadastro">
            <form method="POST" action="login.php">
              <input type="email" placeholder="email" name="emailLogin" autocomplete="off">
              <input type="password" placeholder="senha" name="senhaLogin" autocomplete="off"><br>
              <button type="submit" id="butLogin">Entrar</button>
            </form>
          </div>

          <!-- Caso o motorista esquecer a senha -->
          <div id="LoginOpcoes">
            <p>Suporte</p>
            <button onclick="buttonEsqueciSenha()">Esqueci a senha</button>
          </div>
        </div>

        <!-- Div que aparecerá ao motorista clicar em "Esqueci a senha" -->
        <div id="esqueciSenha">
        </div>

        <!-- Div que aparecerá caso o motorista clicar no botão "Editar Perfil" -->
        <div id="EditarMotorista">

        <!--Div que aparecerá o botão voltar-->
          <div id="botaoVoltar"> <img onclick="buttonPerfil()" src="img/ArrowBack.png">   EDITAR
          <hr> </div>

      
          <p>Preencha os campos em que deseja alterar a informação. Para manter as informações que deseja, deixe o campo específico em branco.<br>
          Caso queira desenhar a rota, clique no botão "Editar Rotas", de acordo com o período que desejar. Depois, no canto superior esquerdo do mapa, clique no botão com um desenho de linha. Já para editar a rota, clique no botão logo abaixo (ou no botão "Editar Rotas"), e depois clique no botão com desenho de linha para desenhar a rota novamente.</p>

          <!-- Formulário para editar os dados do motorista -->
          <form action="editaPerfil.php" method="post" enctype="multipart/form-data">
            <input type="text" placeholder="Nome" name="nomeEdita" id="nomeEdita">
            <input type="text" placeholder="Sobrenome" name="sobrenomeEdita" id="sobrenomeEdita">
            <input type="text" placeholder="Rotas" name="rotasEdita" id="rotasEdita">
            <input type="text" placeholder="Telefone - (DDD) XXXXX-XXXX" name="telefoneEdita" id="telefoneEdita">
            <input type="text" placeholder="Periodo" name="periodoEdita" id="periodoEdita">

            <p>FOTO DE PERFIL (TAMANHO 2X2):</p>
            <input type="file" name="foto_2x2_1_edita" accept=".png, .jpg">

            <br>

            <button class="ButCad" type="submit">Editar</button>
          </form>
          
          <br>

          <button class="ButCad" type="button" onclick="buttonRemoverPerfil()">Remover Conta</button>

          <br><br>

          <button class="ButCad butRotasManha" type="button">Editar Rotas (manhã)</button>
          <button class="ButCad butRotasTarde" type="button">Editar Rotas (tarde)</button>
          <button class="ButCad butRotasNoite" type="button">Editar Rotas (noite)</button>
        </div>

        <!-- Div que aparecerá caso for clicado no botão "Remover Conta"-->
        <div id="RemoverMotorista">
        <div id="botaoVoltar"> <img onclick="buttonPerfil()" src="img/ArrowBack.png"> </div>
        </div>

        <!-- Div com as informações do motorista caso for clicado em "Saiba Mais"-->
        <div id="InfMotorista"></div>

        <!-- Div que aparecerá caso for clicado no botão "Cadastrar"-->
          <div id="Cad" class="row">
            <p>CADASTRAR MOTORISTA</p>
            <hr>

            <p>Para cadastrar-se no site como um motorista, preencha e insira os documetos abaixo:</p>

            <!-- Formulário para cadastro do motorista -->
            <form action="cadastro.php" method="post" enctype="multipart/form-data">
              <input type="text" placeholder="Nome" name="nome" id="nome">
              <input type="text" placeholder="Sobrenome" name="sobrenome" id="sobrenome">
              <input type="text" placeholder="COTAC (apenas números)" name="cotac" id="cotac"><br>
              <input type="text" placeholder="Rotas" name="rotas" id="rotas">
              <input type="text" placeholder="Telefone - (DDD) XXXXX-XXXX" name="telefone" id="telefone">
              <input type="text" placeholder="Periodo" name="periodo" id="periodo">
              <input type="email" placeholder="Email para Login" name="email" id="email" autocomplete="off">
              <input type="password" placeholder="Senha para Login" name="senha" id="senha" autocomplete="off"><br>

              <h1> Documentos Necessários</h1>

              <p>FOTO DE PERFIL (TAMANHO 2X2) - PNG ou JPG</p>
              <input type="file" name="foto_2x2_1" accept=".png, .jpg">
              <p>SEGUNDA FOTO 2X2 - PNG ou JPG</p>
              <input type="file" name="foto_2x2_2" accept=".png, .jpg">
              <p>Certificado Nacional de Habilitação (CNH:frente e verso) - PDF</p>
              <input type="file" name="crlv" accept=".pdf"><br>
              <button class="ButCad" type="submit">Cadastrar</button>
            </form>
            
            <br><br>
          </div>
        </div>
      </main>

      <!-- Declaração do mapa (localizado na direita do site) -->
      <div id="myMap" class="map" preload></div>
      <script src="js/scriptMapa.js" async></script>
  </div>
</body>
</html>