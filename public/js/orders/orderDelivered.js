function confirmDelivered(event) {
    const orderID=document.getElementById(`order-id`).value;
    
    fetch("/confirm-delivered-order/", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            id_order: orderID,
            
        }),
    })
        .then((response) => response.json())
        .then((data) => {
                if(data.status==='success'){
                    window.location.reload();
                }
            
        })
        .catch((error) => {
            console.log("Error: ", error);
        });

}