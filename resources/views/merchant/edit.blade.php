@extends('layouts.tenant')

@section('content_tenant')

{{ Form::open(['url' => 'merchants/update', 'v-ajax', 'class' => 'form-horizontal']) }}
{{ Form::hidden('mer_id', $merchant->mer_id) }}
{{ Form::bsHText('mer_name', trans('merchant.mer_name'), $merchant->mer_name) }}
{{ Form::bsHSelect('mer_country', trans('merchant.mer_country'), $countries, $merchant->mer_country) }}

@foreach(config('merchant.setting') as $setting)
{{ Form::bsHText($setting, '', array_get($mer_setting, $setting)) }}
@endforeach

{{ Form::submit('Sign', ['class' => 'btn btn-primary']) }}
{{ Form::close() }}
@endsection
