
@extends('layout.wrapper') @section('content')

@include('pages.conversations.modals.associate-franchise')

<div class="container-fluid">

    <div class="row page-titles">

    <!-- Page Title & Bread Crumbs -->
    @include('pages.conversations.misc.crumbs')
    <!--Page Title & Bread Crumbs -->

    </div>

    @if (session('success'))
        <div class="alert alert-success px-2">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger px-2">
            {{ session('error') }}
        </div>
    @endif

    <div class="row mt-5 px-3 card px-4 py-5">
        <form action="{{ route('whatsapp.update.meta.business.id') }}" method="POST" class=" radius">
            @csrf
            <div class="form-group">
                <h4 class="mb-4">ID del Negocio (business_id)</h4>
                <input type="text" class="form-control" style="width: 300px;" id="meta_business_id" name="meta_business_id" placeholder="Ingrese business_id brindado por Meta" value="{{ $meta_business_id ?? '' }}">
              </div>
            <button type="submit" class="btn btn-primary">Actualizar ID del Negocio</button>
        </form>

        <form action="{{ route('whatsapp.update.admin.token') }}" method="POST">
            @csrf
            <div class="form-group">
            <h4 class="mb-4 mt-4">Token de Administrador</h4>
                <input type="text" class="form-control" id="admin_token" name="admin_token" placeholder="Ingrese el token de administrador" value="{{ $token ?? '' }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Token</button>
        </form>

        @if(!empty($whatsAppAccounts))
            <div class="mt-4">
                <h4>Cuentas de WhatsApp Business</h4>
                <hr/>
                <div class="row">
                    @foreach($whatsAppAccounts as $account)
                        <div class="flex w-100 px-4 mx-3 card bg-primary text-white py-4 rounded">
                          <h5 class="card-title text-white">{{ $account['name'] }}</h5>
                          <p><strong>ID:</strong> {{ $account['id'] }}</p>
                          <h6 class="text-white">Números de Teléfono:</h6>
                          @if(!empty($account['phone_numbers']))
                                <ul>
                                @foreach($account['phone_numbers'] as $phone)
                                    <li>
                                        <strong>Nombre:</strong> {{ $phone['verified_name'] }}<br>
                                        <strong>Número:</strong> {{ $phone['display_phone_number'] }}<br>
                                        <strong>ID del Teléfono:</strong> {{ $phone['id'] }}<br>
                                        @php
                                            $franchise = $phone['franchise'] ?? null;
                                        @endphp
                                        @if($franchise)
                                            <p>Franquicia Asociada: {{ $franchise->name }}</p>
                                            <button class="btn btn-info btn-sm" onclick="event.preventDefault(); document.getElementById('disassociate-form-{{ $phone['id'] }}').submit();">
                                              <i class="sl-icon-close"></i> Desasociar
                                            </button>
                                            <form id="disassociate-form-{{ $phone['id'] }}" action="{{ route('whatsapp.disassociate', ['phone_id' => $phone['id']]) }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-info btn-sm associate-btn mt-3" data-toggle="modal" data-target="#associateModal" data-phoneid="{{ $phone['id'] }}" data-phonenumber="{{ $phone['display_phone_number'] }}">
                                                <i class="sl-icon-target"></i> Asociar a una Franquicia
                                            </button>
                                        @endif
                                    </li>
                                @endforeach
                                </ul>
                            @else
                                <p>No hay números de teléfono asociados.</p>
                          @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="mt-4">
                <h4>No se encontraron cuentas de WhatsApp Business.</h4>
            </div>
        @endif
    </div>


@endsection