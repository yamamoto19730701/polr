@extends('layouts.base')

@section('css')
    <link rel='stylesheet' href='/css/aboutbakjp.css' />
@endsection

@section('content')
    <div>
        <img class='bakjplogo-img' src='/img/bakjplogo.png' />
    </div>

    <div class='about-contents'>
        {{env('APP_NAME')}} is serviced by <a href="https://tailshape.jp/" target="_new">Tailshape Inc.</a><br>
        <br>
        {{env('APP_NAME')}} is powered by <a href="{{ route('about') }}">Polr 2</a>, an open source, minimalist link shortening platform.<br>
        <br>
        This product includes GeoLite2 data created by MaxMind, available from<br>
        <a href="http://www.maxmind.com">http://www.maxmind.com</a>.
    </div>
@endsection

