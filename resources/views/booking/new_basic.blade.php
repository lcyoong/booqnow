@extends($layout)

@prepend('content')
<div id="booking-new-basic">
<h3><i class="fa fa-bed"></i> @{{ resource.rs_name }} <u>{{ showDate($start) }}</u> @lang('form.to') <u>{{ showDate($end) }}</u> <span class="label label-info">{{ dayDiff($start, $end) }} @lang('booking.nights')</span></h3>
<form-ajax action = "{{ urlTenant('bookings/new') }}" method="POST" reload-on-complete = true @startwait="startWait" @endwait="endWait">
  {{ Form::hidden('book_from', $start) }}
  {{ Form::hidden('book_to', $end) }}
  {{ Form::hidden('book_resource', '', ['v-model' => 'resource.rs_id']) }}
  {{ Form::hidden('book_customer', null, ['v-model'=>'book_customer']) }}
  <!--Section 1 - Select customer-->
  <div v-if="section1">
    <div class="row">
      <div class="col-md-5">
        Register a new customer <a href="{{ urlTenant('customers/new_quick') }}" v-modal><i class="fa fa-user-plus"></i> @lang('form.new')</a>
      </div>
      <div class="col-md-2">
        OR
      </div>
      <div class="col-md-5">
        Search by name
        <!-- <autocomplete name="people" url="{{ url('api/v1/customers/active') }}" anchor="title" class="form-control" label="extra" model="vModelLike"></autocomplete> -->
        <autocomplete :suggestions="customers" :selection="value" :selectionx="value" @selected="setCustomer"></autocomplete>
      </div>
    </div>
  </div>

  <!--Section 2 - Make booking-->
  <div v-if="section2">
    <!-- @if(!empty($customer->cus_id))
    @include('customer.profile', ['customer' => $customer])
    @endif -->
    {{ Form::hidden('bil_customer_name', null, ['v-model' => 'customer.full_name']) }}
    <h4>
      <i class="fa fa-user"></i> @{{ customer.full_name }}
    </h4>
    <div class="row">
      <div class="col-md-3"><i class="fa fa-envelope-o"></i> @{{ customer.cus_email }}</div>
      <div class="col-md-3"><i class="fa fa-phone"></i> @{{ customer.cus_contact1 }}</div>
      <div class="col-md-3"><i class="fa fa-globe"></i>@{{ customer.cus_country }}</div>
    </div>
    <button @click = "selectCustomer" class="btn btn-primary btn-sm">Change customer</button>

    <div class="row">
      {{ Form::bsSelect('book_source', trans('booking.book_source'), $booking_sources) }}
      {{ Form::bsNumber('book_pax', trans('booking.book_pax'), 1, ['min' => 1, 'max'=>20]) }}
      {{ Form::bsText('book_reference', trans('booking.book_reference')) }}
      {{ Form::bsTextarea('book_remarks', trans('booking.book_remarks'), null, ['rows' => 4]) }}
      <!-- {{ Form::bsText('book_tracking', trans('booking.book_tracking')) }} -->
    </div>
    <table class="table">
      <thead>
        <tr>
          <th class="col-md-3">@lang('resource.rs_name')</th>
          <th class="col-md-3">@lang('resource.rs_price')</th>
          <th class="col-md-3">@lang('resource.unit')</th>
          <th class="col-md-3">@lang('form.subtotal')</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for = "(day, index) in days">
          {{ Form::hidden('resource[0]', '', ['name' => "resource[]", 'v-model' => 'resource.rs_id']) }}
          <td>{{ Form::text('', '', ['class' => 'form-control', 'name' => "name[]", 'v-model' => 'day.description']) }}</td>
          <td>{{ Form::text('', null, ['class' => 'form-control', 'name' => "rate[]", 'v-model' => 'day.price']) }}</td>
          <td>{{ Form::text('', null, ['class' => 'form-control', 'readonly', 'name' => "unit[]", 'v-model' => 'day.nights']) }}</td>
          <td>@{{ day.price * day.nights }}</td>
        </tr>
      <tbody>
    </table>
    {{ Form::submit(trans('form.save'), ['id' => 'submit', 'class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
  </div>
</div>
</form-ajax>
@endprepend

@prepend('scripts')
<script>
new Vue({
    el: '#booking-new-basic',

    mixins: [mixForm],

    created: function () {
      this.init()
      this.getCustomers()
      this.getResource()
      // this.selectCustomer()
    },

    data: {
      section1: true,
      section2: false,
      customer: {cus_id: '', cus_email: '', cus_contact1: '', full_name: ''},
      customers : [],
      customer_label: '',
      book_customer: '',
      resource: {},
      days: [],
      value: '',
      nights: {{ dayDiff($start, $end) }},
    },

    watch: {
      book_customer: function (value) {
        if (this.book_customer != '') {
          this.customerReady(value)
        }
      }
    },

    methods: {
        getCustomers: function () {
          this.$http.get("{{ urlTenant("api/v1/customers/active") }}")
              .then(function (response) {
                this.customers = response.data
              });
        },

        getResource: function () {
          this.$http.get("{{ urlTenant("api/v1/resources/$resource_id/$start/$end") }}")
              .then(function (response) {
                this.resource = response.data.resource
                this.days = response.data.days
                console.log(response.data)
              });
        },

        setCustomer: function (value) {
          this.book_customer = value.id
        },

        customerReady: function (value) {
          this.$http.get("api/v1/customers/" + value)
              .then(function (response) {
                this.customer = response.data
              });
          this.section2 = true
          this.section1 = false
        },

        selectCustomer: function () {
          this.section2 = false
          this.section1 = true
          this.book_customer = ''
          this.customer = {}
        },

        init: function () {
          this.section2 = false
          this.section1 = true
          this.book_customer = '{{ $cus_id }}'
        }


    },
});
</script>
@endprepend
