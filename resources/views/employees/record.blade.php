@extends('layouts.dashboard')
@section('title', 'Employee')
@section('content')
    <app-employee-record selected_id="{{$id}}" />
@endsection