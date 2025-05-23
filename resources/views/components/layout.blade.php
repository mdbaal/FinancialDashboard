<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Financial Dashboard - {{ $title }}</title>

    <!-- Global Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

    <!-- Global Styles and js -->
    @vite(['resources/css/app.css'])
    @stack('styles')

    @prepend('scripts')
        @vite('resources/js/app.js')
    @endprepend

</head>
<body>
<x-header></x-header>
@if ( session('success') )
    <div class="alert alert-success drop-shadow-lg max-w-screen-xl mx-auto">
        {{ session('success') }}
    </div>
@endif

@if ( session('error') )
    <div class="alert alert-error drop-shadow-lg max-w-screen-xl mx-auto">
        {{ session('error') }}
    </div>
@endif

<div class="max-w-screen-xl mx-auto my-10">
    {{$slot}}
</div>

<x-footer></x-footer>
@stack('scripts')
</body>
</html>
