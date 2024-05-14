@extends('layouts.nav')

<style>
    input[type="radio"][id^="cb"] {
  display: none;
}

label {
  
  padding: 0px;
  display: block;
  position: relative;
  margin: 10px;
  cursor: pointer;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

label::before {
  background-color: white;
  color: white;
  content: " ";
  display: block;
  border-radius: 50%;
  position: absolute;
  top: -5px;
  left: -5px;
  width: 25px;
  height: 25px;
  text-align: center;
  line-height: 28px;
  transition-duration: 0.4s;
  transform: scale(0);
}

label img {
  height: 100px;
  width: 85px;
  transition-duration: 0.2s;
  transform-origin: 50% 50%;
}

:checked+label {
  border-color: #ddd;
}

:checked+label::before {
  content: "✓";
  background-color: grey;
  transform: scale(1);
}

:checked+label img {
  transform: scale(0.9);
  box-shadow: 0 0 5px #333;
  z-index: -1;
}
</style>

@section('content')
    <title>Carrito</title>
    <div class="flex justify-center w-full bg-slate-700 align-top items-start">
    <div class="grid grid-cols-1 items-center align-middle left-0 justify-center">
        <h1 class="text-3xl text-white text-center pt-3 pb-5 col-span-3 w-full">Carrito de Compras</h1>
          
            @if (!isset($cartIems))  
            @foreach ($cartItems as $item)
            
            <div class="col-span-2">      
                <div class="bg-slate-800 p-5 mx-36 my-4 rounded-2xl flex gap-5 text-white">
                    
                    <a href="{{ url('/product')}}" class="inline-block ">
                        <img src="{{ $item->img }}" alt="" width="100" class="rounded-xl">
                    </a>
                    <div>
                        <div class="flex">
                            <a href="{{ url('/product')}}" class="text-xl hover:underline font-bold w-96 truncate">{{$item->name}}</a>
                            <button id="btn-delete-item" class="flex-none" onclick="deleteItem(event)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current hover:fill-red-500"  height="30" viewBox="0 -960 960 960" width="30"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm80-160h80v-360h-80v360Zm160 0h80v-360h-80v360Z"/></svg>
                            </button>

                        </div>
                        <p id="price" class="text-blue-500 font-bold text-xl m-1">${{$item->price}}</p>
                        <input type="hidden" id="id-product" value="{{$item->cartID}}">
                        <input type="hidden" id="id-product-real" value="{{$item->id}}">
                        <button type="button" id="minus" class="tex-white hover:bg-blue-600 text-xl rounded-md bg-blue-500 px-3 text-center font-bold">-</button>
                        <input disabled id="quantity" min="1" max="{{$item->stock}}" type="number" value="{{$item->quantity}}" class="bg-slate-700 py-1 text-white w-auto text-center rounded-lg border-2 border-gray-500 m-2">
                        <button type="button" id="plus" class="tex-white hover:bg-blue-600 text-xl rounded-md bg-blue-500 px-3 text-center font-bold">+</button>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
    </div>


    @if (isset($cartItems->total))
    <div class="">
        <section class="  ">
          <div class=" bg-slate-800 px-8 text-white py-8 rounded-2xl mb-10">
              <h1 class="text-center mb-10 font-bold text-2xl">Proceder con el pago</h1>
              <form method="POST" action="{{ url('/paypal') }}" id="form" class="grid grid-cols-2">
                  @csrf
                  <label class="align-middle items-center pt-4">Total (MXN)</label>
                  <input id="total-input" name="total" type="text" value="{{isset($cartItems->total) ? $cartItems->total : 0}}" class="bg-slate-700 py-1 text-white w-auto text-center rounded-lg border-2 border-gray-500 m-2 " disabled>
                  <input id="total-input2" name="total2" type="hidden" value="{{isset($cartItems->total) ? $cartItems->total : 0}}" class="bg-slate-700 py-1 text-white w-auto text-center rounded-lg border-2 border-gray-500 m-2 " >
                  <label class="align-middle items-center pt-4">Gastos de envío (MXN)</label>
                  <input name="envio" type="text" value="0" class="bg-slate-700 py-1 text-white w-auto text-center rounded-lg border-2 border-gray-500 m-2 " disabled>
                  <div class="col-span-2">
                    <p class="mt-5 mb-3"><strong>Dirección de envío</strong></p>

                    @if (isset($addresses[0]->id))
                      <select name="address" id="address-select" class="py-2 px-2 w-96 rounded-md bg-slate-700">
                        
                        @foreach ($addresses as $address)
                            <option value="{{$address['id']}}">
                              {{$address['user_name']}}
                              - {{$address['address']}} -
                              CP: {{$address['zip_code']}}
                            </option>
                          
                        @endforeach
                      </select> 
                            
                      <p class="m-3"><strong >Elige tu método de pago:</strong></p>
                      <ul class="flex">
                          <li><input type="radio" id="cb2" class="only-one" name="payment-method"/>
                              <label for="cb2"><img src="{{ asset('images/icons/oxxo.svg') }}" /></label>
                          </li>
                          <li><input type="radio" id="cb1" class="only-one" checked name="payment-method"/>
                            <label for="cb1"><img src="{{ asset('images/icons/card.png') }}" width="80" alt="paypal"/></label>
                          </li>
                      </ul>
                        
                  </div>
                  <button class="col-span-2 mt-9 mb-3 py-2 bg-blue-500 hover:bg-blue-600 rounded-lg checked:border-2 checked:border-red-500">Proceder con el pago</button>
              </form>
              @else
                          <button id="btn-add-address" onclick="addAddressBTN()" class="bg-orange-500 py-2 px-3 rounded-lg mb-3 w-full " >Agregar dirección</button>
                @endif  
          </div>
        </section>
    </div>

</div>


<dialog id="modal_direccion" class="modal">
  <div class="modal-box w-11/12 max-w-5xl">
    <h3 class="font-bold text-2xl text-white text-center">Selecciona la dirección de envio.</h3>
    <p class="py-4">Dirección de envio</p>
    
    @if (isset($addresses[0]))
        
    <select name="address" id="address">
      
      @foreach ($addresses as $address)
          <option value="{{$address['id']}}">
            {{$address['user_name']}}
            - {{$address['address']}} -
            CP: {{$address['zip_code']}}
      @endforeach          
    </select>
        
    @else
        
    <div class="flex flex-col ml-4">
      <label for="name">Nombre Completo</label>
      <input type="text" id="user_name" name="user_name" placeholder="Nombre y apellidos" class="py-2 bg-slate-700 rounded-md px-5">
      <label for="street">Calle y número</label>
      <input type="text" id="address" name="address" placeholder="Calle y número" class="py-2 bg-slate-700 rounded-md px-5">
      <label for="zip">Código Postal</label>
      <input type="text" id="zip" name="zip" placeholder="Codigo postal" class="py-2 bg-slate-700 rounded-md px-5">
    <button id="save-address" type="button" class="m-8  bg-blue-500 hover:bg-blue-600 text-white mx-12 py-3 h-10 rounded-md">Guardar direccion</button>
    @endif
    </div>
    </div>
  </div>
</dialog>
<script src="{{ asset('js/cart/cart.js') }}"></script>
<script src="{{ asset('js/cart/form.js') }}"></script>



<dialog id="modal_pago" class="modal">
  <div class="modal-box w-11/12 max-w-5xl">
    <h3 class="font-bold text-2xl text-white text-center">Pedido reservado. Paga en una tienda utilizando el siguiente código.</h3>
    <p class="py-4">Paga en una ubicación dentro de 72 horas para evitar cancelaciones.</p>

    <p class="pl-9 text-xl"><strong>Monto por pagar: </strong></p>    
    <p class="pl-9">${{$cartItems->total}}</p>

    <p class="pl-9 m-2 text-xl"><strong>Código</strong></p>
    <p class="text-white text-2xl text-center">xxxx-xxxxx-xxxxx-xxx</p>
    <p class="pl-9 text-xl"><strong>Dirección de envío</strong></p>
    <p id="p-address" class="pl-9"></p>
    <div class="modal-action">
      <form method="dialog">
        <!-- if there is a button, it will close the modal -->
        <button class="btn" onclick="addOrder()">Cerrar</button>
      </form>
    </div>
  </div>
</dialog>


<dialog id="modal_paypal" class="modal">
  <div class="modal-box w-11/12 max-w-5xl">
    <h3 class="font-bold text-2xl text-white text-center">Este pedido será pagado por medio de Paypal.</h3>
    <p class="py-4 text-center w-full text-orange-500 text-xl">Verifica la información para continuar</p>
    <form action="{{ route('paypal')}}" method="POST" class="flex flex-col gap-4">
      @csrf
      <label>Dirección de envio:</label>
      <input  type="text" id="addres-paypal-input" name="address-paypal-input" class="text-white text-xl bg-slate-700 border-2 border-gray-500 rounded-md px-4 py-2">
      <label>Total a pagar:</label>
      <input disabled type="text" value="${{$cartItems->total}} MXN" class="text-white text-xl bg-slate-700 border-2 border-gray-500 rounded-md px-4 py-2">
      <input name="total-paypal"  type="hidden" value="{{$cartItems->total}}">
      <button class="bg-yellow-400 text-black flex space-x-5 text-center justify-center mx-10 my-5 py-2 items-center align-middle rounded-md hover:bg-yellow-500">
        <p class="font-semibold text-xl font-sans">Continuar con el pago</p>
        <svg width="70" height="" viewBox="0 0 100 32">
          <path fill="#003087" d="M 12 4.917 L 4.2 4.917 C 3.7 4.917 3.2 5.317 3.1 5.817 L 0 25.817 C -0.1 26.217 0.2 26.517 0.6 26.517 L 4.3 26.517 C 4.8 26.517 5.3 26.117 5.4 25.617 L 6.2 20.217 C 6.3 19.717 6.7 19.317 7.3 19.317 L 9.8 19.317 C 14.9 19.317 17.9 16.817 18.7 11.917 C 19 9.817 18.7 8.117 17.7 6.917 C 16.6 5.617 14.6 4.917 12 4.917 Z M 12.9 12.217 C 12.5 15.017 10.3 15.017 8.3 15.017 L 7.1 15.017 L 7.9 9.817 C 7.9 9.517 8.2 9.317 8.5 9.317 L 9 9.317 C 10.4 9.317 11.7 9.317 12.4 10.117 C 12.9 10.517 13.1 11.217 12.9 12.217 Z"></path>
          <path fill="#003087" d="M 35.2 12.117 L 31.5 12.117 C 31.2 12.117 30.9 12.317 30.9 12.617 L 30.7 13.617 L 30.4 13.217 C 29.6 12.017 27.8 11.617 26 11.617 C 21.9 11.617 18.4 14.717 17.7 19.117 C 17.3 21.317 17.8 23.417 19.1 24.817 C 20.2 26.117 21.9 26.717 23.8 26.717 C 27.1 26.717 29 24.617 29 24.617 L 28.8 25.617 C 28.7 26.017 29 26.417 29.4 26.417 L 32.8 26.417 C 33.3 26.417 33.8 26.017 33.9 25.517 L 35.9 12.717 C 36 12.517 35.6 12.117 35.2 12.117 Z M 30.1 19.317 C 29.7 21.417 28.1 22.917 25.9 22.917 C 24.8 22.917 24 22.617 23.4 21.917 C 22.8 21.217 22.6 20.317 22.8 19.317 C 23.1 17.217 24.9 15.717 27 15.717 C 28.1 15.717 28.9 16.117 29.5 16.717 C 30 17.417 30.2 18.317 30.1 19.317 Z"></path>
          <path fill="#003087" d="M 55.1 12.117 L 51.4 12.117 C 51 12.117 50.7 12.317 50.5 12.617 L 45.3 20.217 L 43.1 12.917 C 43 12.417 42.5 12.117 42.1 12.117 L 38.4 12.117 C 38 12.117 37.6 12.517 37.8 13.017 L 41.9 25.117 L 38 30.517 C 37.7 30.917 38 31.517 38.5 31.517 L 42.2 31.517 C 42.6 31.517 42.9 31.317 43.1 31.017 L 55.6 13.017 C 55.9 12.717 55.6 12.117 55.1 12.117 Z"></path>
          <path fill="#009cde" d="M 67.5 4.917 L 59.7 4.917 C 59.2 4.917 58.7 5.317 58.6 5.817 L 55.5 25.717 C 55.4 26.117 55.7 26.417 56.1 26.417 L 60.1 26.417 C 60.5 26.417 60.8 26.117 60.8 25.817 L 61.7 20.117 C 61.8 19.617 62.2 19.217 62.8 19.217 L 65.3 19.217 C 70.4 19.217 73.4 16.717 74.2 11.817 C 74.5 9.717 74.2 8.017 73.2 6.817 C 72 5.617 70.1 4.917 67.5 4.917 Z M 68.4 12.217 C 68 15.017 65.8 15.017 63.8 15.017 L 62.6 15.017 L 63.4 9.817 C 63.4 9.517 63.7 9.317 64 9.317 L 64.5 9.317 C 65.9 9.317 67.2 9.317 67.9 10.117 C 68.4 10.517 68.5 11.217 68.4 12.217 Z"></path>
          <path fill="#009cde" d="M 90.7 12.117 L 87 12.117 C 86.7 12.117 86.4 12.317 86.4 12.617 L 86.2 13.617 L 85.9 13.217 C 85.1 12.017 83.3 11.617 81.5 11.617 C 77.4 11.617 73.9 14.717 73.2 19.117 C 72.8 21.317 73.3 23.417 74.6 24.817 C 75.7 26.117 77.4 26.717 79.3 26.717 C 82.6 26.717 84.5 24.617 84.5 24.617 L 84.3 25.617 C 84.2 26.017 84.5 26.417 84.9 26.417 L 88.3 26.417 C 88.8 26.417 89.3 26.017 89.4 25.517 L 91.4 12.717 C 91.4 12.517 91.1 12.117 90.7 12.117 Z M 85.5 19.317 C 85.1 21.417 83.5 22.917 81.3 22.917 C 80.2 22.917 79.4 22.617 78.8 21.917 C 78.2 21.217 78 20.317 78.2 19.317 C 78.5 17.217 80.3 15.717 82.4 15.717 C 83.5 15.717 84.3 16.117 84.9 16.717 C 85.5 17.417 85.7 18.317 85.5 19.317 Z"></path>
          <path fill="#009cde" d="M 95.1 5.417 L 91.9 25.717 C 91.8 26.117 92.1 26.417 92.5 26.417 L 95.7 26.417 C 96.2 26.417 96.7 26.017 96.8 25.517 L 100 5.617 C 100.1 5.217 99.8 4.917 99.4 4.917 L 95.8 4.917 C 95.4 4.917 95.2 5.117 95.1 5.417 Z"></path>
      </svg>
      </button>
    </form>
    <div class="modal-action">
      <form method="dialog" class="flex flex-col">
        <!-- if there is a button, it will close the modal -->
        <button class="btn" onclick="addOrder()">Cerrar</button>
      </form>
    </div>
  </div>
</dialog>




<script src="{{ asset('js/cart/cart.js') }}"></script>
<script src="{{ asset('js/cart/form.js') }}"></script>
<script src="{{ asset('js/cart/deleteItem.js') }}"></script>
@endif


@endsection

