$(function(){
    var _lat = $('#_lat').val();
    var _lng = $('#_lng').val();

    if(_lat == 0 && _lng == 0) {
        if (navigator.geolocation){
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback, {enableHighAccuracy: true, timeout: 120000});
        }
        else {
            alert('Your web browser does not support geolocation. You can geolocate youself using the map');
            _lat = "43.5937874";
            _lng = "1.4260095";
            initLocationpicker();
        }
    }
    else {
        initLocationpicker();
    }

    $('#db-start-date').datepicker({dateFormat: "mm/dd/yy"});
    $('#db-end-date').datepicker({dateFormat: "mm/dd/yy"});

    function successCallback(position){
        console.log(position);
        _lat = position.coords.latitude;
        _lng = position.coords.longitude;
        initLocationpicker();
    }

    function errorCallback(error){
        switch(error.code){
            case 1:
                alert('Permission denied: Geolocation failed because the page didn\'t have the permission to access your geolocation information');
                break;
            case 2:
                alert('Position unavailable: Geolocation failed because because at least one internal source of position returned an internal error');
                break;
            case 3:
                alert('Timeout: The time allowed to acquire the geolocation, was reached before the information was obtained');
                break;
        }

        _lat = "43.5937874";
        _lng = "1.4260095";
        initLocationpicker();
    }

    function initLocationpicker(){
        $('#location-picker').locationpicker({
            location: {latitude: _lat, longitude: _lng},   
            radius: 1,
            inputBinding: {
                latitudeInput: $('#location-lat'),
                longitudeInput: $('#location-lng'),
                locationNameInput: $('#location-address')
            },
            enableAutocomplete: true,
            enableReverseGeocode: true
        });
    }
});