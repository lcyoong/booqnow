@extends($layout)

@push('content')
{{ Form::open(['url' => 'customers/new', 'v-ajax', 'goto' => urlTenant('customers')]) }}
<div class="row">
  {{ Form::bsText('cus_first_name', trans('customer.cus_first_name')) }}
  {{ Form::bsText('cus_last_name', trans('customer.cus_last_name')) }}
</div>
<div class="row">
  {{ Form::bsText('cus_contact1', trans('customer.cus_contact1')) }}
  {{ Form::bsText('cus_contact2', trans('customer.cus_contact2')) }}
  {{ Form::bsEmail('cus_email', trans('customer.cus_email')) }}
</div>
<div class="row">
  {{ Form::bsSelect('cus_country', trans('customer.cus_country'), $countries, null, ['class' => 'select2']) }}
  {{ Form::bsTextarea('cus_address', trans('customer.cus_address')) }}
</div>
{{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary']) }}
<redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('customers') }}"></redirect-btn>
{{ Form::close() }}
@endpush
