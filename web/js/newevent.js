
/* --- web/js/scanaddress.js -- */

function clearHtml(id) {
    $('#'+id).html('');
}

function scanAddress() {
    var address = $('#numobundle_event_address').val().trim();
    if (address.length > 0) {
        var geoCoder="https://maps.googleapis.com/maps/api/geocode/json?address="+address; //+"&sensor=false";

        $.getJSON(geoCoder, function (data) { displayAddress(data); });
    }
}

function displayAddress(data) {
    if (data.status == 'OK') {
        var lat = data.results[0].geometry.location.lat
        $('#latitude').val(lat);
        var lng = data.results[0].geometry.location.lng
        $('#longitude').val(lng);
        $('#numobundle_event_address').val(data.results[0].formatted_address);
        $('#addrmessage').html('(adresse validée - lat: '+lat+' lgn: '+lng+')');
    } else {
        $('#addrmessage').html('(ADRESSE INVALIDE : '+data.status+')');
        $('#latitude').val('');
        $('#longitude').val('');
    }
}

function delAddrMessage() {
    $('#addrmessage').html('');
}

setTimeout(scanAddress(), 500);