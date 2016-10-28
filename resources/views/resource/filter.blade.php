{{ Form::open(['url' => 'resources', 'method' => 'get']) }}
<div class="row">
  {{ Form::filterText('name', trans('resource.rs_name'), array_get($filter, 'name'), ['placeholder' => trans('resource.rs_name')]) }}
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary']) }}
<redirect-btn label="@lang('form.clear')" redirect="resources"></redirect-btn>
{{ Form::close() }}
