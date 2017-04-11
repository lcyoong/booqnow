@extends($layout)

@section('content_above_list')
<form-ajax action = "{{ urlTenant('resources/pricing') }}" method="POST" @startwait="startWait" @endwait="endWait" @completesuccess="refresh">
  {{ Form::hidden('rpr_resource', $resource->rs_id) }}
  <div class="row">
    {{ Form::bsSelect('rpr_season', trans('resource_pricing.rpr_season'), $seasons, null, ['v-model' => 'rpr_season']) }}
    {{ Form::bsText('rpr_price', appendCurrency(trans('resource_pricing.rpr_price')), null, ['v-model' => 'rpr_price']) }}
  </div>
  {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
  <redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('resources/' . $resource->rs_type) }}" class="btn-sm"></redirect-btn>
</form-ajax>
@endsection

@section('content_list')
  <table class="table table-condensed table-striped">
    <thead>
      <tr>
        <th>@lang('resource_pricing.rpr_season')</th>
        <th>{{ appendCurrency(trans('resource_pricing.rpr_price')) }}</th>
        <th>@lang('form.actions')</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for = "item in list">
        <td>@{{ item.season.season_text }}</td>
        <td>@{{ item.rpr_price }}</td>
        <td>
          <post-ajax :post-to="'{{ urlTenant(sprintf("resources/pricing/")) }}/' + item.rpr_id + '/delete'" @completesuccess = "refresh"><i class="fa fa-trash"></i></post-ajax>
        </td>
      </tr>
    </tbody>
  </table>
@endsection


@prepend('content')
<div id = "resource-pricing">
@include('layouts.list')
</div>
@endprepend


@prepend('scripts')
<script>
var now = new Vue({
  el: '#resource-pricing',

  mixins: [mixForm],

  created: function () {
    this.getPricing()
  },

  data: {
    disabled: false,
    rpr_season: '',
    rpr_price: '0',
    list: [],
  },

  methods: {
    getPricing: function () {
      this.$http.get("{{ urlTenant("api/v1/resources/" . $resource->rs_id . "/pricing") }}")
          .then(function (response) {
            this.list = response.data
            console.log(this.list)
          }).catch(function (response) {
            util.onErrorNotify(response);
          });
    },

    refresh: function (e) {
      this.getPricing()
      this.rpr_season = ''
      this.rpr_price = '0'
    }
  }
});
</script>
@endprepend
