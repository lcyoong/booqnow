@extends($layout)

@prepend('content')
@include('customer.profile', ['customer' => $booking->customer])
<div id="booking-edit" v-cloak>
  <!-- <a v-modal href="{{ urlTenant(sprintf('trail/bookings/%s', $booking->book_id)) }}"><i class="fa fa-history"></i></a>
  <a class="icon-button-margin" v-modal href="{{ urlTenant(sprintf('comments/bookings/%s', $booking->book_id)) }}" title="@lang('form.comments')"><i class="fa fa-comment-o"></i></a> -->
  <!-- Customer info -->

  <form-ajax action = "{{ urlTenant('bookings/update') }}" method="POST" @startwait="startWait" @endwait="endWait" @completesuccess="redirectToDate">
    {{ Form::hidden('book_id', $booking->book_id) }}
    <div class="row">
      {{ Form::bsSelect('book_resource', trans('booking.book_resource'), $rooms, $booking->book_resource, ['style' => 'width:100%', 'vmodel' => 'booking.book_resource', 'class'=>'select2']) }}
      {{ Form::bsDate('book_expiry', trans('booking.book_expiry'), $booking->book_expiry, ['class' => 'datetimepicker form-control', 'vmodel' => 'booking.book_to']) }}
    </div>
    <div class="row">
      {{ Form::bsDate('book_from', trans('booking.book_from'), $booking->book_from, ['vmodel' => 'booking.book_from']) }}
      {{ Form::bsDate('book_checkin_time', trans('booking.book_checkin_time'), $booking->book_checkin_time, ['class' => 'timepicker form-control']) }}
      {{ Form::bsDate('book_to', trans('booking.book_to'), $booking->book_to, ['vmodel' => 'booking.book_to']) }}
      {{ Form::bsDate('book_checkout_time', trans('booking.book_checkout_time'), $booking->book_checkout_time, ['class' => 'timepicker form-control']) }}
    </div>
    <div class="row">
      {{ Form::bsSelect('book_source', trans('booking.book_source'), $booking_sources, null, ['v-model' => 'source', '@change' => 'switchSource']) }}
      <span v-if="source == 3">
      {{ Form::bsSelect('book_agent', trans('booking.book_agent'), $agents, $booking->book_agent, ['class' => 'select2 form-control']) }}
      </span>
      <span v-else-if="source == 1">
      {{ Form::bsSelect('book_agent', trans('booking.book_sales'), $sales, $booking->book_agent, ['class' => 'select2 form-control']) }}
      </span>
      <span v-else>
      {{ Form::hidden('book_agent', '') }}
      </span>
      {{ Form::bsNumber('book_pax', trans('booking.book_pax'), $booking->book_pax, ['min' => 1, 'max'=>20], 2) }}
      {{ Form::bsNumber('book_pax_child', trans('booking.book_pax_child'), $booking->book_pax_child, ['min' => 0, 'max'=>20], 2) }}
      {{ Form::bsNumber('book_extra_bed', trans('booking.book_extra_bed'), $booking->book_extra_bed, ['min' => 0, 'max'=>5], 2) }}
    </div>
    <div class="row">
      {{ Form::bsText('book_reference', trans('booking.book_reference'), $booking->book_reference) }}
      {{ Form::bsSelect('book_lead_from', trans('booking.book_lead_from'), $book_leads, $booking->book_lead_from, ['style' => 'width:100%', 'vmodel' => 'booking.book_lead_from']) }}
      {{ Form::bsSelect('book_status', trans('booking.book_status'), $book_status, $booking->book_status, ['style' => 'width:100%', 'vmodel' => 'booking.book_status']) }}
      <div class="col-md-3">
        <div class="form-group">
          <label for="book_special" class="control-label">@lang('booking.book_special')</label>
          <div>
            {{ Form::hidden('book_special', 0) }}
            {{ Form::checkbox('book_special', 1, $booking->book_special ? true : false, ['data-toggle' => 'toggle']) }}
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      {{ Form::bsTextarea('book_remarks', trans('booking.book_remarks'), $booking->book_remarks, ['rows' => 4]) }}
    </div>
    {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm', ':disabled' => 'waiting']) }}
    <a href="{{ url('bookings') }}">{{ Form::button(trans('form.cancel'), ['class' => 'btn btn-primary btn-sm']) }}</a>
  </form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#booking-edit",

  mixins: [mixForm],

  created: function () {
    this.switchSource()
    console.log(this.redirect_to_date)
    $(function() {
      $('.timepicker').datetimepicker({
        format: 'LT',
      });
    })
  },

  data: {
    book_special: Boolean({{ $booking->book_special }}),
    agents: [],
    redirect_to_date: {!! json_encode($redirect_to_date) !!},
    agent: '{{ $booking->book_agent }}',
    source: '{{ $booking->book_source }}',
  },

  methods: {
    switchSource: function () {

      $('#book_agent option[value!=""]').remove()

      if (this.source == 3) {

        this.getAgents('agents')

      } else if (this.source == 1) {

        this.getAgents('sales')

      } else {

        this.agents = []

      }

    },

    getAgents: function (type) {

      this.$http.get("{{ urlTenant("api/v1/agents/") }}/" + type)
          .then(function (response) {
            var data = JSON.parse(response.data)
            this.agents = data

          });
    },

    redirectToDate: function(value) {
        if(value.data && value.data.redirect_to && !!this.redirect_to_date) {
          window.location.replace("{{ url('?date=') }}" + value.data.redirect_to);
        }
      }

  }
})
</script>
@endprepend
