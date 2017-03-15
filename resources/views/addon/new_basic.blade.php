@extends($layout)

@prepend('content')
<div id="addon-new">
  <form-ajax action = "{{ urlTenant('addons/new') }}" method="POST" :go-to-next="gotonext" @startwait="startWait" @endwait="endWait" :reload-on-complete="reloadoncomplete">
    @if (!empty($booking))
    @include('customer.profile', ['customer' => $booking->customer])
    @include('booking._info_extended', ['booking' => $booking])
    
    {{ Form::hidden('add_booking', $booking->book_id) }}
    {{ Form::hidden('add_customer', $booking->book_customer) }}
    {{ Form::hidden('bil_customer_name', $booking->customer->full_name) }}
    {{ Form::hidden('add_customer_name', $booking->customer->full_name) }}
    @elseif (!empty($bill))
    {{ Form::hidden('bil_customer_name', $bill->bil_customer_name) }}
    {{ Form::hidden('add_customer_name', $bill->bil_customer_name) }}
    @endif
    @if('myapp.single_bill_booking')
    {{ Form::hidden('add_to_bill', $add_to_bill) }}
    @endif
    {{ Form::hidden('add_pax', 1) }}
    <div class="row">
      {{ Form::bsSelect2('add_resource', trans('addon.add_resource'), [':options' => 'resources', 'style' => 'width: 100%', 'v-model' => 'add_resource', '@input' => 'updatePrice']) }}
      {{ Form::bsNumber('add_unit', trans('addon.add_unit'), 1, ['min' => 1, 'max'=>20]) }}
      {{ Form::bsText('add_price', trans('resource.rs_price'), null, ['v-model' => 'add_price']) }}
      {{ Form::bsDate('add_date', trans('addon.add_date'), today()) }}
    </div>
    <div class="row">
      {{ Form::bsText('add_reference', trans('addon.add_reference')) }}
      <!-- {{ Form::bsText('add_tracking', trans('addon.add_tracking')) }} -->
    </div>
    {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btm-sm', ':disabled' => 'waiting']) }}
  </form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
$(function() {
  $('.select2').select2();

  new Vue({
    el: '#addon-new',

    mixins: [mixForm],

    data: {
      add_price: 0,
      resources: [],
      add_resource: '',
      gotonext: undefined,
      reloadoncomplete: false
    },

    created: function () {
      this.getResources()
    },

    methods: {
      getResources: function () {
        this.$http.get("{{ urlTenant("api/v1/resources/" . $resource_type->rty_id) }}/active/select")
            .then(function (response) {
              console.log(response.data)
              this.resources = response.data
            });
      },

      updatePrice: function () {

        var needle = this.add_resource
        var result = this.resources.filter(function (e) {
          return e.id == needle;
        });

        this.add_price = result[0].price
      },
    }
  });

  $('.datepicker').datepicker({
    format: 'dd-mm-yyyy',
  });

});
</script>
@endprepend
