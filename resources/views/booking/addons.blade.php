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
      <div v-for = "type in types" role="tabpanel" class="tab-pane" :id="type.rty_code" v-if="type.rty_master == 0">
      <ul class="list-group">
        <li class="list-group-item">
          <div class="row">
            <div class="col-md-1">@lang('addon.add_resource')</div>
            <div class="col-md-2">@lang('addon.add_date')</div>
            <div class="col-md-1">@lang('addon.add_pax')</div>
            <!-- <div class="col-md-1">@lang('addon.add_pax_child')</div> -->
            <div class="col-md-1">@lang('addon.add_reference')</div>
            <div class="col-md-2">@lang('addon.add_remarks')</div>
            <div class="col-md-2">@lang('addon.add_agent')</div>
            <div class="col-md-1">@lang('addon.add_status')</div>
          </div>
        </li>
        <li class="list-group-item" v-for="item in items" v-if="item.resource.rs_type === type.rty_id">
          <div class="row">
            <div class="col-md-1">@{{ item.resource.rs_name }}</div>
            <div class="col-md-2">{{ Form::datepicker('add_date', trans('addon.add_date'), null, ['class' => 'datetimepicker form-control', 'v-model' => 'item.add_date']) }}</div>
            <div class="col-md-1">{{ Form::number('add_pax', null, ['v-model' => 'item.add_pax', 'class' => 'form-control', 'min' => 1, 'max' => 20]) }}</div>
            <!-- <div class="col-md-1">{{ Form::number('add_pax_child', null, ['v-model' => 'item.add_pax_child', 'class' => 'form-control', 'min' => 0, 'max' => 20]) }}</div> -->
            <div class="col-md-1">{{ Form::text('add_reference', null, ['v-model' => 'item.add_reference', 'class' => 'form-control', 'placeholder' => trans('addon.add_reference')]) }}</div>
            <div class="col-md-2">{{ Form::textarea('add_remarks', null, ['v-model' => 'item.add_remarks', 'class' => 'form-control', 'rows'=>3, 'placeholder' => trans('addon.add_remarks')]) }}</div>
            <div class="col-md-2">{{ Form::selectBasic('add_agent', trans('addon.add_agent'), $agents, null, ['style'=>'width:100%', 'v-model' => 'item.add_agent', 'class' => 'form-control']) }}</div>
            <div class="col-md-1">{{ Form::selectBasic('add_status', trans('addon.add_status'), $add_status, null, ['v-model' => 'item.add_status', 'class' => 'form-control']) }}</div>
            <div class="col-md-1"><itemized :item = "item" class="form-control btn btn-primary" action="{{ urlTenant('addons/update') }}" @completesuccessx="doneUpdate">Save</itemized></div>
          </div>
          Billed: @{{ item.bill_item.bili_unit_price }} x @{{ item.bill_item.bili_unit }} unit(s) = @{{ item.bill_item.bili_gross }}
        </li>
      </ul>
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
            var data = JSON.parse(response.data)
            this.types = data
          });
    },

    getItems: function () {
      this.$http.get('{{ urlTenant("api/v1/bookings/$book_id/addons") }}')
          .then(function (response) {
            var data = JSON.parse(response.data)
            this.items = data

            $(function() {

              $('.select2').select2()

              $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
              })

            })

          });
    },
  }
})

</script>
@endprepend
