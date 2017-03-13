@extends($layout)

@prepend('content')
<div id="bill-edit" v-cloak>
  <form-ajax action = "{{ urlTenant('bills/update') }}" method="POST" @startwait="startWait" @endwait="endWait">
  {{ Form::hidden('bil_id', '', ['v-model' => 'bill.bil_id']) }}
  <div class="row">
    <div class="col-md-3">@lang('bill.total') <div class="stat-value" style="font-weight: bold; font-size: 2em;">@{{ bill.total_amount }}</div></div>
    <div class="col-md-3">@lang('bill.bil_paid') <div class="stat-value" style="font-weight: bold; font-size: 2em;">@{{ bill.bil_paid }}</div></div>
    <div class="col-md-3">@lang('bill.outstanding') <div class="stat-value" style="font-weight: bold; font-size: 2em;">@{{ bill.outstanding }}</div></div>
  </div>
  <div class="row">
    {{ Form::bsText('bil_description', trans('bill.bil_description'), '', ['v-model' => 'bill.bil_description']) }}
    {{ Form::bsDate('bil_date', trans('bill.bil_date'), null, ['v-model' => 'bill.bil_date']) }}
    {{ Form::bsSelect('bil_status', trans('bill.bil_status'), $rs_status, '', ['style' => 'width:100%', 'v-model' => 'bill.bil_status']) }}
  </div>
  {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
  <a href="{{ url('bills') }}">{{ Form::button(trans('form.cancel'), ['class' => 'btn btn-primary btn-sm']) }}</a>

  </form-ajax>

  <h4>@{{ items.length }} @lang('bill.items')</h4>
  <div class="containerx">
    <ul class="list-group">
      <li class="list-group-item" v-for="item in items">
        <div class="row">
          <div class="col-md-4">{{ Form::text('bili_description', '', ['class' => 'form-control', 'v-model' => 'item.bili_description', '@keyup' => 'change(item)']) }}</div>
          <div class="col-md-2">{{ Form::text('bili_unit_price', '', ['class' => 'form-control', 'v-model' => 'item.bili_unit_price']) }}</div>
          <div class="col-md-1">{{ Form::number('bili_unit', '', ['class' => 'form-control', 'v-model' => 'item.bili_unit', 'min' => 0, 'max' => 20]) }}</div>
          <div class="col-md-2">@{{ item.bili_unit_price * item.bili_unit }}</div>
          <div class="col-md-1"><bootstrap-toggler name="bili_active" v-model="item.bili_active" data-size="normal"/></div>
          <div class="col-md-1"><itemized :item = "item" class="form-control btn btn-primary" action="{{ urlTenant('bills/item/update') }}" @completesuccess="getList">Save</itemized></div>
        </div>
      </li>
      <li class="list-group-item list-group-item-success">
        <div class="row">
          <input type="hidden" v-model="new_item.bili_bill">
          <div class="col-md-4">{{ Form::text('bili_description', '', ['class' => 'form-control', 'v-model' => 'new_item.bili_description']) }}</div>
          <div class="col-md-2">{{ Form::text('bili_unit_price', '', ['class' => 'form-control', 'v-model' => 'new_item.bili_unit_price']) }}</div>
          <div class="col-md-1">{{ Form::number('bili_unit', '', ['class' => 'form-control', 'v-model' => 'new_item.bili_unit', 'min' => 0, 'max' => 20]) }}</div>
          <div class="col-md-2">@{{ new_item.bili_unit_price * new_item.bili_unit }}</div>
          <div class="col-md-1"></div>
          <div class="col-md-1"><itemized :item = "new_item" class="form-control btn btn-primary" action="{{ urlTenant('bills/item') }}" @completesuccess="doneAddNew"> <i class="fa fa-plus"></i> @lang('form.new')</itemized></div>
        </div>
      </li>
    </ul>
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
    bill: {'bil_id': '', 'bil_description': '', 'bil_date' : '', 'bil_status': ''},
    items: {},
    new_item: {'bili_description': '', 'bili_unit_price': 0.00, 'bili_unit': 1, 'bili_bill' : {{ $id }}}
  },

  methods: {
    doneAddNew: function () {
      this.getList()
      this.new_item = {'bili_description': '', 'bili_unit_price': 0.00, 'bili_unit': 1, 'bili_bill' : {{ $id }}}
    },

    getList: function () {
      this.$http.get('{{ urlTenant("api/v1/bills/$id") }}')
          .then(function (response) {
            console.log(response.data)
            this.bill = response.data
            this.items = response.data.items
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
    }

  }
})
</script>
@endprepend
