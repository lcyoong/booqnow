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
      @foreach ($resources->chunk(6) as $resource_chunk)
        <div class="row row-eq-height">
          @foreach ($resource_chunk as $resource)
            <div class="col-md-2" style="padding: 10px 3px; margin-right: 2px; margin-bottom: 2px; background: #fdfdfd; text-align: center; font-size: 0.8em;">
              <div style="">
                <!-- <a href="#" v-post postto="{{ urlTenant(sprintf("addons/push/%s/%s", $booking->book_id, $resource->rs_id)) }}">{{ $resource->rs_name }}</a> -->
                <a href="#" v-on:click="addItem({{ $resource }})">{{ $resource->rs_name }}</a>
              </div>
            </div>
          @endforeach
        </div>
      @endforeach
    </div>
    <div class="col-md-4">
      <ul class="list-group">
      <li class="list-group-item" v-for="item in items">
        <div class="row">
          <div class="col-md-6">@{{ item.rs_name }}</div>
          <div class="col-md-4">@{{ item.rs_price }}</div>
          <div class="col-md-2"><span @click="removeItem(item)"><i class="fa fa-trash"></i></span></div>
        </div>
        <input type="hidden" name="addon_id[@{{ item.rs_id }}]" value="@{{ item.json }}">
      </li>
      </ul>
      Total: @{{ sum_amount }}
    </div>
  </div>
</div>
{{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary']) }}
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
      sum_amount: 0,
    },

    methods: {
      addItem: function(item) {
        item.json = JSON.stringify(item);
        console.log(item);
        this.items.push(item);
        this.updateSum();
      },

      removeItem: function(item) {
        console.log(item);
        var index = this.items.indexOf(item);
        this.items.splice(index, 1);
        this.updateSum();
      },

      updateSum: function() {

        var sum = 0;

        for( var i = 0; i < this.items.length; i++ ){
          sum += parseFloat(this.items[i].rs_price);
        }

        this.sum_amount = sum;
      }
    }
});
</script>
@endprepend
