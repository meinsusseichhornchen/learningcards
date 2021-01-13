@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <app-collection-compose
            action="{{ route('store_collection') }}"
            csrf="{{ csrf_token() }}"
            :errors="{{ json_encode($errors->messages()) }}"
        >
        </app-collection-compose>
    @else
        <app-collection-compose
                action="{{ route('store_collection') }}"
                csrf="{{ csrf_token() }}"
        >
        </app-collection-compose>
    @endif

@endsection