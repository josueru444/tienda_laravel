function deleteItem(event) {
    const parent=(event.target).parentNode.parentNode.parentNode.parentNode;
    console.log(parent);
    const idProductInput=parent.querySelector('#id-product-real');
    const idProd=idProductInput.value;
    console.log(parent);
    fetch("/delete-cartItem/", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            idProduct: idProd,
            
        }),
    })
        .then((response) => response.json())
        .then((data) => {
           if (data.status==='success') {
            location.reload();
           }
            // 

            console.log(data);
        })

        .catch((error) => {
            console.log("Error: ", error);
        });
}