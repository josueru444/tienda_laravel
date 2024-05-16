@extends('layouts.nav')

@section('content')
<title>Inicio</title>
   <section class="bg-slate-700 mt-0">
    <p class="w-full- text-center text-2xl font-semibold text-white mb-7">Productos recomendados</p>
    <div class="mx-10 ">
        <div class="carousel carousel-end rounded-box">
            <a href="/product/1" class="carousel-item border-x-2 border-gray-600 ">
              <img src="https://imgaz.staticbg.com/thumb/large/oaupload/banggood/images/FE/B9/56de2650-1961-482a-bd07-2b1a00b0c1bf.jpg.webp" alt="Drink" width="250" class="overflow-hidden bg-blue-400 bg-fixed opacity-1 transition duration-300 ease-in-out hover:opacity-80"/>
            </a> 
            <a href="/product/7" class="carousel-item border-x-2 border-gray-600">
              <img src="https://imgaz2.staticbg.com/thumb/large/oaupload/banggood/images/76/35/0ac22511-56fe-47a8-9949-e1e8745d05d3.png.webp" alt="Drink" width="250" class="overflow-hidden bg-blue-400 bg-fixed opacity-1 transition duration-300 ease-in-out hover:opacity-80"/>
            </a> 
            <a href="/product/3" class="carousel-item border-x-2 border-gray-600">
              <img src="https://imgaz.staticbg.com/thumb/large/oaupload/banggood/images/3E/D6/f3a392d2-1b15-48d1-a548-deeab7600c63.jpg.webp" alt="Drink" width="250" class="overflow-hidden bg-blue-400 bg-fixed opacity-1 transition duration-300 ease-in-out hover:opacity-80"/>
            </a> 
            <a href="/product/6" class="carousel-item border-x-2 border-gray-600">
              <img src="https://imgaz2.staticbg.com/thumb/large/oaupload/banggood/images/91/4F/74e36694-c843-49b8-ade0-a7ccdf956ff5.jpg.webp" alt="Drink" width="250" class="overflow-hidden bg-blue-400 bg-fixed opacity-1 transition duration-300 ease-in-out hover:opacity-80"/>
            </a> 
            <a href="/product/9" class="carousel-item border-x-2 border-gray-600">
              <img src="https://imgaz2.staticbg.com/thumb/large/oaupload/banggood/images/B0/D2/931604d1-f0fa-4557-92d3-ebc5a3c54799.jpg.webp" alt="Drink" width="250" class="overflow-hidden bg-blue-400 bg-fixed opacity-1 transition duration-300 ease-in-out hover:opacity-80"/>
            </a> 
            <a href="/product/2" class="carousel-item border-x-2 border-gray-600">
              <img src="https://imgaz3.staticbg.com/thumb/large/oaupload/banggood/images/38/E2/117a82e9-62ab-4b30-81a4-5bb8edf59fde.jpg.webp" alt="Drink" width="250" class="overflow-hidden bg-blue-400 bg-fixed opacity-1 transition duration-300 ease-in-out hover:opacity-80"/>
            </a> 
            <a href="/product/4" class="carousel-item border-x-2 border-gray-600">
              <img src="https://imgaz3.staticbg.com/thumb/large/oaupload/banggood/images/19/C5/2d0141f7-b20e-4858-8a6b-3118ad9c2a79.jpg.webp" alt="Drink" width="250" class="overflow-hidden bg-blue-400 bg-fixed opacity-1 transition duration-300 ease-in-out hover:opacity-80"/>
            </a> 
            <a href="/product/8" class="carousel-item border-x-2 border-gray-600">
              <img src="https://imgaz1.staticbg.com/thumb/large/oaupload/banggood/images/BB/70/d60b79d8-6618-4f86-a39f-b91229c57485.jpg.webp" alt="Drink" width="250" class="overflow-hidden bg-blue-400 bg-fixed opacity-1 transition duration-300 ease-in-out hover:opacity-80"/>
            </a> 
            
          </div>
    </div>

    <div class="flex flex-col  mx-10">
        
        <div class="divider bg-gray-500 h-1"></div> 
        
      </div>

        <div class="grid xl:grid-cols-5 gap-4 px-8 pb-5 md:grid-cols-2 sm:grid-cols-1 sm:grid">
            @foreach ($products as $product)
            <div class="bg-slate-800  py-5  flex flex-col items-center rounded-xl hover:scale-105 transition-transform hover:duration-300" >
                    <img  src="{{$product->img}}" alt="" width="200" class="rounded-xl">
                    <a href="{{route('customer.product',['id'=>$product->id])}}" class="text-white font-bold text-xl m-1 w-60 hover:underline py-2 truncate">{{$product->name}}</a>
                    <p class="text-blue-500 font-bold text-xl m-1">$1200.00</p>
            </div>
            
            @endforeach
        </div>
        <div id="fb-root"></div>

   </section>

@endsection

