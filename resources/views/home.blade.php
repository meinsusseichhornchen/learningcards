@extends('layouts.app')

@section('content')
    <div class="relative">
        <button class="bg-gray absolute right-0 text-hiro py-2 px-2">
            <svg class="fill-current w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    <div class="flex">
        <h1 class="w-100 block border-b-2 border-corn">{{ __('My Collections') }}</h1>
    </div>
    <div class="flex">
        <app-accordion-list></app-accordion-list>
    </div>
@endsection