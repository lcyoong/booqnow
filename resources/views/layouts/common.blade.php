@extends('layouts.master')
@section('content')
<h2>{{ $page_title or '' }}</h2>
@yield('content_common')
@endsection
