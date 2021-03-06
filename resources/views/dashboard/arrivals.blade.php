<div class="panel panel-default">
  <div class="panel-heading">
    <a data-toggle="collapse" data-parent="#accordion" href="#{{ $id }}">
      <h4>@lang('booking.arrival_today', ['no' => $arrivals['today']->count()])</h4>
    </a>
  </div>
  <div id="{{ $id }}" class="panel-collapse collapse">
    <div class="panel-body">
      <ul class="list-group">
        @if ($arrivals['today']->count() > 0)
        <table class="table table-hover table-striped">
          <thead>
            <tr>
              <th>@lang('booking.book_customer')</th>
              <th>@lang('booking.book_status')</th>
              <th>@lang('booking.pax')</th>
              <th>@lang('form.actions')</th>
            </tr>
          </thead>
          <tbody>
            @foreach($arrivals['today'] as $arrival)
              <tr>
                <td class="col-md-4">{{ $arrival->customer->full_name }}
                  <div><span class="label label-info">{{ $arrival->resource->rs_name }}</span></div>
                  <i class="fa fa-sign-in"></i> {{ $arrival->book_checkin_time }}
                </td>
                <td class="col-md-3"><i class="fa fa-circle status-{{ $arrival->book_status }}"></i> {{ array_get($book_status,$arrival->book_status) }}</td>
                <td class="col-md-2">{{ $arrival->book_pax }} @lang('booking.book_pax') + {{ $arrival->book_pax_child }} @lang('booking.book_pax_child_simple')</td>
                <td class="col-md-3"><a href="{{ urlTenant(sprintf("bookings/%s", $arrival->book_id)) }}" v-modal><i class="fa fa-eye"></i></a></td>
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
