var mapClosed = false;
function closeMap() {
    if (mapClosed) {
        objet = document.getElementById('mapzone');
        objet.style.visibility = 'visible';
        objet.style.height = "300px";
        objet = document.getElementById('closemap');
        objet.style.backgroundColor = '#FF0000';
        objet.innerHTML = 'X';
        mapClosed = false;
    } else {
        objet = document.getElementById('mapzone');
        objet.style.visibility = 'hidden';
        objet.style.height = "20px";
        objet = document.getElementById('closemap');
        objet.style.backgroundColor = '#CADB2A';
        objet.innerHTML = 'Map';
        mapClosed = true;
    }
}
