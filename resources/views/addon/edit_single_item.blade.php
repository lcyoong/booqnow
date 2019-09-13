@extends($layout)

@prepend('content')
<div id="addon-new">
  <form-ajax action = "{{ urlTenant('addons/update') }}" method="POST" :go-to-next="gotonext" @startwait="startWait" @endwait="endWait" :reload-on-complete="reloadoncomplete">
    {{ Form::hidden('add_id', $addon->add_id) }}
    <div class="row">
      {{ Form::bsNumber('add_pax', trans('addon.add_pax'), null, ['min' => 1, 'max'=>20, 'v-model' => 'addon.add_pax']) }}
      {{-- Form::bsNumber('add_pax_child', trans('addon.add_pax_child'), null, ['min' => 0, 'max'=>20, 'v-model' => 'addon.add_pax_child']) --}}
      {{ Form::bsSelect('add_status', trans('addon.add_status'), $add_status, $addon->add_status, ['class' => 'form-control']) }}
    </div>
    <div class="row">
      {{ Form::bsDate('add_date', trans('addon.add_date'), null, ['class' => 'datetimepicker form-control', 'v-model' => 'addon.add_date']) }}
      {{ Form::bsText('add_reference', trans('addon.add_reference'), null, ['v-model' => 'addon.add_reference']) }}
      {{ Form::bsSelect('add_agent', trans('addon.add_agent'), $agents, $addon->add_agent, ['class' => 'form-control select2']) }}
      {{ Form::bsTextarea('add_remarks', trans('addon.add_remarks'), $addon->add_remarks) }}
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
      resources: [],
      addon: {!! $addon !!},
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
