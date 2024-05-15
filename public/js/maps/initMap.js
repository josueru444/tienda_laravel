
function initMap(coords) {
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 15,
      center: { lat: 19.43667, lng: -100.35799 },
    });
    console.log(coords);
    
    const store=[];

    for (let index = 0; index < coords.length; index++) {
      console.log(coords[index].id);
        
        const latDB=parseFloat(coords[index].latitude);
        
        const longDB=parseFloat(coords[index].longitude);
        
        const name=coords[index].name;

        store[index]=[{lat:latDB,lng:longDB},name]
        
    }
    console.log(store);
    
    const infoWindow = new google.maps.InfoWindow();
    console.log(store);
    
    store.forEach(([position, title], i) => {
      const marker = new google.maps.Marker({
        position,
        map,
        title: `${i + 1}. ${title}`,
        label: `${i + 1}`,
        optimized: false,
      });
  
      
      marker.addListener("click", () => {
        infoWindow.close();
        infoWindow.setContent(marker.getTitle());
        infoWindow.open(marker.getMap(), marker);
      });
    });
  }
  

  function getLocations() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '/get-map-db/');
    xhr.responseType = 'json';

    xhr.onload = () => {
        if (xhr.status === 200) {
            const data = xhr.response;
            
            window.initMap=initMap(data.locations);
        } else {
            console.error('Error fetching data. Status:', xhr.status);
        }
    };

    xhr.onerror = () => {
        console.error('Network error while fetching data.');
    };

    xhr.send();
}

getLocations();

  
