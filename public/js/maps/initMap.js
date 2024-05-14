
function initMap(coords) {
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 15,
      center: { lat: 19.43667, lng: -100.35799 },
    });
    
    const store=[];

    for (let index = 0; index < coords.length; index++) {
        
        const latDB=parseFloat(coords[index].latitude);
        
        const longDB=parseFloat(coords[index].longitude);
        
        const name=coords[index].name;

        store[index]=[{lat:latDB,lng:longDB},name]
        
    }
    

    console.log(store);
   
    const infoWindow = new google.maps.InfoWindow();
  
    
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
  


  
