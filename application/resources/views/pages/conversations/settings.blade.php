@extends('layout.wrapper') @section('content')
<div class="container-fluid">

    <div class="row page-titles">

    <!-- Page Title & Bread Crumbs -->
    @include('pages.conversations.misc.crumbs')
    <!--Page Title & Bread Crumbs -->

    </div>

    <div class="container mt-5">
        <form>
          <div class="form-group">
            <label for="inputTexto">Número de teléfono</label>
            <input type="text" class="form-control" id="inputTexto" placeholder="Ingrese su texto">
          </div>
          <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
      </div>


@endsection