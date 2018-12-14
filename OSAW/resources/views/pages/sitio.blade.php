@extends('layouts.master')

@section('titulo', 'Sitio Web')

@section('content')
    <div class="container">
        Sitio -> {{$sitio->nombre}}
    </div>
@endsection