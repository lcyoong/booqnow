{{ Form::open(['url' => 'agents', 'method' => 'get']) }}
<div class="row">
  {{ Form::filterText('name', trans('agent.ag_name'), array_get($filter, 'name'), ['placeholder' => trans('agent.ag_name')]) }}
  {{ Form::filterSelect('status', trans('agent.ag_status'), $rs_status, array_get($filter, 'status'), ['class' => 'select2 form-control']) }}
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary btn-sm']) }}
<a href="{{ url('agents') }}">{{ Form::button(trans('form.clear'), ['class' => 'btn btn-primary btn-sm']) }}</a>
{{ Form::close() }}
