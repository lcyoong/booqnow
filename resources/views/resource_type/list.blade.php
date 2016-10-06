@extends('layouts.tenant')

@section('content_tenant')
<a href="{{ urlTenant('resource_types/new') }}">{{ Form::button(Lang::get('form.new'), ['class' => 'btn btn-primary']) }}</a>
@foreach ($resource_types as $type)
<div class="row">
  <div class="col-md-2">{{ $type->rty_name }}</div>
  <div class="col-md-2">{{ $type->rty_price }}</div>
  <div class="col-md-2"><a href="{{ urlTenant(sprintf('resource_types/%s/edit', $type->rty_id)) }}">@lang('form.edit')</a></div>
</div>
@endforeach
@endsection
