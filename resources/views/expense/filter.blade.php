{{ Form::open(['url' => 'expenses', 'method' => 'get']) }}
<div class="row">
  {{ Form::filterText('name', trans('expense.exp_description'), array_get($filter, 'name'), ['placeholder' => trans('expense.exp_description')]) }}
  {{ Form::filterDate('start', trans('expense.exp_date_start'), array_get($filter, 'start')) }}
  {{ Form::filterDate('end', trans('expense.exp_date_end'), array_get($filter, 'end')) }}
  {{ Form::filterSelect('account', trans('expense.exp_account'), $account, array_get($filter, 'account'), ['class' => 'select2 form-control']) }}
  {{ Form::filterSelect('category', trans('expense.exp_category'), $category, array_get($filter, 'category'), ['class' => 'select2 form-control']) }}
  {{ Form::filterSelect('status', trans('expense.exp_status'), $rs_status, array_get($filter, 'status'), ['class' => 'select2 form-control']) }}
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary btn-sm']) }}
<a href="{{ url('expenses') }}">{{ Form::button(trans('form.clear'), ['class' => 'btn btn-primary btn-sm']) }}</a>
{{ Form::close() }}
