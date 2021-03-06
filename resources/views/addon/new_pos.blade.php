@extends($layout)

@prepend('content')
<div id="add-pos">
<form-ajax action = "{{ urlTenant('addons/new/list') }}" method="POST" :go-to-next = "gotonext" @startwait="startWait" @endwait="endWait" :reload-on-complete="reloadoncomplete">
  @if (!empty($booking))
  <h4><i class="fa fa-user"></i> {{ $booking->customer->full_name }}</h4>
  @include('booking._info_extended', ['booking' => $booking])

  {{ Form::hidden('add_booking', $booking->book_id) }}
  {{ Form::hidden('add_date', date('d-m-Y')) }}
  {{ Form::hidden('add_customer', $booking->book_customer) }}
  {{ Form::hidden('bil_customer_name', $booking->customer->full_name) }}
  {{ Form::hidden('add_customer_name', $booking->customer->full_name) }}
  @elseif (!empty($bill))
  {{ Form::hidden('add_date', date('d-m-Y')) }}
  {{ Form::hidden('bil_customer_name', $bill->bil_customer_name) }}
  {{ Form::hidden('add_customer_name', $bill->bil_customer_name) }}
  @endif

  @if('myapp.single_bill_booking')
  {{ Form::hidden('add_to_bill', $add_to_bill) }}
  @endif

  <div class="container-fluid" style="padding: 20px">
    <div class="row">
      <div class="col-md-6" style="max-height: 400px; overflow-y: scroll;">
        <div v-for = "(resources, index) in groupResources">
          <div class="row">
            <div class="col-md-12" style="padding: 5px 10px; background-color: #efefef;"><h5>@{{ !(index in sub_types) ? 'N/A' : sub_types[index] }}</h5></div>
          </div>
          <div class="row row-eq-height" v-for = "chunk in _.chunk(resources, 6)">
            <div v-for = "resource in chunk" class="col-md-2" style="padding: 10px 3px; margin-right: 2px; margin-bottom: 2px; background: #fdfdfd; text-align: center; font-size: 0.8em;">
              <div style="">
                <a href="#" @click="addItem(resource)">@{{ resource.text }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12">
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
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <label for="add_tax" class="control-label">Tax?</label>
            <bootstrap-toggler name="add_with_tax" v-model="add_with_tax" data-size="normal"/>
          </div>
        </div>

        <h4><span class="label label-success">Total: @{{ sum_amount }}</span></h4>
        {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
      </div>
    </div>
  </div>
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
      sub_types: [],
      groupResources: [],
      gotonext: '{{ !empty($booking) ? urlTenant(sprintf("bookings/%s", $booking->book_id)) : '' }}',
      reloadoncomplete: @if(empty($booking)) true @else false @endif,
      add_with_tax: true,
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
       },

    },

    created: function () {

      this.getSubTypes()
      this.getResources()

    },

    methods: {
      /**
       * Get all the resources
       */
      getResources: function () {

        this.$http.get("{{ urlTenant("api/v1/resources/" . $resource_type->rty_id) }}/active/grouped")
            .then(function (response) {
              var data = JSON.parse(response.data)
              this.groupResources = data
            });
      },

      getSubTypes: function () {

        this.$http.get("{{ urlTenant("api/v1/resources/sub_types/{$resource_type->rty_id}") }}")
            .then(function (response) {
              var data = JSON.parse(response.data)
              this.sub_types = data
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

        item.json = JSON.stringify({rs_name: item.text, rs_pax: 1, rs_unit: item.unit, rs_price: item.price, rs_id: item.id})

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

          json = JSON.parse(temp.json)

          temp.unit --

          json.rs_unit = temp.unit

          temp.json = JSON.stringify(json)

          Vue.set(this.items, index, temp)

        } else {

          this.removeItem(item)

        }

      },

      incrementItem: function(item) {

        var index = this.items.indexOf(item)

        temp = this.items[index]

        json = JSON.parse(temp.json)

        temp.unit ++

        json.rs_unit = temp.unit

        temp.json = JSON.stringify(json)

        Vue.set(this.items, index, temp)

      }

    }
});
</script>
@endprepend
