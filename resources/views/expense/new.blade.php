@extends($layout)

@prepend('content')
<div id="expense-new">
<form-ajax action = "{{ urlTenant('expenses/new') }}" method="POST" redirect-on-complete="{{ urlTenant('expenses') }}" @startwait="startWait" @endwait="endWait">
  <div class="row">
    {{ Form::bsDate('exp_date', trans('expense.exp_date')) }}
    {{ Form::bsText('exp_description', trans('expense.exp_description')) }}
    {{ Form::bsText('exp_memo', trans('expense.exp_memo')) }}
  </div>
  <div class="row">
    {{ Form::bsSelect('exp_account', trans('expense.exp_account'), $account) }}
    {{ Form::bsSelect('exp_category', trans('expense.exp_category'), $category, null, ['class' => 'form-control select2']) }}
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
