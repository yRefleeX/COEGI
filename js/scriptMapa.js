$(document).ready(function() {
  // funções para o funcionamento do mapa

  var map = L.map('myMap').setView([-23.5505, -46.6333], 13); // Coordenadas de São Paulo como exemplo

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

  // Camada para armazenar as rotas
  var drawnItems = L.featureGroup().addTo(map);

  // Controle de desenho para motoristas
  var drawControl = new L.Control.Draw({
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

  // Manipulação de eventos de desenho
  map.on(L.Draw.Event.CREATED, function(e) {
  var layer = e.layer;
  drawnItems.addLayer(layer);
  
  // Obter os pontos da rota em formato GeoJSON
  var geojson = layer.toGeoJSON();

  // Envia os dados para o servidor via AJAX
  $.ajax({
    url: 'salvar_rota.php', // Arquivo PHP que irá receber os dados
    type: 'POST', // Método HTTP
    data: { geojson: JSON.stringify(geojson) }, // Dados a serem enviados
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
      url: 'get_rotas.php',
      type: 'GET',
      dataType: 'json', // Espera-se uma resposta JSON do servidor
      success: function(rotas) {
        // Iterar pelas rotas recebidas
        $.each(rotas, function(index, rota) { 
          // Adicionar cada rota ao mapa usando Leaflet
          var geojsonLayer = L.geoJSON(rota.geojson).addTo(map);
          geojsonLayer.bindPopup("Rota do motorista: " + rota.nome_motorista); 
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
      });
      map.addControl(drawControl);
    }
  }
});