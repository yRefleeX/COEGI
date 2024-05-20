<html>

<head>

  <meta charset="utf-8">
  <title>Projeto COEGI</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script type='text/javascript' src='script.js'> </script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">


</head>

<body>


  <div class="container">

    <div class="coluna1">



      <div class="head">

        <img src="https://moodle.cmp.ifsp.edu.br/pluginfile.php/1/theme_moove/logo/1706647608/LogoIFSPCMP_moodle.png"
          style="height: 80px; width: 180px;">
        
          <svg id="menuBurger" onclick="buttonMenu()" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>

      </div>


      <div class="menu">

        <div class="botoes" id="botoes">
        <button type="submit" onclick="buttonMoto()"> Motoristas</button>
        <?php
          session_start();
          if (isset($_SESSION['motorista_id'])) {
            echo '<button type="submit" onclick="buttonPerfil()"> Perfil</button>';
          } else {
            echo '<button type="submit" onclick="buttonCadastra()"> Cadastrar</button>';
            echo '<button type="submit" onclick="buttonLogin()">Login</button>';
          }
          ?>
        </div>



      </div>

      <div id="transportadores" class="transportadores">

        <div class="pesquisar">

          <form method="POST">

          <input type="search" placeholder="Procurar..." id="searchInput">
            <input type="submit" value="Ok" id="botao">

          </form>

        </div>

        <div id="listMot">




          <?php
					 
					 
					 include_once("listaMotorista.php");
					 
					 while (  $row = mysqli_fetch_assoc($query)) {
										 
						  echo '<div class="Mot"><div class="ImgM"><img style="display: inline-block;  height: 100; width: 80px; z-index: -1;" src="'. $row['path_2x2_1']. '"></div><div class="desc">';			 
						  echo '<h3>'. $row['nome']. ' ' .$row['sobrenome'].'</h3>';
						  echo'<p >'. 'Rotas:  ' .$row['rotas']. '</p>';
						  echo'<p >'. 'Periodo:  '.$row['periodo'].'</p>';
						  echo'<p >'. 'telefone:  ' .$row['telefone'].'</p>';
						  echo'<input type="hidden" name="idMot" id="idMot" value="'.$row['motorista_id'].'"><button type="button" id="salvar" name="salvar">Saiba Mais</button></div></div>';
						  
					 }
					 
				
					?>








        </div>

      </div>

      <div id="Perfil" class="Login">
        <p>PERFIL</p>
        <hr style="border: 1px solid black;">
        <div class="botoes" id="botoesPerfil">
          <button type="button" onclick="buttonVerPerfil()"> Ver Perfil</button>
          <button type="submit" onclick="buttonEdita()"> Editar Perfil</button>
          <button type="submit" onclick="buttonLogout()"> Fazer Logout</button>
        </div>
      </div>


      <!-- Tela de login -->

      <div id="Login" class="Login">

        <p>LOGIN</p>
        <hr style="border: 1px solid black;">

        <p>Entre com a sua conta para ter acesso as ferramentas do motorista:</p>

        <div id="FormularioLogin">

          <img id="img"
            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTjSAK1iGtaQ6QTCdpq1iGyJki53MmDISyYag&s">

          <form method="POST" action="login.php">

            <input type="email" placeholder="email" name="emailLogin">
            <input type="password" placeholder="senha" name="senhaLogin"><br>
            
            <button type="submit">Entrar</button>

          </form>

        </div>

        <div id="LoginOpcoes">

          <p>Suporte</p>


          <button onclick="buttonEsqueciSenha()">Esqueceu a senha</button>

        </div>

      </div>

      <div id="esqueciSenha">
      </div>

      <div id="EditarMotorista">

        <p> EDITAR</p>
        <hr style="border: 1px solid black;">

        <p>Preencha os campos em que deseja alterar a informação. Para manter as informações que deseja, deixe o campo
          especifico em branco.</p>

        <!-- Editar motorista -->
        <form>
          <input type="text" placeholder="Nome" name="nome" required>
          <input type="text" placeholder="Sobrenome" name="sobrenome" required>
          <input type="text" placeholder="RG" name="rg" required>
          <input type="text" placeholder="CPF" name="cpf" pattern="\d{3}\.?\d{3}\.?\d{3}-?\d{2}" required>
          <input type="text" placeholder="CNH" name="cnh" required><br>
          <input type="text" placeholder="Preço" name="preco" required>
          <input type="text" placeholder="Rotas" name="rotas" required>
          <input type="text" placeholder="Telefone" name="telefone" required>
          <input type="text" placeholder="Periodo" name="periodo" required><br>

          <p>DUAS FOTOS TAMANHO 2x2:</p>
          <input type="file" accept=".png, .pdf, .jpg">

          <button class="ButCad" type="submit" onclick="buttonMoto()">Editar</button>
        </form><br><br>


      </div>

      <div id="InfMotorista">
      </div>

        <div id="Cad" class="row">
          <p>CADASTRAR MOTORISTA</p>
          <hr style="border: 1px solid black;">

          <p>Para cadastrar-se no site como um motorista, preencha e insira os documetos abaixo:</p>

          <!-- Cadastro -->
          <form action="cadastro.php" method="post" enctype="multipart/form-data">
            <input type="text" placeholder="Nome" name="nome" id="nome">
            <input type="text" placeholder="Sobrenome" name="sobrenome" id="sobrenome">
            <input type="text" placeholder="RG" name="rg" id="rg">
            <input type="text" placeholder="CPF" name="cpf" pattern="\d{3}\.?\d{3}\.?\d{3}-?\d{2}" id="cpf">
            <input type="text" placeholder="CNH" name="cnh" id="cnh"><br>
            <input type="text" placeholder="Preço" name="preco" id="preco">
            <input type="text" placeholder="Rotas" name="rotas" id="rotas">
            <input type="text" placeholder="Telefone" name="telefone" id="telefone">
            <input type="text" placeholder="Periodo" name="periodo" id="periodo">
            <input type="email" placeholder="Email para Login" name="email" id="email">
            <input type="password" placeholder="Senha para Login" name="senha" id="senha"><br>

            <h1> Documentos Necessários</h1>

            <p>COMPROVANTE ATUALIZADO DE RESIDÊNCIA:</p>
            <input type="file" name="res" accept=".png, .pdf, .jpg">
            <p>DUAS FOTOS TAMANHO 2x2:</p>
            <input type="file" name="foto_2x2_1" accept=".png, .pdf, .jpg">
            <input type="file" name="foto_2x2_2" accept=".png, .pdf, .jpg">
            <p>Certificado de registro e licenciamento de veículo (CRLV)</p>
            <input type="file" name="crlv" accept=".png, .pdf, .jpg"><br>
            <button class="ButCad" type="submit">Cadastrar</button>
          </form><br><br>



        </div>
      </div>


        <div id="myMap" class="map"></div>

        <script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?key=AqpANMZ9clo-TaUnWYgSMzqTZEcd6-kAisw3L0ny18ltPnCdDb3YnbksBUQMsO2i&callback=loadMapScenario'> </script>

</body>

</html>