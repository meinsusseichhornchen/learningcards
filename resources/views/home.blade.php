@extends('layouts.app')

@section('content')
    <app-navbar></app-navbar>

    <div class="flex">
        <home></home>
        <app-accordion-list></app-accordion-list>
    </div>
@endsection