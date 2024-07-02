@extends('template')

@section('aside')
    @include('partials.aside.pegawai')
@endsection

@section('content-header')

@endsection

@section('content')
<h1>Selamat datang {{$user->first_name}} {{$user->last_name}}</h1>

@endsection
