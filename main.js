var serverPort = 'localhost:8080';
var geoserverWorkspace = 'wilayaSIG';

var identifyLayers = [];
var projectionName = 'EPSG:3857';
var layerList = [];

var geojson;
var queryGeoJSON;

var highlightStyle = new ol.style.Style({
    fill: new ol.style.Fill({
        color: 'rgba(64,244,208,0.4)',
    }),
    stroke: new ol.style.Stroke({
        color: '#40E0D0',
        width: 3,
    }),
    image: new ol.style.Circle({
        radius: 10,
        fill: new ol.style.Fill({
            color: '#40E0D0'
        })
    })
});
var featureOverlay = new ol.layer.Vector({
    source: new ol.source.Vector(),
    map: map,
    style: highlightStyle
});

var querySelectedFeatureStyle = new ol.style.Style({
    fill: new ol.style.Fill({
        color: 'rgba(64,244,208,0.4)',
    }),
    stroke: new ol.style.Stroke({
        color: '#40E0D0',
        width: 3,
    }),
    image: new ol.style.Circle({
        radius: 10,
        fill: new ol.style.Fill({
            color: '#40E0D0'
        })
    })
});
var querySelectedFeatureOverlay = new ol.layer.Vector({
    source: new ol.source.Vector(),
    map: map,
    style: querySelectedFeatureStyle
});

var clickSelectedFeatureStyle = new ol.style.Style({
    fill: new ol.style.Fill({
        color: 'rgba(255,255,0,0.4)',
    }),
    stroke: new ol.style.Stroke({
        color: '#FFFF00',
        width: 3,
    }),
    image: new ol.style.Circle({
        radius: 10,
        fill: new ol.style.Fill({
            color: '#FFFF00'
        })
    })
});
var clickSelectedFeatureOverlay = new ol.layer.Vector({
    source: new ol.source.Vector(),
    map: map,
    style: clickSelectedFeatureStyle
});
var interactionStyle = new ol.style.Style({
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
    })
});

var mapView = new ol.View({
    center: ol.proj.fromLonLat([-8.5, 31.82]),
    zoom: 8
});

var map = new ol.Map({
    target: 'map',
    view: mapView,
    controls: []
});

var osmTile = new ol.layer.Tile({
    title: 'Open Street Map',
    type: 'base',
    visible: true,
    attributions: '',
    source: new ol.source.OSM()
});
var satellite = new ol.layer.Tile({
    title: 'satellite',
    type: 'base',
    visible: false,
    source: new ol.source.XYZ({
            attributions: ['Powered by Esri',
                'Source: Esri, DigitalGlobe, GeoEye, Earthstar Geographics, CNES/Airbus DS, USDA, USGS, AeroGRID, IGN, and the GIS User Community'
            ],
            attributionsCollapsible: false,
            url: 'https://services.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
            maxZoom: 23
        })
});

var noneTile = new ol.layer.Tile({
    title: 'None',
    type: 'base',
    visible: false
});

var baseGroup = new ol.layer.Group({
    title: 'Base Maps',
    fold: true,
    layers: [osmTile,satellite, noneTile]
});



map.addLayer(baseGroup);
// map.addLayer(lbLayer);
/*
for (y = 0; y < map.getLayers().getLength(); y++) {
    var lyr1 = map.getLayers().item(y)
    if (lyr1.get('title') == 'Base Maps') { } else {
        if (lyr1.getLayers().getLength() > 0) {
            for (z = 0; z < lyr1.getLayers().getLength(); z++) {
                var lyr2 = lyr1.getLayers().item(z);
                layerList.push(lyr2.getSource().getParams().LAYERS);
            }
        } else {
            layerList.push(lyr1.getSource().getParams().LAYERS);
        }
    }

}*/

// start : mouse position
var mousePosition = new ol.control.MousePosition({
    className: 'mousePosition',
    projection: 'EPSG:4326',
    coordinateFormat: function (coordinate) { return ol.coordinate.format(coordinate, '{y} , {x}', 6); }
});
map.addControl(mousePosition);
// end : mouse position

// start : scale control
var scaleControl = new ol.control.ScaleLine({
    bar: true,
    text: true,
});
map.addControl(scaleControl);
// end : scale control

var toolbarDivElement = document.createElement('div');
toolbarDivElement.className = 'toolbarDiv';


var toolbarDivElementRight = document.createElement('div');
toolbarDivElementRight.className = 'toolbarDivRight';

var toolbarDivElementSwitcher = document.createElement('div');
toolbarDivElementSwitcher.className = 'toolbarDivSwitcher';

// start : home Control
var homeButton = document.createElement('button');
homeButton.innerHTML = '<img src="resources/images/home.svg" alt="" class="myImg"></img>';
homeButton.className = 'myButton';
homeButton.title = 'Home';


var homeElement = document.createElement('div');
homeElement.className = 'homeButtonDiv';
homeElement.appendChild(homeButton);
toolbarDivElement.appendChild(homeElement);

homeButton.addEventListener("click", () => {
    location.href = "index.php";
})

// map.addControl(homeControl);
// end : home Control

// start : full screen Control
var fsButton = document.createElement('button');
fsButton.innerHTML = '<img src="resources/images/fullscreen.svg" alt="" class="myImg"></img>';
fsButton.className = 'myButton';
fsButton.title = 'Full Screen';

var fsElement = document.createElement('div');
fsElement.className = 'myButtonDiv';
fsElement.appendChild(fsButton);
toolbarDivElement.appendChild(fsElement);

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

// map.addControl(fsControl);
// end : full screen Control

// start : Layers Control
var lyrsButton = document.createElement('button');
lyrsButton.innerHTML = '<img src="resources/images/layers.svg" alt="" class="myImg"></img>';
lyrsButton.className = 'myButton';
lyrsButton.title = 'Layers';

var lyrElement = document.createElement('div');
lyrElement.className = 'myButtonDiv';
lyrElement.appendChild(lyrsButton);
toolbarDivElementSwitcher.appendChild(lyrElement);

var layersFlag = false;
lyrsButton.addEventListener("click", () => {
    lyrsButton.classList.toggle('clicked');
    document.getElementById("map").style.cursor = "default";
    layersFlag = !layersFlag;

    if (layersFlag) {
        document.getElementById("layersDiv").style.display = "block";
    } else {
        document.getElementById("layersDiv").style.display = "none";
    }
})
// end : Layers Control


// start : pan Control
var panButton = document.createElement('button');
panButton.innerHTML = '<img src="resources/images/pan.svg" alt="" class="myImg"></img>';
panButton.className = 'myButton';
panButton.id = 'panButton';
panButton.title = 'Pan';

var panElement = document.createElement('div');
panElement.className = 'myButtonDiv';
panElement.appendChild(panButton);
toolbarDivElement.appendChild(panElement);

var panFlag = false;
var drgPanInteraction = new ol.interaction.DragPan();
panButton.addEventListener("click", () => {
    panButton.classList.toggle('clicked');
    panFlag = !panFlag;
    if (panFlag) {
        document.getElementById("map").style.cursor = "grab";
        map.addInteraction(drgPanInteraction);
    } else {
        document.getElementById("map").style.cursor = "default";
        map.removeInteraction(drgPanInteraction);
    }
})
// end : pan Control

// start : zoomIn Control

var zoomInInteraction = new ol.interaction.DragBox();

zoomInInteraction.on('boxend', function () {
    var zoomInExtent = zoomInInteraction.getGeometry().getExtent();
    map.getView().fit(zoomInExtent);
});

var ziButton = document.createElement('button');
ziButton.innerHTML = '<img src="resources/images/zoomIn.svg" alt="" class="myImg"></img>';
ziButton.className = 'myButton';
ziButton.id = 'ziButton';
ziButton.title = 'Zoom In';

var ziElement = document.createElement('div');
ziElement.className = 'myButtonDiv';
ziElement.appendChild(ziButton);
toolbarDivElement.appendChild(ziElement);

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

// end : zoomIn Control

// start : zoomOut Control
var zoomOutInteraction = new ol.interaction.DragBox();

zoomOutInteraction.on('boxend', function () {
    var zoomOutExtent = zoomOutInteraction.getGeometry().getExtent();
    map.getView().setCenter(ol.extent.getCenter(zoomOutExtent));

    mapView.setZoom(mapView.getZoom() - 1)
});

var zoButton = document.createElement('button');
zoButton.innerHTML = '<img src="resources/images/zoomOut.png" alt="" class="myImg"></img>';
zoButton.className = 'myButton';
zoButton.id = 'zoButton';
zoButton.title = 'Zoom Out';

var zoElement = document.createElement('div');
zoElement.className = 'myButtonDiv';
zoElement.appendChild(zoButton);
toolbarDivElement.appendChild(zoElement);

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
// end : zoomOut Control

// start : FeatureInfo Control
var featureInfoButton = document.createElement('button');
featureInfoButton.innerHTML = '<img src="resources/images/identify.svg" alt="" class="myImg"></img>';
featureInfoButton.className = 'myButton';
featureInfoButton.id = 'featureInfoButton';
featureInfoButton.title = 'Feature Info';

var featureInfoElement = document.createElement('div');
featureInfoElement.className = 'myButtonDiv';
featureInfoElement.appendChild(featureInfoButton);
toolbarDivElement.appendChild(featureInfoElement);

var featureInfoFlag = false;
featureInfoButton.addEventListener("click", () => {
    featureInfoButton.classList.toggle('clicked');
    featureInfoFlag = !featureInfoFlag;
})

const container = document.getElementById('popup');
const content = document.getElementById('popup-content');
const closer = document.getElementById('popup-closer');

const popup = new ol.Overlay({
    element: container,
    autoPan: true,
    autoPanAnimation: {
        duration: 250,
    },
});


closer.onclick = function () {
    popup.setPosition(undefined);
    container.style.display = "none";
    closer.blur();
    return false;
};

map.addOverlay(popup);

map.on('singleclick', function (evt) {
    if (featureInfoFlag) {
        content.innerHTML = '';
        var resolution = mapView.getResolution();

        var url = indiaDsTile.getSource().getFeatureInfoUrl(evt.coordinate, resolution,
            'EPSG:3857', { 'INFO_FORMAT': 'application/json', 'propertyName': 'dist_name,state_name' });

        if (url) {
            $.getJSON(url, function (data) {
                // console.log(data);
                var feature = data.features[0];
                var props = feature.properties;
                content.innerHTML = "<h3> State : </h3> <p>" + props.state_name.toUpperCase() + "</p><br><h3> District : </h3> <p>" + props.dist_name.toUpperCase() + "</p>";
                popup.setPosition(evt.coordinate);
                container.style.display = "block";
            })
        } else {
            // maybe you hide the popup here
            popup.setPosition(undefined);
            container.style.display = "none";
        }
    }
});
// start : FeatureInfo Control



// start : Length and Area Measurement Control
var lengthButton = document.createElement('button');
lengthButton.innerHTML = '<img src="resources/images/measure-length.png" alt="" class="myImg"></img>';
lengthButton.className = 'myButton';
lengthButton.id = 'lengthButton';
lengthButton.title = 'Measure Length';

var lengthElement = document.createElement('div');
lengthElement.className = 'myButtonDiv';
lengthElement.appendChild(lengthButton);
toolbarDivElement.appendChild(lengthElement);

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

var areaButton = document.createElement('button');
areaButton.innerHTML = '<img src="resources/images/measure-area.png" alt="" class="myImg"></img>';
areaButton.className = 'myButton';
areaButton.id = 'areaButton';
areaButton.title = 'Measure Area';

var areaElement = document.createElement('div');
areaElement.className = 'myButtonDiv';
areaElement.appendChild(areaButton);
toolbarDivElement.appendChild(areaElement);

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
        style: interactionStyle
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

//  map.getViewport().addEventListener('mouseout', function () {
//    helpTooltipElement.classList.add('hidden');
//  });

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

//start button print

/*var printButton = document.createElement('button');
printButton.innerHTML = '<img src="print.svg" alt="" style="width:20px;height:20px;filter:brightness(0) invert(1);vertical-align:middle"></img>';
printButton.className = 'myButton';
printButton.id = 'printButton'

var printElement = document.createElement('div');
printElement.className =' myButtonDiv';
printElement.appendChild(printButton);
toolbarDivElement.appendChild(printElement);



$("#printButton").on("click" ,function (printpage) {
    var headstr = "<html><head><title></title></head><body>";
    var footstr = "</body>";
    var newstr = document.all.item(printpage).innerHTML;
    var oldstr = document.body.innerHTML;
    document.body.innerHTML = headstr + newstr + footstr;
    window.print();
    document.body.innerHTML = oldstr;
    return false;
}
)
*/

/*<script>
function printContent(el){
var restorepage = $('body').html();
var printcontent = $('#' + el).clone();
$('body').empty().html(printcontent);
window.print();
$('body').html(restorepage);
}
</script>*/
// end print
// localisation

var printButton = document.createElement('button');
printButton.innerHTML = '<img src="print.svg" alt="" style="width:20px;height:20px;filter:brightness(0) invert(1);vertical-align:middle"></img>';
printButton.className = 'myButton';

var printElement = document.createElement('div');
printElement.className ='myButtonDivpr';
printElement.appendChild(printButton);

var printControl = new ol.control.Control({
    element: printElement
})
var printFlag = false;

    printButton.addEventListener("click", ()=> {
        var restorepage = $('body').html();
        var printcontent = $('#map').clone();
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);
        
    
})

map.addControl(printControl);




/*var locaButton = document.createElement('button');
locaButton.innerHTML = '<img src="loca.svg" alt="" style="width:20px;height:20px;filter:brightness(0) invert(1);vertical-align:middle"></img>';
locaButton.className = 'myButton';
locaButton.id = 'locaButton';

var locaElement = document.createElement('div');
locaElement.className = 'myButtonDiv';
locaElement.appendChild(locaButton);
toolbarDivElement.appendChild(locaElement);


var locaFlag = false;
$("#locaButton").on("click" ,function (evt){
    $("#locaButton").toggleClass("clicked");
    if($("#locaButton").hasClass("clicked"))
    {
    startAutolocate();
    }else{
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

  // end localisation
*/







// start : attribute query
var qryButton = document.createElement('button');
qryButton.innerHTML = '<img src="resources/images/query.svg" alt="" class="myImg"></img>';
qryButton.className = 'myButton';
qryButton.id = 'qryButton';
qryButton.title = 'Attribute Query';

var qryElement = document.createElement('div');
qryElement.className = 'myButtonDiv';
qryElement.appendChild(qryButton);
toolbarDivElementRight.appendChild(qryElement);

var qryFlag = false;
qryButton.addEventListener("click", () => {
    // disableOtherInteraction('lengthButton');
    qryButton.classList.toggle('clicked');
    qryFlag = !qryFlag;
    document.getElementById("map").style.cursor = "default";
    if (qryFlag) {
        if (queryGeoJSON) {
            queryGeoJSON.getSource().clear();
            map.removeLayer(queryGeoJSON);
        }

        if (clickSelectedFeatureOverlay) {
            clickSelectedFeatureOverlay.getSource().clear();
            map.removeLayer(clickSelectedFeatureOverlay);
        }
        document.getElementById("map").style.cursor = "default";
        document.getElementById("attQueryDiv").style.display = "block";

        bolIdentify = false;

        addMapLayerList('selectLayer');
    } else {
        document.getElementById("map").style.cursor = "default";
        document.getElementById("attQueryDiv").style.display = "none";

        document.getElementById("attListDiv").style.display = "none";

        if (queryGeoJSON) {
            queryGeoJSON.getSource().clear();
            map.removeLayer(queryGeoJSON);
        }

        if (clickSelectedFeatureOverlay) {
            clickSelectedFeatureOverlay.getSource().clear();
            map.removeLayer(clickSelectedFeatureOverlay);
        }
    }

})

var markerFeature;
function addInteractionForSpatialQuery(intType) {
    draw = new ol.interaction.Draw({
        source: clickSelectedFeatureOverlay.getSource(),
        type: intType,
        style: interactionStyle
    });
    map.addInteraction(draw);

    draw.on('drawend', function (e) {
        markerFeature = e.feature;
        markerFeature.set('geometry', markerFeature.getGeometry());
        map.removeInteraction(draw);
        document.getElementById('spUserInput').classList.toggle('clicked');
        map.addLayer(clickSelectedFeatureOverlay);
    })
}


function selectFeature(evt) {
    if (featureOverlay) {
        featureOverlay.getSource().clear();
        map.removeLayer(featureOverlay);
    }
    var selectedFeature = map.forEachFeatureAtPixel(evt.pixel,
        function (feature, layer) {
            return feature;
        });

    if (selectedFeature) {
        featureOverlay.getSource().addFeature(selectedFeature);
    }
}

function addMapLayerList(selectElementName) {
    $('#editingLayer').empty();
    $('#selectLayer').empty();
    $('#buffSelectLayer').empty();
    
    
    $(document).ready(function () {
        $.ajax({
            type: "GET",
            url: "http://" + serverPort + "/geoserver/wfs?request=getCapabilities",
            dataType: "xml",
            success: function (xml) {
                var select = $('#' + selectElementName);
                select.append("<option class='ddindent' value=''></option>");
                $(xml).find('FeatureType').each(function () {
                    $(this).find('Name').each(function () {
                        var value = $(this).text();
                        if (layerList.includes(value)) {
                            select.append("<option class='ddindent' value='" + value + "'>" + value + "</option>");
                        }
                    });
                });
            }
        });
    });

};

//location
var locaButton = document.createElement('button');
locaButton.innerHTML = '<img src="loca.svg" alt="" style="width:20px;height:20px;filter:brightness(0) invert(1);vertical-align:middle"></img>';
locaButton.className = 'myButton';
locaButton.id = 'locaButton';

var locaElement = document.createElement('div');
locaElement.className = 'myButtonDivps';
locaElement.appendChild(locaButton);

var locaControl = new ol.control.Control({
    element: locaElement
})
map.addControl(locaControl); 

var locaFlag = false;
$("#locaButton").on("click" ,function (evt){
    $("#locaButton").toggleClass("clicked");
    if($("#locaButton").hasClass("clicked"))
    {
    startAutolocate();
    }else{
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
//end location
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

function newaddGeoJsonToMap(url) {

    if (queryGeoJSON) {
        queryGeoJSON.getSource().clear();
        map.removeLayer(queryGeoJSON);
    }

    queryGeoJSON = new ol.layer.Vector({
        source: new ol.source.Vector({
            url: url,
            format: new ol.format.GeoJSON()
        }),
        style: querySelectedFeatureStyle,

    });

    queryGeoJSON.getSource().on('addfeature', function () {
        map.getView().fit(
            queryGeoJSON.getSource().getExtent(),
            { duration: 1590, size: map.getSize(), maxZoom: 21 }
        );
    });
    map.addLayer(queryGeoJSON);
};

function newaddRowHandlers() {
    var attTable = document.getElementById("attQryTable");
    // var rows = document.getElementById("attQryTable").rows;
    var rows = attTable.rows;
    var heads = attTable.getElementsByTagName('th');
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
                clickSelectedFeatureOverlay.getSource().clear();

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

                var features = queryGeoJSON.getSource().getFeatures();

                for (i = 0; i < features.length; i++) {
                    if (features[i].getId() == id) {
                        clickSelectedFeatureOverlay.getSource().addFeature(features[i]);

                        clickSelectedFeatureOverlay.getSource().on('addfeature', function () {
                            map.getView().fit(
                                clickSelectedFeatureOverlay.getSource().getExtent(),
                                { duration: 1500, size: map.getSize(), maxZoom: 24 }
                            );
                        });

                    }
                }
            };
        }(rows[i]);
    }
}
// end : attribute query


// start : spatial query
var bufferButton = document.createElement('button');
bufferButton.innerHTML = '<img src="resources/images/mapSearch.png" alt="" class="myImg"></img>';
bufferButton.className = 'myButton';
bufferButton.id = 'bufferButton';
bufferButton.title = 'Spatial Query';

var bufferElement = document.createElement('div');
bufferElement.className = 'myButtonDiv';
bufferElement.appendChild(bufferButton);
toolbarDivElementRight.appendChild(bufferElement);

var bufferFlag = false;
bufferButton.addEventListener("click", () => {
    // disableOtherInteraction('lengthButton');
    bufferButton.classList.toggle('clicked');
    bufferFlag = !bufferFlag;
    document.getElementById("map").style.cursor = "default";
    if (bufferFlag) {
        if (geojson) {
            geojson.getSource().clear();
            map.removeLayer(geojson);
        }

        if (featureOverlay) {
            featureOverlay.getSource().clear();
            map.removeLayer(featureOverlay);
        }
        document.getElementById("map").style.cursor = "default";
        document.getElementById("spQueryDiv").style.display = "block";

        addMapLayerList_spQry();
    } else {
        document.getElementById("map").style.cursor = "default";
        document.getElementById("spQueryDiv").style.display = "none";
        document.getElementById("attListDiv").style.display = "none";

        if (geojson) {
            geojson.getSource().clear();
            map.removeLayer(geojson);
        }

        if (featureOverlay) {
            featureOverlay.getSource().clear();
            map.removeLayer(featureOverlay);
        }
        map.removeInteraction(draw);
        if (document.getElementById('spUserInput').classList.contains('clicked')) { document.getElementById('spUserInput').classList.toggle('clicked'); }
    }

})

function addMapLayerList_spQry() {
    $(document).ready(function () {
        $.ajax({
            type: "GET",
            url: "http://" + serverPort + "/geoserver/wfs?request=getCapabilities",
            dataType: "xml",
            success: function (xml) {
                var select = $('#buffSelectLayer');
                select.append("<option class='ddindent' value=''></option>");
                $(xml).find('FeatureType').each(function () {
                    $(this).find('Name').each(function () {
                        var value = $(this).text();
                        if (layerList.includes(value)) {
                            select.append("<option class='ddindent' value='" + value + "'>" + value + "</option>");
                        }
                    });
                });
            }
        });
    });

};
// end : spatial query


// end location



// start : start editing Control
var editgeojson;
var editLayer;
var modifiedFeatureList = [];
var editTask;
var editTaskName;
var modifiedFeature = false;
var modifyInteraction;
var featureAdd;
var snap_edit;
var selectedFeatureOverlay = new ol.layer.Vector({
    title: 'Selected Feature',
    source: new ol.source.Vector(),
    map: map,
    style: highlightStyle
});

var startEditingButton = document.createElement('button');
startEditingButton.innerHTML = '<img src="resources/images/edit.png" alt="" class="myImg"></img>';
startEditingButton.className = 'myButton';
startEditingButton.id = 'startEditingButton';
startEditingButton.title = 'Start Editing';

var startEditingElement = document.createElement('div');
startEditingElement.className = 'myButtonDiv';
startEditingElement.appendChild(startEditingButton);
toolbarDivElementRight.appendChild(startEditingElement);

var startEditingFlag = false;
startEditingButton.addEventListener("click", () => {
    startEditingButton.classList.toggle('clicked');
    startEditingFlag = !startEditingFlag;
    document.getElementById("map").style.cursor = "default";
    if (startEditingFlag) {
        document.getElementById("editingControlsDiv").style.display = "block";
        editLayer = document.getElementById('editingLayer').value;
        var style = new ol.style.Style({
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
                    color: '#00FFFF'
                })
            })
        });

        if (editgeojson) {
            editgeojson.getSource().clear();
            map.removeLayer(editgeojson);
        }

        editgeojson = new ol.layer.Vector({
            title: "Edit Layer",
            source: new ol.source.Vector({
                format: new ol.format.GeoJSON(),
                url: function (extent) {
                    return 'http://' + serverPort + '/geoserver/' + geoserverWorkspace + '/ows?service=WFS&' +
                        'version=1.0.0&request=GetFeature&typeName=' + editLayer + '&' +
                        'outputFormat=application/json&srsname=EPSG:3857&' +
                        'bbox=' + extent.join(',') + ',EPSG:3857';
                },
                strategy: ol.loadingstrategy.bbox
            }),
            style: style,
        });
        map.addLayer(editgeojson);

    } else {
        document.getElementById("editingControlsDiv").style.display = "none";
        editgeojson.getSource().clear();
        map.removeLayer(editgeojson);
    }
})
// end : start editing Control

// start : add feature control

var editingControlsDivElement = document.getElementById('editingControlsDiv');

var addFeatureButton = document.createElement('button');
addFeatureButton.innerHTML = '<img src="resources/images/editAdd.png" alt="" class="myImg"></img>';
addFeatureButton.className = 'myButton';
addFeatureButton.id = 'addFeatureButton';
addFeatureButton.title = 'Add Feature';

var addFeatureElement = document.createElement('div');
addFeatureElement.className = 'myButtonDiv';
addFeatureElement.id = 'addFeatureButtonDiv';
addFeatureElement.appendChild(addFeatureButton);
editingControlsDivElement.appendChild(addFeatureElement);

var addFeatureFlag = false;
addFeatureButton.addEventListener("click", () => {
    addFeatureButton.classList.toggle('clicked');
    addFeatureFlag = !addFeatureFlag;
    document.getElementById("map").style.cursor = "default";
    if (addFeatureFlag) {
        if (modifiedFeatureList) {
            if (modifiedFeatureList.length > 0) {
                var answer = confirm('Save edits?');
                if (answer) {
                    saveEdits(editTask);
                    modifiedFeatureList = [];
                } else {
                    // cancelEdits();
                    modifiedFeatureList = [];
                }

            }
        }
        editTask = 'insert';
        addFeature();
    } else {
        if (modifiedFeatureList.length > 0) {
            var answer = confirm('You have unsaved edits. Do you want to save edits?');
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
        map.removeInteraction(snap_edit);
        editTask = '';


        if (modifyInteraction) {
            map.removeInteraction(modifyInteraction);
        }
        if (snap_edit) {
            map.removeInteraction(snap_edit);
        }
        if (drawInteraction) {
            map.removeInteraction(drawInteraction);
        }
    }
})

function addFeature(evt) {
    if (clickSelectedFeatureOverlay) {
        clickSelectedFeatureOverlay.getSource().clear();
        map.removeLayer(clickSelectedFeatureOverlay);
    }

    if (modifyInteraction) {
        map.removeInteraction(modifyInteraction);
    }
    if (snap_edit) {
        map.removeInteraction(snap_edit);
    }

    var interactionType;
    source_mod = editgeojson.getSource();
    drawInteraction = new ol.interaction.Draw({
        source: editgeojson.getSource(),
        type: editgeojson.getSource().getFeatures()[0].getGeometry().getType(),
        style: interactionStyle
    });
    map.addInteraction(drawInteraction);
    snap_edit = new ol.interaction.Snap({
        source: editgeojson.getSource()
    });
    map.addInteraction(snap_edit);

    drawInteraction.on('drawend', function (e) {
        var feature = e.feature;
        feature.set('geometry', feature.getGeometry());
        modifiedFeatureList.push(feature);
    })

}

// end : add feature control

// start : Modify Feature Control
var modifyFeatureButton = document.createElement('button');
modifyFeatureButton.innerHTML = '<img src="resources/images/editModify.svg" alt="" class="myImg"></img>';
modifyFeatureButton.className = 'myButton';
modifyFeatureButton.id = 'modifyFeatureButton';
modifyFeatureButton.title = 'Modify Feature';

var modifyFeatureElement = document.createElement('div');
modifyFeatureElement.className = 'myButtonDiv';
modifyFeatureElement.id = 'modifyFeatureButtonDiv';
modifyFeatureElement.appendChild(modifyFeatureButton);
editingControlsDivElement.appendChild(modifyFeatureElement);

var modifyFeatureFlag = false;
modifyFeatureButton.addEventListener("click", () => {
    modifyFeatureButton.classList.toggle('clicked');
    modifyFeatureFlag = !modifyFeatureFlag;
    document.getElementById("map").style.cursor = "default";
    if (modifyFeatureFlag) {
        modifiedFeatureList = [];
        selectedFeatureOverlay.getSource().clear();
        map.removeLayer(selectedFeatureOverlay);
        map.on('click', modifyFeature);
        editTask = 'update';
    } else {
        if (modifiedFeatureList.length > 0) {
            var answer = confirm('Save edits?');
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
        map.removeInteraction(snap_edit);
        editTask = '';
    }
})

function modifyFeature(evt) {
    selectedFeatureOverlay.getSource().clear();
    map.removeLayer(selectedFeatureOverlay);
    var selectedFeature = map.forEachFeatureAtPixel(evt.pixel,
        function (feature, layer) {
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

    var sourceEditGeoJson = editgeojson.getSource();
    snap_edit = new ol.interaction.Snap({
        source: sourceEditGeoJson
    });
    map.addInteraction(snap_edit);
    modifyInteraction.on('modifyend', function (e) {
        modifiedFeature = true;
        featureAdd = true;
        if (modifiedFeatureList.length > 0) {

            for (var j = 0; j < modifiedFeatureList.length; j++) {
                if (e.features.item(0)['id_'] == modifiedFeatureList[j]['id_']) {
                    // modifiedFeatureList.splice(j, 1);
                    featureAdd = false;
                }
            }
        }
        if (featureAdd) { modifiedFeatureList.push(e.features.item(0)); }
    })
    // }
    // }
}

var clones = [];

function saveEdits(editTaskName) {
    clones = [];
    for (var i = 0; i < modifiedFeatureList.length; i++) {
        var feature = modifiedFeatureList[i];
        var featureProperties = feature.getProperties();

        delete featureProperties.boundedBy;
        var clone = feature.clone();
        clone.setId(feature.getId());

        // if (editTaskName != 'insert') {clone.setGeometryName('the_geom');}
        clones.push(clone)
        // if (editTaskName == 'insert') { transactWFS('insert', clone); }
    }

    if (editTaskName == 'update') { transactWFS('update_batch', clones); }
    if (editTaskName == 'insert') { transactWFS('insert_batch', clones); }

}


var formatWFS = new ol.format.WFS();


var transactWFS = function (mode, f) {

    var node;
    var formatGML = new ol.format.GML({
        // featureNS: 'http://argeomatica.com',
        featureNS: geoserverWorkspace,
        // featureType: 'playa_sample',
        featureType: editLayer,
        service: 'WFS',
        version: '1.1.0',
        request: 'GetFeature',
        srsName: 'EPSG:3857'
    });
    switch (mode) {
        case 'insert':
            node = formatWFS.writeTransaction([f], null, null, formatGML);
            break;
        case 'insert_batch':
            node = formatWFS.writeTransaction(f, null, null, formatGML);
            break;
        case 'update':
            node = formatWFS.writeTransaction(null, [f], null, formatGML);
            break;
        case 'update_batch':
            node = formatWFS.writeTransaction(null, f, null, formatGML);
            break;
        case 'delete':
            node = formatWFS.writeTransaction(null, null, [f], formatGML);
            break;
        case 'delete_batch':
            node = formatWFS.writeTransaction(null, null, [f], formatGML);
            break;
    }
    var xs = new XMLSerializer();
    var payload = xs.serializeToString(node);

    payload = payload.split('feature:' + editLayer).join(editLayer);
    if (editTask == 'insert') { payload = payload.split(geoserverWorkspace + ':geometry').join(geoserverWorkspace + ':geom'); }
    if (editTask == 'update') { payload = payload.split('<Name>geometry</Name>').join('<Name>geom</Name>'); }
    // payload = payload.replace(/feature:editLayer/g, editLayer);

    $.ajax('http://localhost/geoserver/wfs', {
        type: 'POST',
        dataType: 'xml',
        processData: false,
        contentType: 'text/xml',
        data: payload.trim(),
        success: function (data) {
            // console.log('building updated');
        },
        error: function (e) {
            var errorMsg = e ? (e.status + ' ' + e.statusText) : "";
            alert('Error saving this feature to GeoServer.<br><br>'
                + errorMsg);
        }
    }).done(function () {

        editgeojson.getSource().refresh();

    });
};
// end : Modify Feature Control

// start : Delete feature control
var deleteFeatureButton = document.createElement('button');
deleteFeatureButton.innerHTML = '<img src="resources/images/editErase.svg" alt="" class="myImg"></img>';
deleteFeatureButton.className = 'myButton';
deleteFeatureButton.id = 'deleteFeatureButton';
deleteFeatureButton.title = 'Delete Feature';

var deleteFeatureElement = document.createElement('div');
deleteFeatureElement.className = 'myButtonDiv';
deleteFeatureElement.id = 'deleteFeatureButtonDiv';
deleteFeatureElement.appendChild(deleteFeatureButton);
editingControlsDivElement.appendChild(deleteFeatureElement);

var deleteFeatureFlag = false;
deleteFeatureButton.addEventListener("click", () => {
    deleteFeatureButton.classList.toggle('clicked');
    deleteFeatureFlag = !deleteFeatureFlag;
    document.getElementById("map").style.cursor = "default";
    if (deleteFeatureFlag) {
        modifiedFeatureList = [];
        selectedFeatureOverlay.getSource().clear();
        map.removeLayer(selectedFeatureOverlay);
        editTask = 'delete';
        map.on('click', selectFeatureToDelete);

    } else {
        if (modifiedFeatureList.length > 0) {
            var answer = confirm('You have unsaved edits. Do you want to save edits?');
            if (answer) {
                saveEdits(editTask);
                modifiedFeatureList = [];
            } else {
                // cancelEdits();
                modifiedFeatureList = [];
            }
        }
        map.un('click', selectFeatureToDelete);
        selectedFeatureOverlay.getSource().clear();
        map.removeLayer(selectedFeatureOverlay);
        modifiedFeature = false;
        // map.removeInteraction(modifyInteraction);
        // map.removeInteraction(snap_edit);
        editTask = '';
    }
})

function selectFeatureToDelete(evt) {
    clickSelectedFeatureOverlay.getSource().clear();
    map.removeLayer(clickSelectedFeatureOverlay);
    var selectedFeature = map.forEachFeatureAtPixel(evt.pixel,
        function (feature, layer) {
            return feature;
        });

    if (selectedFeature) {
        // clickSelectedFeatureOverlay.getSource().addFeature(selectedFeature);
        clones = [];
        var answer = confirm('Do you want to delete selected feature?');
        if (answer) {
            var feature = selectedFeature;
            var featureProperties = feature.getProperties();

            delete featureProperties.boundedBy;
            var clone = feature.clone();
            clone.setId(feature.getId());

            // clone.setGeometryName('the_geom');
            clones.push(clone)
            if (editTask == 'update') { transactWFS('update_batch', clones); }
            if (editTask == 'insert') { transactWFS('insert_batch', clones); }
            if (editTask == 'delete') { transactWFS('delete', clone); }
        }

    }
}
// end : Delete feature control

// finally add all editing control to map
var editingControl = new ol.control.Control({
    element: editingControlsDivElement
})
map.addControl(editingControl);







// start : settings Control
var settingsButton = document.createElement('button');
settingsButton.innerHTML = '<img src="resources/images/settings.svg" alt="" class="myImg"></img>';
settingsButton.className = 'myButton';
settingsButton.id = 'settingButton';
settingsButton.title = 'Settings';

var settingElement = document.createElement('div');
settingElement.className = 'myButtonDiv';
settingElement.appendChild(settingsButton);
toolbarDivElementRight.appendChild(settingElement);

var settingFlag = false;
settingsButton.addEventListener("click", () => {
    settingsButton.classList.toggle('clicked');
    settingFlag = !settingFlag;
    document.getElementById("map").style.cursor = "default";
    if (settingFlag) {
        document.getElementById("settingsDiv").style.display = "block";
        addMapLayerList('editingLayer');
    } else {
        document.getElementById("settingsDiv").style.display = "none";
    }
})
// end : settings Control

// finally add all main control to map
var allControl = new ol.control.Control({
    element: toolbarDivElement
})
map.addControl(allControl);

var allControlRight = new ol.control.Control({
    element: toolbarDivElementRight
})
map.addControl(allControlRight);

var allControlSwitcher = new ol.control.Control({
    element: toolbarDivElementSwitcher
})
map.addControl(allControlSwitcher);



// start : onload functions
$(function () {

    // render layerswitcher control
    var toc = document.getElementById('layerSwitcherContent');
    layerSwitcherControl = new ol.control.LayerSwitcher.renderPanel(map, toc, { reverse: true });

    document.getElementById("selectLayer").onchange = function () {
        var select = document.getElementById("selectAttribute");
        while (select.options.length > 0) {
            select.remove(0);
        }
        var value_layer = $(this).val();
        $(document).ready(function () {
            $.ajax({
                type: "GET",
                url: "http://" + serverPort + "/geoserver/wfs?service=WFS&request=DescribeFeatureType&version=1.1.0&typeName=" + value_layer,
                dataType: "xml",
                success: function (xml) {

                    var select = $('#selectAttribute');
                    //var title = $(xml).find('xsd\\:complexType').attr('name');
                    //	alert(title);
                    select.append("<option class='ddindent' value=''></option>");
                    $(xml).find('xsd\\:sequence').each(function () {

                        $(this).find('xsd\\:element').each(function () {
                            var value = $(this).attr('name');
                            //alert(value);
                            var type = $(this).attr('type');
                            //alert(type);
                            if (value != 'geom' && value != 'the_geom') {
                                select.append("<option class='ddindent' value='" + type + "'>" + value + "</option>");
                            }
                        });

                    });
                }
            });
        });
    }
    document.getElementById("selectAttribute").onchange = function () {
        var operator = document.getElementById("selectOperator");
        while (operator.options.length > 0) {
            operator.remove(0);
        }

        var value_type = $(this).val();
        // alert(value_type);
        var value_attribute = $('#selectAttribute option:selected').text();
        operator.options[0] = new Option('Select operator', "");

        if (value_type == 'xsd:short' || value_type == 'xsd:int' || value_type == 'xsd:double') {
            var operator1 = document.getElementById("selectOperator");
            operator1.options[1] = new Option('Greater than', '>');
            operator1.options[2] = new Option('Less than', '<');
            operator1.options[3] = new Option('Equal to', '=');
        }
        else if (value_type == 'xsd:string') {
            var operator1 = document.getElementById("selectOperator");
            operator1.options[1] = new Option('Like', 'Like');
            operator1.options[2] = new Option('Equal to', '=');
        }
    }

    document.getElementById('attQryRun').onclick = function () {
        map.set("isLoading", 'YES');

        if (featureOverlay) {
            featureOverlay.getSource().clear();
            map.removeLayer(featureOverlay);
        }

        var layer = document.getElementById("selectLayer");
        var attribute = document.getElementById("selectAttribute");
        var operator = document.getElementById("selectOperator");
        var txt = document.getElementById("enterValue");

        if (layer.options.selectedIndex == 0) {
            alert("Select Layer");
        } else if (attribute.options.selectedIndex == -1) {
            alert("Select Attribute");
        } else if (operator.options.selectedIndex <= 0) {
            alert("Select Operator");
        } else if (txt.value.length <= 0) {
            alert("Enter Value");
        } else {
            var value_layer = layer.options[layer.selectedIndex].value;
            var value_attribute = attribute.options[attribute.selectedIndex].text;
            var value_operator = operator.options[operator.selectedIndex].value;
            var value_txt = txt.value;
            if (value_operator == 'Like') {
                value_txt = "%25" + value_txt + "%25";
            }
            else {
                value_txt = value_txt;
            }
            var url = "http://" + serverPort + "/geoserver/" + geoserverWorkspace + "/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=" + value_layer + "&CQL_FILTER=" + value_attribute + "+" + value_operator + "+'" + value_txt + "'&outputFormat=application/json"
            newaddGeoJsonToMap(url);
            newpopulateQueryTable(url);
            setTimeout(function () { newaddRowHandlers(url); }, 1000);
            map.addLayer(clickSelectedFeatureOverlay);
            map.set("isLoading", 'NO');
        }
    }

    document.getElementById("srcCriteria").onchange = function () {
        if (queryGeoJSON) {
            queryGeoJSON.getSource().clear();
            map.removeLayer(queryGeoJSON);
        }

        if (clickSelectedFeatureOverlay) {
            clickSelectedFeatureOverlay.getSource().clear();
            map.removeLayer(clickSelectedFeatureOverlay);
        }
        if (document.getElementById('spUserInput').classList.contains('clicked')) { document.getElementById('spUserInput').classList.toggle('clicked'); }
    }

    document.getElementById('spUserInput').onclick = function () {
        document.getElementById('spUserInput').classList.toggle('clicked');
        if (document.getElementById('spUserInput').classList.contains('clicked')) {
            if (queryGeoJSON) {
                queryGeoJSON.getSource().clear();
                map.removeLayer(queryGeoJSON);
            }

            if (clickSelectedFeatureOverlay) {
                clickSelectedFeatureOverlay.getSource().clear();
                map.removeLayer(clickSelectedFeatureOverlay);
            }
            var srcCriteriaValue = document.getElementById('srcCriteria').value;
            if (srcCriteriaValue == 'pointMarker') {
                addInteractionForSpatialQuery('Point');

            }
            if (srcCriteriaValue == 'lineMarker') {
                addInteractionForSpatialQuery('LineString');
            }
            if (srcCriteriaValue == 'polygonMarker') {
                addInteractionForSpatialQuery('Polygon');
            }
        } else {
            coordList = '';
            markerFeature = undefined;
            map.removeInteraction(draw);
        }
    }

    document.getElementById('spQryRun').onclick = function () {

        var layer = document.getElementById("buffSelectLayer");
        var value_layer = layer.options[layer.selectedIndex].value;

        var srcCriteria = document.getElementById("srcCriteria");
        var value_src = srcCriteria.options[srcCriteria.selectedIndex].value;
        var coordList = '';
        var url;
        var markerType = '';
        if (markerFeature) {
            if (value_src == 'pointMarker') {
                coordList = markerFeature.getGeometry().getCoordinates()[0] + " " + markerFeature.getGeometry().getCoordinates()[1];
                markerType = 'Point';
            }
            if (value_src == 'lineMarker') {
                var coordArray = markerFeature.getGeometry().getCoordinates();

                for (i = 0; i < coordArray.length; i++) {
                    if (i == 0) {
                        coordList = coordArray[i][0] + " " + coordArray[i][1];
                    } else {
                        coordList = coordList + ", " + coordArray[i][0] + " " + coordArray[i][1];
                    }
                }
                markerType = 'LineString';
            }
            if (value_src == 'polygonMarker') {
                var coordArray = markerFeature.getGeometry().getCoordinates()[0];
                for (i = 0; i < coordArray.length; i++) {
                    if (i == 0) {
                        coordList = coordArray[i][0] + " " + coordArray[i][1];
                    } else {
                        coordList = coordList + ", " + coordArray[i][0] + " " + coordArray[i][1];
                    }
                }
                coordList = "(" + coordList + ")";
                markerType = 'Polygon';
            }

            var value_attribute = $('#qryType option:selected').text();
            if (value_attribute == 'Within Distance of') {

                var dist = document.getElementById("bufferDistance");
                var value_dist = Number(dist.value);
                // value_dist = value_dist / 111.325;

                var distanceUnit = document.getElementById("distanceUnits");
                var value_distanceUnit = distanceUnit.options[distanceUnit.selectedIndex].value;
                url = "http://" + serverPort + "/geoserver/" + geoserverWorkspace + "/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=" + value_layer + "&CQL_FILTER=DWITHIN(geom," + markerType + "(" + coordList + ")," + value_dist + "," + value_distanceUnit + ")&outputFormat=application/json";


            } else if (value_attribute == 'Intersecting') {
                url = "http://" + serverPort + "/geoserver/" + geoserverWorkspace + "/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=" + value_layer + "&CQL_FILTER=INTERSECTS(geom," + markerType + "(" + coordList + "))&outputFormat=application/json";
            } else if (value_attribute == 'Completely Within') {
                url = "http://" + serverPort + "/geoserver/" + geoserverWorkspace + "/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=" + value_layer + "&CQL_FILTER=WITHIN(geom," + markerType + "(" + coordList + "))&outputFormat=application/json";
            }
            newaddGeoJsonToMap(url);
            coordList = '';
            markerFeature = undefined;
        }
    }

    var mapInteractions = map.getInteractions();
    for (var x = 0; x < mapInteractions.getLength(); x++) {
        var mapInteraction = mapInteractions.item(x);
        if (mapInteraction instanceof ol.interaction.DoubleClickZoom) {
            map.removeInteraction(mapInteraction);
            break;
        }
    }

    for (var x = 0; x < mapInteractions.getLength(); x++) {
        var mapInteraction = mapInteractions.item(x);
        if (mapInteraction instanceof ol.interaction.DragPan) {
            map.removeInteraction(mapInteraction);
            break;
        }
    }

    document.getElementById("qryType").onchange = function () {
        var value_attribute = $('#qryType option:selected').text();
        var buffDivElement = document.getElementById("bufferDiv");

        if (value_attribute == 'Within Distance of') {
            buffDivElement.style.display = "block";
        } else {
            buffDivElement.style.display = "none";
        }
    }

    document.getElementById('spQryClear').onclick = function () {
        if (queryGeoJSON) {
            queryGeoJSON.getSource().clear();
            map.removeLayer(queryGeoJSON);
        }

        if (clickSelectedFeatureOverlay) {
            clickSelectedFeatureOverlay.getSource().clear();
            map.removeLayer(clickSelectedFeatureOverlay);
        }
        coordList = '';
        markerFeature = undefined;
    }

    document.getElementById('attQryClear').onclick = function () {
        if (queryGeoJSON) {
            queryGeoJSON.getSource().clear();
            map.removeLayer(queryGeoJSON);
        }

        if (clickSelectedFeatureOverlay) {
            clickSelectedFeatureOverlay.getSource().clear();
            map.removeLayer(clickSelectedFeatureOverlay);
        }
        coordList = '';
        markerFeature = undefined;
        document.getElementById("attListDiv").style.display = "none";
    }

    // live search input box behaviour
    $("#inpt_search").on('focus', function () {
        $(this).parent('label').addClass('active');
    });

    $("#inpt_search").on('blur', function () {
        if ($(this).val().length == 0)
            $(this).parent('label').removeClass('active');
    });

    // live location
    $("#btnCrosshair").on("click", function (event) {
        $("#btnCrosshair").toggleClass("clicked");
        if ($("#btnCrosshair").hasClass("clicked")) {
            startAutolocate();
        } else {
            stopAutolocate();
        }
    });
});
// end : onload functions



