@extends($layout)

@push('content')
<div class="row">
  <div class="col-md-6">
    <h4>@lang('booking.arrival_today', ['no' => $arrivals['today']->count()])</h4>
    @if ($arrivals['today']->count() > 0)
    <ul class="list-group">
    @foreach($arrivals['today'] as $arrival)
      <li class="list-group-item">
        <div class="row">
          <div class="col-md-4">{{ $arrival->customer->full_name }}
            <div><span class="label label-info">{{ $arrival->resource->rs_name }}</span></div>
          </div>
          <div class="col-md-3"><i class="fa fa-circle status-{{ $arrival->book_status }}"></i> {{ $book_status[$arrival->book_status] }}</div>
          <div class="col-md-2">{{ $arrival->book_pax }} @lang('booking.book_pax')</div>
          <div class="col-md-3"><a href="{{ urlTenant(sprintf("bookings/%s", $arrival->book_id)) }}" v-modal><i class="fa fa-eye"></i></a></div>
        </div>
      </li>
    @endforeach
    </ul>
    @else
    <h4>@lang('booking.no_arrival')</h4>
    @endif
  </div>
  <div class="col-md-6">
    <h4>@lang('booking.departure_today', ['no' => $departures['today']->count()])</h4>
    <ul class="list-group">
    @foreach($departures['today'] as $departure)
      <li class="list-group-item">
        <div class="row">
          <div class="col-md-4">{{ $departure->customer->full_name }}
            <div><span class="label label-info">{{ $departure->resource->rs_name }}</span></div>
          </div>
          <div class="col-md-3"><i class="fa fa-circle status-{{ $departure->book_status }}"></i> {{ $book_status[$departure->book_status] }}</div>
          <div class="col-md-4">O/S: <span class="label label-success">{{ showMoney($departure->totalBillOS()) }}</span></div>
          <div class="col-md-1"><a href="{{ urlTenant(sprintf("bookings/%s", $departure->book_id)) }}" v-modal><i class="fa fa-eye"></i></a></div>
        </div>
      </li>
    @endforeach
    </ul>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <h4>{{ $tours->count() }} tour(s)</h4>
    <ul class="list-group">
    @foreach($tours as $tour)
      <li class="list-group-item">
        <div class="row">
          <div class="col-md-4">{{ $tour->add_customer_name }}
            <div><span class="label label-info">{{ $tour->booking->resource->rs_name or '' }}</span></div>
          </div>
          <div class="col-md-4">{{ $tour->resource->rs_name }}</div>
          <div class="col-md-2">{{ $tour->add_pax }} @lang('addon.add_pax')</div>
          <div class="col-md-2">{{ $tour->add_status }}</div>
        </div>
      </li>
    @endforeach
    </ul>
  </div>
  <div class="col-md-6">
  </div>
</div>

@endpush
