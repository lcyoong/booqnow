@extends('layouts.modal')

@section('content_modal')
{{ Form::open(['url' => Request::url(), 'v-ajax', 'class' => 'form-horizontal']) }}
<sample></sample>
{{ Form::submit(trans('form.add'), ['class' => 'btn btn-primary']) }}
{{ Form::close() }}
@endsection
