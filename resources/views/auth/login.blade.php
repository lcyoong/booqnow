@extends('layouts.master')
@section('content')
<div class="container">
  <h1>Log In</h1>
  {{ Form::open(['url' => 'login']) }}
  {{ Form::email('email') }}
  {{ Form::password('password') }}
  {{ Form::submit('Sign') }}
  {{ Form::close() }}
</div>
@endsection
