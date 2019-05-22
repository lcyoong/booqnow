@extends($layout)

@prepend('content')
<div id="bill-edit" v-cloak>
  <ul class="list-group" v-if="customer">
    <li class="list-group-item list-group-item-info">
      <div style="font-weight: bold; font-size: 1.1em;"><i class="fa fa-user-circle-o"></i> Guest</div>
      <div class="row">
        <div class="col-md-3"><i class="fa fa-user"></i> @{{ customer.full_name }}</div>
        <div class="col-md-3"><i class="fa fa-envelope-o"></i> @{{ customer.cus_email }}</div>
        <div class="col-md-3"><i class="fa fa-globe"></i> @{{ customer.cus_country }}</div>
        <div class="col-md-3"><i class="fa fa-phone"></i> @{{ customer.cus_contact1 }}</div>
      </div>
    </li>
  </ul>
  <span v-else class="label label-info"><i class="fa fa-blind"></i> @lang('bill.walkin')</span>
  <form-ajax action = "{{ urlTenant('bills/update') }}" method="POST" @startwait="startWait" @endwait="endWait" @completesuccess="redirectToDate">
  {{ Form::hidden('bil_id', '', ['v-model' => 'bill.bil_id']) }}
  <div class="row">
    <div class="col-md-3">@lang('bill.total') <div class="stat-value" style="font-weight: bold; font-size: 2em;">@{{ bill.total_amount }}</div></div>
    <div class="col-md-3">@lang('bill.bil_paid') <div class="stat-value" style="font-weight: bold; font-size: 2em;">@{{ bill.bil_paid }}</div></div>
    <div class="col-md-3">@lang('bill.outstanding') <div class="stat-value" style="font-weight: bold; font-size: 2em;">@{{ bill.outstanding }}</div></div>
    <div class="col-md-3">@lang('bill.bil_with_tax') <div class="stat-value" style="font-weight: bold; font-size: 2em;">@{{ bill.bil_with_tax }}
      <post-ajax v-if="bill.bil_with_tax == 1" :post-to="'{{ urlTenant("bills") }}/' + bill.bil_id + '/untax'" reload-on-complete="1">{{ Form::button(trans('form.untax'), ['class' => 'btn btn-primary btn-sm']) }}</post-ajax>
      <post-ajax v-if="bill.bil_with_tax  == 0" :post-to="'{{ urlTenant("bills") }}/' + bill.bil_id + '/tax'" reload-on-complete="1">{{ Form::button(trans('form.tax'), ['class' => 'btn btn-primary btn-sm']) }}</post-ajax>
    </div></div>
  </div>
  <div class="row">
    {{ Form::bsText('bil_customer_name', trans('bill.bil_customer_name'), '', ['v-model' => 'bill.bil_customer_name']) }}
    {{ Form::bsText('bil_description', trans('bill.bil_description'), '', ['v-model' => 'bill.bil_description']) }}
    {{ Form::bsDate('bil_date', trans('bill.bil_date'), null, ['v-model' => 'bill.bil_date']) }}
    {{ Form::bsSelect('bil_status', trans('bill.bil_status'), $rs_status, '', ['style' => 'width:100%', 'v-model' => 'bill.bil_status']) }}
  </div>
  {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
  <a href="{{ url('bills') }}">{{ Form::button(trans('form.cancel'), ['class' => 'btn btn-primary btn-sm']) }}</a>
  <a :href="'{{ urlTenant("bills") }}/' + bill.bil_id + '/print?{{ str_random(40) }}'" target=_blank title="@lang('form.print')">{{ Form::button(trans('form.print'), ['class' => 'btn btn-primary btn-sm']) }}</a>
  <!-- <a :href="'{{ urlTenant("bills") }}/' + bill.bil_id + '/printable?{{ str_random(40) }}'" target=_blank title="@lang('form.print')">{{ Form::button('Print Selective', ['class' => 'btn btn-primary btn-sm']) }}</a> -->
  </form-ajax>
  <hr/>
  <span class="label label-default">@{{ items.length }} @lang('bill.items')</span>
  <div>
    <ul class="list-group">
      <li class="list-group-item">
        <div class="row">
          <div class="col-md-4">@lang('bill.bil_description')</div>
          <div class="col-md-1">@lang('bill.bili_unit_price')</div>
          <div class="col-md-1">@lang('bill.bili_unit')</div>
          <div class="col-md-1">@lang('bill.bili_unit_price') * @lang('bill.bili_unit')</div>
          <div class="col-md-2">@lang('bill.bili_date')</div>
          <!-- <div class="col-md-1">@lang('form.print')</div> -->
          <div class="col-md-1">@lang('bill.bili_active')</div>
          <div class="col-md-1">@lang('bill.bili_with_tax')</div>
          <div class="col-md-1"></div>
        </div>

      </li>
      <li class="list-group-item" v-for="item in items">
        <div class="row">
          <div class="col-md-4">
            {{ Form::text('bili_description', '', ['class' => 'form-control', 'v-model' => 'item.bili_description', '@keyup' => 'change(item)']) }}
          </div>
          <div class="col-md-1">{{ Form::text('bili_unit_price', '', ['class' => 'form-control', 'v-model' => 'item.bili_unit_price']) }}</div>
          <div class="col-md-1">{{ Form::number('bili_unit', '', ['class' => 'form-control', 'v-model' => 'item.bili_unit', 'min' => 0, 'max' => 20]) }}</div>
          <div class="col-md-1">@{{ item.bili_unit_price * item.bili_unit }}</div>
          <div class="col-md-2">{{ Form::datepicker('bili_date', trans('bill.bili_date'), null, ['v-model' => 'item.bili_date']) }}</div>
          <!-- <div class="col-md-1"><bootstrap-toggler name="bili_print" v-model="item.bili_print" data-size="normal"/></div> -->
          <div class="col-md-1"><bootstrap-toggler name="bili_active" v-model="item.bili_active" data-size="normal"/></div>
          <div class="col-md-1"><bootstrap-toggler name="bili_with_tax" v-model="item.bili_with_tax" data-size="normal"/></div>
          <div class="col-md-1"><itemized :item = "item" class="form-control btn btn-primary" action="{{ urlTenant('bills/item/update') }}" @completesuccess="getList">Save</itemized></div>
        </div>
        <a v-if="item.addon && (item.resource.rs_type == 2 || item.resource.rs_type == 4)" v-modal :href="'{{ urlTenant('addons/edit/bill_item') }}/' + item.bili_id"><span style="font-size: 0.8em;"><i class="fa fa-link"></i> @{{ item.resource.rs_name }}</span></a>
        <span v-else-if="item.addon" style="font-size: 0.8em;"><i class="fa fa-link"></i> @{{ item.resource.rs_name }}</span>
        <div v-if="item.addon && (item.resource.rs_type == 2 || item.resource.rs_type == 4)" style="background: #efefef; padding: 5px; margin-top: 5px;">
          <div class="row" style="font-size: 0.8em;">
            <div class="col-md-2">@lang('addon.add_date')<div class="value">@{{ item.addon.add_date }}</div></div>
            <div class="col-md-2">@lang('addon.add_pax')<div class="value">@{{ item.addon.add_pax }}</div></div>
            <div class="col-md-2">@lang('addon.add_pax_child')<div class="value">@{{ item.addon.add_pax_child }}</div></div>
            <div class="col-md-2">@lang('addon.add_remarks')<div class="value">@{{ item.addon.add_remarks }}</div></div>
            <div class="col-md-2">@lang('addon.add_agent')<div class="value">@{{ item.addon.add_agent }}</div></div>
            <div class="col-md-2">@lang('addon.add_status')<div class="value">@{{ item.addon.add_status }}</div></div>
          </div>
        </div>

      </li>
      <li class="list-group-item list-group-item-success">
        <form-ajax action = "{{ urlTenant('bills/item') }}" method="POST" @startwait="startWait" @endwait="endWait" @completesuccess="doneAddNew">
          <div class="row">
            <input type="hidden" name="bili_bill" v-model="new_item.bili_bill">
            <div class="col-md-4">{{ Form::text('bili_description', '', ['class' => 'form-control', 'v-model' => 'new_item.bili_description', 'placeholder' => 'New item description']) }}</div>
            <div class="col-md-1">{{ Form::text('bili_unit_price', '', ['class' => 'form-control', 'v-model' => 'new_item.bili_unit_price']) }}</div>
            <div class="col-md-1">{{ Form::number('bili_unit', '', ['class' => 'form-control', 'v-model' => 'new_item.bili_unit', 'min' => 0, 'max' => 20]) }}</div>
            <div class="col-md-1">@{{ new_item.bili_unit_price * new_item.bili_unit }}</div>
            <div class="col-md-2">{{ Form::datepicker('bili_date', trans('bill.bili_date'), null, ['v-model' => 'new_item.bili_date']) }}</div>
            <div class="col-md-1"></div>
            <div class="col-md-1"></div>
            <div class="col-md-1">{{ Form::submit(trans('form.save'), ['id' => 'submit', 'class' => 'form-control btn btn-primary btn-sm', ':disabled' => 'waiting']) }}</div>
          </div>
        </form-ajax>
      </li>
    </ul>
  </div>

  <div v-if="booking">
    <i class="fa fa-exclamation-circle"></i> Please use the <a v-modal :href="'{{ urlTenant('bookings') }}/' + booking.book_id" title="@lang('form.view')">booking action</a> function to add other add-ons to this bill
  </div>
  <div v-else>
    @foreach($resource_types as $type)
      @if(!$type->rty_master)
        <a :href="'{{ urlTenant(sprintf("addons/%s/new/bill", $type->rty_id)) }}/' + bill.bil_id +  '/{{ $type->rty_pos ? '1' : '0' }}'" v-modal><button class="btn btn-primary btn-sm"><i class="fa {{ config('myapp.icon-' . $type->rty_code) }}"></i> @lang('form.add_itinerary', ['name' => $type->rty_name])</button></a>
      @endif
    @endforeach
  </div>
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#bill-edit",

  mixins: [mixForm, mixResponse],

  created: function () {
    this.getList()
  },

  data: {
    hello: 0,
    bill: {},
    customer: {},
    booking: {},
    items: [],
    new_item: {'bili_description': '', 'bili_unit_price': 0.00, 'bili_unit': 1, 'bili_date': '{{ date('d-m-Y') }}', 'bili_bill' : {{ $id }}},
    redirect_to_date: {!! json_encode($redirect_to_date) !!},
  },

  methods: {
    doneAddNew: function () {
      this.getList()
      this.new_item = {'bili_description': '', 'bili_unit_price': 0.00, 'bili_unit': 1, 'bili_date': '{{ date('d-m-Y') }}', 'bili_bill' : {{ $id }}}
    },

    getList: function () {
      this.$http.get('{{ urlTenant("api/v1/bills/$id") }}')
          .then(function (response) {
            var data = JSON.parse(response.data)
            console.log(data)
            this.bill = data
            this.customer = data.customer
            this.booking = data.booking
            this.items = data.allitems
          });
    },

    // saveItem: function(e, item) {
    //   formData = item
    //   this
    //     .$http.post('{{ urlTenant('bills/item/update') }}', formData)
    //     .then(this.onComplete.bind(this))
    //     .catch(this.onError.bind(this));
    // },
    //
    change: function (item) {
      item.display = "none"
    },

    redirectToDate: function(value) {
        if(value.data && value.data.redirect_to && !!this.redirect_to_date) {
          window.location.replace("{{ url('?date=') }}" + value.data.redirect_to);
        }
      }


  }
})
</script>
@endprepend
