@extends($layout)

@prepend('content')
<div id="bill-new">
<form-ajax action = "{{ urlTenant('bills/new') }}" method="POST" redirect-on-complete = "{{ urlTenant('bills') }}" @startwait="startWait" @endwait="endWait">
<div class="row">
  {{ Form::bsText('bil_description', trans('bill.bil_description')) }}
</div>
{{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
<redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('bills') }}" class="btn-sm"></redirect-btn>
<!-- {{ Form::close() }} -->
</form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#bill-new",

  mixins: [mixForm],

})

</script>
@endprepend
