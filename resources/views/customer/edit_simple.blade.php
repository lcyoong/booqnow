<div>
<div style="font-weight: bold; font-size: 1.1em;"><i class="fa fa-user-circle-o"></i> Guest </div>
  <!-- <a v-modal href="{{ url(sprintf('trail/customers/%s', $customer->cus_id)) }}" title="@lang('form.trail')"><i class="fa fa-history"></i></a> -->
  <form-ajax action = "{{ urlTenant('customers/update') }}" method="POST" @startwait="startWait" @endwait="endWait" @completesuccess="profileSaved">
  {{ Form::hidden('cus_id', $customer->cus_id) }}
  <div class="row">
    {{ Form::bsText('cus_first_name', trans('customer.cus_first_name'), null, ['v-model'=>'customer.cus_first_name']) }}
    {{ Form::bsText('cus_last_name', trans('customer.cus_last_name'), null, ['v-model'=>'customer.cus_last_name']) }}
    {{ Form::bsSelect('cus_country', trans('customer.cus_country'), $countries, null, ['class' => 'select2', 'style' => 'width:100%', 'v-model'=>'customer.cus_country']) }}
  </div>
  <div class="row">
    {{ Form::bsEmail('cus_email', trans('customer.cus_email'), null, ['v-model'=>'customer.cus_email']) }}
    {{ Form::bsText('cus_contact1', trans('customer.cus_contact1'), null, ['v-model'=>'customer.cus_contact1']) }}
    {{ Form::bsText('cus_contact2', trans('customer.cus_contact2'), null, ['v-model'=>'customer.cus_contact2']) }}
  </div>
  {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
  <a href="#" @click="edit_profile = 0">{{ Form::button(trans('form.cancel'), ['class' => 'btn btn-primary btn-sm']) }}</a>
  </form-ajax>
</div>