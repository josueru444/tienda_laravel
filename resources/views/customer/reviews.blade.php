@extends('layouts.nav')

@section('content')
<title>Comentarios</title>
<div class="w-full flex justify-center">
    <div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v19.0&appId=425230733472459" nonce="g4FKeFxM"></script>

<div class="fb-comments"  data-href="https://facebook.com.rd/" data-width="900" data-numposts="20" data-colorscheme="dark" data-lazy="true"></div>

</div>

@endsection

