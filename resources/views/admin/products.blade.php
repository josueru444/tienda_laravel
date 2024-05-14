@extends('admin.layoutsAdmin.nav')

@section('content')
    <title>Admin</title>
    <section class="w-full bg-slate-700">
        <div role="tablist" class="tabs tabs-lifted mx-10">
            <input type="radio" name="my_tabs_2" role="tab" class="tab " aria-label="Listar" checked/>
    
                <div role="tabpanel" class="tab-content border-base-300 rounded-box p-6 bg-base-100 ">
                    <div class="overflow-x-auto ">
                        <table class="table">
                          <thead class="text-blue-600 text-md">
                            <tr>
                              <th>Imagen</th>
                              <th>Nombre</th>
                              <th>Descripcion</th>
                              <th>Precio</th>
                              <th>Stock</th>
                              <th>Activo</th>
                              <th>Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($products as $item)
                            <tr class="border-b-2 border-white">
                              <td>
                                <div class="flex items-center gap-3">
                                  <div class="avatar">
                                    <div class="w-40 h-40">
                                      <img src="{{$item->img}}" alt="imagen-product" width="1200" class="rounded-lg"/>
                                    </div>
                                  </div>
                                </div>
                              </td>
                              <td class="">
                                {{$item->name}}
                              </td>
                              <td>{{$item->description}}</td>
                              <th>
                                ${{$item->price}}
                              </th>
                              <th>
                                 {{$item->stock}}
                              </th>
                              <th>
                                 {{$item->active}}
                              </th>
                              <th>
                                <div>
                                    <input type="hidden" value="{{$item->id}}">
                                    <button id="btn-mod" class="py-2 bg-orange-400 text-white rounded-md px-2 hover:bg-orange-500 m-2">Modicar</button>
                                    <button id="btn-delete" class="py-2 bg-red-500 text-white rounded-md px-2 hover:bg-red-600 m-2">Eliminar</button>
                                    
                                </div>
                              </th>
                            </tr>
                          </tbody>
                          @endforeach
                         
                        </table>
                      </div>
                   

                </div>
          
            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Registrar" />
            <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6 ">
                <form method="POST" class="flex flex-col gap-3" id="form-insert-prod" >
                   
                    <label>Nombre</label>
                    <input id="input-name-insert" name="input-name" required type="text" class="bg-slate-700 border-2 border-gray-500 text-white rounded-md py-1 px-3">
        
                    <label>URL de la imagen</label>
                    <input id="input-url-insert" name="input-url" required type="text" class="bg-slate-700 border-2 border-gray-500 text-white rounded-md py-1 px-3">
        
                    <label>Descripción</label>
                    <textarea id="input-desc-insert" name="input-desc" required name="" id="" cols="30" rows="10" class="bg-slate-700 border-2 border-gray-500 text-white rounded-md py-1 px-3"></textarea>
                    
                    <label>Precio de venta (MXN)</label>
                    <input id="input-price-insert" name="input-price" required type="text" class="bg-slate-700 border-2 border-gray-500 text-white rounded-md py-1 px-3">
        
                    <label>Stock</label>
                    <input id="input-stock-insert" name="input-stock" required type="number" class="bg-slate-700 border-2 border-gray-500 text-white rounded-md py-1 px-3">
        
                    <input type="submit" value="Actualizar Producto" class="bg-orange-500 hover:bg-orange-600 py-2 px-2 rounded-lg text-white">
                    
                  </form>
            </div>
                
                
            
          </div>
    </section>

    <dialog id="edit_modal" class="modal">
        <div class="modal-box">
          <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
          </form>
          <h3 class="font-bold text-lg">Modificar Producto</h3>
          <form method="POST" class="flex flex-col gap-3" id="form-update-prod">
            <input id="input-id" type="text">
            <label>Nombre</label>
            <input id="input-name" name="input-name" required type="text" class="bg-slate-700 border-2 border-gray-500 text-white rounded-md py-1 px-3">

            <label>URL de la imagen</label>
            <input id="input-url" name="input-url" required type="text" class="bg-slate-700 border-2 border-gray-500 text-white rounded-md py-1 px-3">

            <label>Descripción</label>
            <textarea id="input-desc" name="input-desc" required name="" id="" cols="30" rows="10" class="bg-slate-700 border-2 border-gray-500 text-white rounded-md py-1 px-3"></textarea>
            
            <label>Precio de venta (MXN)</label>
            <input id="input-price" name="input-price" required type="text" class="bg-slate-700 border-2 border-gray-500 text-white rounded-md py-1 px-3">

            <label>Stock</label>
            <input id="input-stock" name="input-stock" required type="number" class="bg-slate-700 border-2 border-gray-500 text-white rounded-md py-1 px-3">

            <input type="submit" value="Actualizar Producto" class="bg-orange-500 hover:bg-orange-600 py-2 px-2 rounded-lg text-white">

          </form>
        </div>
      </dialog>
    

<script src="{{ asset('js/admin/products/editProduct.js') }}"></script>
<script src="{{ asset('js/admin/products/addProduct.js') }}"></script>

@endsection



