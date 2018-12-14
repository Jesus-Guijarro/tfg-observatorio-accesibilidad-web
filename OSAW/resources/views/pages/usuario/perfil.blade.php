@extends('layouts.master')

@section('titulo', 'Perfil usuario')

@section('content')
    <div class="container">
        Usuario {{$user->nombre}}
    </div>
@endsection