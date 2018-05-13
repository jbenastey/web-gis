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

    <link rel="stylesheet" href="assets/css/ol.css" type="text/css">
    <!-- The line below is only needed for old environments like Internet Explorer and Android 4.x -->

    <script src="assets/js/ol.js"></script>
    <script src="assets/js/jquery-3.1.1.min.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.min.js"></script>

    <title>OpenLayers example</title>
  </head>
  <body>
    <h2>My Map</h2>
    <div id="map" class="map"><div id="popup"></div></div>
    <script>
      var fst = [101.355749, 0.468027];
      var fstt = ol.proj.transform(fst,'EPSG:4326','EPSG:3857');
      var iconFeatureFST = new ol.Feature({
        geometry: new ol.geom.Point(fstt),
        name: 'Fakultas Sains dan Teknologi',
        population: 4000,
        rainfall: 500
      }
      );
      var fsh = [101.353925, 0.466759];
      var fshh = ol.proj.transform(fsh,'EPSG:4326','EPSG:3857');
      var iconFeatureFSH = new ol.Feature({
        geometry: new ol.geom.Point(fshh),
        name: 'Fakultas Syariah dan Hukum',
        population: 4000,
        rainfall: 500
      }
      );


      var iconStyle = new ol.style.Style({
        image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
          anchor: [0.5, 46],
          anchorXUnits: 'fraction',
          anchorYUnits: 'pixels',
          src: 'icon.png'
        }))
      });

      iconFeatureFST.setStyle(iconStyle);
      iconFeatureFSH.setStyle(iconStyle);

      var vectorSource = new ol.source.Vector({
        features: [iconFeatureFST,iconFeatureFSH],projection:'EPSG:4326'
      });

      var vectorLayer = new ol.layer.Vector({
        source: vectorSource
      });

      var kecamatanLayer = new ol.layer.Image({
        source: new ol.source.ImageWMS({
          url: "http://localhost/mapserver/mapserv.exe?map=C:/xampp/htdocs/web-gis/data/kecamatan.map",
          serverType: "mapserver",
          params: {
            LAYERS: "Kecamatan",
            FORMAT: "image/png"
          }
        })
      });

      var jalanLayer = new ol.layer.Image({
        source: new ol.source.ImageWMS({
          url: "http://localhost/mapserver/mapserv.exe?map=C:/xampp/htdocs/web-gis/data/jalan.map",
          serverType: "mapserver",
          params: {
            LAYERS: "jalan",
            FORMAT: "image/png"
          }
        })
      });

      var uinLayer = new ol.layer.Image({
        source: new ol.source.ImageWMS({
          url: "http://localhost/mapserver/mapserv.exe?map=C:/xampp/htdocs/web-gis/data/uin.map",
          serverType: "mapserver",
          params: {
            LAYERS: "uin",
            FORMAT: "image/png"
          }
        })
      });

      var rasterLayer = new ol.layer.Tile({
            source: new ol.source.OSM()
          });

      var map = new ol.Map({
        layers: [rasterLayer, kecamatanLayer, jalanLayer, uinLayer,
         vectorLayer],
        target: document.getElementById('map'),
        view: new ol.View({
          center: ol.proj.fromLonLat([101.468675,0.481528]),
          zoom: 11
        })
      });

      map.getLayers().forEach(function(layer, i)
      {
        if (layer.getVisible() && typeof layer.get('featureSource') != 'undefined' && layers[layer.get('id')].info)
        {
          switch (layer.get('featureSource').from)
          {
            case 'GetFeatureInfo' :
              var url = layer.getSource().getGetFeatureInfoUrl
              (
                evt.coordinate, map.getView().getResolution() , map.getView().getProjection().getCode(),
              {'INFO_FORMAT': 'application/vnd.ogc.gml'}
            );

              $.ajax({
                url: url,
                type: 'GET',
                crossDomain: true,
                dataType: 'html',
                success: function(response){

                }
              },
              // error: function(XMLHttpRequest, textStatus, errorThrown)
              // {
              //   showLog("exclamation", 'Fitur getFeatureInfo pada Layer <span class="fg-amber">' + layers[layer.get('id')].nama+'</span> ini tidak tersedia');
              // }
            );
            }
        }
      })

      var element = document.getElementById('popup');

      var popup = new ol.Overlay({
        element: element,
        positioning: 'bottom-center',
        stopEvent: false,
        offset: [0, -50]
      });
      map.addOverlay(popup);

      // display popup on click
      map.on('click', function(evt) {
        var feature = map.forEachFeatureAtPixel(evt.pixel,
            function(feature) {
              return feature;
            });
        if (feature) {
          var coordinates = feature.getGeometry().getCoordinates();
          popup.setPosition(coordinates);
          $(element).popover({
            'placement': 'top',
            'html': true,
            'content': feature.get('name')
          });
          $(element).popover('show');
        } else {
          $(element).popover('destroy');
        }
      });

      // change mouse cursor when over marker
      map.on('pointermove', function(e) {
        if (e.dragging) {
          $(element).popover('destroy');
          return;
        }
        var pixel = map.getEventPixel(e.originalEvent);
        var hit = map.hasFeatureAtPixel(pixel);
        map.getTarget().style.cursor = hit ? 'pointer' : '';
      });
    </script>
  </body>
</html>
