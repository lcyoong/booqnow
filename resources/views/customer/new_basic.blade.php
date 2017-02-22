@extends($layout)

@prepend('content')
<div id="customer-new">
<form-ajax action = "{{ urlTenant('customers/new') }}" method="POST" go-to-next="{{ urlTenant('bookings/new') }}" go-to-append-data = 1 @startwait="startWait" @endwait="endWait">
<div class="row">
  {{ Form::bsEmail('cus_email', trans('customer.cus_email')) }}
  {{ Form::bsSelect('cus_country', trans('customer.cus_country'), $countries, null, ['class' => 'select2', 'style' => 'width:100%']) }}
  {{ Form::bsText('cus_first_name', trans('customer.cus_first_name')) }}
  {{ Form::bsText('cus_last_name', trans('customer.cus_last_name')) }}
</div>
{{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
</form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
$(function() {
  $('.select2').select2()
});

new Vue({
  el: '#customer-new',
  mixins: [mixForm],
});

</script>
@endprepend
