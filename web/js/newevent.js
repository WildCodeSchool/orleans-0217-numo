
/* --- web/js/scanaddress.js -- */

setTimeout(scanAddress(), 500);

function init() {
    // --- instanciation de l'objet geocoder de google
    geocoder = new google.maps.Geocoder();
    // --- declenchement de l'analyse d'adresse au (re)chargement du formulaire
    setTimeout(scanAddress(), 500);
    affTrashes();
}

function affTrashes() {
    if ($('#evtdatelist li').length == 1) {
        $('.cachable').hide();
    } else {
        $('.cachable').show();
    }

}

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

function addDate() {
    /* --- gestion du formulaire - ajout d'une date --- */
    var nbEvtDates = $('#evtdatelist li').length;
    var objet = $('#evtdatelist');
    var newWidget = objet.attr('data-prototype');
    newWidget = newWidget.replace(/__name__/g, nbEvtDates);
    var newEvtDate = jQuery('<li></li>').html(newWidget);
    newEvtDate.appendTo(objet);
    affTrashes();
}

