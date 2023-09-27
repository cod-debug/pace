@extends('layouts.dashboard')
@section('title', 'Employee')
@section('content')
    <app-employee-list auth='{{ json_encode(auth()->user()) }}' />
@endsection