{{-- 
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>
 
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel=”stylesheet”>
  <link href="{{'css/app.css'}}" rel="stylesheet">
</head>

<body>

  <div id="app"> --}}

    @extends('layouts.app')

    @section('content')
 {{--  <v-app-bar fixed class="elevation-10">
      <v-app-bar-nav-icon></v-app-bar-nav-icon>
      <v-img src="https://oplus.pacificmedicalsuite.com/pacific-saas/images/home/pms-logo.png" position="start" height = "35px"  contain ></v-img>
      <v-spacer></v-spacer>
      <v-btn icon>
        <v-icon>mdi-bell</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon>mdi-heart</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon x-large>mdi-account-circle</v-icon>
      </v-btn>
    </v-app-bar > --}}

    <div class="conteiner">
      <div class="tableinfo">
        <v-app>
          <table-pacific-actions>
        </v-app>
      </div>
    </div> 
    

    @endsection

{{--   </div>

 

</body>

</html> --}}