@extends('layouts.nav')

@section('content')
    <title>Pedidos</title>
    <h1 class="text-center text-2xl font-semibold text-white">Tus pedidos</h1>

    <div role="tablist" class="tabs tabs-boxed bg-slate-700">
        <input id="tab1" type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Pedidos pagados" checked  onclick="getPaid()"/>
        <div role="tabpanel" class="tab-content bg-slate-700 border-base-300 rounded-box p-6">
            <section role="tabpanel" class="text-white mt-8 pb-10  flex flex-col bg-slate-700 gap-10 " id="orders-container">
                <div class="w-full  flex justify-center">
                    <span class="loading loading-infinity loading-lg"></span>
                </div>
            </section>
        </div>
        <input id="tab2" type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Pedidos por pagar"onclick="getUnpaid()" />
        <div role="tabpanel" class="tab-content bg-slate-700 border-base-300 rounded-box p-6">
            <section role="tabpanel" class="text-white mt-8 pb-10  flex flex-col bg-slate-700 gap-10 " id="orders-unpaid">
                <div class="w-full  flex justify-center">
                    <span class="loading loading-infinity loading-lg"></span>
                </div>
            </section>
        </div>
        <input id="tab3" type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Pedidos recibidos"onclick="getDelivered()" />
        <div role="tabpanel" class="tab-content bg-slate-700 border-base-300 rounded-box p-6">
            <section role="tabpanel" class="text-white mt-8 pb-10  flex flex-col bg-slate-700 gap-10 " id="orders-delivered">
                <div class="w-full  flex justify-center">
                    <span class="loading loading-infinity loading-lg"></span>
                </div>
            </section>
        </div>
        
    </div>
      </div>
    
    <div class="hidden">
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
    </div>
    
    <script src="{{ asset('js/orders/getOrders.js') }}"></script>

@endsection



