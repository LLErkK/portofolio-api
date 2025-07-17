@extends('layouts.app')

@section('content')
    <h1>Selamat Datang, {{ auth()->user()->name }}</h1>
    <p>Ini adalah halaman dashboard admin.</p>
@endsection
