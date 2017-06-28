setTimeout(init(), 300);

function init() {
    // --- si rechargement du formulaire
    scanAddress();
    affTrashes();
}
// -----------------------------------------------------------
function affTrashes() {
    if ($('#evtdatelist li').length == 1) {
        $('.showtrash').css('visibility','hidden');
    } else {
        $('.showtrash').css('visibility','visible');
    }
}
// -----------------------------------------------------------
function scanAddress() {
    var address = $('#numobundle_event_address').val().trim();
    if (address.length > 0) {
        var geoCoder="https://maps.googleapis.com/maps/api/geocode/json?address="+address; //+"&sensor=false";
        $.getJSON(geoCoder, function (data) { displayAddress(data); });
    } else {
        $('#addrmessage').html('');
    }
}
// -----------------------------------------------------------
function displayAddress(data) {
    if (data.status == 'OK') {
        var lat = data.results[0].geometry.location.lat;
        $('#'+$('#id-lat').val()).val(lat);
        var lng = data.results[0].geometry.location.lng;
        $('#'+$('#id-lng').val()).val(lng);
        $('#'+$('#id-addr').val()).val(data.results[0].formatted_address);
        $('#addrmessage').html('(adresse validée - lat: '+lat+' lgn: '+lng+')');
    } else {
        $('#addrmessage').html('(ADRESSE INVALIDE : '+data.status+')');
        $('#latitude').val('');
        $('#longitude').val('');
    }
}
// -----------------------------------------------------------
function addDate() {
    /* --- gestion du formulaire - ajout d'une date --- */
    var nbEvtDates = $('#evtdatelist li').length; // nombre de dates existantes
    var ulObj = $('#evtdatelist'); //objet ul
    var newWidget = $('#evtdatelist li').first().html(); // contenu html du premier li
    newWidget = newWidget.replace(/_0_/g, '_'+nbEvtDates+'_');
    newWidget = newWidget.replace(/\[0\]/g, '['+nbEvtDates+']');
    var newEvtDate = $('<li class="form-group"></li>').html(newWidget);
    newEvtDate.appendTo(ulObj);
    ulObj.data('index', $('#evtdatelist li').length);
    affTrashes();
}
// -----------------------------------------------------------
function delDate(obj) {
    var id = parseInt(obj.id.replace(/^_|_$/g,''));
    // --- supprime le <li> concerne
    $('#evtdatelist li')[id].remove();
    $('#evtdatelist').data('index', $('#evtdatelist li').length);
    // --- renumerote les autres <li>
    while ($('#evtdatelist li')[id]) {
        obj = $('#evtdatelist li')[id];
        toFind = '_'+(id+1)+'_';
        toReplace = '_'+id+'_';
        obj.innerHTML = obj.innerHTML.replace(new RegExp(toFind, 'g'), toReplace);
        toFind = '\\['+(id+1)+'\\]';
        toReplace = '['+id+']';
        obj.innerHTML = obj.innerHTML.replace(new RegExp(toFind, 'g'), toReplace);
        id++;
    }
    affTrashes();
}
// -----------------------------------------------------------
