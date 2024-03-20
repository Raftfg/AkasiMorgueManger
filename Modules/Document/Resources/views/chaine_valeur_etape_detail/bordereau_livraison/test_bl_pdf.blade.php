@extends('document::layouts.master')

@section('content')
    <h1>{{ $titrePage }}</h1>

    <p>
        {!! $description !!}
    </p>
    
    <p style="text-align: center;">{!! $footer !!}</p>
@endsection
