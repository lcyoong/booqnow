{{ Form::open(['url' => urlTenant('resources/' . $resource_type->rty_id), 'method' => 'get']) }}
<div class="row">
  {{ Form::filterText('name', trans('resource.rs_name'), array_get($filter, 'name'), ['placeholder' => trans('resource.rs_name')]) }}
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary']) }}
<redirect-btn label="@lang('form.clear')" redirect="{{ urlTenant('resources/' . $resource_type->rty_id) }}"></redirect-btn>
{{ Form::close() }}
