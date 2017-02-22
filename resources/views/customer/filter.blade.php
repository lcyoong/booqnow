{{ Form::open(['url' => 'customers', 'method' => 'get']) }}
<div class="row">
  {{ Form::filterText('name', trans('customer.full_name'), array_get($filter, 'name'), ['placeholder' => trans('customer.full_name')]) }}
  {{ Form::filterText('contact1', trans('customer.cus_contact1'), array_get($filter, 'contact1')) }}
  {{ Form::filterText('email', trans('customer.cus_email'), array_get($filter, 'email')) }}
  {{ Form::filterSelect('country', trans('customer.cus_country'), $countries, array_get($filter, 'country'), ['class' => 'select2', 'style' => 'width: 100%']) }}
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary btn-sm']) }}
<a href="{{ url('customers') }}">{{ Form::button(trans('form.clear'), ['class' => 'btn btn-primary btn-sm']) }}</a>
{{ Form::close() }}
