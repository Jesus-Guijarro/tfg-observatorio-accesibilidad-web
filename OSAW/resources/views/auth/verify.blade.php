@extends('layouts.master')

@section('titulo', 'Verificar correo electrónico')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Verificar correo electrónico</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Se ha enviado un enlace de verificación de correo a tu correo electrónico de registro.
                        </div>
                    @endif

                    Antes de seguir, comprueba que hayas verificado tu correo electrónico
                    {{ __('Si  no has recibido el enlace ') }}, <a href="{{ route('verification.resend') }}">{{ __('haz click aquí') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
