@extends($layout)

@prepend('content')
<div id="expense-category-edit">
<form-ajax action = "{{ urlTenant('expenses_category/update') }}" method="POST" redirect-on-complete="{{ urlTenant('expenses_category') }}" @startwait="startWait" @endwait="endWait">
  {{ Form::hidden('exc_id', $category->exc_id) }}
  <div class="row">
    {{ Form::bsText('exc_name', trans('expense_category.exc_name'), $category->exc_name) }}
    {{ Form::showField($category->creator->name, trans('form.created_by')) }}
    {{ Form::showField($category->created_at, trans('form.created_at')) }}
  </div>
  {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
  <redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('expenses_category') }}" class="btn-sm"></redirect-btn>
</form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#expense-category-edit",

  mixins: [mixForm],

  data: {
  },

  methods: {
  }

})

</script>
@endprepend
