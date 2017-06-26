<div class="panel panel-default">
  <div class="panel-heading">
    <a data-toggle="collapse" data-parent="#accordion" href="#{{ $id }}">
      <h4>@lang('booking.departure_today', ['no' => $departures['today']->count()])</h4>
    </a>
  </div>
  <div id="{{ $id }}" class="panel-collapse collapse">
    <div class="panel-body">
      <ul class="list-group">
        @if ($departures['today']->count() > 0)
        <table class="table table-hover table-striped">
          <thead>
            <tr>
              <th>@lang('booking.book_customer')</th>
              <th>@lang('booking.book_status')</th>
              <th>@lang('bill.outstanding')</th>
              <th>@lang('form.actions')</th>
            </tr>
          </thead>
          <tbody>
            @foreach($departures['today'] as $departure)
              <tr>
                <td class="col-md-4">{{ $departure->customer->full_name }}
                  <div><span class="label label-info">{{ $departure->resource->rs_name }}</span></div>
                </td>
                <td class="col-md-3"><i class="fa fa-circle status-{{ $departure->book_status }}"></i> {{ $book_status[$departure->book_status] }}</td>
                <td class="col-md-4"><span class="label label-success">{{ showMoney($departure->totalBillOS()) }}</span></td>
                <td class="col-md-1"><a href="{{ urlTenant(sprintf("bookings/%s", $departure->book_id)) }}" v-modal><i class="fa fa-eye"></i></a></td>
              </tr>
            @endforeach
          </tbody>
        </table>
        @else
        <h4>@lang('booking.no_arrival')</h4>
        @endif
      </ul>
    </div>
  </div>
</div>
