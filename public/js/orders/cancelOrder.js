const idProd=document.querySelectorAll('#id-prod');
const quantityProd=document.querySelectorAll('#quantity-prod');
const orderInput=document.getElementById('order-id');
const toast = document.getElementById("toast");
const msgToast=document.getElementById("msg");


function cancelOrder() {
    const orderID=orderInput.value;
    const products=[]
    let i=0;
    idProd.forEach(prod => {
       quantityProd.forEach(quantity=>{
        products[i]={
            id:prod.value,
            quantity:quantity.value,
            orderId:orderID
        };
       });
       i++;
    });

    fetch("/cancel-order/", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            order:products
        }),
    })
        .then((response) => response.json())
        .then((data) => {
           if(data.status==='success'){

            setTimeout(()=>{
                window.history.back()
            },3000)

            toast.classList.remove("hidden");
            msgToast.textContent='Pedido cancelado';
            setTimeout(() => {
                toast.classList.add("hidden");
                msgToast.textContent='';
            }, 2000);

           }else{
            alert('Ha ocurrido un error');
           }
            
        })
        
        .catch((error) => {
            console.log("Error: ", error);
        });

}

    


