@extends($layout)

@push('content')
{{ Form::open(['url' => urlTenant('resources/update'), 'v-ajax']) }}
{{ Form::hidden('rs_id', $resource->rs_id) }}
<div class="row">
  {{ Form::bsText('rs_name', trans('resource.rs_name'), $resource->rs_name) }}
  {{ Form::bsText('rs_price', trans('resource.rs_price'), $resource->rs_price) }}
</div>
<div class="row">
  {{ Form::bsTextarea('rs_description', trans('resource.rs_description'), $resource->rs_description) }}
</div>
{{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary']) }}
<redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('resources') }}"></redirect-btn>
{{ Form::close() }}
@endpush
