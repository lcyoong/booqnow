@extends($layout)

@push('content')

{{ Form::open(['url' => urlTenant('resource_types/update'), 'v-ajax']) }}
{{ Form::hidden('rty_id', $resource_type->rty_id) }}
<div class="row">
  {{ Form::bsText('rty_name', trans('resource_type.rty_name'), $resource_type->rty_name) }}
  {{ Form::bsText('rty_price', trans('resource_type.rty_price'), $resource_type->rty_price) }}
</div>
{{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary']) }}
{{ Form::close() }}
@endpush
