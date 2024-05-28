var drawnItems;

$(document).ready(function() {
  // funções para o funcionamento do mapa

  var map = L.map('myMap', {
    minZoom: 15, 
    maxZoom: 18
  }).setView([-22.948060704805442, -47.14962819945917], 16);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

  // Camada para armazenar as rotas
  drawnItems = L.featureGroup().addTo(map);

  var drawControl;
  var rotaDesenhada = false; // Variável para controlar se o motorista já desenhou uma rota

  // Manipulação de eventos de desenho
  map.on(L.Draw.Event.CREATED, function(e) {
  var layer = e.layer;
  drawnItems.addLayer(layer);
  
  // Obter os pontos da rota em formato GeoJSON
  var geojson = layer.toGeoJSON();

  // Envia os dados para o servidor via AJAX
  $.ajax({
    url: 'salvarRota.php', // Arquivo PHP que irá receber os dados
    type: 'POST', // Método HTTP
    data: { // Dados a serem enviados
      geojson: JSON.stringify(geojson),
      motorista_id: $('#motorista_id').val()
    },
    dataType: 'json', // Tipo de dado esperado na resposta do servidor
    success: function(resposta) {
      if (resposta.status === 'sucesso') {
        // Rota salva com sucesso!
        alert(resposta.mensagem);

        // Adiciona a nova rota ao mapa
        var novaRotaLayer = L.geoJSON(geojson, { // 'geojson' deve estar acessível aqui
          style: { 
            color: 'blue',
            weight: 5
          }
        });

        // 2. Adicione a nova camada ao drawnItems
        drawnItems.addLayer(novaRotaLayer); 
      } else {
        // Exibe a mensagem de erro
        alert("Erro ao salvar a rota: " + resposta.mensagem); 
      }
    },
    error: function(erro) {
      // Erro na requisição AJAX
      console.error("Erro ao enviar dados da rota:", erro);
      alert("Erro ao salvar a rota. Por favor, tente novamente.");
    }
  });
});

  // Função para carregar as rotas usando jQuery AJAX
  function carregarRotas() {
    $.ajax({
      url: 'getRotas.php',
      type: 'GET',
      dataType: 'json', // Espera-se uma resposta JSON do servidor
      success: function(rotas) {
        // Iterar pelas rotas recebidas
        $.each(rotas, function(index, rota) { 
          // Adicionar cada rota ao mapa usando Leaflet
          var geojsonLayer = L.geoJSON(rota.geojson).addTo(map);
        });
      },
      error: function(erro) {
        console.error('Erro ao carregar rotas:', erro);
      }
    });
  }

  // Chamar a função para carregar as rotas quando o mapa estiver pronto
  carregarRotas();

  var drawControl; // Declarando a variável globalmente

  // Função para adicionar o controle de desenho ao mapa
  window.adicionarControleDesenho = function() {
    if (!drawControl) { 
      drawControl = new L.Control.Draw({
        // ... (suas opções do Leaflet Draw)
        edit: {
          featureGroup: drawnItems, // Camada para armazenar as rotas desenhadas
        },
        draw: {
          polyline: true,
          polygon: false,
          marker: false,
          circle: false,
          rectangle: false,
          circlemarker: false
        }
      });
      map.addControl(drawControl);
    }
  }
});

window.exibirRotaMotorista = function(motoristaId) {
  // Limpa as rotas existentes do mapa
  drawnItems.clearLayers();

  // Faz a requisição AJAX para buscar a rota do motorista
  $.ajax({
    url: 'getRotaMotorista.php', // Crie este arquivo PHP
    type: 'GET',
    data: { motorista_id: motoristaId }, 
    dataType: 'json',
    success: function(rota) {
      if (rota && rota.geojson) {
        // Adiciona a rota ao mapa
        L.geoJSON(rota.geojson, {
          style: { 
            color: 'blue',
            weight: 5
          }
        }).addTo(drawnItems); // Adicione ao drawnItems
      } else {
        console.error("Rota não encontrada para o motorista:", motoristaId);
      }
    },
    error: function(erro) {
      console.error('Erro ao carregar a rota do motorista:', erro);
    }
  });
}