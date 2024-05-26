var drawnItems;

$(document).ready(function() {
  // funções para o funcionamento do mapa

  var map = L.map('myMap').setView([-23.5505, -46.6333], 13); // Coordenadas de São Paulo como exemplo

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

  // Camada para armazenar as rotas
  drawnItems = L.featureGroup().addTo(map);

  var drawControl;

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
  map.on('load', carregarRotas);

  var drawControl; // Declarando a variável globalmente

  // Função para adicionar o controle de desenho ao mapa
  window.adicionarControleDesenho = function() {
    if (!drawControl) { 
      drawControl = new L.Control.Draw({
        // ... (suas opções do Leaflet Draw)
        edit: {
          featureGroup: drawnItems // Camada para armazenar as rotas desenhadas
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