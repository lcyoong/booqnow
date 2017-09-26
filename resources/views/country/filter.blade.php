{{ Form::open(['url' => 'countries', 'method' => 'get']) }}
<div class="row">
  {{ Form::filterText('name', trans('country.coun_name'), array_get($filter, 'name'), ['placeholder' => trans('country.coun_name')]) }}
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary btn-sm']) }}
<redirect-btn label="@lang('form.clear')" redirect="{{ urlTenant('countries') }}" class="btn-sm"></redirect-btn>
{{ Form::close() }}
