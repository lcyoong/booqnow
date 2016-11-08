@extends($layout)

@push('content')
@include('customer.profile', ['customer' => $booking->customer])
<hr/>
{{ Form::open(['url' => urlTenant('addons/new'), 'v-ajax', 'gotonext' => urlTenant(sprintf("bookings/%s", $booking->book_id)), 'hidecompletemessage' => true]) }}
{{ Form::hidden('add_booking', $booking->book_id) }}
{{ Form::hidden('add_bill', $bill->bil_id) }}
{{ Form::hidden('add_customer', $booking->book_customer) }}
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8">
      @foreach ($resources->chunk(4) as $resource_chunk)
        <div class="row row-eq-height">
          @foreach ($resource_chunk as $resource)
            <div class="col-md-3" style="padding: 2px; background: #fdfdfd;">
              <div style="">
                <a href="#" v-post postto="{{ urlTenant(sprintf("addons/push/%s/%s", $booking->book_id, $resource->rs_id)) }}">{{ $resource->rs_name }}</a>
              </div>
            </div>
          @endforeach
        </div>
      @endforeach
    </div>
    <div class="col-md-4">
      <addon-list book_id="{{ $booking->book_id }}"></addon-list>
    </div>
  </div>
</div>
{{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary']) }}
{{ Form::close() }}

<script>
var app2 = new Vue({
    el: 'body',
    ready: function () {
      // alert('sss');
    },
    data: {
      items: [
            { message: 'Foo' },
            { message: 'Bar' }
          ]
    },
    methods: {
    }
});
</script>
@endpush