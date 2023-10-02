@extends('layouts.dashboard')
@section('title', 'Employee')
@section('content')
    <app-employee-add  selected_id="{{isset($id) ? $id : false}}" />
@endsection