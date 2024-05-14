const url = window.location.href;
const urlSplit = url.split("/")[4];

function createOrders(orders, idContainer) {
    const container = document.getElementById(idContainer);
    container.innerHTML = ""; // Limpia el contenido actual del contenedor

    // Itera sobre cada orden y construye el HTML correspondiente
    const orderHTML = orders.map((order) => {
        // Construye el HTML para cada orden utilizando template literals
        return `
            <div class="border-2 mx-20 rounded-xl flex flex-col p-4 items-center border-blue-500 transition delay-150 ease-in-out hover:scale-105 duration-300">
                <div class="w-full">
                    <p class="pl-10 mb-3"><strong>Enviado a:</strong> ${
                        order.shipping_address
                    }</p>
                    <p class="pl-10"><strong>Comprado el:</strong> ${
                        order.created_at
                    }</p>
                </div>
                <ul class="steps steps-vertical lg:steps-horizontal my-10 w-full">
                    <li id='li1' class="step step-primary">Pago en espera</li>
                    <li id='li2' class="step ${
                        order.status === "Paid" ||
                        order.status === "Shipped" ||
                        order.status === "Delivered"
                            ? "step-primary"
                            : ""
                    }">Pago recibido</li>
                    <li id='li3' class="step ${order.status === "Paid" || order.status === "Shipped" || order.status === "Delivered" ? "step-primary" : ""}">En preparación</li>
                    <li id='li4' class="step ${order.status === "Shipped"  || order.status==='Delivered' ? "step-primary" : ""}">Envíado</li>
                    <li id='li5' class="step ${order.status === "Delivered" ? "step-primary" : ""}">Recibido</li>
                </ul>
                ${order.status}
                <a href="/order-details/${
                    order.id
                }" class="text center bg-blue-500 py-2 px-3 rounded-xl hover:bg-blue-600">Mostrar más detalles</a>
            </div>`;
    });

    // Une todos los bloques de HTML generados en una cadena y asigna al contenedor
    container.innerHTML = orderHTML.join("");
}

function getOrders(user, route, idContainer) {
    fetch(route, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            user: user,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            const response = data.status;
            
            if (data.long === 0 || data.long==='0') {
                
                const contenedor=document.getElementById(idContainer);
                contenedor.innerHTML=' ';
                const loading=`
                <div class="w-full  flex justify-center">
                    <p class="text-xl font-bold">No tienes pedidos en esta categoría</p>
                </div>`;
                contenedor.innerHTML=loading;
            }
            else if (response === "success" && data.long >= 1) {
                createOrders(data.orders, idContainer);
            }
             else {
                window.location.replace("/");
            }
        })

        .catch((error) => {
            console.log("Error: ", error);
        });
}

document.addEventListener("DOMContentLoaded", (e) => {
    getPaid();
});

function getPaid() {
    getOrders(urlSplit, "/get-my-orders/", "orders-container");
}

function getUnpaid() {
    getOrders(urlSplit, "/get-my-orders-unpaid/", "orders-unpaid");
}
function getDelivered() {
    getOrders(urlSplit, "/get-my-orders-delivered/", "orders-delivered");
}