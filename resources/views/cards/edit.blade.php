@extends('layouts.app')

@section('content')
    @if ($errors->any()))
    <app-card-edit
            :card="{{ json_encode($card) }}"
            action="{{ route('update_card', ['card' => $card->id]) }}"
            :links="{{ json_encode($links) }}"
            csrf="{{ csrf_token() }}"
            :errors="{{ json_encode($errors->messages()) }}"
    >
    </app-card-edit>
    @else
        <app-card-edit
            :card="{{ json_encode($card) }}"
            action="{{ route('update_card', ['card' => $card->id]) }}"
            :links="{{ json_encode($links) }}"
            csrf="{{ csrf_token() }}"
        >
        </app-card-edit>
    @endif
@endsection