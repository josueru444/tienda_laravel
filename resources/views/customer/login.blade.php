@extends('layouts.nav')

@section('content')
    <section class="flex m-auto justify-center h-full w-full items-center" >
            <div class="h-80 pb-11 w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="">
                    <h1 class="mb-10 mt-3 text-xl text-center font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Ingresar / Registrar
                    </h1>
                    <div class="flex flex-col items-center">
                    <a class="flex gap-x-4 border-2 mx-8 w-72 hover:text-white border-gray-500 rounded-xl hover:border-gray-400 py-2 px-2 text-gray-500 font-semibold text-xl" href="google-auth/redirect"><img src="{{ asset('images/icons/google.webp') }}" alt="icono de google" width="30" height="30">
                    Ingresar con Google</a>
                    
                    {{-- <a href="{{ route('auth.redirect') }}" class="flex items-center w-72 justify-center  px-4 py-2 mt-2 space-x-3 text-xl text-center bg-blue-500 text-white transition-colors duration-200 transform border rounded-lg dark:text-gray-300 dark:border-gray-300 hover:bg-gray-600 dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                        </svg>
                        <span class="text-sm text-white dark:text-gray-200">Iniciar sesión con Facebook</span>
                    </a> --}}

                    <a href="#" class="flex items-center w-72 justify-center  px-4 py-2 mt-2 space-x-3 text-xl text-center bg-blue-500 text-white transition-colors duration-200 transform border rounded-lg dark:text-gray-300 dark:border-gray-300 hover:bg-gray-600 dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                        </svg>
                        <span class="text-sm text-white dark:text-gray-200">Iniciar sesión con Facebook</span>
                    </a>
                    </div>
        
                </div>
            </div>
    </section>
    
    
    
@endsection