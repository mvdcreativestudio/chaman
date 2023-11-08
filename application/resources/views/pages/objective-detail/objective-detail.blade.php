@extends('layout.wrapper') @section('content')


   

    <!-- Main content -->
    <div class="container-fluid">
        <div class="row page-titles">
            <!-- Page Title & Bread Crumbs -->
            @include('pages.objective-detail.misc.crumbs')
            <!-- Page Title & Bread Crumbs -->

            <!-- action buttons -->
            @include('pages.objective-detail.misc.actions')
             <!-- action buttons -->
        </div>

        <div class="objective-detail">
        <img src="imagen.jpg" alt="Imagen">
        <h1>Título del elemento</h1>
        <p>Descripción del elemento.</p>
        <p>Precio: $100</p>
    </div>
       
     

        
    
    </div>
    <!-- Main content -->
@endsection