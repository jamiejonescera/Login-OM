@extends('layout')
@section('title', 'Homepage')
@section('content')
    {{ auth()->user()->name}}
@endsection