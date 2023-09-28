@extends('layouts.dashboard')
@section('title', 'Offices')
@section('content')
    <app-office auth="{{ auth()->user() }}" />
@endsection