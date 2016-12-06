@extends($layout)

@push('content')
@include('customer.profile', ['customer' => $booking->customer])
<hr/>
{{ Form::open(['url' => urlTenant('addons/new/list'), 'v-ajax', 'hidecompletemessage' => false, 'gotonext' => urlTenant(sprintf("bookings/%s", $booking->book_id))]) }}
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
{{ Form::close() }}

<script>
var app2 = new Vue({
    el: 'body',
    ready: function () {
    },

    data: {
      items: [],
      sum_amount: 0,
    },

    methods: {
      // getItems: function() {
      //   $.getJSON('addons/pop/' + this.book_id, function(data) {
      //     this.items = data;
      //     console.log(data);
      //   }.bind(this))
      // },
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
@endpush
