$(function(){
    var refreshRate = 1000; //Refresh every x ms
    var positionAtStartup = [43.6025941, 1.4366249]; //Default position when launching map
    var defaultZoom = 12;
    var lineColor = "#1d51a2"; //Line color
    var lineOpacity = 0.7; //Line opacity
    var lineWeight = 4; //Line weight
    var baseUrl = document.URL; //Url of the current page
    var lastKnownPosition = [0, 0];
    var markers = [null];
    var username = $('#username').val();
    var tripId = $('#tripid').val();

    initialize();

    google.maps.event.addListenerOnce(map, 'idle', function(){ //Wait until map is ready
        populateData(username, tripId);
    });

    //first function to be called : init map fields
    function initialize() {
        var styles = [ { "elementType": "labels.text.fill", "stylers": [ { "color": "#523735" } ] }, { "elementType": "labels.text.stroke", "stylers": [ { "color": "#f5f1e6" } ] }, { "featureType": "administrative", "elementType": "geometry.stroke", "stylers": [ { "color": "#c9b2a6" } ] }, { "featureType": "administrative.land_parcel", "elementType": "geometry.stroke", "stylers": [ { "color": "#dcd2be" } ] }, { "featureType": "administrative.land_parcel", "elementType": "labels.text.fill", "stylers": [ { "color": "#ae9e90" } ] }, { "featureType": "landscape.man_made", "stylers": [ { "color": "#ebe3cd" } ] }, { "featureType": "landscape.natural.terrain", "stylers": [ { "visibility": "on" } ] }, { "featureType": "poi", "elementType": "geometry", "stylers": [ { "color": "#dfd2ae" } ] }, { "featureType": "poi", "elementType": "labels.text.fill", "stylers": [ { "color": "#93817c" } ] }, { "featureType": "poi.park", "elementType": "geometry.fill", "stylers": [ { "color": "#bbca9f" } ] }, { "featureType": "poi.park", "elementType": "labels.text.fill", "stylers": [ { "color": "#447530" } ] }, { "featureType": "road", "elementType": "geometry", "stylers": [ { "color": "#f5f1e6" }, { "visibility": "simplified" }, { "weight": 1 } ] }, { "featureType": "road.arterial", "stylers": [ { "visibility": "simplified" } ] }, { "featureType": "road.arterial", "elementType": "geometry", "stylers": [ { "color": "#fdfcf8" } ] }, { "featureType": "road.highway", "elementType": "geometry", "stylers": [ { "color": "#f8c967" } ] }, { "featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [ { "color": "#e9bc62" } ] }, { "featureType": "road.highway.controlled_access", "elementType": "geometry", "stylers": [ { "color": "#e98d58" } ] }, { "featureType": "road.highway.controlled_access", "elementType": "geometry.stroke", "stylers": [ { "color": "#db8555" } ] }, { "featureType": "road.local", "elementType": "labels.text.fill", "stylers": [ { "color": "#806b63" } ] }, { "featureType": "transit.line", "elementType": "geometry", "stylers": [ { "color": "#dfd2ae" } ] }, { "featureType": "transit.line", "elementType": "labels.text.fill", "stylers": [ { "color": "#8f7d77" } ] }, { "featureType": "transit.line", "elementType": "labels.text.stroke", "stylers": [ { "color": "#ebe3cd" } ] }, { "featureType": "transit.station", "elementType": "geometry", "stylers": [ { "color": "#dfd2ae" } ] }, { "featureType": "water", "elementType": "geometry.fill", "stylers": [ { "color": "#aecfe1" } ] }, { "featureType": "water", "elementType": "labels.text.fill", "stylers": [ { "color": "#92998d" } ] } ];
        var styledMap = new google.maps.StyledMapType(styles, {name: "Styled Map"});

        map = new google.maps.Map($('#map')[0], {
            zoom: defaultZoom,
            center: {lat: positionAtStartup[0], lng: positionAtStartup[1]},
            mapTypeId: [google.maps.MapTypeId.ROADMAP, 'map_style']
        });

        map.mapTypes.set('map_style', styledMap);
        map.setMapTypeId('map_style');
    }

    //second function to be called: populate the data
    function populateData(username, idTrip){
        var uri = baseUrl + "/destinations";
        var loc;
        var bounds = new google.maps.LatLngBounds();

        $.ajax({
            type: "GET",
            url: uri,
            data: null,
            dataType: 'json',
            success: function(data){
                if(data != null){ //there are destinations !
                    var destinationsNumber = data.length;
                    data.forEach(function(item, index){

                        loc = new google.maps.LatLng(item["lat"], item["lng"]);
                        bounds.extend(loc);

                        var travelIconImg = item.transportationType.fa_icon;

                        if(index != 0){ //not the first destination
                            var travelIconImgLat = (item["lat"] + lastKnownPosition[0]) / 2;
                            var travelIconImgLng = (item["lng"] + lastKnownPosition[1]) / 2;

                            var marker = new google.maps.Marker({
                                position: {lat: travelIconImgLat, lng: travelIconImgLng},
                                icon: {
                                        path: fontawesome.markers[travelIconImg.replace('-', '_').toUpperCase()],
                                        scale: 0.3,
                                        strokeWeight: 0.4,
                                        strokeColor: 'white',
                                        strokeOpacity: 1,
                                        fillColor: '#222222',
                                        fillOpacity: 1
                                    },
                                map: map
                            });
                        }

                        var destIcon = item.transportationType.icon_destination;
                        if(index == 0)
                            destIcon = item.transportationType.icon_first;
                        if(index == (destinationsNumber - 1) && index != 0)
                            destIcon = item.transportationType.icon_last;

                        var marker = new MarkerWithLabel({
                            position: {lat: item["lat"], lng: item["lng"]},
                            map: map,
                            draggable: false,
                            raiseOnDrag: true,
                            labelContent: (index+1).toString(),
                            labelAnchor: new google.maps.Point(14, 22),
                            labelClass: "gmap-labels", // the CSS class for the label
                            labelInBackground: false,
                            icon: { url: destIcon, scaledSize: new google.maps.Size(32, 32)}
                        });

                        var infowindow = new google.maps.InfoWindow({
                            content: item["infoWindow"]
                        });

                        marker.addListener('click', function() {
                            infowindow.open(map, marker);
                        });

                        //Create a line (if there is a previous not [0, 0] known position)
                        if (lastKnownPosition[0] != 0 && lastKnownPosition[1] != 0){
                            var lineToDraw =
                            [
                                {lat: lastKnownPosition[0], lng: lastKnownPosition[1]},
                                {lat: item["lat"], lng: item["lng"]}
                            ];

                            var newLine = new google.maps.Polyline({
                                path: lineToDraw,
                                strokeColor: lineColor,
                                strokeOpacity: lineOpacity,
                                strokeWeight: lineWeight
                            });
                            newLine.setMap(map);
                        }

                        //map.panTo({lat: data[0], lng: data[1]}); //Center the map on the new point

                        lastKnownPosition[0] = item["lat"]; //Update last known position with current position
                        lastKnownPosition[1] = item["lng"];
                    });
                    
                    map.fitBounds(bounds);
                    map.panToBounds(bounds);
                }
            },
            error: function(result, statut, error){
                console.log("Error when retrieving the trip destinations")
            }
        })
    }
});