@extends('layouts.master')
@section('navbar')
  @include('partials.navbar')
@endsection

@section('content')
  <h2>{{ $page_title or '' }}</h2>
  @yield('content_tenant')
@endsection

@section('script')
  @yield('script_tenant')
@endsection
