const btnDelete=document.querySelectorAll('#btn-delete');
const btnMod=document.querySelectorAll('#btn-mod');

const inputID=document.getElementById('input-id');
var inputName = document.getElementById('input-name');
var inputUrl = document.getElementById('input-url');
var inputDesc = document.getElementById('input-desc');
var inputPrice = document.getElementById('input-price');
var inputStock = document.getElementById('input-stock');
const form=document.getElementById('form-update-prod');






//obtener la info del producto
function getProduct(id) {
    fetch("/get-specific-product/", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            idProd: id,
           
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            inputID.value=data[1].id;
           inputName.value=data[1].name;
           inputUrl.value=data[1].img;
           inputDesc.value=data[1].description;
           inputPrice.value=data[1].price;
           inputStock.value=data[1].stock;

        })
        
        .catch((error) => {
            console.log("Error: ", error);
        });
}


form.addEventListener('submit',e=>{
    e.preventDefault();

    fetch("/update-product/", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            id:inputID.value,
            name:inputName.value,
            img:inputUrl.value,
            desc:inputDesc.value,
            price:inputPrice.value,
            stock:inputStock.value
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            window.location.reload();

        })
        
        .catch((error) => {
            console.log("Error: ", error);
        });

});







btnDelete.forEach(element => {
    element.addEventListener('click',e=>{

        const divButtons=e.target.parentNode;
        const productID=divButtons.querySelector('input[type="hidden"]');
        console.log(productID.value);

        fetch("/delete-specific-product/", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({
                idProd: productID.value,
               
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                if(data.status==='success'){
                    window.location.reload();
                }
            
            })
            
            .catch((error) => {
                console.log("Error: ", error);
            });
    })
});







btnMod.forEach(element => {
    element.addEventListener('click',e=>{
        const divButtons=e.target.parentNode;
        const productID=divButtons.querySelector('input[type="hidden"]').value;
        
        getProduct(productID);


        edit_modal.showModal();
    })
});


