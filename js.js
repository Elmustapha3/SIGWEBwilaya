
var mapView = new ol.View({
    center: ol.proj.fromLonLat([-8, 31.82]),
    zoom: 7
});

var map = new ol.Map({
    target: 'map',
    view: mapView,
    controls: []
});

var noneTile = new ol.layer.Tile({
    title: 'None',
    type: 'base',
    visible: false
});

var OSM = new ol.layer.Tile({
    title: 'Open Street Map',
    visible: true,
    type: 'base',
    source: new ol.source.OSM()
});

var satellite = new ol.layer.Tile({
    title: 'satellite',
    type: 'base',
    visible: true,
    source: new ol.source.XYZ({
            attributions: ['Powered by Esri',
                'Source: Esri, DigitalGlobe, GeoEye, Earthstar Geographics, CNES/Airbus DS, USDA, USGS, AeroGRID, IGN, and the GIS User Community'
            ],
            attributionsCollapsible: false,
            url: 'https://services.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
            maxZoom: 23
        })
});

map.addLayer(Base_Maps);

var overlayers= new ol.layer.Group({
    title:'Overlays',
    
})
map.addLayer(overlayers);

var layerSwitcher = new LayerSwitcher({
    activationMode: 'click',
    startActive: true,
    label: '',
    collapseLabel:'\u00BB',
    tipLabel: 'Legend',
    collapseTipLabel: 'Collapse legend',
    groupSelectStyle: 'children',
    reverse: false,
    selection:true,
    extent:true,
    noScroll:true
});
map.addControl(layerSwitcher);
map.addControl(layerSwitcher);
//layerSwitcher.renderPanel();


//var IndiaDsTile = new ol.layer.Tile({
 //   title: "India Districts",
    //    url: 'http://localhost:8080/geoserver/GISSimplified/wms',
        //params: { 'LAYERS': 'GISSimplified:india_ds', 'TILED': true },
     //   serverType: 'geoserver',
       // visible: true
   // })
//});
//loub


// map.addLayer(IndiaDsTile);

var IndiaStTile = new ol.layer.Tile({
    title: "India States",
    source: new ol.source.TileWMS({
        url: 'http://localhost:8080/geoserver/GISSimplified/wms',
        params: { 'LAYERS': 'GISSimplified:india_st', 'TILED': true },
        serverType: 'geoserver',
        visible: true
    })
});



var mousePosition = new ol.control.MousePosition({
    className: 'mousePosition',
    projection: 'EPSG:4326',
    coordinateFormat: function (coordinate) { return ol.coordinate.format(coordinate, '{y} , {x}', 6); }
});
map.addControl(mousePosition);

var scaleControl = new ol.control.ScaleLine({
    bar: true,
    text: true
});
map.addControl(scaleControl);

var container = document.getElementById('popup');
var content = document.getElementById('popup-content');
var closer = document.getElementById('popup-closer');

var popup = new ol.Overlay({
    element: container,
    autoPan: true,
    autoPanAnimation: {
        duration: 250,
    },
});

map.addOverlay(popup);

closer.onclick = function () {
    popup.setPosition(undefined);
    closer.blur();
    return false;
};

// start : home Control


var homeButton = document.createElement('button');
homeButton.innerHTML = '<img src="resources/images/loub.png" alt="" style="width:20px;height:20px;filter:brightness(0) invert(1);vertical-align:middle"></img>';
homeButton.className = 'myButton';

var homeElement = document.createElement('div');
homeElement.className = 'homeButtonDiv';
homeElement.appendChild(homeButton);

var homeControl = new ol.control.Control({
    element: homeElement
})

homeButton.addEventListener("click", () => {
    location.href = "index.php";
})

map.addControl(homeControl);



// end : home Control

// start : full screen Control

var fsButton = document.createElement('button');
fsButton.innerHTML = '<img src="resources/images/jjj.png" alt="" style="width:20px;height:20px;filter:brightness(0) invert(1);vertical-align:middle"></img>';
fsButton.className = 'myButton';

var fsElement = document.createElement('div');
fsElement.className = 'fsButtonDiv';
fsElement.appendChild(fsButton);

var fsControl = new ol.control.Control({
    element: fsElement
})

fsButton.addEventListener("click", () => {
    var mapEle = document.getElementById("map");
    if (mapEle.requestFullscreen) {
        mapEle.requestFullscreen();
    } else if (mapEle.msRequestFullscreen) {
        mapEle.msRequestFullscreen();
    } else if (mapEle.mozRequestFullscreen) {
        mapEle.mozRequestFullscreen();
    } else if (mapEle.webkitRequestFullscreen) {
        mapEle.webkitRequestFullscreen();
    }
})

map.addControl(fsControl);

// end : full screen Control

// start : zoomIn Control

var zoomInInteraction = new ol.interaction.DragBox();

zoomInInteraction.on('boxend', function () {
    var zoomInExtent = zoomInInteraction.getGeometry().getExtent();
    map.getView().fit(zoomInExtent);
});

var ziButton = document.createElement('button');
ziButton.innerHTML = '<img src="resources/images/zoomIn.svg" alt="" style="width:18px;height:18px;transform: rotate(270deg);filter:brightness(0) invert(1);vertical-align:middle"></img>';
ziButton.className = 'myButton';
ziButton.id = 'ziButton';

var ziElement = document.createElement('div');
ziElement.className = 'ziButtonDiv';
ziElement.appendChild(ziButton);

var ziControl = new ol.control.Control({
    element: ziElement
})

var zoomInFlag = false;
ziButton.addEventListener("click", () => {
    ziButton.classList.toggle('clicked');
    zoomInFlag = !zoomInFlag;
    if (zoomInFlag) {
        document.getElementById("map").style.cursor = "zoom-in";
        map.addInteraction(zoomInInteraction);
    } else {
        map.removeInteraction(zoomInInteraction);
        document.getElementById("map").style.cursor = "default";
    }
})

map.addControl(ziControl);

// end : zoomIn Control

// start : zoomOut Control

var zoomOutInteraction = new ol.interaction.DragBox();

zoomOutInteraction.on('boxend', function () {
    var zoomOutExtent = zoomOutInteraction.getGeometry().getExtent();
    map.getView().setCenter(ol.extent.getCenter(zoomOutExtent));

    mapView.setZoom(mapView.getZoom() - 1)
});

var zoButton = document.createElement('button');
zoButton.innerHTML = '<img src="resources/images/zoomOut.png" alt="" style="width:18px;height:18px;transform: rotate(270deg);filter:brightness(0) invert(1);vertical-align:middle"></img>';
zoButton.className = 'myButton';
zoButton.id = 'zoButton';

var zoElement = document.createElement('div');
zoElement.className = 'zoButtonDiv';
zoElement.appendChild(zoButton);

var zoControl = new ol.control.Control({
    element: zoElement
})

var zoomOutFlag = false;
zoButton.addEventListener("click", () => {
    zoButton.classList.toggle('clicked');
    zoomOutFlag = !zoomOutFlag;
    if (zoomOutFlag) {
        document.getElementById("map").style.cursor = "zoom-out";
        map.addInteraction(zoomOutInteraction);
    } else {
        map.removeInteraction(zoomOutInteraction);
        document.getElementById("map").style.cursor = "default";
    }
})

map.addControl(zoControl);

// end : zoomOut Control

// start : FeatureInfo Control

var featureInfoButton = document.createElement('button');
featureInfoButton.innerHTML = '<img src="resources/images/identify.svg" alt="" style="width:20x;height:20px;filter:brightness(0) invert(1);vertical-align:middle"></img>';
featureInfoButton.className = 'myButton';
featureInfoButton.id = 'featureInfoButton';

var featureInfoElement = document.createElement('div');
featureInfoElement.className = 'featureInfoDiv';
featureInfoElement.appendChild(featureInfoButton);

var featureInfoControl = new ol.control.Control({
    element: featureInfoElement
})

var featureInfoFlag = false;
featureInfoButton.addEventListener("click", () => {
    featureInfoButton.classList.toggle('clicked');
    featureInfoFlag = !featureInfoFlag;
})

map.addControl(featureInfoControl);

map.on('singleclick', function (evt) {
    if (featureInfoFlag) {
        content.innerHTML = '';
        var resolution = mapView.getResolution();

        var url = IndiaDsTile.getSource().getFeatureInfoUrl(evt.coordinate, resolution, 'EPSG:3857', {
            'INFO_FORMAT': 'application/json',
            'propertyName': 'state,district'
        });

        if (url) {
            $.getJSON(url, function (data) {
                var feature = data.features[0];
                var props = feature.properties;
                content.innerHTML = "<h3> State : </h3> <p>" + props.state.toUpperCase() + "</p> <br> <h3> District : </h3> <p>" +
                    props.district.toUpperCase() + "</p>";
                popup.setPosition(evt.coordinate);
            })
        } else {
            popup.setPosition(undefined);
        }
    }
});

// start : Length and Area Measurement Control

var lengthButton = document.createElement('button');
lengthButton.innerHTML = '<img src="resources/images/measure-length.png" alt="" style="width:17px;height:17px;filter:brightness(0) invert(1);vertical-align:middle"></img>';
lengthButton.className = 'myButton';
lengthButton.id = 'lengthButton';

var lengthElement = document.createElement('div');
lengthElement.className = 'lengthButtonDiv';
lengthElement.appendChild(lengthButton);

var lengthControl = new ol.control.Control({
    element: lengthElement
})

var lengthFlag = false;
lengthButton.addEventListener("click", () => {
    // disableOtherInteraction('lengthButton');
    lengthButton.classList.toggle('clicked');
    lengthFlag = !lengthFlag;
    document.getElementById("map").style.cursor = "default";
    if (lengthFlag) {
        map.removeInteraction(draw);
        addInteraction('LineString');
    } else {
        map.removeInteraction(draw);
        source.clear();
        const elements = document.getElementsByClassName("ol-tooltip ol-tooltip-static");
        while (elements.length > 0) elements[0].remove();
    }

})

map.addControl(lengthControl);

var areaButton = document.createElement('button');
areaButton.innerHTML = '<img src="resources/images/measure-area.png" alt="" style="width:17px;height:17px;filter:brightness(0) invert(1);vertical-align:middle"></img>';
areaButton.className = 'myButton';
areaButton.id = 'areaButton';


var areaElement = document.createElement('div');
areaElement.className = 'areaButtonDiv';
areaElement.appendChild(areaButton);

var areaControl = new ol.control.Control({
    element: areaElement
})

var areaFlag = false;
areaButton.addEventListener("click", () => {
    // disableOtherInteraction('areaButton');
    areaButton.classList.toggle('clicked');
    areaFlag = !areaFlag;
    document.getElementById("map").style.cursor = "default";
    if (areaFlag) {
        map.removeInteraction(draw);
        addInteraction('Polygon');
    } else {
        map.removeInteraction(draw);
        source.clear();
        const elements = document.getElementsByClassName("ol-tooltip ol-tooltip-static");
        while (elements.length > 0) elements[0].remove();
    }
})

map.addControl(areaControl);


/**
 * Message to show when the user is drawing a polygon.
 * @type {string}
 */
var continuePolygonMsg = 'Click to continue polygon, Double click to complete';

/**
 * Message to show when the user is drawing a line.
 * @type {string}
 */
var continueLineMsg = 'Click to continue line, Double click to complete';

var draw; // global so we can remove it later

var source = new ol.source.Vector();
var vector = new ol.layer.Vector({
    source: source,
    style: new ol.style.Style({
        fill: new ol.style.Fill({
            color: 'rgba(255, 255, 255, 0.2)',
        }),
        stroke: new ol.style.Stroke({
            color: '#ffcc33',
            width: 2,
        }),
        image: new ol.style.Circle({
            radius: 7,
            fill: new ol.style.Fill({
                color: '#ffcc33',
            }),
        }),
    }),
});

map.addLayer(vector);

function addInteraction(intType) {

    draw = new ol.interaction.Draw({
        source: source,
        type: intType,
        style: new ol.style.Style({
            fill: new ol.style.Fill({
                color: 'rgba(200, 200, 200, 0.6)',
            }),
            stroke: new ol.style.Stroke({
                color: 'rgba(0, 0, 0, 0.5)',
                lineDash: [10, 10],
                width: 2,
            }),
            image: new ol.style.Circle({
                radius: 5,
                stroke: new ol.style.Stroke({
                    color: 'rgba(0, 0, 0, 0.7)',
                }),
                fill: new ol.style.Fill({
                    color: 'rgba(255, 255, 255, 0.2)',
                }),
            }),
        }),
    });
    map.addInteraction(draw);

    createMeasureTooltip();
    createHelpTooltip();

    /**
     * Currently drawn feature.
     * @type {import("../src/ol/Feature.js").default}
     */
    var sketch;

    /**
     * Handle pointer move.
     * @param {import("../src/ol/MapBrowserEvent").default} evt The event.
     */
    var pointerMoveHandler = function (evt) {
        if (evt.dragging) {
            return;
        }
        /** @type {string} */
        var helpMsg = 'Click to start drawing';

        if (sketch) {
            var geom = sketch.getGeometry();
            // if (geom instanceof ol.geom.Polygon) {
            //   helpMsg = continuePolygonMsg;
            // } else if (geom instanceof ol.geom.LineString) {
            //   helpMsg = continueLineMsg;
            // }
        }

        //helpTooltipElement.innerHTML = helpMsg;
        //helpTooltip.setPosition(evt.coordinate);

        //helpTooltipElement.classList.remove('hidden');
    };

    map.on('pointermove', pointerMoveHandler);

    // var listener;
    draw.on('drawstart', function (evt) {
        // set sketch
        sketch = evt.feature;

        /** @type {import("../src/ol/coordinate.js").Coordinate|undefined} */
        var tooltipCoord = evt.coordinate;

        //listener = sketch.getGeometry().on('change', function (evt) {
        sketch.getGeometry().on('change', function (evt) {
            var geom = evt.target;
            var output;
            if (geom instanceof ol.geom.Polygon) {
                output = formatArea(geom);
                tooltipCoord = geom.getInteriorPoint().getCoordinates();
            } else if (geom instanceof ol.geom.LineString) {
                output = formatLength(geom);
                tooltipCoord = geom.getLastCoordinate();
            }
            measureTooltipElement.innerHTML = output;
            measureTooltip.setPosition(tooltipCoord);
        });
    });

    draw.on('drawend', function () {
        measureTooltipElement.className = 'ol-tooltip ol-tooltip-static';
        measureTooltip.setOffset([0, -7]);
        // unset sketch
        sketch = null;
        // unset tooltip so that a new one can be created
        measureTooltipElement = null;
        createMeasureTooltip();
        //ol.Observable.unByKey(listener);
    });
}



/**
 * The help tooltip element.
 * @type {HTMLElement}
 */
var helpTooltipElement;

/**
 * Overlay to show the help messages.
 * @type {Overlay}
 */
var helpTooltip;

/**
 * Creates a new help tooltip
 */
function createHelpTooltip() {
    if (helpTooltipElement) {
        helpTooltipElement.parentNode.removeChild(helpTooltipElement);
    }
    helpTooltipElement = document.createElement('div');
    helpTooltipElement.className = 'ol-tooltip hidden';
    helpTooltip = new ol.Overlay({
        element: helpTooltipElement,
        offset: [15, 0],
        positioning: 'center-left',
    });
    map.addOverlay(helpTooltip);
}

// map.getViewport().addEventListener('mouseout', function () {
//     helpTooltipElement.classList.add('hidden');
// });

/**
* The measure tooltip element.
* @type {HTMLElement}
*/
var measureTooltipElement;


/**
* Overlay to show the measurement.
* @type {Overlay}
*/
var measureTooltip;

/**
 * Creates a new measure tooltip
 */

function createMeasureTooltip() {
    if (measureTooltipElement) {
        measureTooltipElement.parentNode.removeChild(measureTooltipElement);
    }
    measureTooltipElement = document.createElement('div');
    measureTooltipElement.className = 'ol-tooltip ol-tooltip-measure';
    measureTooltip = new ol.Overlay({
        element: measureTooltipElement,
        offset: [0, -15],
        positioning: 'bottom-center',
    });
    map.addOverlay(measureTooltip);
}





/**
 * Format length output.
 * @param {LineString} line The line.
 * @return {string} The formatted length.
 */
var formatLength = function (line) {
    var length = ol.sphere.getLength(line);
    var output;
    if (length > 100) {
        output = Math.round((length / 1000) * 100) / 100 + ' ' + 'km';
    } else {
        output = Math.round(length * 100) / 100 + ' ' + 'm';
    }
    return output;
};

/**
 * Format area output.
 * @param {Polygon} polygon The polygon.
 * @return {string} Formatted area.
 */
var formatArea = function (polygon) {
    var area = ol.sphere.getArea(polygon);
    var output;
    if (area > 10000) {
        output = Math.round((area / 1000000) * 100) / 100 + ' ' + 'km<sup>2</sup>';
    } else {
        output = Math.round(area * 100) / 100 + ' ' + 'm<sup>2</sup>';
    }
    return output;
};

// end : Length and Area Measurement Control

// start : attribute query

var geojson;
var featureOverlay;

var qryButton = document.createElement('button');
qryButton.innerHTML = '<img src="resources/images/db.png" alt="" style="width:17px;height:17px;filter:brightness(0) invert(1);vertical-align:middle"></img>';
qryButton.className = 'myButton';
qryButton.id = 'qryButton';

var qryElement = document.createElement('div');
qryElement.className = 'myButtonDiv';
qryElement.appendChild(qryButton);

var qryControl = new ol.control.Control({
    element: qryElement
})

var qryFlag = false;
qryButton.addEventListener("click", () => {
    // disableOtherInteraction('lengthButton');
    qryButton.classList.toggle('clicked');
    qryFlag = !qryFlag;
    document.getElementById("map").style.cursor = "default";
    if (qryFlag) {
        if (geojson) {
            geojson.getSource().clear();
            map.removeLayer(geojson);
        }

        if (featureOverlay) {
            featureOverlay.getSource().clear();
            map.removeLayer(featureOverlay);
        }
        document.getElementById("attQueryDiv").style.display = "block";

        bolIdentify = false;

        addMapLayerList();
    } else {
        document.getElementById("attQueryDiv").style.display = "none";
        document.getElementById("attListDiv").style.display = "none";

        if (geojson) {
            geojson.getSource().clear();
            map.removeLayer(geojson);
        }

        if (featureOverlay) {
            featureOverlay.getSource().clear();
            map.removeLayer(featureOverlay);
        }
    }

})

map.addControl(qryControl);

function addMapLayerList_spQry() {
    $(document).ready(function () {
        $.ajax({
            type: "GET",
            url: "http://localhost:8080/geoserver/wfs?request=getCapabilities",
            dataType: "xml",
            success: function (xml) {
                var select = $('#selectLayer');
                select.append("<option class='ddindent' value=''></option>");
                $(xml).find('FeatureType').each(function () {
                    $(this).find('Name').each(function () {
                        var value = $(this).text();
                        select.append("<option class='ddindent' value='" + value + "'>" + value + "</option>");
                    });
                });
            }
        });
    });

};
//end spatial query

/////
var settingButton = document.createElement('button');
settingButton.innerHTML = '<img src="setting.png" alt="" style="width:20px;height:20px;filter:brightness(0) invert(1);vertical-align:middle"></img>';
settingButton.className = 'myButton';
settingButton.id = 'settingsButton';

var settingElement = document.createElement('div');
settingElement.className = 'homeButtonDiv';
settingElement.appendChild(settingButton);

var settingControl = new ol.control.Control({
    element: settingElement
})
map.addControl(settingControl);

var settingFlag = false;
settingsButton.addEventListener("click", () => {
    settingsButton.classList.toggle('clicked');
    settingFlag=!settingFlag;
    document.getElementById("map").style.cursor = "default";
    if (settingFlag) {
    document.getElementById("settingDiv").style.display="block";
    addMapLayerList('editingLayer');
    } else {
    document.getElementById("settingDiv").style.display="none";
}
})


///start modification 
map.on('singleclick', function(evt) { 
	var source = coucheWFS.getSource();
	console.log('source : ', source);
});
map.on('singleclick', function(evt) { 
	var features = coucheWFS.getSource().getFeatures();
	console.log('objets g??ographiques: ', features);
});

/////////////////fin 

var bufferButton=document.createElement('button');
bufferButton.innerHTML = '<img src="loubna2.svg" alt="" class="myImg"></img><span class="tooltiptext"></span>';
bufferButton.className= 'myButton';
bufferButton.id ='bufferButton';

var bufferElement= document.createElement('div');
bufferElement.className= 'myButtonDiv';
bufferElement.appendChild(bufferButton);

var buffControl = new ol.control.Control({
    element: bufferElement})

var bufferFlag =false;
bufferButton.addEventListener("click", () => {
bufferButton.classList.toggle('clicked');
bufferFlag =!bufferFlag;
document.getElementById("map").style.cursor="default"
if (bufferFlag) {
if (geojson) {
    geojson.getSource().clear();
    map.removeLayer (geojson);
}
if (featureOverlay) {
    featureoverlay.getsource().clear();
    map.removeLayer(featureOverlay);
}

    document.getElementById ("map").style.cursor= "default";
    document.getElementById ("spatialQry").style.display= "block";
    addMapLayerList_spQry();
 } else {
    document.getElementById("map"). style.cursor ="default";
    document.getElementById("spatialQry").style.display="none";
    document.getElementById("attListDiv"). style.display= "none";
    if (geojson){
    geojson.getSource().clear();
    map.removeLayer (geojson);
    }
    if (featureoverlay) {
    featureoverlay.getsource().clear ();
    }
 map.removeInteraction (draw);
if (document.getElementById('spUserInput').classList.contains ('clicked'))
     { document.getElementById('spUserInput' ).classList.toggle('clicked');
        }
        }
        });
        map.addControl(buffControl);
function addMapLayerList_spQry() {
$(document).ready(function () {
$.ajax({ 
   type: "GET",
    url: "http://"+serverPort+"/geoserver/wfs?request-getCapabilities",
     dataType: "xml",
      success: function (xml) {
          var select= $('#buffSelectLayer');
         select.append("<option class='ddindent' value=''></option>");
          $(xml).find('FeatureType').each(function (){
            $(this).find('Name').each(function (){
                var value =$(this).text();
                  if (layerList.includes(value)) {
                      select.append("<option class='ddindent' value='"+ value + ">" + value + "</option>");
        }
    });
  });
  }
});
});
};
//// end 1


function newaddGeoJsonToMap(url) {

    if (geojson) {
        geojson.getSource().clear();
        map.removeLayer(geojson);
    }

    var style = new ol.style.Style({
        // fill: new ol.style.Fill({
        //   color: 'rgba(0, 255, 255, 0.7)'
        // }),
        stroke: new ol.style.Stroke({
            color: '#FFFF00',
            width: 3
        }),
        image: new ol.style.Circle({
            radius: 7,
            fill: new ol.style.Fill({
                color: '#FFFF00'
            })
        })
    });

    geojson = new ol.layer.Vector({
        source: new ol.source.Vector({
            url: url,
            format: new ol.format.GeoJSON()
        }),
        style: style,

    });

    geojson.getSource().on('addfeature', function () {
        map.getView().fit(
            geojson.getSource().getExtent(),
            { duration: 1590, size: map.getSize(), maxZoom: 21 }
        );
    });
    map.addLayer(geojson);
};

function newpopulateQueryTable(url) {
    if (typeof attributePanel !== 'undefined') {
        if (attributePanel.parentElement !== null) {
            attributePanel.close();
        }
    }
    $.getJSON(url, function (data) {
        var col = [];
        col.push('id');
        for (var i = 0; i < data.features.length; i++) {

            for (var key in data.features[i].properties) {

                if (col.indexOf(key) === -1) {
                    col.push(key);
                }
            }
        }

        var table = document.createElement("table");

        table.setAttribute("class", "table table-bordered table-hover table-condensed");
        table.setAttribute("id", "attQryTable");
        // CREATE HTML TABLE HEADER ROW USING THE EXTRACTED HEADERS ABOVE.

        var tr = table.insertRow(-1);                   // TABLE ROW.

        for (var i = 0; i < col.length; i++) {
            var th = document.createElement("th");      // TABLE HEADER.
            th.innerHTML = col[i];
            tr.appendChild(th);
        }

        // ADD JSON DATA TO THE TABLE AS ROWS.
        for (var i = 0; i < data.features.length; i++) {
            tr = table.insertRow(-1);
            for (var j = 0; j < col.length; j++) {
                var tabCell = tr.insertCell(-1);
                if (j == 0) { tabCell.innerHTML = data.features[i]['id']; }
                else {
                    tabCell.innerHTML = data.features[i].properties[col[j]];
                }
            }
        }

        // var tabDiv = document.createElement("div");
        var tabDiv = document.getElementById('attListDiv');

        var delTab = document.getElementById('attQryTable');
        if (delTab) {
            tabDiv.removeChild(delTab);
        }

        tabDiv.appendChild(table);

        document.getElementById("attListDiv").style.display = "block";
    });

};

var highlightStyle = new ol.style.Style({
    fill: new ol.style.Fill({
      color: 'rgba(255,0,255,0.3)',
    }),
    stroke: new ol.style.Stroke({
        color: '#FF00FF',
        width: 3,
    }),
    image: new ol.style.Circle({
        radius: 10,
        fill: new ol.style.Fill({
            color: '#FF00FF'
        })
    })
});


var featureOverlay = new ol.layer.Vector({
    source: new ol.source.Vector(),
    map: map,
    style: highlightStyle
});

function newaddRowHandlers() {
    var table = document.getElementById("attQryTable");
    var rows = document.getElementById("attQryTable").rows;
    var heads = table.getElementsByTagName('th');
    var col_no;
    for (var i = 0; i < heads.length; i++) {
        // Take each cell
        var head = heads[i];
        if (head.innerHTML == 'id') {
            col_no = i + 1;
        }

    }
    for (i = 0; i < rows.length; i++) {
        rows[i].onclick = function () {
            return function () {
                featureOverlay.getSource().clear();

                $(function () {
                    $("#attQryTable td").each(function () {
                        $(this).parent("tr").css("background-color", "white");
                    });
                });
                var cell = this.cells[col_no - 1];
                var id = cell.innerHTML;
                $(document).ready(function () {
                    $("#attQryTable td:nth-child(" + col_no + ")").each(function () {
                        if ($(this).text() == id) {
                            $(this).parent("tr").css("background-color", "#d1d8e2");
                        }
                    });
                });

                var features = geojson.getSource().getFeatures();

                for (i = 0; i < features.length; i++) {
                    if (features[i].getId() == id) {
                        featureOverlay.getSource().addFeature(features[i]);

                        featureOverlay.getSource().on('addfeature', function () {
                            map.getView().fit(
                                featureOverlay.getSource().getExtent(),
                                { duration: 1500, size: map.getSize(), maxZoom: 24 }
                            );
                        });

                    }
                }
            };
        }(rows[i]);
    }
}
function addMapLayerList(selectElementName){
    $('#editingLayer').empty();
    $('#selectLayer').empty();
    $('#buffSelectLayer').empty();
    $('#buffSelectLayer').ready(function(){
        $.ajax({
            type: "GET",
url: "http://"+serverPort+"/geoserver/wfs?request-getCapabilities",
dataType: "xml",
success: function (xml) {
var select =$('#' +selectElementName);
select.append("<option class='ddindent' value=''></option>");
$(xml).find('FeatureType').each(function (){
$(this).find('Name').each(function () {
var value= $(this).text();
if (layerList.includes (value)) {
select.append("<option class='ddindent' value='"+ value + ">" + value + "</option>");
}
});
        });
    }
    });   
}); 
};
///STAR LOCALISATION 

$('#btnCrosshair').on("click", function (event) {
    $('#btnCrosshair').toggleClass('clicked');
    if ($('#btnCrosshair').hasClass('clicked'))
    {
    startAutolocate();
    } else {
    stopAutolocate();
    }
});
var intervalAutolocate;
var posCurrent;
var geolocation = new ol.Geolocation({
    trackingOptions: {
    enableHighAccuracy: true,
},
tracking: true,
projection: mapView.getProjection()
});

var positionFeature =new ol.Feature();
positionFeature.setStyle(
new ol.style.Style({
image: new ol.style.Circle({
radius: 6,
fill: new ol.style.Fill({
color:'#3399CC',
}),
stroke: new ol.style.Stroke({
color: '#fff',
width: 2,
}),
}),
})
);
map.addFeature(positionFeature);

var accuracyFeature = new ol. Feature();
var currentPositionLayer = new ol.layer.Vector({
map: map,
source: new ol.source.Vector({
features: [accuracyFeature, positionFeature],
}),
});
map.addFeature(accuracyFeature);
    function startAutolocate() {
        var coordinates = geolocation.getPosition();
        positionFeature.setGeometry(coordinates? new ol.geom.Point(coordinates) : null);
        mapView.setCenter (coordinates);
        mapView.setZoom (16);
        accuracyFeature.setGeometry(geolocation.getAccuracyGeometry());
        intervalAutolocate=setInterval(function () {
        var coordinates= geolocation.getPosition();
        var accuracy = geolocation.getAccuracyGeometry()
        positionFeature.setGeometry(coordinates? new ol.geom.Point (coordinates) : null);
        map.getView().setCenter (coordinates);
        mapView.setZoom (16);
        accuracyFeature.setGeometry (accuracy);
        }, 10000);
        }
        function stopAutolocate() {
        clearInterval (intervalAutolocate);
        positionFeature.setGeometry (null);
        accuracyFeature.setGeometry (null);
        }

//start editing 
//start: start editing Control
var editgeojson;
var editLayer;
 var modifiedFeatureList = [];
 var editTask;
 var editTaskName;
 var modifiedFeature =false;
 var modifyInteraction;
 var featureAdd;
 var snap_edit;
 var selectedFeatureOverlay =new ol.layer.Vector({
title: 'Selected Feature',
source: new ol.source.Vector(),
map: map,
style: highlightStyle
});
var startEditingButton= document.createElement('button');
startEditingButton.innerHTML = '<img src="editer.png" alt=""class="myImg"></img>';
startEditingButton.className = 'myButton';
startEditingButton.id = 'startEditingButton';
startEditingButton.title= 'Start Editing';
var startEditingElement= document.createElement('div');
startEditingElement.className= 'myButtonDiv';
startEditingElement.appendChild(startEditingButton);
var editControl = new ol.control.Control({
    element: startEditingElement})
    map.addControl(editControl);

var startEditingFlag= false;
startEditingButton.addEventListener("click", () => {
startEditingButton.classList.toggle('clicked');
startEditingFlag =!startEditingFlag;
document.getElementById("map").style.cursor= "default";
if (startEditingFlag) {
document.getElementById("editingControlDiv").style.display="block";
document.getElementById('editingLayer').value;
bolIdentify = false;
editLayer=document.getElementById('editingControlDiv').style.display="block";
var style= new ol.style.Style({
fill: new ol.style.Fill({
color: 'rgba(0, 0, 0, 0)'
}),
stroke: new ol.style.Stroke({
color: '#00FFFF',
width: 1
}),
image: new ol.style.Circle({
radius: 7,
fill: new ol.style.Fill({
color:'#00FFFF'
})
})
});
if (editgeojson) {
editgeojson.getSource().clear();
map.removeLayer(editgeojson);
}
editgeojson =new ol.layer.Vector({
title: "Edit Layer",
source: new ol.source.Vector({
format: new ol.format.GeoJSON(),
url: function (extent) {
return 'http://' + serverPort + '/geoserver/' + geoserverWorkspace + '/ows?service-WFS&' +'version-1.0.0&request-GetFeature&typeName= + editLayer' + '&' +'output Format=application/json&srsname=EPSG:3857&' +'bbox=' + extent.join(',') + ',EPSG:3857';
},
strategy: ol.loadingstrategy.bbox
}),
style: style,
});
map.addLayer(editgeojson);
}else{
    document.getElementById("editingControlsDiv").style.display="none";
    editgeojson.getSource().clear();
    map.removeLayer(editgeojson);
}
 })
//end start  edition 
 //jjjjjjjj
 var editingControlsDivElement= document.getElementById('editingControlDiv');
var addFeatureButton = document.createElement('button');
addFeatureButton.innerHTML = '<img src="editer.png" alt="" class="my Img"></img>';
addFeatureButton.className= 'myButton';
addFeatureButton.id = 'add FeatureButton';
addFeatureButton.title= 'Add Feature';
var addFeatureElement= document.createElement('div');
addFeatureElement.className= 'myButtonDiv';
addFeatureElement.id = 'addFeatureButtonDiv';
addFeatureElement.appendChild(addFeatureButton);
editingControlsDivElement.appendChild(addFeatureElement);
var addFeatureControl = new ol.control.Control({
    element: addFeatureElement})
    map.addControl(addFeatureControl);
var addFeatureFlag = false;
addFeatureButton.addEventListener("click", () => {
addFeatureButton.classList.toggle('clicked');
addFeatureFlag= !addFeatureFlag;
document.getElementById("map").style.cursor = "default";
if (addFeatureFlag) {
if (modifiedFeatureList) {
if (modifiedFeatureList.length > 0) {
var answer =confirm('Save edits?');
if (answer) {
saveEdits (editTask);
modifiedFeatureList = [];
} else {
// cancelEdits();
modifiedFeatureList = [];
}
}
}
editTask= 'insert';
addFeature();
} else {
if
(modifiedFeatureList.length > 0) {
var answer =confirm('You have unsaved edits. Do you want to save edits?');
if (answer) {
saveEdits (editTask);
modifiedFeatureList = [];
} else {
// cancelEdits();
modifiedFeatureList = [];
}
}

map.un('click', modifyFeature);
selectedFeatureOverlay.getSource().clear();
map.removeLayer (selectedFeatureOverlay);
modifiedFeature = false;
map.removeInteraction (modifyInteraction);
map.removeInteraction (snap_edit);
editTask='';

if (modifyInteraction) {
map.removeInteraction (modifyInteraction);
}if (snap_edit) {
map.removeInteraction (snap_edit);
}
if (drawInteraction) {
map.removeInteraction (drawInteraction)
}
}
})
 function addFeature(evt) {

    if (clickSelectedFeatureOverlay) {
    clickSelectedFeatureOverlay.getSource().clear();
    map.removeLayer (clickSelectedFeatureOverlay);
    }
    if (modifyInteraction) {
    map.removeInteraction (modifyInteraction);
    }
    if (snap_edit) {
    map.removeInteraction(snap_edit);
    }
    var interactionType;
    source_mod=editgeojson.getSource();
    drawInteraction = new ol.interaction.Draw({
    source: editgeojson.getSource(),
    type: editgeojson.getSource().getFeatures ()[0].getGeometry().getType(),
    style: interactionStyle
    });
    map.addInteraction(drawInteraction);
    snap_edit =new ol.interaction.Snap({
    source: editgeojson.getSource()
    });
    map.addInteraction(snap_edit);

    drawInteraction . on('drawend ' , function (e) {
        var feature= e.feature;
        feature.set ('geometry', feature.getGeometry() );
        modifiedFeatureList.push(feature) ;
    })
}
 // start: Hodify Feature Control
var modifyFeatureButton=document.createElement('button');
modifyFeatureButton.innerHTML = '<img src="resources/images/editModify.svg" alt="" class="my Img"></img>';
modifyFeatureButton.className= 'myButton';
modifyFeatureButton.id = 'modifyFeatureButton';
modifyFeatureButton.title= 'Modify Feature';
var modifyFeatureElement = document.createElement('div');
modifyFeatureElement.className= 'myButtonDiv';
modifyFeatureElement.id = 'modifyFeatureButtonDiv';
modifyFeatureElement.appendChild(modifyFeatureButton);
editingControlsDivElement.appendChild(modifyFeatureElement);
var modifyFeatureControl = new ol.control.Control({
    element: modifyFeatureElement})
    map.addControl(modifyFeatureControl);
var modifyFeatureFlag = false;
modifyFeatureButton.addEventListener("click", () => {
modifyFeatureButton.classList.toggle('clicked');
modifyFeatureFlag=ImodifyFeatureFlag;
document.getElementById("map").style.cursor = "default";
if (modifyFeatureFlag) {
modifiedFeatureList = [];
selectedFeatureOverlay.getSource().clear();
map.removeLayer (selectedFeatureOverlay);
map.on('click', modifyFeature);
editTask ='update';
} else {
if(modifiedFeatureList.length > 0) {
var answer=confirm('Save edits?');
if (answer) {
saveEdits(editTask);
modifiedFeatureList = [];
} else {
// cancelEdits();
modifiedFeatureList = [];
}
}

map.un('click', modifyFeature);
selectedFeatureOverlay.getSource().clear();
map.removeLayer(selectedFeatureOverlay);
modifiedFeature = false;
map.removeInteraction(modifyInteraction);
map.removeInteraction (snap_edit);
editTask='';
}
})
function modifyFeature(evt) {
selectedFeatureOverlay.getSource().clear();
map.removeLayer (selectedFeatureOverlay);
var selectedFeature=map.forEachFeatureAtPixel(evt.pixel,
function(feature, layer) {
return feature;
});
if (selectedFeature) {
selectedFeatureOverlay.getSource().addFeature(selectedFeature);

}

var modifySource = selectedFeatureOverlay.getSource();
modifyInteraction = new ol.interaction.Modify({
    source: modifySource
        });
        map.addInteraction(modifyInteraction);
        var sourceEditGeoJson= editgeojson.getSource();
        snap_edit = new ol.interaction.Snap({
        source: sourceEditGeoJson
        });
        map.addInteraction(snap_edit);
        modifyInteraction.on('modifyend', function (e) {
        modifiedFeature = true;
        featureAdd = true;
        if (modifiedFeatureList.length > 0) {
        for (var j = 0; j < modifiedFeatureList.length; j++) {
        if (e.features. item(0) ['id_'] == modifiedFeatureList[j]['id_']) {
        // modifiedFeatureList.splice (j, 1);
        featureAdd =false;
        }
        }
        }
        if (featureAdd) { modifiedFeatureList.push(e. features.item(0)); }
     })

    }

 var clones = [];
function saveEdits(editTaskName) {
clones = [];
for (var i = 0; i < modifiedFeatureList.length; i++) {
var feature = modifiedFeatureList[i];
var featureProperties =feature.getProperties();
delete featureProperties.boundedBy;
var clone= feature.clone();
clone.setId(feature.getId());
// if (editTaskName != 'insert') {clone.setGeometryName('the_geom');}
clones.push(clone)
// if (editTaskName == 'insert') { transactWFS ('insert', clone); }
}
if (editTaskName == 'update') { transactWFS ('update_batch', clones); }
if (editTaskName =='insert') { transactWFS('insert_batch', clones); }
}
var formatWFS = new ol.format.WFS ();
var transactWFS=function(mode,f){
    var node;
    var formatGML=new ol.format.GML({
        featureNS:geoserverWorkspace,
        featueType:editLayer,
        service:'WFS',
        version:'1.1.0',
        request:'GetFeature',
        srsName:'EPSG:3857'
    });
    switch (mode){

case 'insert':
node= formatMFS.writeTransaction([f], null, null, formatGML);
break;
case 'insert_batch':
node =formatMFS.writeTransaction(f, null, null, formatGML);
break;
case 'update':
node =formatMFS.writeTransaction(null, [f], null, formatGML);
break;
case 'update_batch':
node= formatMFS.writeTransaction(null, f, null, formatGML);
break;
case 'delete':
node =formatMFS.writeTransaction(null, null, [f], formatGML);
break;
case 'delete_batch':
node= formatWFS.writeTransaction(null, null, [f], formatGML);
break;
}
var xs= new XMLSerializer();
var payload =xs.serializeToString(node);
payload= payload.split('feature:' + editLayer).join(editLayer);
if (editTask== 'insert') { payload =payload.split(geoserverworkspace +':geometry').join(geoserverWorkspace+':geom');}
if (editTask == 'update') { payload=payload.split('<Name>geometry</Name>').join('<Name>geom</Name>'); }
// payload payload.replace(/feature:editLayer/g, editLayer);
$.ajax('http://localhost:8080/geoserver/wfs', {
type: 'POST',
dataType: 'xml',
processData: false,
contentType: 'text/xml',
data: payload.trim(),
success: function (data) {
// console.log('building updated');
},
error: function (e) {
var errorMsg=e ? (e.status + ''+ e.statusText): "";
alert('Error saving this feature to GeoServer.<br><br>'+ errorMsg);}
}).done(function () {
    editgeojson.getSource().refresh();
});
};

function selectFeatureToDelete(evt) {
    clickselectedFeatureOverlay.getSource().clear();
    nap.removeLayer(clickSelectedFeatureOverlay);
    var selectedFeature=map.forEachFeatureAtPixel(evt.pixel,
    function (feature, layer) {
    return feature;
    });
    if (selectedFeature) {
    // clickSelected
    clones = [];
    var answer
    if (answer) {
        var feature= selectedFeature;
    var featureProperties= feature.getProperties();
    delete featureProperties.boundedBy;
    var clone =feature.clone();
    clone.setId(feature.getId());
    // clone.setGeometryName("the_geom');
   
clones.push(clone)
if (editTask == 'update') { transactWFS('update_batch',clones);}
if (editTask == 'insert') { transactWFS('insert_batch',clones);}
if (editTask == 'delete') { transactWFS('delete', clone); }
}
}
}

 //start:setting add feauture 
 var deleteFeatureButton
 document.createElement('button');
 deleteFeatureButton.innerHTML = '<img src="editer.png" alt="" class="myImg"></img>';
 deleteFeatureButton.className= 'myButton';
 deleteFeatureButton.id = 'deleteFeatureButton';
 deleteFeatureButton.title='Delete Feature';
 var deleteFeatureElement= document.createElement('div');
  deleteFeatureElement.className= 'myButtonDiv';
  deleteFeatureElement.id= 'deleteFeatureButtonDiv';
  deleteFeatureElement.appendChild(deleteFeatureButton);
 editingControlsDivElement.appendChild(deleteFeatureElement);
  

 var deleteFeatureFlag = false;
deleteFeatureButton.addEventListener("click", ()=> {
deleteFeatureButton.classList.toggle('clicked');
deleteFeatureFlag=!deleteFeatureFlag;
document.getElementById("map").style.cursor= "default";
if (deleteFeatureFlag) {
modifiedFeatureList= [];
selectedFeatureOverlay.getSource().clear();
map.removeLayer (selectedFeatureOverlay);
editTask ='delete';
map.on('click', selectFeatureToDelete);
//start:setting add feauture 
}else{
    if (modifiedFeatureList.lenght >0){
        var answer =confirm('You have unsaved edits. Do you want to save edits?');
if (answer) {
saveEdits (editTask);
modifiedFeatureList = [];
} else {
// cancelEdits();
modifiedFeatureList = [];
}
    }
    map.un('click', modifyFeature);
selectedFeatureOverlay.getSource().clear();
map.removeLayer(selectedFeatureOverlay);
modifiedFeature = false;
map.removeInteraction(modifyInteraction);
map.removeInteraction (snap_edit);
editTask='';
}
})




///////////////////////////////
var geojson;
var featureOverlay;

var bufferButton=document.createElement('button');
bufferButton.innerHTML = '<img src="resources/images/mapsearch.png" alt="" class="my Img"></img><span class="tooltiptext">Spatial Query</span>';
bufferButton.className= 'myButton';
bufferButton.id = 'bufferButton';

var bufferElement= document.createElement('div');
bufferElement.className= 'myButtonDiv';
bufferElement.appendChild(bufferButton);
toolbarDivElement.appendChild (bufferElement);

var bufferFlag =false;
bufferButton.addEventListener("click", () => {
bufferButton.classList.toggle('clicked');
bufferFlag =!bufferFlag;
document.getElementById("map").style.cursor="default"
if (bufferFlag) {
if (geojson) {
geojson.getSource().clear();
map.removeLayer (geojson);
}
if (featureOverlay) {
    featureoverlay.getsource().clear();
    map.removeLayer(featureOverlay);
    document.getElementById ("map").style.cursor= "default";
    document.getElementById ("spQueryDiv").style.display= "block";
    addMapLayerList_spQry();
 } else {
    document.getElementById("map"). style.cursor ="default";
    document.getElementById("spQueryDiv").style.display="none";
    document.getElementById("attListDiv"). style.display= "none";
    if (geojson){
    geojson.getSource().clear();
    map.removeLayer (geojson);
    }
    if (featureoverlay) {
    featureoverlay.getsource().clear ();
    }
 map.removeInteraction (draw);
if (document.getElementById(' spUserInput').classList.contains ('clicked')) { document.getElementById('spUserInput' ).classList.toggle('clicked');}
    }
 }
});

function addMapLayerList_spQry() {
$(document).ready(function () {
$.ajax({ 
type: "GET",
url: "http://"+serverPort+"/geoserver/wfs?request-getCapabilities",
dataType: "xml",
success: function (xml) {
var select= $('#buffSelectLayer');
select.append("<option class='ddindent' value=''></option>");
$(xml).find('FeatureType').each(function (){
$(this).find('Name').each(function (){
var value =$(this).text();
if (layerList.includes (value)) {
select.append("<option class='ddindent' value='"+ value + ">" + value + "</option>");
}
});
});
}
});
});
};
//// end 1
// live location
$('#btnCrosshair').on("click", function (event) {
    $('#btnCrosshair').toggleClass('clicked');
    if ($('#btnCrosshair').hasClass('clicked'))
    {
    startAutolocate();
    } else {
    stopAutolocate();
    }
});
var intervalAutolocate;
var posCurrent;
var geolocation = new ol.Geolocation({
trackingOptions: {
enableHighAccuracy: true,
},
tracking: true,
projection: mapView.getProjection()
});

var positionFeature =new ol.Feature();
positionFeature.setStyle(
new ol.style.Style({
image: new ol.style.Circle({
radius: 6,
fill: new ol.style.Fill({
color:'#3399CC',
}),
stroke: new ol.style.Stroke({
color: '#fff',
width: 2,
}),
}),
})
);

var accuracyFeature = new ol. Feature();
var currentPositionLayer = new ol.layer.Vector({
map: map,
source: new ol.source.Vector({
features: [accuracyFeature, positionFeature],
}),
});
    function startAutolocate() {
        var coordinates = geolocation.getPosition();
        positionFeature.setGeometry(coordinates? new ol.geom.Point(coordinates) : null);
        mapView.setCenter (coordinates);
        mapView.setZoom (16);
        accuracyFeature.setGeometry(geolocation.getAccuracyGeometry());
        intervalAutolocate=setInterval(function () {
        var coordinates= geolocation.getPosition();
        var accuracy = geolocation.getAccuracyGeometry()
        positionFeature.setGeometry(coordinates? new ol.geom.Point (coordinates) : null);
        map.getView().setCenter (coordinates);
        mapView.setZoom (16);
        accuracyFeature.setGeometry (accuracy);
        }, 10000);
        }
        function stopAutolocate() {
        clearInterval (intervalAutolocate);
        positionFeature.setGeometry (null);
        accuracyFeature.setGeometry (null);
        }
//MAP  print 
function imprimer_page(){
    window.print();

  }


