@extends('layout.wrapper')

@section('content')
    <h1>Listado de Ventas</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Subtotal</th>
                <th>Total</th>
                <th>Moneda</th>
                <th>Estado</th>
                <th>Fecha de Creación</th>
                <!-- Agrega más columnas según tus necesidades -->
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->subtotal }}</td>
                    <td>{{ $sale->total }}</td>
                    <td>{{ $sale->moneda }}</td>
                    <td>{{ $sale->estado }}</td>
                    <td>{{ $sale->fecha_creacion }}</td>
                    <!-- Agrega más celdas según tus necesidades -->
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
