@extends('layouts.master')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
    {!! Form::open(['url' => 'merchant']) !!}
    @lang('merchant.mer_name'): {{ Form::text('mer_name') }}
    {!! Form::close() !!}
    </div>
  </div>
</div>
@endsection
