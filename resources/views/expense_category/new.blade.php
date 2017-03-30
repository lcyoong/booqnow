@extends($layout)

@prepend('content')
<div id="expense-category-new">
<form-ajax action = "{{ urlTenant('expenses_category/new') }}" method="POST" redirect-on-complete="{{ urlTenant('expenses_category') }}" @startwait="startWait" @endwait="endWait">
  <div class="row">
    {{ Form::bsText('exc_name', trans('expense_category.exc_name')) }}
  </div>
  {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
  <redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('expenses_category') }}" class="btn-sm"></redirect-btn>
</form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#expense-category-new",

  mixins: [mixForm],

  data: {
  },

  methods: {
  }

})

</script>
@endprepend
