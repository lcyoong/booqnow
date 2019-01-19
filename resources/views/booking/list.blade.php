@extends($layout)

@section('content_above_list')
@include('booking.filter')
@endsection

@section('content_list')
<table class="table table-condensed">
<thead>
  <tr>
    <th>@lang('booking.book_id')</th>
    <th>@lang('booking.book_customer')</th>
    <th>@lang('booking.book_resource')</th>
    <th>@lang('booking.duration')</th>
    <th class="text-center">@lang('booking.book_pax')</th>
    <th class="text-center">@lang('booking.book_pax_child')</th>
    <th class="text-center">@lang('booking.book_extra_bed')</th>
    <th>@lang('booking.book_reference')</th>
    <th>@lang('booking.book_agent')</th>
    <!-- <th>@lang('booking.book_tracking')</th> -->
    <th>@lang('booking.book_status')</th>
    <th>@lang('form.actions')</th>
  </tr>
</thead>
<tbody>
  @foreach ($list as $item)
  <tr>
    <td>{{ $item->display_id }}</td>
    <td>{{ $item->customer->full_name }} @if($item->book_special) <i class="fa fa-star special-color"></i>@endif</td>
    <td>{{ $item->resource->rs_name }}</td>
    <td>{{ showDate($item->book_from) }} <i class="fa fa-sign-in"></i> {{ $item->book_checkin_time }}<br>{{ showDate($item->book_to) }} <i class="fa fa-sign-out"></i> {{ $item->book_checkout_time }}<br><span class="label label-info">{{ dayDiff($item->book_from, $item->book_to) }} @lang('booking.nights')</span></td>
    <td class="text-center">{{ $item->book_pax }}</td>
    <td class="text-center">{{ $item->book_pax_child }}</td>
    <td class="text-center">{{ $item->book_extra_bed }}</td>
    <td>{{ $item->book_reference }}</td>
    <td>{{ isset($item->agent) ? $item->agent->ag_name : null }}</td>
    <!-- <td>{{ $item->book_tracking }}</td> -->
    <td><i class="fa fa-circle status-{{ $item->book_status }}"></i> {{ $book_status[$item->book_status] }}</td>
    <td>
      <a v-modal href="{{ url(sprintf('bookings/%s', $item->book_id)) }}" title="@lang('form.view')"><i class="fa fa-eye"></i></a>
      <a href="{{ url(sprintf('bookings/%s/edit', $item->book_id)) }}" title="@lang('form.edit')"><i class="fa fa-edit"></i></a>
      <a href="{{ url(sprintf('bookings/%s/addons', $item->book_id)) }}" title="@lang('form.addons')"><i class="fa fa-plus"></i></a>
      <a v-modal href="{{ url(sprintf('trail/bookings/%s', $item->book_id)) }}"><i class="fa fa-history"></i></a>
      <!-- <a v-modal href="{{ url(sprintf('comments/bookings/%s', $item->book_id)) }}" title="@lang('form.comments')"><i class="fa fa-comment-o"></i></a> -->
    </td>
  </tr>
  @endforeach
</tbody>
</table>
@endsection


@push('content')
<div id="booking-list">
@include('layouts.list', ['count' => $list->total()])
{{ $list->appends(Request::input())->links() }}
</div>
@endpush

@push('scripts')
<script>

new Vue({
  el: '#booking-list',
  components: {
  },
});

</script>
@endpush
