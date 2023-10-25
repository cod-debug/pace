@extends('layouts.dashboard')
@section('title', 'Users')
@section('content')
    <app-user-index auth='{{ json_encode(auth()->user()) }}'  />
@endsection