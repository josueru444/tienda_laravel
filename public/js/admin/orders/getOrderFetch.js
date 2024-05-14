function drawTable(idTbody,data,textBtn,functionName) {
    const tbody=document.getElementById(idTbody);
    if(data.length===0){
        tbody.innerHTML=`<td colspan="5" class="text-center text-white text-xl py-5">No hay elementos en esta categoría</td>`;

    }
    let row='';
    data.forEach(element => {
        console.log(element);
         row +=`
    <tr class="border-b-2 border-b-gray-500">
        <td class="text-center">${element.id}</td>
        <td class="text-center">${element.users_id}</td>
        <td class="text-center">${element.shipping_address}</td>
        <td class="text-center">${element.status}</td>
        <td class="text-center">
        <button id="btn-confirm" onclick="${functionName}(${element.id},event)" class="bg-orange-500 hover:bg-orange-600 text-white py-1 px-2 rounded-md m-2">${textBtn}</button>
        </td>
    </tr>`;
    tbody.innerHTML=row;
    });   
}

function  getOrder(status,idParent,textBtn,functionName) {
    fetch(`/get-custom-orders/`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            status:status
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data.status);
            if(data.status==='success'){
                drawTable(idParent,data.data,textBtn,functionName);
            }
        })

        .catch((error) => {
            console.log("Error: ", error);
        });
    
}
function CheckPayment(id,event) {
    window.location.href=`/orders-unpaid/${id}`;
}

function getProcessingOrder() {
    getOrder('Processing','tbody-processing','Comprobar pago','CheckPayment');
}

document.addEventListener('DOMContentLoaded',()=>{
    getProcessingOrder()
})

function getPaidOrders() {
    getOrder('Paid','tbody-preparing','Confirmar envío','confirmDelivery');
}

function getShippedOrders() {
    getOrder('Shipped','tbody-shipped','Pedido enviado','');
}