@extends($layout)

@prepend('content')
<div id="expense-new">
<form-ajax action = "{{ urlTenant("expenses/update") }}" method="POST" redirect-on-complete="{{ urlTenant('expenses') }}" @startwait="startWait" @endwait="endWait">
  {{ Form::hidden('exp_id', $id) }}
  <div class="row">
    {{ Form::bsDate('exp_date', trans('expense.exp_date'), $expense->exp_date) }}
    {{ Form::bsText('exp_description', trans('expense.exp_description'), $expense->exp_description) }}
    {{ Form::bsText('exp_amount', trans('expense.exp_amount'), $expense->exp_amount) }}
    {{ Form::bsText('exp_memo', trans('expense.exp_memo'), $expense->exp_memo) }}
  </div>
  <div class="row">
    {{ Form::bsSelect('exp_account', trans('expense.exp_account'), $account, $expense->exp_account) }}
    {{ Form::bsSelect('exp_category', trans('expense.exp_category'), $category, $expense->exp_category, ['class' => 'form-control select2']) }}
    {{ Form::bsSelect('exp_status', trans('expense.exp_status'), $rs_status, $expense->exp_status) }}
  </div>
  <div class="row">
    {{ Form::showField($expense->creator->name, trans('form.created_by')) }}
    {{ Form::showField($expense->created_at, trans('form.created_at')) }}
  </div>
  {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
  <redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('expenses') }}" class="btn-sm"></redirect-btn>
</form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#expense-new",

  mixins: [mixForm],

  created: function () {
    $(function() {
      $('.select2').select2()

      $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
      })

    })
  },

  data: {
  },

  methods: {
  }

})

</script>
@endprepend
