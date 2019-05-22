@extends($layout)

@prepend('content')
<div id="addon-new">
  <form-ajax action = "{{ urlTenant('addons/new') }}" method="POST" :go-to-next="gotonext" @startwait="startWait" @endwait="endWait" :reload-on-complete="reloadoncomplete">
    @if (!empty($booking))
    <h4><i class="fa fa-user"></i> {{ $booking->customer->full_name }}</h4>
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
    {{ Form::hidden('add_unit', 1) }}
    <div class="row">
      {{ Form::bsSelect2('add_resource', trans('addon.add_resource'), [':options' => 'resources', 'style' => 'width: 100%', 'v-model' => 'add_resource', '@input' => 'updatePrice']) }}
      {{ Form::bsNumber('add_pax', trans('addon.add_pax'), 1, ['min' => 1, 'max'=>20], 2) }}
      {{ Form::bsNumber('add_pax_child', trans('addon.add_pax_child'), 0, ['min' => 0, 'max'=>20], 2) }}
      {{ Form::bsText('add_price', trans('resource.rs_price'), null, ['v-model' => 'add_price'], 2) }}
      <div class="col-md-1">
        <label for="add_tax" class="control-label">Tax</label>
        <bootstrap-toggler name="add_with_tax" v-model="add_with_tax" data-size="normal"/>
      </div>
    </div>
    <div class="row">
      {{ Form::bsDate('add_date', trans('addon.add_date'), $resource_type->rty_id == 4 && !empty($booking) ? Carbon\Carbon::parse($booking->book_from)->format('d-m-Y') : today('d-m-Y'), ['class' => 'datetimepicker form-control']) }}
      {{ Form::bsText('add_reference', trans('addon.add_reference')) }}
      {{ Form::bsSelect('add_agent', trans('addon.add_agent'), $agents, null, ['class' => 'form-control select2']) }}
      {{ Form::bsTextarea('add_remarks', trans('addon.add_remarks')) }}
    </div>
    {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btm-sm', ':disabled' => 'waiting']) }}
  </form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
  new Vue({
    el: '#addon-new',

    mixins: [mixForm],

    data: {
      add_price: 0,
      add_with_tax: true,
      resources: [],
      add_resource: '',
      gotonext: '{{ !empty($booking) ? urlTenant(sprintf("bookings/%s", $booking->book_id)) : '' }}',
      reloadoncomplete: @if(empty($booking)) true @else false @endif
    },

    created: function () {
      this.getResources()
      $(function() {
        $('.datepicker').datepicker({
          format: 'dd-mm-yyyy',
        })

        $('.datetimepicker').datetimepicker({
          format: 'DD-MM-YYYY HH:mm',
        });

        $('.select2').select2()
      })
    },

    methods: {
      getResources: function () {
        this.$http.get("{{ urlTenant("api/v1/resources/" . $resource_type->rty_id) }}/active/select")
            .then(function (response) {
              var data = JSON.parse(response.data)
              this.resources = data
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
</script>
@endprepend
