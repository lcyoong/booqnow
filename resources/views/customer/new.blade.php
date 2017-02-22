@extends($layout)

@prepend('content')
<div id="customer-new">
<!-- {{ Form::open(['url' => 'customers/new', 'v-ajax', 'goto' => urlTenant('customers')]) }} -->
<form-ajax action = "{{ urlTenant('customers/new') }}" method="POST" redirect-on-complete = "{{ urlTenant('customers') }}" @startwait="startWait" @endwait="endWait">
<div class="row">
  {{ Form::bsText('cus_first_name', trans('customer.cus_first_name')) }}
  {{ Form::bsText('cus_last_name', trans('customer.cus_last_name')) }}
  {{ Form::bsSelect('cus_country', trans('customer.cus_country'), $countries, null, ['class' => 'select2', 'style' => 'width: 100%']) }}
</div>
<div class="row">
  {{ Form::bsEmail('cus_email', trans('customer.cus_email')) }}
  {{ Form::bsText('cus_contact1', trans('customer.cus_contact1')) }}
  {{ Form::bsText('cus_contact2', trans('customer.cus_contact2')) }}
</div>
<div class="row">
  {{ Form::bsTextarea('cus_address', trans('customer.cus_address')) }}
</div>
{{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
<redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('customers') }}" class="btn-sm"></redirect-btn>
<!-- {{ Form::close() }} -->
</form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#customer-new",

  mixins: [mixForm],

})

</script>
@endprepend
