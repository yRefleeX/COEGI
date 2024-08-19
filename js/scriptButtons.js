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


    removerControleDesenho();
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
            // Adie a habilitação da edição
            setTimeout(function() {
            if (drawControl && drawControl.edit) {
              drawControl.setDrawingOptions({ polyline: false });
              drawControl.edit.enable(); 
            }
            }, 100);
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
                 'Telefone: ' + dados.telefone + '</div><br>' +
                 '<div><button class="ButCad butRotasManha" type="button">Rotas (manhã)</button>' +
                 '<button class="ButCad butRotasTarde" type="button">Rotas (tarde)</button>' +
                 '<button class="ButCad butRotasNoite" type="button">Rotas (noite)</button></div></div>';
  
                 // Exibe a div InfMotorista
                 infMot.style.display = "block";

                 $('.butRotasManha').click(function() {
                  exibirRotaMotorista(dados.motorista_id, 'manha');
                });
                $('.butRotasTarde').click(function() {
                  exibirRotaMotorista(dados.motorista_id, 'tarde');
                });
                $('.butRotasNoite').click(function() {
                  exibirRotaMotorista(dados.motorista_id, 'noite');
                });
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
    
    removerControleDesenho();
    
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

    rem.innerHTML = '<div style="display: grid; justify-items: center;"><p>Você deseja mesmo remover sua conta?</p><button class="butCad" type="submit" onclick="removerConta()">Sim</button></div>';
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
  
    divEsqueciSenha.innerHTML = '<div style="display: grid; justify-content: center;"><input type="email" placeholder="Digite seu email" id="emailEsqueciSenha"><button class="butCad" onclick="enviarEmailRedefinicao()">Enviar</button></div>';
  }