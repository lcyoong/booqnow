@extends('layouts.master')
@section('content')
<div class="container">
  <h1>Sign Up</h1>
{{ Form::open(['url' => 'signup']) }}
{{ Form::text('name') }}
{{ Form::email('email') }}
{{ Form::password('password') }}
{{ Form::submit('Sign') }}
{{ Form::close() }}
</div>
@endsection
