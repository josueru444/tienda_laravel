@extends('layouts.nav')

@section('content')
    
    <section>
        <div class="absolute top-0 w-full h-lvh" id="map">

        </div>
    </section>
    <script src="{{ asset('js/maps/initMap.js') }}"></script>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmFx31LX3uDPx2fLgDv-T6e8q2wXPWQA4&callback=initMap">
    </script>    
@endsection