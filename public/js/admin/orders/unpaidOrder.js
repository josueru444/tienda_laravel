//Cambia a pagado el estado del pedido
console.log('pagando');
const btnPay=document.getElementById('btn-pay');
const inputID=document.getElementById('idOrder');


btnPay.addEventListener('click',e=>{
    const url=window.location.href
    const urlObj=new URL(url);

    const urlSegment=urlObj.pathname.split('/')
    const lastSegment = urlSegment[urlSegment.length - 1];


    fetch("/confirm-payment/", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            idOrder:lastSegment,
            idPayOrder:inputID.value

        }),
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data.data);
            if(data.msg==='success'){
                window.location.href='/admin-orders/';
            }


        })
        
        .catch((error) => {
            console.log("Error: ", error);
        });
})