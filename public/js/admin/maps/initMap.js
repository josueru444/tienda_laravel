function initMap() {
    const latitude = 19.43667;
    const longitude = -100.35799;

    const coords = {
        lng: longitude,
        lat: latitude
    };

    generateMap(coords);
}

function generateMap(coords) {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: new google.maps.LatLng(coords.lat, coords.lng)
    });

    let marker = new google.maps.Marker({
        map: map,
        draggable: true,
        position: new google.maps.LatLng(coords.lat, coords.lng)
    });

    // Función para actualizar los campos de entrada
    function updateInputValues() {
        document.getElementById('latitude').value = marker.getPosition().lat();
        document.getElementById('longitude').value = marker.getPosition().lng();
    }

    // Actualizar los campos de entrada al cargar el marcador
    updateInputValues();

    // Listener para actualizar los campos al arrastrar el marcador
    marker.addListener('dragend', function(event) {
        updateInputValues();
    });
}
