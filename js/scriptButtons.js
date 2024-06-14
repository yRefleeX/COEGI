// funções para ocultar e mostrar divs na tela

function buttonLogin(){
    var perfil = document.getElementById("Perfil");
     var ed = document.getElementById("EditarMotorista");
    var log = document.getElementById("Login");
    var moto = document.getElementById("transportadores");
    var cad = document.getElementById("Cad"); 
    var infMot = document.getElementById("InfMotorista");
    var divEsqueciSenha = document.getElementById("esqueciSenha");
    var rem = document.getElementById("RemoverMotorista");
  
     log.style.display = "block";
     moto.style.display = "none";
     cad.style.display = "none";
     ed.style.display = "none";
     infMot.style.display = "none";
     perfil.style.display = "none";
     divEsqueciSenha.style.display = "none";
     rem.style.display = "none";

     drawnItems.clearLayers();
  
  }
  
  function buttonMoto(){
    var perfil = document.getElementById("Perfil");
    var ed = document.getElementById("EditarMotorista");
    var log = document.getElementById("Login");
    var moto = document.getElementById("transportadores");
    var cad = document.getElementById("Cad");
    var infMot = document.getElementById("InfMotorista");
    var divEsqueciSenha = document.getElementById("esqueciSenha");
    var rem = document.getElementById("RemoverMotorista");
    
     log.style.display = "none";
     moto.style.display = "block";
     cad.style.display = "none";
     ed.style.display = "none";
     infMot.style.display = "none";
     perfil.style.display = "none";
     divEsqueciSenha.style.display = "none";
     rem.style.display = "none";

    drawnItems.clearLayers();
  }
  
  function buttonCadastra(){
    var perfil = document.getElementById("Perfil");
    var ed = document.getElementById("EditarMotorista");
    var log = document.getElementById("Login");
    var moto = document.getElementById("transportadores");
    var cad = document.getElementById("Cad");
    var infMot = document.getElementById("InfMotorista");
    var divEsqueciSenha = document.getElementById("esqueciSenha");
    var rem = document.getElementById("RemoverMotorista");
    
     log.style.display = "none";
     moto.style.display = "none";
     cad.style.display = "block";
     ed.style.display = "none";
     infMot.style.display = "none";
     perfil.style.display = "none";
     divEsqueciSenha.style.display = "none";
     rem.style.display = "none";

     drawnItems.clearLayers();
  }
  
  function buttonEdita(){
  
    var perfil = document.getElementById("Perfil");
    var ed = document.getElementById("EditarMotorista");
    var log = document.getElementById("Login");
    var moto = document.getElementById("transportadores");
    var cad = document.getElementById("Cad");
    var infMot = document.getElementById("InfMotorista");
    var divEsqueciSenha = document.getElementById("esqueciSenha");
    var rem = document.getElementById("RemoverMotorista");
    
     log.style.display = "none";
     moto.style.display = "none";
     cad.style.display = "none";
     ed.style.display = "block";
     infMot.style.display = "none";
     perfil.style.display = "none";
     divEsqueciSenha.style.display = "none";
     rem.style.display = "none";
    
     adicionarControleDesenho();

      
	  $.ajax({
         url: "mostraPerfil.php",
         method: "POST",
         dataType: "json",
         success: function(dados) {
             if ("nome" in dados && "sobrenome" in dados) {
                
                 exibirRotaMotorista(dados.motorista_id);
             } else {
                 alert("Erro: Dados do motorista não encontrados."); 
             }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert("Erro ao buscar detalhes.");
             console.log(jqXHR, textStatus, errorThrown);
         }
		 
     });

  }
  
  function buttonInfoMotorista(){
  
    var perfil = document.getElementById("Perfil");
    var ed = document.getElementById("EditarMotorista");
    var log = document.getElementById("Login");
    var moto = document.getElementById("transportadores");
    var cad = document.getElementById("Cad");
    var infMot = document.getElementById("InfMotorista");
    var divEsqueciSenha = document.getElementById("esqueciSenha");
    var rem = document.getElementById("RemoverMotorista");
  
     log.style.display = "none";
     moto.style.display = "none";
     cad.style.display = "none";
     ed.style.display = "none";
     perfil.style.display = "none";
     divEsqueciSenha.style.display = "none";
     rem.style.display = "none";
  
     $.ajax({
         url: "mostraPerfil.php",
         method: "POST",
         dataType: "json",
         success: function(dados) {
             if ("nome" in dados && "sobrenome" in dados) {
                 infMot.innerHTML = '<p><b>Motorista: ' + dados.nome + ' ' + dados.sobrenome + '</b></p>' +
                 '<img alt="imagemMotorista" src="' + dados.path_2x2_1 + '" style="border-radius: 50%; height: 100; width: 100px; z-index: -1; margin-left: auto; margin-right: auto;">' +
                 '<div id="descMotorista">' +
                 'Rotas: ' + dados.rotas + '<br>' +
                 'Periodo: ' + dados.periodo + '<br>' +
                 'Telefone: ' + dados.telefone + '' +
                 '</div></div>';
  
                 // Exibe a div InfMotorista
                 infMot.style.display = "block";

                 exibirRotaMotorista(dados.motorista_id);
             } else {
                 alert("Erro: Dados do motorista não encontrados."); 
             }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert("Erro ao buscar detalhes.");
             console.log(jqXHR, textStatus, errorThrown);
         }
     });
     
  }
  
  function buttonMenu(){
      
      var menu = document.getElementById("botoes");
      
      if(menu.style.display == "flex"){
          
          menu.style.display = "none";
      
      }
      else{
          menu.style.display = "flex";
      }
  }
  
  function buttonPerfil(){
    var perfil = document.getElementById("Perfil");
    var log = document.getElementById("Login");
    var moto = document.getElementById("transportadores");
    var cad = document.getElementById("Cad");
    var ed = document.getElementById("EditarMotorista");
    var infMot = document.getElementById("InfMotorista");
    var divEsqueciSenha = document.getElementById("esqueciSenha");
    var rem = document.getElementById("RemoverMotorista");
    
    log.style.display = "none";
    moto.style.display = "none";
    cad.style.display = "none";
    ed.style.display = "none";
    infMot.style.display = "none";
    perfil.style.display = "block";
    divEsqueciSenha.style.display = "none";
    rem.style.display = "none";
    
    drawnItems.clearLayers();
  }
  
  function buttonVerPerfil(){
    buttonInfoMotorista();
  }

  function buttonRemoverPerfil(){
    var perfil = document.getElementById("Perfil");
    var log = document.getElementById("Login");
    var moto = document.getElementById("transportadores");
    var cad = document.getElementById("Cad");
    var ed = document.getElementById("EditarMotorista");
    var infMot = document.getElementById("InfMotorista");
    var divEsqueciSenha = document.getElementById("esqueciSenha");
    var rem = document.getElementById("RemoverMotorista");

    log.style.display = "none";
    moto.style.display = "none";
    cad.style.display = "none";
    ed.style.display = "none";
    infMot.style.display = "none";
    perfil.style.display = "none";
    divEsqueciSenha.style.display = "none";
    rem.style.display = "block";

    rem.innerHTML = '<p>Você deseja mesmo remover sua conta?</p><button class="butCad" type="submit" onclick="removerConta()">Sim</button>';
  }

  function removerConta(){
    window.location.href = "removerPerfil.php";
  }

  function buttonLogout(){
    window.location.href = "logout.php";
  }
  
  function buttonEsqueciSenha(){
    var perfil = document.getElementById("Perfil");
    var ed = document.getElementById("EditarMotorista");
    var log = document.getElementById("Login");
    var moto = document.getElementById("transportadores");
    var cad = document.getElementById("Cad");
    var infMot = document.getElementById("InfMotorista");
    var divEsqueciSenha = document.getElementById("esqueciSenha");
    var rem = document.getElementById("RemoverMotorista");
    
    log.style.display = "none";
    moto.style.display = "none";
    cad.style.display = "none";
    ed.style.display = "none";
    infMot.style.display = "none";
    perfil.style.display = "none";
    rem.style.display = "none";
    divEsqueciSenha.style.display = "block";
  
    divEsqueciSenha.innerHTML = '<input type="email" placeholder="Digite seu email" id="emailEsqueciSenha"><br><button class="butCad" onclick="enviarEmailRedefinicao()">Enviar</button>';
  }