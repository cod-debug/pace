@extends('layouts.dashboard')
@section('title', 'Employee')
@section('content')
    <app-employee-record selected_id="{{$id}}" auth='{{ json_encode(auth()->user()) }}'  />
@endsection