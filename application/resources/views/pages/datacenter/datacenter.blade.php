@extends('layout.wrapper') @section('content')
<!-- main content -->
<div class="container-fluid">


    <div id="js-trigger-home-admin-wrapper">

        @include('pages.datacenter.first-row.wrapper')
        
        @include('pages.datacenter.second-row.wrapper')
        
        <div> <br> </div>
        
        @include('pages.datacenter.third-row.wrapper')

        @include('pages.datacenter.fourth-row.wrapper')
                
    </div>     


</div>




    

      
<!--main content -->
@endsection