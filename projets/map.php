<?php

$map = "var $projet = new ol.layer.Tile({   title: '$projet',   visible: $visi,    source: new ol.source.TileWMS({ url: 'http://localhost/geoserver/wilayaSIG/wms',      params: {'LAYERS':'wilayaSIG:$projet','TILED':true}, serverType: 'geoserver',    })  }); map.addLayer($projet);";

//$map = "var $projet = new ol.layer.Tile({   title: '$projet',   visible: true,    source: new ol.source.TileWMS({ url: 'http://localhost/geoserver/ows?request=GetFeature&service=WFS&version=2.0.0&typename=wilayaSIG:$projet&outputformat=JSON',      params: {'LAYERS':'wilayaSIG:$projet','TILED':true}, serverType: 'geoserver',      visisble: $visi    })  }); map.addLayer($projet);";
//$map = "var mygeojson = new ol.layer.Vector({ source : new ol.source.Vector({ format: new ol.format.GeoJSON(), url:'http://localhost/geoserver/ows?request=GetFeature&service=WFS&version=2.0.0&typename=wilayaSIG:$projet&outputformat=JSON' }) }) map.addLayer(mygeojson)";

echo $map;



?>