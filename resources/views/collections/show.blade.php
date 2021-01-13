@extends('layouts.app')

@section('content')
    <app-collection-show
            :collection="{{ $collection->id }}"
            :links="{{ json_encode([
                'create_card_collection' => route('create_card_collection' , ['collection' => $collection->id])
            ]) }}"
    ></app-collection-show>

@endsection