@extends($layout)

@prepend('content')
<div id="customer-edit">
  <!-- <a v-modal href="{{ url(sprintf('trail/customers/%s', $customer->cus_id)) }}" title="@lang('form.trail')"><i class="fa fa-history"></i></a> -->
  <form-ajax action = "{{ urlTenant('customers/update') }}" method="POST" @startwait="startWait" @endwait="endWait">
  {{ Form::hidden('cus_id', $customer->cus_id) }}
  <div class="row">
    {{ Form::bsText('cus_first_name', trans('customer.cus_first_name'), $customer->cus_first_name) }}
    {{ Form::bsText('cus_last_name', trans('customer.cus_last_name'), $customer->cus_last_name) }}
    {{ Form::bsSelect('cus_country', trans('customer.cus_country'), $countries, $customer->cus_country, ['class' => 'select2', 'style' => 'width:100%']) }}
  </div>
  <div class="row">
    {{ Form::bsEmail('cus_email', trans('customer.cus_email'), $customer->cus_email) }}
    {{ Form::bsText('cus_contact1', trans('customer.cus_contact1'), $customer->cus_contact1) }}
    {{ Form::bsText('cus_contact2', trans('customer.cus_contact2'), $customer->cus_contact2) }}
  </div>
  <div class="row">
    {{ Form::bsTextarea('cus_address', trans('customer.cus_address'), $customer->cus_address) }}
    {{ Form::bsSelect('cus_status', trans('customer.cus_status'), $cus_status, $customer->cus_status, ['class' => 'select2', 'style' => 'width:100%']) }}
  </div>
  {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
  <a href="{{ url('customers') }}">{{ Form::button(trans('form.cancel'), ['class' => 'btn btn-primary btn-sm']) }}</a>
  </form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#customer-edit",

  mixins: [mixForm],
})
</script>
@endprepend
