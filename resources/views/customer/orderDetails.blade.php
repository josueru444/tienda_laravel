@extends('layouts.nav')

@section('content')
    <title>Detalles del pedido</title>
    <section class="grid grid-cols-3">
        <h1 class=" inline-block row-start-1 col-span-4 text-center text-xl text-white font-semibold mb-5">Lista de artículos del pedido</h1>
        <div class="grid grid-cols-4 gap-3 px-5 col-span-2">
            
            @foreach ($details as $detail)
                <div id='container-product' class="flex flex-col items-center align-middle bg-slate-800 py-5 px-2 rounded-xl">
                    <img src="{{$detail->img}}" alt="img-producto" width="200">
                    <p class="m-3" >{{$detail->name}}</p>
                    <p>cantidad: <strong>{{$detail->quantity}}</strong></p>
                    <input type="hidden" name="" id="id-prod" value="{{$detail->id}}" >
                    <input type="hidden" name="" id="quantity-prod" value="{{$detail->quantity}}" >
                </div>
                
            @endforeach
        </div>
        <div class="px-5 text-lg">
            <input type="hidden" id="order-id" value="{{$details[0]->order_id}}">
            <p>Dirección de envío:</p>
            <p><strong> {{$details[0]->shipping_address}}</strong></p>
            <p>Total del pedido(MXN):</p>
            <p><strong>{{$total}}</strong></p>
            <p>Status:</p>
            <p><strong>{{$details[0]->status}}</strong></p>
            @if ($details[0]->status=='Unpaid')
                <button class="btn mt-8 w-full bg-blue-500 text-white hover:bg-blue-600" onclick="file_modal.showModal()">Subir comprobante de pago</button>
                <button class="btn my-5 w-full bg-red-500 text-white hover:bg-red-600" onclick="cancel_modal.showModal()">Cancelar pedido</button>
            @elseif($details[0]->status=='Delivered')
                <button class="btn my-5 w-full bg-orange-500 text-white hover:bg-orange-600"">Gracias por su compra</button>
                <a href="/reviews" class="btn my-5 w-full bg-purple-500 text-white hover:bg-purple-600" >Comparte tu experiencia con otros compradores</a>
            @elseif($details[0]->status=='Shipped')
                <p>Su paquete ha sido enviado y llegará en un plazo de 3 días hábiles</p>
                <button onclick="confirmDelivered(event)" class="btn my-5 w-full bg-green-500 text-white hover:bg-green-600"">Recibí mi pedido</button>
            @elseif($details[0]->status=='Processing')
                <p>Estamos procesando tu pago, por favor espera la confirmación</p>
            @elseif( $details[0]->status=='Paid')
              <p>Su pago ha sido aceptado, su producto está siendo preparado</p>    
            @endif
        </div>
    </section>

<dialog id="file_modal" class="modal">
    <div class="modal-box">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
      </form>
      <h3 class="font-bold text-lg">Subir comprobate</h3>
      <p class="py-4">Selecciona tu comprobante de pago y persiona enviar</p>
      <form action="{{ route('add-manual-payment') }}" method="POST" class="flex flex-col items-center" id="form-payment">
        @csrf
        <input name="idOrder" type="hidden" id="order-id" value="{{$details[0]->order_id}}">
        <input name="TotalOrder" type="hidden" value="{{$total}}">
        <input required type="file" name="file" id="file-payment-input" class="file-input file-input-bordered file-input-info w-full max-w-xs"  accept="image/*"/>
        <button type="submit" id="btn-input-payment" class="btn my-8 w-full bg-blue-500 text-white hover:bg-blue-600">Subir comprobante de pago</button>
    </form>
    </div>
  </dialog>
  

  <dialog id="cancel_modal" class="modal">
    <div class="modal-box">
      
      <h3 class="font-bold text-lg">Cancelar Pedido</h3>
      <p class="my-5 text-center text-xl text-white">¿Quieres cancelar este pedido?</p>
      <form method="dialog" class="grid grid-cols-2 text-white gap-2">
        
        <button class="bg-red-500 hover:bg-red-600 py-2 rounded-lg" onclick="cancelOrder()">Cancelar pedido</button>
        <button class="bg-blue-500 hover:bg-blue-600 rounded-lg">Salir</button>
      </form>
    </div>
   
  </dialog>


  

<script src="{{ asset('js/orders/cancelOrder.js') }}"></script>
<script src="{{ asset('js/orders/sendPayment.js') }}"></script>
<script src="{{ asset('js/orders/orderDelivered.js') }}"></script>

<script>
  // Ejemplo de código JavaScript para manejar la solicitud AJAX y mostrar el resultado
const form = document.getElementById("form-payment");
const fileInput = document.getElementById("file-payment-input");
const btn=document.getElementById('btn-input-payment');


form.addEventListener("submit", (e) => {
    e.preventDefault();

    btn.disabled=true;
    btn.classList.remove('bg-blue-500');
    btn.classList.remove('hover:bg-blue-500');
    btn.classList.add('bg-orange-500');
    btn.classList.add('hover:bg-orange-600');
    btn.textContent='Subiendo comprobante';
    const formData = new FormData(form);

    fetch("{{ route('add-manual-payment') }}", {
        method: "POST",
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if(data.status==='success'){
          window.location.reload();
        }

    })
    .catch(error => {
        console.error("Error:", error);
    });
});

</script>

@endsection

