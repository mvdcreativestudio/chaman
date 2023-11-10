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
        <div>

            <div class="p-b-10 align-right">
                
                <span class="badge badge-pill badge-success p-t-4 p-l-12 p-r-12">Activa</span>
                
                
            </div>
            
            <small class="text-muted">Asignada a:</small>
            <h6></h6>
            <small class="text-muted">Valor:</small>
            <h6>$10.000/$11.000</h6>
            <small class="text-muted">Fecha Objetivo: 17/12</small>
            <small class="text-muted">Descripción:</small>
            
        </div>
    </div>
       
     

        
    
    </div>
    <!-- Main content -->
@endsection