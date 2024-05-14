@extends('admin.layoutsAdmin.nav')

@section('content')
    <title>Pedidos</title>
    <div role="tablist" class="tabs tabs-boxed mx-10 bg-slate-700">
      <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Todos los pedidos" />
      <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">Tab content 1</div>
    
      <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Confirmar pago" checked onclick="getProcessingOrder()" />
      <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">

        <table class="w-full">
            <thead class="border-2 border-b-gray-500 border-t-transparent border-x-transparent">
              <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Dirección</th>
                <th>Status</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody id="tbody-processing">
                <tr>
                    <td>
                        <div class="w-full flex justify-center">
                            <span class="loading loading-dots loading-lg"></span>
                        </div></td>
                    <td>
                        <div class="w-full flex justify-center">
                            <span class="loading loading-dots loading-lg"></span>
                        </div></td>
                    <td>
                        <div class="w-full flex justify-center">
                            <span class="loading loading-dots loading-lg"></span>
                        </div></td>
                    <td>
                        <div class="w-full flex justify-center">
                            <span class="loading loading-dots loading-lg"></span>
                        </div>
                    </td>
                </tr>
            </tbody>
          </table>
          
      </div>
      <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Pedidos por enviar" onclick="getPaidOrders()"/>
      <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
        <table class="w-full">
          <thead class="border-2 border-b-gray-500 border-t-transparent border-x-transparent">
            <tr>
              <th>ID</th>
              <th>Usuario</th>
              <th>Dirección</th>
              <th>Status</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="tbody-preparing">
            <td>
                <div class="w-full flex justify-center">
                    <span class="loading loading-dots loading-lg"></span>
                </div></td>
            <td>
                <div class="w-full flex justify-center">
                    <span class="loading loading-dots loading-lg"></span>
                </div></td>
            <td>
                <div class="w-full flex justify-center">
                    <span class="loading loading-dots loading-lg"></span>
                </div></td>
            <td>
                <div class="w-full flex justify-center">
                    <span class="loading loading-dots loading-lg"></span>
                </div>
            </td>
          </tbody>
        </table>
      </div>

      <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Pedidos Envidos" onclick="getShippedOrders()" />
      <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
        <table class="w-full">
            <thead class="border-2 border-b-gray-500 border-t-transparent border-x-transparent">
              <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Dirección</th>
                <th>Status</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody id="tbody-shipped">
                <td>
                    <div class="w-full flex justify-center">
                        <span class="loading loading-dots loading-lg"></span>
                    </div></td>
                <td>
                    <div class="w-full flex justify-center">
                        <span class="loading loading-dots loading-lg"></span>
                    </div></td>
                <td>
                    <div class="w-full flex justify-center">
                        <span class="loading loading-dots loading-lg"></span>
                    </div></td>
                <td>
                    <div class="w-full flex justify-center">
                        <span class="loading loading-dots loading-lg"></span>
                    </div>
                </td>
            </tbody>
          </table>
      </div>

    </div>
  
    <script src="{{ asset('js/admin/orders/PaidOrder.js') }}"></script>
    <script src="{{ asset('js/admin/orders/getOrderFetch.js') }}"></script>
@endsection



