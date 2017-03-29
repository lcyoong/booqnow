{{ Form::open(['url' => 'users', 'method' => 'get']) }}
<div class="row">
  {{ Form::filterText('id', trans('user.id'), array_get($filter, 'id'), ['placeholder' => trans('user.id')]) }}
  {{ Form::filterText('name', trans('user.name'), array_get($filter, 'name'), ['placeholder' => trans('user.name')]) }}
  {{ Form::filterText('email', trans('user.email'), array_get($filter, 'email'), ['placeholder' => trans('user.email')]) }}
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary btn-sm']) }}
<redirect-btn label="@lang('form.clear')" redirect="{{ urlTenant('users') }}" class="btn-sm"></redirect-btn>
{{ Form::close() }}
