@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <app-card-compose
            action="{{ route('store_card_collection', ['collection' => $collection->id]) }}"
            csrf="{{ csrf_token() }}"
            :errors="{{ json_encode($errors->messages()) }}"
        >
        </app-card-compose>
    @else
        <app-card-compose
            action="{{ route('store_card_collection', ['collection' => $collection->id]) }}"
            csrf="{{ csrf_token() }}"
        >
        </app-card-compose>
    @endif
@endsection