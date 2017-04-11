@extends($layout)

@prepend('content')
<div id="bill-new">
<form-ajax action = "{{ urlTenant('bills/new') }}" method="POST" redirect-on-complete = "{{ urlTenant('bills') }}" @startwait="startWait" @endwait="endWait">
  {{ Form::hidden('bil_customer', null, ['v-model' => 'bil_customer']) }}
  <div class="row">
    {{ Form::bsText('bil_description', trans('bill.bil_description')) }}
    {{ Form::bsDate('bil_date', trans('bill.bil_date')) }}
    <div class="col-md-3">
      <autocomplete :suggestions="customers" :selection="value" @selected="setCustomer"></autocomplete>
    </div>
  </div>
  {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
  <redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('bills') }}" class="btn-sm"></redirect-btn>
</form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#bill-new",

  mixins: [mixForm],

  created: function () {
    this.getCustomers()
  },

  data: {
    customers : [],
    value: '',
    bil_customer: '',
  },

  methods: {
    getCustomers: function () {
      this.$http.get("{{ urlTenant("api/v1/customers/active") }}")
          .then(function (response) {
            this.customers = response.data
          });
    },

    setCustomer: function (value) {
      this.bil_customer = value.id
    },

  }

})

</script>
@endprepend
