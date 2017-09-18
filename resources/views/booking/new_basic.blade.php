@extends($layout)

@prepend('content')
<div id="booking-new-basic">
<h3><i class="fa fa-bed"></i> @{{ resource.rs_name }} <u>{{ showDate($start) }}</u> @lang('form.to') <u>{{ showDate($end) }}</u> <span class="label label-info">{{ dayDiff($start, $end) }} @lang('booking.nights')</span></h3>
<form-ajax action = "{{ urlTenant('bookings/new') }}" method="POST" reload-on-complete=true @startwait="startWait" @endwait="endWait">
  {{ Form::hidden('book_from', $start) }}
  {{ Form::hidden('book_to', $end) }}
  {{ Form::hidden('book_status', 'hold') }}
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
    <h4><i class="fa fa-user"></i> @{{ customer.full_name }} <a href="#" @click = "selectCustomer" class="btn-sm"><i class="fa fa-edit"></i> Change customer</a></h4>
    <!-- <div class="row">
      <div class="col-md-3"><i class="fa fa-envelope-o"></i> @{{ customer.cus_email }}</div>
      <div class="col-md-3"><i class="fa fa-phone"></i> @{{ customer.cus_contact1 }}</div>
      <div class="col-md-3"><i class="fa fa-globe"></i>@{{ customer.cus_country }}</div>
    </div> -->

    <div class="row">
      {{ Form::bsSelect('book_source', trans('booking.book_source'), $booking_sources, null, ['v-model' => 'source', '@change' => 'switchSource']) }}
      {{ Form::bsSelect2('book_agent', trans('booking.book_agent'), ['style' => 'width: 100%', 'id' => 'book_agent', ':options' => 'agents', ':value' => 'agent']) }}
      {{ Form::bsNumber('book_pax', trans('booking.book_pax'), 1, ['min' => 1, 'max'=>20]) }}
      {{ Form::bsNumber('book_pax_child', trans('booking.book_pax_child'), 0, ['min' => 0, 'max'=>20]) }}
      <!-- {{ Form::bsText('book_tracking', trans('booking.book_tracking')) }} -->
    </div>
    <div class="row">
      {{ Form::bsDate('book_expiry', trans('booking.book_expiry'), null, ['class' => 'datetimepicker form-control']) }}
      {{ Form::bsTextarea('book_remarks', trans('booking.book_remarks'), null, ['rows' => 3]) }}
      {{ Form::bsText('book_reference', trans('booking.book_reference')) }}
      <div class="col-md-3">
        <div class="form-group">
          <label for="book_special" class="control-label">@lang('booking.book_special')</label>
          <div>
            <!-- <bootstrap-toggler name="bili_active" data-size="normal"/> -->
            {{ Form::checkbox('book_special', 1, false, ['class' => 'toggleIt']) }}
          </div>
        </div>
      </div>
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
      this.switchSource()
      // this.selectCustomer()
    },

    data: {
      section1: true,
      section2: false,
      customer: {cus_id: '', cus_email: '', cus_contact1: '', full_name: ''},
      customers : [],
      agents: [],
      agent: '',
      customer_label: '',
      book_customer: '',
      resource: {},
      days: [],
      value: '',
      source: {{ config('myapp.default_booking_source') }},
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
      switchSource: function () {

        $('#book_agent option[value!=""]').remove()

        if (this.source == 3) {

          this.getAgents('agents')

        } else if (this.source == 1) {

          this.getAgents('sales')

        } else {

          this.agents = []

        }

      },

      getCustomers: function () {

        this.$http.get("{{ urlTenant("api/v1/customers/active") }}")
            .then(function (response) {
              var data = JSON.parse(response.data)
              this.customers = data
            })

      },

      getAgents: function (type) {

        this.$http.get("{{ urlTenant("api/v1/agents/") }}/" + type)
            .then(function (response) {
              var data = JSON.parse(response.data)
              this.agents = data
            })

      },

      getResource: function () {
        this.$http.get("{{ urlTenant("api/v1/resources/$resource_id/$start/$end") }}")
            .then(function (response) {
              var data = JSON.parse(response.data)
              this.resource = data.resource
              this.days = data.days
            });
      },

      setCustomer: function (value) {
        this.book_customer = value.id
      },

      customerReady: function (value) {
        this.$http.get("api/v1/customers/" + value)
            .then(function (response) {
              var data = JSON.parse(response.data)
              this.customer = data
            });
        this.section2 = true
        this.section1 = false
        $(function() {
          $('.toggleIt').bootstrapToggle()
          $('.select2').select2()
          $('.datetimepicker').datetimepicker({
            format: 'DD-MM-YYYY HH:mm',
          });
        })
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
