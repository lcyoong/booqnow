@extends($layout)

@push('content')
<div class="row">
  {{ Form::open(['url' => 'dashboard', 'method' => 'get']) }}
  <div class="col-md-2">
    {{ Form::datepicker('date', 'Pick a date', $date) }}
  </div>
  <div class="col-md-2">
    {{ Form::submit(trans('form.go'), ['class' => 'btn btn-primary btn-sm']) }}
  </div>
  {{ Form::close() }}
</div>
<br/>
<div class="panel panel-default" id="dashboard">
  <div class="panel-body">
    <div class="row">
      <div class="col-md-6">
        @include('dashboard.arrivals', ['arrivals' => $arrivals, 'id' => 'arrivals'])
      </div>
      <div class="col-md-6">
        @include('dashboard.departures', ['departures' => $departures, 'id' => 'departures'])
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        @include('dashboard.addons', ['addons' => $tours, 'id' => 'tours', 'type' => 'Tour'])
      </div>
      <div class="col-md-6">
        @include('dashboard.addons', ['addons' => $transfers, 'id' => 'transfers', 'type' => 'Transfer'])
      </div>
    </div>
  </div>
</div>

@endpush

@prepend('scripts')
<script>
var app2 = new Vue({
  el: '#dashboard',
  mixins: [mixForm],
});
</script>
@endprepend
