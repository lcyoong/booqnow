@extends($layout)

@section('content_above_list')
@include('booking.filter')
@endsection

@section('content_list')
<thead>
  <tr>
    <th>@lang('booking.book_id')</th>
    <th>@lang('booking.book_customer')</th>
    <th>@lang('booking.book_resource')</th>
    <th>@lang('booking.duration')</th>
    <th>@lang('booking.book_pax')</th>
    <th>@lang('booking.book_reference')</th>
    <th>@lang('booking.book_tracking')</th>
    <th>@lang('booking.book_status')</th>
    <th>@lang('form.actions')</th>
  </tr>
</thead>
<tbody>
  @foreach ($list as $item)
  <tr>
    <td>{{ $item->book_id }}</td>
    <td>{{ $item->customer->full_name }}</td>
    <td>{{ $item->resource->rs_name }}</td>
    <td><span class="label label-info">{{ dayDiff($item->book_from, $item->book_to) }} @lang('booking.nights')</span> {{ showDate($item->book_from) }} - {{ showDate($item->book_to) }}</td>
    <td>{{ $item->book_pax }}</td>
    <td>{{ $item->book_reference }}</td>
    <td>{{ $item->book_tracking }}</td>
    <td>{{ $item->book_status }}</td>
    <td>
      <a v-modal href="{{ url(sprintf('bookings/%s', $item->book_id)) }}" title="@lang('form.view')"><i class="fa fa-eye"></i></a>
    </td>
  </tr>
  @endforeach
</tbody>
@endsection

@push('content')
@include('layouts.list', ['count' => $list->count()])
@endpush
