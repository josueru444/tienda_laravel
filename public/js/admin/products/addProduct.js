var inputNameInsert = document.getElementById('input-name-insert');
var inputUrlInsert = document.getElementById('input-url-insert');
var inputDescInsert = document.getElementById('input-desc-insert');
var inputPriceInsert = document.getElementById('input-price-insert');
var inputStockInsert = document.getElementById('input-stock-insert');
const formInsert=document.getElementById('form-insert-prod');

formInsert.addEventListener('submit',e=>{
    e.preventDefault();
    fetch("/insert-product/", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            
            name:inputNameInsert.value,
            img:inputUrlInsert.value,
            desc:inputDescInsert.value,
            price:inputPriceInsert.value,
            stock:inputStockInsert.value
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
})

