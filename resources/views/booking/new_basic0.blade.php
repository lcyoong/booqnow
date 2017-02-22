@extends($layout)

@push('content')
<div id="booking-new-basic">
<h3><i class="fa fa-bed"></i> {{ session('booking.resource')->rs_name }} <u>{{ showDate(session('booking.start')) }}</u> @lang('form.to') <u>{{ showDate(session('booking.end')) }}</u> <span class="label label-info">{{ dayDiff(session('booking.start'), session('booking.end')) }} @lang('booking.nights')</span></h3>
<!-- {{ Form::open(['url' => 'bookings/new', 'autocomplete' => 'off', "@submit.prevent"=>'testForm', 'successreload' => true]) }} -->
<form-ajax action = "{{ urlTenant('bookings/new') }}" method="POST" reload-on-complete = true>
  {{ Form::hidden('book_from', session('booking.start')) }}
  {{ Form::hidden('book_to', session('booking.end')) }}
  {{ Form::hidden('book_resource', session('booking.resource')->rs_id) }}
  {{ Form::hidden('book_customer', null, ['v-model'=>'book_customer']) }}
  <!--Section 1 - pick customer-->
  <div v-if="section1">
    <hr/>
    <div class="row">
      <div class="col-md-5">
        Register a new customer <a href="{{ urlTenant('customers/new_quick') }}" v-modal><i class="fa fa-user-plus"></i> @lang('form.new')</a>
      </div>
      <div class="col-md-2">
        OR
      </div>
      <div class="col-md-5">
        Search by name
        <!-- <autocomplete name="people" url="{{ url('api/v1/customers/active') }}" anchor="title" class="form-control" label="extra" model="vModelLike"></autocomplete> -->
        <!-- <autocomplete :suggestions="cities" :selection.sync="value"></autocomplete> -->
      </div>
    </div>
  </div>

  <!--Section 2 - fill booking-->
  <div v-if="section2">
    {{ Form::hidden('resource[0]', session('booking.resource')->rs_id) }}
    @if(!empty($customer->cus_id))
    @include('customer.profile', ['customer' => $customer])
    @endif
    <div class="row">
      {{ Form::bsSelect('book_source', trans('booking.book_source'), $booking_sources) }}
      {{ Form::bsNumber('book_pax', trans('booking.book_pax'), 1, ['min' => 1, 'max'=>20]) }}
      {{ Form::bsText('book_reference', trans('booking.book_reference')) }}
      {{ Form::bsTextarea('book_remarks', trans('booking.book_remarks')) }}
      <!-- {{ Form::bsText('book_tracking', trans('booking.book_tracking')) }} -->
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
          <td>{{ Form::text('rate[0]', session('booking.resource')->rs_price, ['class' => 'form-control', 'v-model' => 'rate']) }}</td>
          <td>{{ Form::text('unit[0]', dayDiff(session('booking.start'), session('booking.end')), ['class' => 'form-control', 'readonly', 'v-model' => 'unit']) }}</td>
          <!-- <td>{{ showMoney(session('booking.resource')->rs_price * dayDiff(session('booking.start'), session('booking.end'))) }}</td> -->
          <td>@{{ rate * unit }}</td>
        </tr>
      <tbody>
    </table>
    {{ Form::submit(trans('form.save'), ['id' => 'submit', 'class' => 'btn btn-primary', ':disabled' => 'disabled']) }}
  </div>
</div>
</form-ajax>
<!-- {{ Form::close() }} -->
@endpush

@push('scripts')
<script>
new Vue({
    el: '#booking-new-basic',
    created: function () {
      @if(!empty($customer->cus_id))
      this.section2 = true;
      this.section1 = false;
      this.book_customer = {{ $customer->cus_id }};
      @endif
      // alert('sss');

    },
    data: {
      section1: true,
      section2: false,
      book_customer: null,
      disabled: false,
      rate: 0,
      unit: 0,
      cities : [
                  'Bangalore','Chennai','Cochin',
                  'Delhi','Kolkata','Mumbai'
              ],

      value: ''
    },

    methods: {
        ajaxPost: function() {
          $('input[type="submit"]').prop('disabled', true);
        }
    },

    events: {
      'autocomplete-people:selected': function(data){
        console.log('selected-people',data);
        $('#basicModal').find('.modal-content').html('');
        $('#basicModal').modal('show');
        $('#basicModal').find('.modal-content').load("{{ urlTenant('bookings/new') }}" + '/' + data.id);
        // this.section2 = true;
        // this.section1 = false;
        // this.book_customer = data.id;
        // this.customer_label = data.title;
      },
    },
});
</script>
@endpush
