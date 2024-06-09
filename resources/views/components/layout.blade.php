<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Financial Dashboard - {{ $title }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<x-header></x-header>

<div class="max-w-screen-xl mx-auto my-10">
    {{$slot}}
</div>

<x-footer></x-footer>
</body>
</html>
