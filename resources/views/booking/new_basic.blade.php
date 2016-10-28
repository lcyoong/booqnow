@extends($layout)

@push('content')
<h3><i class="fa fa-bed"></i> {{ session('booking.resource')->rs_name }} <u>{{ showDate(session('booking.start')) }}</u> @lang('form.to') <u>{{ showDate(session('booking.end')) }}</u> <span class="label label-info">{{ dayDiff(session('booking.start'), session('booking.end')) }} @lang('booking.nights')</span></h3>

{{ Form::open(['url' => 'bookings/new', 'v-ajax', 'autocomplete' => 'off', '@keydown.enter.prevent'=>'', 'successreload' => true]) }}
  {{ Form::hidden('book_from', session('booking.start')) }}
  {{ Form::hidden('book_to', session('booking.end')) }}
  {{ Form::hidden('book_resource', session('booking.resource')->rs_id) }}
  {{ Form::hidden('book_customer', null, ['v-model'=>'book_customer']) }}
  <!--Section 1 - pick customer-->
  <div v-if="section1">
    <hr/>
    @lang('booking.pick_customer_desc') <a href="{{ urlTenant('customers/new_quick') }}" v-modal><i class="fa fa-user-plus"></i> @lang('form.new')</a>
    <div class="row">
      <div class="col-md-3">
        <autocomplete name="people" url="{{ url('api/v1/customers/active') }}" anchor="title" class="form-control" label="extra" model="vModelLike"></autocomplete>
      </div>
      <div class="col-md-3">

      </div>
    </div>
  </div>

  <!--Section 2 - fill booking-->
  <div v-if="section2">
    <div class="row">
      {{ Form::bsNumber('book_pax', trans('booking.book_pax'), 1, ['min' => 1, 'max'=>20]) }}
      {{ Form::bsText('book_reference', trans('booking.book_reference')) }}
      {{ Form::bsText('book_tracking', trans('booking.book_tracking')) }}
      {{ Form::hidden('resource[0]', session('booking.resource')->rs_id) }}
    </div>
    <table class="table">
      <thead>
        <tr>
          <th class="col-md-3">@lang('resource.rs_name')</th>
          <th class="col-md-3">@lang('resource.rs_price')</th>
          <th class="col-md-3">@lang('resource.unit')</th>
          <th class="col-md-3">@lang('form.subtotal')</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ Form::text('name[0]', session('booking.resource')->rs_name, ['class' => 'form-control']) }}</td>
          <td>{{ Form::text('rate[0]', session('booking.resource')->rs_price, ['class' => 'form-control']) }}</td>
          <td>{{ Form::text('unit[0]', dayDiff(session('booking.start'), session('booking.end')), ['class' => 'form-control', 'readonly']) }}</td>
          <td>{{ showMoney(session('booking.resource')->rs_price * dayDiff(session('booking.start'), session('booking.end'))) }}</td>
        </tr>
      <tbody>
    </table>
    {{ Form::submit(trans('form.save'), ['id' => 'submit', 'class' => 'btn btn-primary']) }}
  </div>
<script>
var app3 = new Vue({
    el: 'body',
    ready: function () {
      // alert('sss');
    },
    data: {
      section1: true,
      section2: false,
      book_customer: null
    },
    events: {
      'autocomplete-people:selected': function(data){
        console.log('selected-people',data);
        this.section2 = true;
        this.book_customer = data.id;
      },
    },
});
</script>

{{ Form::close() }}
@endpush
