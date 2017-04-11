@extends($layout)

@prepend('content')
@include('resource_pricing.basic_info', ['pricing' => $pricing])
<div id = "resource-pricing-tier">
  <div>
    <ul class="list-group">
      <li class="list-group-item">
        <div class="row">
          <div class="col-md-3">@lang('resource_pricing.rpt_from')</div>
          <div class="col-md-3">@lang('resource_pricing.rpt_to')</div>
          <div class="col-md-3">@lang('resource_pricing.rpt_price')</div>
          <div class="col-md-3">@lang('resource_pricing.rpt_from')</div>
        </div>
      </li>
      <li class="list-group-item" v-for="tier in tiers">
        <div class="row">
          <div class="col-md-3">{{ Form::number('rpt_from', '', ['class' => 'form-control', 'v-model' => 'tier.rpt_from', 'min' => 1, 'max' => 20, 'readonly']) }}</div>
          <div class="col-md-3">{{ Form::number('rpt_to', '', ['class' => 'form-control', 'v-model' => 'tier.rpt_to', 'min' => 1, 'max' => 20, 'readonly']) }}</div>
          <div class="col-md-3">{{ Form::text('rpt_price', '', ['class' => 'form-control', 'v-model' => 'tier.rpt_price', 'readonly']) }}</div>
          <div class="col-md-3">
            <post-ajax :post-to="'{{ urlTenant(sprintf("resources/pricing/tier")) }}/' + tier.rpt_id + '/delete'" @completesuccess = "getList"><i class="fa fa-trash"></i></post-ajax>
          </div>
        </div>
      </li>
      <li class="list-group-item list-group-item-success">
        <div class="row">
          <input type="hidden" v-model="new_tier.rpt_pricing">
          <div class="col-md-3">{{ Form::number('rpt_from', '', ['class' => 'form-control', 'v-model' => 'new_tier.rpt_from', 'min' => 1, 'max' => 20]) }}</div>
          <div class="col-md-3">{{ Form::number('rpt_to', '', ['class' => 'form-control', 'v-model' => 'new_tier.rpt_to', 'min' => 1, 'max' => 20]) }}</div>
          <div class="col-md-3">{{ Form::text('rpt_price', '', ['class' => 'form-control', 'v-model' => 'new_tier.rpt_price']) }}</div>
          <div class="col-md-3"><itemized :item = "new_tier" class="form-control btn btn-primary" action="{{ urlTenant('resources/pricing/tier') }}" @completesuccess="doneAddNew"> <i class="fa fa-plus"></i> @lang('form.new')</itemized></div>
        </div>
      </li>
    </ul>
  </div>

</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#resource-pricing-tier",

  mixins: [mixForm, mixResponse],

  created: function () {
    this.getList()
  },

  data: {
    bill: {},
    customer: {},
    booking: {},
    tiers: [],
    new_tier: {'rpt_pricing': {{ $pricing_id }}}
  },

  methods: {
    doneAddNew: function () {
      this.getList()
      this.new_tier = {}
    },

    getList: function () {
      this.$http.get('{{ urlTenant("api/v1/resources/pricing/$pricing_id/tier") }}')
          .then(function (response) {
            console.log(response.data)
            this.tiers = response.data
          });
    },
  }
})
</script>
@endprepend
