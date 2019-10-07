<form-ajax action = "{{ urlTenant('reports/request') }}" method="POST" @startwait="startWait" @endwait="endWait" :reload-on-complete=true>
  {{ Form::hidden('rep_function', $type) }}
  {{ Form::hidden('rep_class', 'Reports\ExportExpensesExcel') }}
<div class="row">
  {{ Form::filterDate('rep_filter[start]', trans('expense.exp_date_start'), array_get($filter, 'start')) }}
  {{ Form::filterDate('rep_filter[end]', trans('expense.exp_date_end'), array_get($filter, 'end')) }}
  {{ Form::filterSelect('rep_filter[method]', trans('expense.exp_method'), $exp_methods, array_get($filter, 'method'), ['class' => 'select2', 'style' => 'width: 100%']) }}
  {{ Form::filterSelect('rep_filter[category]', 'Category', $category, array_get($filter, 'category'), ['class' => 'select2', 'style' => 'width: 100%']) }}
  {{ Form::filterText('rep_filter[payable]', trans('expense.exp_payable'), array_get($filter, 'payable'), ['placeholder' => trans('expense.exp_payable')]) }}
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary']) }}
<redirect-btn label="@lang('form.clear')" redirect="{{ urlTenant('reports/export_expenses') }}"></redirect-btn>
</form-ajax>
