@extends('admin.layoutsAdmin.nav')

@section('content')

    <section >
        <form method="post" onsubmit="addLocation(event)" class="text-white flex flex-col w-fit bg-slate-800 py-10 px-8 gap-3 rounded-xl fixed left-10 z-10 top-20">
            <label class="text-lg font-semibold">Nombre de la ubicación</label>
            <input id="name" autofocus type="text" name="name-location" required placeholder="Nombre de la ubicación" class="px-2 py-1 bg-slate-700 border-2 border-gray-500 rounded-lg ">
            
            <input id="latitude" type="hidden" name="latitude" id="latitude" required >  
                 
            <input id="longitude" type="hidden" name="longitude" id="longitude" required >
            <input type="submit" value="Guardar direccion" class="py-1 px-2 bg-blue-500 hover:bg-blue-600 rounded-md">
        </form>
    </section>
    <div class="w-full h-lvh absolute top-0">
        <div id="map" class="w-full h-screen top-0">

        </div>
    </div>

    <script src="{{ asset('js/admin/maps/initMap.js') }}"></script>
    <script src="{{ asset('js/admin/maps/addLocation.js') }}"></script>


    
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmFx31LX3uDPx2fLgDv-T6e8q2wXPWQA4&callback=initMap">
    </script>
@endsection



