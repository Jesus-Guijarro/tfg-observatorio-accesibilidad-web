@extends('layouts.master')

@section('titulo', 'Pagina de inicio')

@section('content')
<div class="container">
    <div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        You are logged in!
    </div>
</div>
@endsection
