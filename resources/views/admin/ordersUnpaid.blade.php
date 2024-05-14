@extends('admin.layoutsAdmin.nav')

@section('content')
    <div class="grid grid-cols-3 grid-rows-3 bg-slate-700">
        <div class="col-span-2 row-span-2">
            <iframe id='fileViewer' class='w-full h-full p-10'></iframe>
        </div>
        <div class="flex flex-col gap-4 top-0 mx-10 align-top items-start row-span-1 h-fit">
            <p>total a pagar: ${{$request[0]->total}}</p>
            <div>
                <input type="hidden" name="idOrder" id="idOrder" value="{{$request[0]->id}}">
                <button id="btn-pay" class="bg-green-500 py-2 px-4 rounded-md hover:bg-green-600 text-white my-16 w-full ">Aceptar Pago</button>
                <button class="bg-red-500 py-2 px-4 rounded-md hover:bg-red-600 text-white my-16 w-full ">Rechazar Pago</button>
            </div>
        </div>
    </div>
    
    <script>
    
        let base64Data = "{{ $request[0]->file }}";

       
        function base64toBlob(base64Data) {
            const byteCharacters = atob(base64Data);
            const byteArrays = [];

            for (let offset = 0; offset < byteCharacters.length; offset += 512) {
                const slice = byteCharacters.slice(offset, offset + 512);

                const byteNumbers = new Array(slice.length);
                for (let i = 0; i < slice.length; i++) {
                    byteNumbers[i] = slice.charCodeAt(i);
                }

                const byteArray = new Uint8Array(byteNumbers);
                byteArrays.push(byteArray);
            }

            return new Blob(byteArrays, { type: 'image/png' }); // Ajusta el tipo de archivo según tu imagen
        }

        // Convertir la cadena base64 en Blob
        const blob = base64toBlob(base64Data);

        // Crear una URL para el Blob y mostrar la imagen en la página
        const fileViewer = document.getElementById('fileViewer');
        fileViewer.src = URL.createObjectURL(blob);

        // Liberar la URL del Blob cuando la imagen se haya cargado
        fileViewer.onload = () => {
            URL.revokeObjectURL(fileViewer.src);
        };
    </script>

    <script src="{{ asset('js/admin/orders/unpaidOrder.js') }}"></script>
@endsection



