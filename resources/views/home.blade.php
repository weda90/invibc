@extends('layouts.app')

@section('content')
    <div class="note note-info">
        <p> A black page template with a minimal dependency assets to use as a base for any custom page you create </p>
    </div>
    {{ dump(Config::get('database')) }}
    {{-- {{ var_dump( get_class_methods(new Config)) }} --}}
@endsection
