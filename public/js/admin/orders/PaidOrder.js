
function confirmDelivery(id,event) {
    const element=event.target;
    const parent=element.parentNode.parentNode;
    fetch("/shipping-Order/", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            idOrder:id,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);

        })
        
        .catch((error) => {
            console.log("Error: ", error);
        });


    console.log(parent);
    parent.remove();
    
}