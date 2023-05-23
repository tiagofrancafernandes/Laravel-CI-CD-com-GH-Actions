@extends('layouts.base')

@section('body')
@hasSection ('content')
    @yield('content')
@else
    @isset($slot)
        {{ $slot }}
    @endisset
@endif
@endsection
