// ajax para o envio do id sem refresh na pagina para expor as informações do motorista expessifico




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

function buttonLogin(){
   var ed = document.getElementById("EditarMotorista");
  var log = document.getElementById("Login");
  var moto = document.getElementById("transportadores");
  var cad = document.getElementById("Cad"); 
  var usu = document.getElementById("Usuario");
  var excl = document.getElementById("ExcluirMotorista");
  var infMot = document.getElementById("InfMotorista");

   log.style.display = "block";
   moto.style.display = "none";
   cad.style.display = "none";
   usu.style.display = "none";
   ed.style.display = "none";
   excl.style.display = "none";
   infMot.style.display = "none";

}


function buttonUsuario(){
  var ed = document.getElementById("EditarMotorista");
  var log = document.getElementById("Login");
  var moto = document.getElementById("transportadores");
  var cad = document.getElementById("Cad");
  var usu = document.getElementById("Usuario");
  var excl = document.getElementById("ExcluirMotorista");
  var infMot = document.getElementById("InfMotorista");
  
   log.style.display = "none";
   moto.style.display = "none";
   cad.style.display = "none";
   usu.style.display = "block";
   ed.style.display = "none";
   excl.style.display = "none";
   infMot.style.display = "none";
}

function buttonMoto(){
  var ed = document.getElementById("EditarMotorista");
  var log = document.getElementById("Login");
  var moto = document.getElementById("transportadores");
  var cad = document.getElementById("Cad");
  var usu = document.getElementById("Usuario");
  var excl = document.getElementById("ExcluirMotorista");
  var infMot = document.getElementById("InfMotorista");
  
   log.style.display = "none";
   moto.style.display = "block";
   cad.style.display = "none";
   usu.style.display = "none";
   ed.style.display = "none";
   excl.style.display = "none";
   infMot.style.display = "none";
}

function buttonCadastra(){
  var ed = document.getElementById("EditarMotorista");
  var log = document.getElementById("Login");
  var moto = document.getElementById("transportadores");
  var cad = document.getElementById("Cad");
  var usu = document.getElementById("Usuario");
  var excl = document.getElementById("ExcluirMotorista");
  var infMot = document.getElementById("InfMotorista");
  
   log.style.display = "none";
   moto.style.display = "none";
   cad.style.display = "block";
   usu.style.display = "none";
   ed.style.display = "none";
   excl.style.display = "none";
   infMot.style.display = "none";
}

function buttonEdita(){

  var ed = document.getElementById("EditarMotorista");
  var log = document.getElementById("Login");
  var moto = document.getElementById("transportadores");
  var cad = document.getElementById("Cad");
  var usu = document.getElementById("Usuario");
  var excl = document.getElementById("ExcluirMotorista");
  var infMot = document.getElementById("InfMotorista");
  
   log.style.display = "none";
   moto.style.display = "none";
   cad.style.display = "none";
   usu.style.display = "none";
   ed.style.display = "block";
   excl.style.display = "none";
   infMot.style.display = "none";
  
}

function buttonExclui(){

  var ed = document.getElementById("EditarMotorista");
  var log = document.getElementById("Login");
  var moto = document.getElementById("transportadores");
  var cad = document.getElementById("Cad");
  var usu = document.getElementById("Usuario");
  var excl = document.getElementById("ExcluirMotorista");
  var infMot = document.getElementById("InfMotorista");
  
   log.style.display = "none";
   moto.style.display = "none";
   cad.style.display = "none";
   usu.style.display = "none";
   ed.style.display = "none";
   excl.style.display = "block";
   infMot.style.display = "none";
}
function buttonInfoMotorista(){

  var ed = document.getElementById("EditarMotorista");
  var log = document.getElementById("Login");
  var moto = document.getElementById("transportadores");
  var cad = document.getElementById("Cad");
  var usu = document.getElementById("Usuario");
  var excl = document.getElementById("ExcluirMotorista");
  var infMot = document.getElementById("InfMotorista");

   log.style.display = "none";
   moto.style.display = "none";
   cad.style.display = "none";
   usu.style.display = "none";
   ed.style.display = "none";
   excl.style.display = "none";
   infMot.style.display = "block";
}
