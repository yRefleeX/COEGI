// ajax para o envio do id sem refresh na pagina para expor as informações do motorista expessifico

$(document).ready(function(){
  $("#botao").click(function(event) {
    event.preventDefault(); // Impede o envio do formulário

    var searchTerm = $("#searchInput").val(); // Obtém o valor do campo de pesquisa

    $.ajax({
      url: "search.php", // URL do script PHP que irá consultar o banco de dados
      method: "POST",
      data: { search: searchTerm },
      dataType: "html",
      success: function(response) {
        $("#listMot").html(response); // Atualiza a lista de motoristas com os resultados
      }
    });
  });

  // Função para enviar a solicitação AJAX e exibir detalhes
  function exibirDetalhes(idMot, motDiv) {  
    $.ajax({
      url: "listaMotoristaId.php",
      method: "POST",
      data: { idMot: idMot },
      dataType: "json",
      success: function(dados) {
        // Verificar se os dados existem
        if ("nome" in dados && "sobrenome" in dados) {
          var detalhesDiv = document.getElementById("InfMotorista"); // Cria a div com o ID "InfMotorista"

          // Pegando as outras divs para apresentar display: "none"
          var ed = document.getElementById("EditarMotorista");
          var log = document.getElementById("Login");
          var cad = document.getElementById("Cad");
          var infMot = document.getElementById("InfMotorista");


          // Define o conteúdo HTML da div (ANTES de inserir)
          detalhesDiv.innerHTML = '<p><b>Motorista: ' + dados.nome + ' ' + dados.sobrenome + '</b></p>' +
          '<img src="' + dados.path_2x2_1 + '" style="border-radius: 50%; height: 100; width: 100px; z-index: -1;">' +
          '<div id="descMotorista">' +
          'Rotas: ' + dados.rotas + '<br>' +
          'Periodo: ' + dados.periodo + '<br>' +
          'Telefone: ' + dados.telefone + '' +
          '</div></div>';
          // Adicione outras informações conforme necessário
          
          log.style.display = "none";
          document.querySelectorAll('.transportadores').forEach(function(mot){
            mot.style.display = "none";
          });
          cad.style.display = "none";
          ed.style.display = "none";
          infMot.style.display = "block";
        } else {
          alert("Erro: Dados do motorista não encontrados."); // Lidar com a ausência de dados (exibir mensagem de erro, etc.)
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert("Erro ao buscar detalhes.");
        console.log(jqXHR, textStatus, errorThrown)
      }
    });
  }

  // Vincule o evento de clique ao botão "saiba mais"
  $("#listMot").on("click", "#salvar", function(event) {
    var idMot = $(this).siblings('#idMot').val();
    var motDiv = $(this).closest('.Mot');
    exibirDetalhes(idMot, motDiv);
  });
});

// funções para o funcionamento do mapa

var map, directionsManagers = [];

function loadMapScenario(){
    map = new Microsoft.Maps.Map(document.getElementById('myMap'), {
    center: new Microsoft.Maps.Location(-22.94825022737269, -47.14981763333731),  
    mapTypeId: Microsoft.Maps.MapTypeId.aerial,
    zoom: 18
  });

  Microsoft.Maps.loadModule('Microsoft.Maps.Directions', function () {
    getRoute('R. Heitor Lacerda Guedes, 1000 - Cidade Satélite Íris, Campinas - SP, 13059-581', 'Av. Imperatriz Leopoldina - Vila Nova, Campinas - SP', 'red');
    getRoute('R. Heitor Lacerda Guedes, 1000 - Cidade Satélite Íris, Campinas - SP, 13059-581', 'Av. Andrade Neves - Jardim Chapadão, Campinas - SP', 'blue');
    getRoute('R. Heitor Lacerda Guedes, 1000 - Cidade Satélite Íris, Campinas - SP, 13059-581', 'Rua Custódio Manoel Alves - Bonfim, Campinas - SP', 'orange');
  });
}

function getRoute(start, end, color) {
        var dm = new Microsoft.Maps.Directions.DirectionsManager(map);
        directionsManagers.push(dm);

        dm.setRequestOptions({
            routeMode: Microsoft.Maps.Directions.RouteMode.driving
        });

        dm.setRenderOptions({
            autoUpdateMapView: false,
            drivingPolylineOptions: {
                strokeColor: color,
                strokeThickness: 3
            }
        });

        dm.addWaypoint(new Microsoft.Maps.Directions.Waypoint({ address: start }));
        dm.addWaypoint(new Microsoft.Maps.Directions.Waypoint({ address: end }));

        dm.calculateDirections();
    }

// funções para ocultar e mostrar divs na tela

var perfil = document.getElementById("Perfil");

function buttonLogin(){
  var perfil = document.getElementById("Perfil");
   var ed = document.getElementById("EditarMotorista");
  var log = document.getElementById("Login");
  var moto = document.getElementById("transportadores");
  var cad = document.getElementById("Cad"); 
  var infMot = document.getElementById("InfMotorista");
  var divEsqueciSenha = document.getElementById("esqueciSenha");

   log.style.display = "block";
   moto.style.display = "none";
   cad.style.display = "none";
   ed.style.display = "none";
   infMot.style.display = "none";
   perfil.style.display = "none";
   divEsqueciSenha.style.display = "none";

}

function buttonMoto(){
  var perfil = document.getElementById("Perfil");
  var ed = document.getElementById("EditarMotorista");
  var log = document.getElementById("Login");
  var moto = document.getElementById("transportadores");
  var cad = document.getElementById("Cad");
  var infMot = document.getElementById("InfMotorista");
  var divEsqueciSenha = document.getElementById("esqueciSenha");
  
   log.style.display = "none";
   moto.style.display = "block";
   cad.style.display = "none";
   ed.style.display = "none";
   infMot.style.display = "none";
   perfil.style.display = "none";
   divEsqueciSenha.style.display = "none";
}

function buttonCadastra(){
  var perfil = document.getElementById("Perfil");
  var ed = document.getElementById("EditarMotorista");
  var log = document.getElementById("Login");
  var moto = document.getElementById("transportadores");
  var cad = document.getElementById("Cad");
  var infMot = document.getElementById("InfMotorista");
  var divEsqueciSenha = document.getElementById("esqueciSenha");
  
   log.style.display = "none";
   moto.style.display = "none";
   cad.style.display = "block";
   ed.style.display = "none";
   infMot.style.display = "none";
   perfil.style.display = "none";
   divEsqueciSenha.style.display = "none";
}

function buttonEdita(){

  var perfil = document.getElementById("Perfil");
  var ed = document.getElementById("EditarMotorista");
  var log = document.getElementById("Login");
  var moto = document.getElementById("transportadores");
  var cad = document.getElementById("Cad");
  var infMot = document.getElementById("InfMotorista");
  var divEsqueciSenha = document.getElementById("esqueciSenha");
  
   log.style.display = "none";
   moto.style.display = "none";
   cad.style.display = "none";
   ed.style.display = "block";
   infMot.style.display = "none";
   perfil.style.display = "none";
   divEsqueciSenha.style.display = "none";
  
}

function buttonInfoMotorista(){

  var perfil = document.getElementById("Perfil");
  var ed = document.getElementById("EditarMotorista");
  var log = document.getElementById("Login");
  var moto = document.getElementById("transportadores");
  var cad = document.getElementById("Cad");
  var infMot = document.getElementById("InfMotorista");
  var divEsqueciSenha = document.getElementById("esqueciSenha");

   log.style.display = "none";
   moto.style.display = "none";
   cad.style.display = "none";
   ed.style.display = "none";
   perfil.style.display = "none";
   divEsqueciSenha.style.display = "none";

   $.ajax({
       url: "mostraPerfil.php",
       method: "POST",
       dataType: "json",
       success: function(dados) {
           if ("nome" in dados && "sobrenome" in dados) {
               infMot.innerHTML = '<p><b>Motorista: ' + dados.nome + ' ' + dados.sobrenome + '</b></p>' +
               '<img src="' + dados.path_2x2_1 + '" style="border-radius: 50%; height: 100; width: 100px; z-index: -1;">' +
               '<div id="descMotorista">' +
               'Rotas: ' + dados.rotas + '<br>' +
               'Periodo: ' + dados.periodo + '<br>' +
               'Telefone: ' + dados.telefone + '' +
               '</div></div>';

               // Exibe a div InfMotorista
               infMot.style.display = "block"; 
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
  
  log.style.display = "none";
  moto.style.display = "none";
  cad.style.display = "none";
  ed.style.display = "none";
  infMot.style.display = "none";
  perfil.style.display = "block";
  divEsqueciSenha.style.display = "none";
}

function buttonVerPerfil(){
  buttonInfoMotorista();
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
  
  log.style.display = "none";
  moto.style.display = "none";
  cad.style.display = "none";
  ed.style.display = "none";
  infMot.style.display = "none";
  perfil.style.display = "none";
  divEsqueciSenha.style.display = "block";

  divEsqueciSenha.innerHTML = '<input type="email" placeholder="Digite seu email" id="emailEsqueciSenha"><button onclick="enviarEmailRedefinicao()">Enviar</button>';
}

function enviarEmailRedefinicao(){
  var email = document.getElementById("emailEsqueciSenha").value;
  if(email === "") {
    alert("Por favor, digite seu email!");
    return;
  }

  $.ajax({
    url: "enviarEmailRedefinicao.php",
    method: "POST",
    data: { email: email },
    success: function(response) {
      alert(response);
      document.getElementById("esqueciSenha").display = "none";
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert("Erro ao enviar email. Tente novamente mais tarde.");
      console.log(jqXHR, textStatus, errorThrown);
    }
  });
}