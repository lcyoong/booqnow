@extends($layout)

@prepend('content')

@include('customer.profile', ['customer' => $booking->customer])
@include('booking._info_extended', ['booking' => $booking])
<div id="booking-addon">
  <div v-cloak>
    <ul class="nav nav-tabs" role="tablist">
      <li v-for = "type in types" role="presentation" v-if = "type.rty_master == 0">
        <a :href="'#' + type.rty_code" :aria-controls="type.rty_code" role="tab" data-toggle="tab"><i class="fa"></i> @{{ type.rty_plural }}</a>
      </li>
    </ul>

    <div class="tab-content">
      <div v-for = "type in types" role="tabpanel" class="tab-pane" :id="type.rty_code">
        <table class="table table-striped table-hover" v-if = "type.rty_master == 0">
          <thead>
            <tr>
              <th>@lang('addon.add_resource')</th>
              <th>@lang('addon.add_date')</th>
              <th>@lang('addon.add_unit')</th>
              <th>@lang('addon.add_reference')</th>
              <th>@lang('addon.add_status')</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for = "item in items" v-if = "item.resource.rs_type === type.rty_id">
              <td>@{{ item.resource.rs_name }}</td>
              <td>{{ Form::datepicker('add_date', trans('addon.add_date'), null, ['v-model' => 'item.add_date']) }}</td>
              <td>{{ Form::number('add_unit', null, ['v-model' => 'item.add_unit', 'class' => 'form-control', 'min' => 1, 'max' => 20]) }}</td>
              <td>{{ Form::text('add_reference', null, ['v-model' => 'item.add_reference', 'class' => 'form-control']) }}</td>
              <td>{{ Form::selectBasic('add_status', trans('addon.add_status'), $add_status, null, ['v-model' => 'item.add_status', 'class' => 'form-control']) }}</td>
              <td><itemized :item = "item" class="form-control btn btn-primary" action="{{ urlTenant('addons/update') }}" @completesuccess="doneUpdate">Save</itemized></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#booking-addon",

  mixins: [mixForm, mixResponse],

  created: function () {
    this.getTypes()
    this.getItems()
  },

  data: {
    items: {},
    types: {}
  },

  methods: {
    doneUpdate: function () {
      this.getItems()
    },

    getTypes: function () {
      this.$http.get('{{ urlTenant("api/v1/resources/types") }}')
          .then(function (response) {
            console.log(response.data)
            this.types = response.data
          });
    },

    getItems: function () {
      this.$http.get('{{ urlTenant("api/v1/bookings/$book_id/addons") }}')
          .then(function (response) {
            console.log(response.data)
            this.items = response.data
          });
    },
  }
})

</script>
@endprepend
