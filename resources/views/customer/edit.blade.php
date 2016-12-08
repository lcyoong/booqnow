@extends($layout)

@push('content')
{{ Form::open(['url' => 'customers/update', 'v-ajax', 'class' => '']) }}
{{ Form::hidden('cus_id', $customer->cus_id) }}
<div class="row">
  {{ Form::bsText('cus_first_name', trans('customer.cus_first_name'), $customer->cus_first_name) }}
  {{ Form::bsText('cus_last_name', trans('customer.cus_last_name'), $customer->cus_last_name) }}
</div>
<div class="row">
  {{ Form::bsEmail('cus_email', trans('customer.cus_email'), $customer->cus_email) }}
  {{ Form::bsText('cus_contact1', trans('customer.cus_contact1'), $customer->cus_contact1) }}
  {{ Form::bsText('cus_contact2', trans('customer.cus_contact2'), $customer->cus_contact2) }}
</div>
<div class="row">
  {{ Form::bsSelect('cus_country', trans('customer.cus_country'), $countries, $customer->cus_country, ['class' => 'select2']) }}
  {{ Form::bsTextarea('cus_address', trans('customer.cus_address'), $customer->cus_address) }}
</div>
{{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary']) }}
<redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('customers') }}"></redirect-btn>
{{ Form::close() }}
@endpush
