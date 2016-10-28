@extends('layouts.tenant')

@section('content_tenant')

{{ Form::open(['url' => 'merchants/new', 'v-ajax', 'class' => 'form-horizontal']) }}
{{ Form::bsHText('mer_name', trans('merchant.mer_name')) }}
{{ Form::bsHSelect('mer_country', trans('merchant.mer_country'), $countries) }}
{{ Form::submit(trans('form.create'), ['class' => 'btn btn-primary']) }}
{{ Form::close() }}
@endsection
