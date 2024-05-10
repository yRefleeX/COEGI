<html>

<head>

  <meta charset="utf-8">
  <title>Projeto COEGI</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script type='text/javascript' src='script.js'> </script>



</head>

<body>


  <div class="container">

    <div class="coluna1">



      <div class="head">

        <img src="https://moodle.cmp.ifsp.edu.br/pluginfile.php/1/theme_moove/logo/1706647608/LogoIFSPCMP_moodle.png"
          style="height: 80px; width: 180px;">


      </div>


      <div class="menu">

        <div class="botoes">


          <button type="submit" onclick="buttonMoto()"> Motoristas</button>

          <button type="submit" onclick="buttonCadastra()"> Cadastrar</button>

          <button type="submit" onclick="buttonLogin()">Login</button>




        </div>



      </div>

      <div id="transportadores" class="transportadores">

        <div class="pesquisar">

          <form method="POST">

            <input type="search" placeholder="Procurar...">
            <input type="submit" value="ok" id="botao">

          </form>

        </div>




        <hr>

        <div id="listMot">




          <?php
					 
					 
					 include_once("listaMotorista.php");
					 
					 while (  $row = mysqli_fetch_assoc($query)) {
										 
						  echo '<div class="Mot"><div class="ImgM"><img style="display: inline-block;  height: 100; width: 80px; z-index: -1;" src="http://servicosweb.cnpq.br/wspessoa/servletrecuperafoto?tipo=1&id=K4216967Y1"></div><div class="desc">';			 
						  echo '<h3>'. $row['nome']. ' ' .$row['sobrenome'].'</h3>';
						  echo'<p >'. 'Rotas:  ' .$row['rotas']. '</p>';
						  echo'<p >'. 'Periodo:  '.$row['periodo'].'</p>';
						  echo'<p >'. 'telefone:  ' .$row['telefone'].'</p>';
						  echo'<input type="hidden" name="idMot" id="idMot" value="'.$row['motorista_id'].'"><button type="button" id="salvar" name="salvar" style=" cursor: pointer; color:blue; float:left">saiba mais</button></div></div>';
						
						 

						  
						  echo'<hr>';
						  
					 }
					 
				
					?>








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

          <form method="POST">

            <input type="email" placeholder="email">
            <input type="password" placeholder="senha"><br>


          </form>

          <button onclick="buttonUsuario()">Entrar</button>

        </div>

        <div id="LoginOpcoes">

          <p>Suporte</p>


          <button onclick="buttonInfoMotorista()">Esqueceu a senha</button>

        </div>

      </div>

      <!-- opções do usuario motorista -->

      <div id="Usuario" class="row">

        <p> USUÁRIO</p>
        <hr style="border: 1px solid black;">

        <div class="formularioCentro">


          <p>Usuário: Gabriel Fernandes</p>

          <label>Editar informações do motorista
            <button type="submit" onclick="buttonEdita()">Seguir</button>
          </label>

          <label> Excluir conta e motorista do site
            <button type="submit" onclick="buttonExclui()">Seguir</button>
          </label>

        </div>

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

      <div id="ExcluirMotorista">

        <p> EXCLUIR</p>
        <hr style="border: 1px solid black;">

        <p>Você tem certeza que deseja excluir sua conta e motorista do site? essa a ação não pode ser desfeita.</p>

        <button>CONFIRMAR</button> <button>CANCELAR</button>

      </div>

      <div id="InfMotorista">
      </div>

        <div id="Cad" class="row">
          <p>CADASTRAR MOTORISTA</p>
          <hr style="border: 1px solid black;">

          <p>Para cadastrar-se no site como um motorista, preencha e insira os documetos abaixo:</p>

          <!-- Cadastro -->
          <form method="POST" action="cadastro.php">
            <input type="text" placeholder="Nome" name="nome" required>
            <input type="text" placeholder="Sobrenome" name="sobrenome" required>
            <input type="text" placeholder="RG" name="rg" required>
            <input type="text" placeholder="CPF" name="cpf" pattern="\d{3}\.?\d{3}\.?\d{3}-?\d{2}" required>
            <input type="text" placeholder="CNH" name="cnh" required><br>
            <input type="text" placeholder="Preço" name="preco" required>
            <input type="text" placeholder="Rotas" name="rotas" required>
            <input type="text" placeholder="Telefone" name="telefone" required>
            <input type="text" placeholder="Periodo" name="periodo" required>
            <input type="text" placeholder="Email para Login" name="email" required>
            <input type="text" placeholder="Senha para Login" name="senha" required><br>

            <h1> Documentos Necessários</h1>

            <p>COMPROVANTE ATUALIZADO DE RESIDÊNCIA:</p>
            <input type="file" accept=".png, .pdf, .jpg">
            <p>DUAS FOTOS TAMANHO 2x2:</p>
            <input type="file" accept=".png, .pdf, .jpg">
            <p>Certificado de registro e licenciamento de veículo (CRLV)</p>
            <input type="file" accept=".png, .pdf, .jpg"><br>
            <button class="ButCad" type="submit">Cadastrar</button>
          </form><br><br>



        </div>
      </div>


        <div id="myMap" class="map"></div>

        <script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?key=AqpANMZ9clo-TaUnWYgSMzqTZEcd6-kAisw3L0ny18ltPnCdDb3YnbksBUQMsO2i&callback=loadMapScenario'> </script>

</body>

</html>