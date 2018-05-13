<!doctype html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="assets/css/ol.css" type="text/css">
    <style>
      .map {
        height: 400px;
        width: 100%;
      }
    </style>
    <script src="assets/js/ol-debug.js" type="text/javascript"></script>
    <script type="text/javascript" src="assets/js/FeaturePopups.js"></script>
    <script type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>
    <title>OpenLayers example</title>
  </head>
  <body>
    <h2>My Map</h2>
    <div id="map" class="map"></div>
    <script type="text/javascript">


      var map = new ol.Map({
        target: 'map',
        layers: [
          new ol.layer.Tile({
            source: new ol.source.OSM()
          }),
		  new ol.layer.Image({
			  source: new ol.source.ImageWMS({
				  url: "http://localhost/mapserver/mapserv.exe?map=C:/xampp/htdocs/web-gis/data/kecamatan.map",
				  serverType: "mapserver",
				  params: {
					  LAYERS: "Kecamatan",
					  FORMAT: "image/png"
				  }
			  })
		  }),
  new ol.layer.Image({
    source: new ol.source.ImageWMS({
      url: "http://localhost/mapserver/mapserv.exe?map=C:/xampp/htdocs/web-gis/data/jalan.map",
      serverType: "mapserver",
      params: {
        LAYERS: "jalan",
        FORMAT: "image/png"
      }
    })
  }),
  new ol.layer.Image({
    source: new ol.source.ImageWMS({
      url: "http://localhost/mapserver/mapserv.exe?map=C:/xampp/htdocs/web-gis/data/uin.map",
      serverType: "mapserver",
      params: {
        LAYERS: "uin",
        FORMAT: "image/png"
      }
    })
  }),
new ol.layer.Image({
source: new ol.source.ImageWMS({
  url: "http://localhost/mapserver/mapserv.exe?map=C:/xampp/htdocs/web-gis/data/fakultas.map",
  serverType: "mapserver",
  params: {
    LAYERS: "fakultas",
    FORMAT: "image/png"
  }
})
})

        ],
        view: new ol.View({
          center: ol.proj.fromLonLat([101.468675,0.481528]),
          zoom: 11
        })
      });
    </script>
  </body>
</html>
