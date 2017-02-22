@extends($layout)

@prepend('content')
<div id="add-pos">
@include('customer.profile', ['customer' => $booking->customer])
<hr/>
<form-ajax action = "{{ urlTenant('addons/new/list') }}" method="POST" go-to-next ="{{ urlTenant(sprintf("bookings/%s", $booking->book_id)) }}" @startwait="startWait" @endwait="endWait">
{{ Form::hidden('add_booking', $booking->book_id) }}
@if('myapp.single_bill_booking')
{{ Form::hidden('add_bill', array_get($account_bill, $resource_type->rty_accounting)) }}
@endif
{{ Form::hidden('add_customer', $booking->book_customer) }}
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8">
      <div class="row row-eq-height" v-for = "chunk in chunkedResources">
        <div v-for = "resource in chunk" class="col-md-2" style="padding: 10px 3px; margin-right: 2px; margin-bottom: 2px; background: #fdfdfd; text-align: center; font-size: 0.8em;">
          <div style="">
            <a href="#" @click="addItem(resource)">@{{ resource.text }}</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <ul class="list-group">
      <li class="list-group-item" v-for="item in items">
        <div class="row">
          <div class="col-md-6">@{{ item.text }}</div>
          <div class="col-md-4">@{{ item.price }}</div>
          <div class="col-md-2"><span @click="removeItem(item)"><i class="fa fa-trash"></i></span></div>
        </div>
        <input type="hidden" name="addon_id[]" :value="item.json">
      </li>
      </ul>
      <h4><span class="label label-success">Total: @{{ sum_amount }}</span></h4>
    </div>
  </div>
</div>
{{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
</form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
var app2 = new Vue({
    el: '#add-pos',

    mixins: [mixForm],

    data: {
      items: [],
      resources: [],
    },

    computed: {
      sum_amount: function () {

        var sum = 0

        for( var i = 0; i < this.items.length; i++ ){
          sum += parseFloat(this.items[i].price)
        }

        return sum
      },

      chunkedResources () {
         return _.chunk(this.resources, 6)
       }
    },

    created: function () {

      this.getResources()

    },

    methods: {
      /**
       * Get all the resources
       */
      getResources: function () {

        this.$http.get("{{ urlTenant("api/v1/resources/" . $resource_type->rty_id) }}/active/select")
            .then(function (response) {

              this.resources = response.data
            });
      },

      /**
       * Add item
       */
      addItem: function(item) {

        item.json = JSON.stringify({rs_name: item.text, rs_price: item.price, rs_id: item.id})

        this.items.push(item)
      },

      /**
       * Remove item
       */
      removeItem: function(item) {

        var index = this.items.indexOf(item)

        this.items.splice(index, 1)
      },

    }
});
</script>
@endprepend
