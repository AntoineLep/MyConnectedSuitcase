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
        map = new google.maps.Map($('#map')[0], {
            zoom: defaultZoom,
            center: {lat: positionAtStartup[0], lng: positionAtStartup[1]},
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
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

                        var travelIconImg = item.transportationType.folder + item.transportationType.ds + item.transportationType.prefix;

                        if(lastKnownPosition[0] != 0 && lastKnownPosition[1] != 0){
                            var deltaLat = lastKnownPosition[0] - item["lat"];
                            var deltaLng = lastKnownPosition[1] - item["lng"];
                            
                            if(Math.abs(deltaLat) > Math.abs(deltaLng)) //Lat movement stronger than lng
                                if(deltaLat > 0)
                                    travelIconImg += "_bottom." + item.transportationType.extension;
                                else
                                    travelIconImg += "_top." + item.transportationType.extension;
                            else //Lng movement stronger than lat
                                if(deltaLng > 0)
                                    travelIconImg += "_left." + item.transportationType.extension;
                                else
                                    travelIconImg += "_right." + item.transportationType.extension;
                        }
                        else {
                            travelIconImg += "_top." + item.transportationType.extension;
                        }

                        if(index != 0){ //not the first destination
                            var travelIconImgLat = (item["lat"] + lastKnownPosition[0]) / 2;
                            var travelIconImgLng = (item["lng"] + lastKnownPosition[1]) / 2;

                            var marker = new google.maps.Marker({
                                position: {lat: travelIconImgLat, lng: travelIconImgLng},
                                icon: travelIconImg,
                                map: map
                            });
                        }

                        var destIcon = "step.png";
                        if(index == 0){ // first destination
                            destIcon = "start.png";
                        }
                        if(index != 0 && index == destinationsNumber - 1) //last destination
                            destIcon = "finish.png"

                        destIcon = item.transportationType.iconx32Folder + item.transportationType.ds + destIcon;
                        //Create the new marker
                        var marker = new google.maps.Marker({
                            position: {lat: item["lat"], lng: item["lng"]},
                            icon: destIcon,
                            map: map
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