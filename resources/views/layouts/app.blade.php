<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VERO Web Portal') }}</title>


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@19.2.16/build/css/intlTelInput.css">
    <link rel="stylesheet" href="{{ asset('/css/style.css').'?v='.config('app.version') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>

</head>
<body class="antialiased">
<div class="min-h-screen bg-gray-100 pb-20">

  
    @yield('content')

</div>

</main>


<footer class="bg-white rounded-lg  dark:bg-gray-900 m-4 ">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
        
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
              

            </ul>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">Developed By Nader Humaid</span>
    </div>
</footer>
<script src="{{ asset('/js/main.js')}}"></script>

</body>
</html>
