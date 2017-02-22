@extends($layout)

@push('content')
<div id="customer-edit">
<form-ajax action = "{{ urlTenant('customers/update') }}" method="POST">
<!-- {{ Form::hidden('cus_id', $customer->cus_id, ['v-model' => 'cus_id']) }} -->
<input type="hidden" name="cus_id" v-model="cus_id">
<div class="row">
  {{ Form::bsText('cus_first_name', trans('customer.cus_first_name'), null, ['v-model' => 'item.cus_first_name']) }}
  {{ Form::bsText('cus_last_name', trans('customer.cus_last_name'), null, ['v-model' => 'item.cus_last_name']) }}
</div>
<div class="row">
  {{ Form::bsEmail('cus_email', trans('customer.cus_email'), $customer->cus_email) }}
  {{ Form::bsText('cus_contact1', trans('customer.cus_contact1'), $customer->cus_contact1) }}
  {{ Form::bsText('cus_contact2', trans('customer.cus_contact2'), $customer->cus_contact2) }}
</div>
<div class="row">
  {{ Form::bsSelect('cus_country', trans('customer.cus_country'), $countries, 0, ['class' => 'select2', 'v-model' => 'item.cus_country']) }}
  {{ Form::bsTextarea('cus_address', trans('customer.cus_address'), $customer->cus_address) }}
</div>
{{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary']) }}
<redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('customers') }}"></redirect-btn>
</form-ajax>
</div>
@endpush

@push('scripts')
<script>
new Vue ({
  el: "#customer-edit",

  created: function () {
    console.log("vue ready")

    // console.log()
    this.cus_id = {{ $customer->cus_id }}

    this.getCustomer()
  },

  methods: {
    getCustomer: function () {
      this.$http.get("{{ urlTenant("api/v1/customers") }}/" + this.cus_id)
          .then(function (response) {
            console.log(response.data)
            this.item = response.data
          });
    }
  },

  data: {
    cus_id: 0,
    item: {
      cus_first_name: '',
      cus_last_name: '',
      cus_country: '',
    },
  }
})
</script>
@endpush
