<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Laravel</title>
  <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel=”stylesheet”>
  <link href="{{'css/app.css'}}" rel="stylesheet">
</head>

<body>
  <div id="app">
        <main class="py-1">
              @yield('content')
        </main>
    </div>
    <script src="{{'js/app.js'}}"></script>
</body>
</html>
