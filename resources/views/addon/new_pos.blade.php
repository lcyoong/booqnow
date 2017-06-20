@extends($layout)

@prepend('content')
<div id="add-pos">
<form-ajax action = "{{ urlTenant('addons/new/list') }}" method="POST" :go-to-next = "gotonext" @startwait="startWait" @endwait="endWait">
  @if (!empty($booking))
  <!-- @include('customer.profile', ['customer' => $booking->customer]) -->
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

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="row row-eq-height" v-for = "chunk in chunkedResources">
          <div v-for = "resource in chunk" class="col-md-2" style="padding: 10px 3px; margin-right: 2px; margin-bottom: 2px; background: #fdfdfd; text-align: center; font-size: 0.8em;">
            <div style="">
              <a href="#" @click="addItem(resource)">@{{ resource.text }}</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <ul class="list-group">
        <li class="list-group-item" v-for="item in items">
          <div class="row">
            <div class="col-md-5">@{{ item.text }}</div>
            <div class="col-md-4">@{{ item.price }} x @{{ item.unit }}</div>
            <div class="col-md-3">
              <a href="#"><span @click="incrementItem(item)"><i class="fa fa-plus"></i></span></a>
              <a href="#"><span @click="decrementItem(item)"><i class="fa fa-minus"></i></span></a>
              <a href="#"><span @click="removeItem(item)"><i class="fa fa-trash"></i></span></a>
            </div>
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
      gotonext: '{{ !empty($booking) ? urlTenant(sprintf("bookings/%s", $booking->book_id)) : '' }}',
    },

    computed: {
      sum_amount: function () {

        var sum = 0

        for( var i = 0; i < this.items.length; i++ ){
          sum += parseFloat(this.items[i].price * this.items[i].unit)
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

        var found = false

        for (var i = 0; i < this.items.length; i++) {
        	if (this.items[i].id === item.id) {
            temp = this.items[i]
            temp.unit ++
            Vue.set(this.items, i, temp)
            found = true
        	}
        }

        if (found === false) {

          item.unit = 1

          this.items.push(item)

        }

        item.json = JSON.stringify({rs_name: item.text, rs_unit: item.unit, rs_price: item.price, rs_id: item.id})

      },

      /**
       * Remove item
       */
      removeItem: function(item) {

        var index = this.items.indexOf(item)

        this.items.splice(index, 1)
      },

      decrementItem: function(item) {

        var index = this.items.indexOf(item)

        if (item.unit > 1) {

          temp = this.items[index]

          temp.unit --

          Vue.set(this.items, index, temp)

        } else {

          this.removeItem(item)

        }

      },

      incrementItem: function(item) {

        var index = this.items.indexOf(item)

        temp = this.items[index]

        temp.unit ++

        Vue.set(this.items, index, temp)

      }

    }
});
</script>
@endprepend
