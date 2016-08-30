$(function(){
    var refreshRate = 1000; //Refresh every x ms
    var positionAtStartup = [43.6025941, 1.4366249]; //Default position when launching map
    var defaultZoom = 15;
    var sensitivity = 0.001; //Minimum gps lat or lng change to take into an account
    var lineColor = "#1d51a2"; //Line color
    var lineOpacity = 0.7; //Line opacity
    var lineWeight = 4; //Line weight

    //Marker position is not exactly the same as set in the code...
    //The delta is approximaively 1E-6 each time. Sensitivity is set to 1.E-5 to match with any cases
    //var markerErasementSensitivity = 0.000001; //usefull if the markers array if not limited in size (also uncomment lines 44 to 56 to enable this feature)
    var lastKnownPosition = [0, 0];
    var markers = [null];

    initialize();

    google.maps.event.addListenerOnce(map, 'idle', function(){ //Wait until map is ready
        setInterval(refresh, refreshRate); //Apply the refresh rate to the refresh function
    });

    function initialize() {
        map = new google.maps.Map($('#map')[0], {
            zoom: defaultZoom,
            center: {lat: positionAtStartup[0], lng: positionAtStartup[1]},
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
    }

    function refresh() {
        $.ajax({
            type: "GET",
            url: "ajax/script.php",
            data: null,
            dataType: 'json',
            success: function(data){
                if(JSON.stringify(lastKnownPosition) != JSON.stringify(data)) {
                    if(Math.abs(lastKnownPosition[0] - data[0]) > sensitivity || Math.abs(lastKnownPosition[1] - data[1]) > sensitivity ) {

                        //Create the new marker
                        var marker = new google.maps.Marker({
                            position: {lat: data[0], lng: data[1]},
                            map: map
                        });

                        markers.push(marker);

                        //Create a line (if there is a previous not [0, 0] known position)
                        if (lastKnownPosition[0] != 0 && lastKnownPosition[1] != 0){
                            var lineToDraw =
                            [
                                {lat: lastKnownPosition[0], lng: lastKnownPosition[1]},
                                {lat: data[0], lng: data[1]}
                            ];

                            var newLine = new google.maps.Polyline({
                                path: lineToDraw,
                                strokeColor: lineColor,
                                strokeOpacity: lineOpacity,
                                strokeWeight: lineWeight
                            });
                            newLine.setMap(map);
                        }

                        map.panTo({lat: data[0], lng: data[1]}); //Center the map on the new point
                        lastKnownPosition = data; //Update last known position with current position
                    }
                }
            }
        })
    }
});