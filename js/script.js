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
  function exibirDetalhes(idMot) {  
    $.ajax({
      url: "listaMotoristaId.php",
      method: "POST",
      data: { idMot: idMot },
      dataType: "json",
      success: function(dados) {
        // Verificar se os dados existem
        if ("nome" in dados && "sobrenome" in dados) {
          var infMot = document.getElementById("InfMotorista"); // Cria a div com o ID "InfMotorista"

          // Pegando as outras divs para apresentar display: "none"
          var ed = document.getElementById("EditarMotorista");
          var log = document.getElementById("Login");
          var cad = document.getElementById("Cad");


          // Define o conteúdo HTML da div (ANTES de inserir)
          infMot.innerHTML = '<p><b>Motorista: ' + dados.nome + ' ' + dados.sobrenome + '</b></p>' +
          '<img alt="imagemMotorista" src="' + dados.path_2x2_1 + '" style="border-radius: 50%; height: 100px; width: 100px; z-index: -1; margin-left: auto; margin-right: auto;">' +
          '<div id="descMotorista">' +
          'Rotas: ' + dados.rotas + '<br>' +  
          'Periodo: ' + dados.periodo + '<br>' +
          'Telefone: ' + dados.telefone + '' +
          '</div></div>';
          
          log.style.display = "none";
          document.querySelectorAll('.transportadores').forEach(function(mot){
            mot.style.display = "none";
          });
          cad.style.display = "none";
          ed.style.display = "none";
          infMot.style.display = "block";

          exibirRotaMotorista(dados.motorista_id);
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

  // Vincula o evento de clique ao botão "saiba mais"
  $("#listMot").on("click", ".salvar", function(event) {
    var idMot = $(this).siblings('#idMot').val();
    exibirDetalhes(idMot);
  });
});

// Função para enviar o email de redefinição de senha
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
      alert("Link para recuperação enviado ao seu email.")
      document.getElementById("esqueciSenha").display = "none";
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert("Erro ao enviar email. Tente novamente mais tarde.");
    }
  });
}