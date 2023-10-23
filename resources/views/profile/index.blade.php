@extends('layouts.dashboard')
@section('title', 'Offices')
@section('content')
    <app-profile-index auth="{{ auth()->user() }}" />
@endsection