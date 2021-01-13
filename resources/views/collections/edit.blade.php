@extends('layouts.app')

@section('content')
    <app-collections-edit
            :collection="{{ json_encode($collection) }}"
            action="{{ route('update_collection') }}"
            csrf="{{ csrf_token() }}"
    ></app-collections-edit>
@endsection