@extends($layout)

@section('content_above_list')
@include('bill.filter')
@endsection

@section('content_list')
<thead>
  <tr>
    <th>@lang('bill.bil_id')</th>
    <th>@lang('bill.bil_customer')</th>
    <!-- <th>@lang('bill.bil_booking')</th> -->
    <th>@lang('bill.bil_date')</th>
    <th>{{ appendCurrency(trans('bill.total')) }}</th>
    <th>{{ appendCurrency(trans('bill.outstanding')) }}</th>
    <!-- <th>@lang('bill.bil_status')</th> -->
    <th>@lang('form.actions')</th>
  </tr>
</thead>
<tbody>
  @foreach ($list as $item)
  <tr>
    <td>{{ $item->bil_id }}</td>
    <td>{{ $item->customer->full_name }}</td>
    <!-- <td>{{ $item->bil_booking }}</td> -->
    <td>{{ showDate($item->bil_date) }}</td>
    <td>{{ showMoney($item->bil_gross + $item->bil_tax) }}</td>
    <td><span class="label label-success">{{ showMoney($item->outstanding) }}</span></td>
    <!-- <td>{{ $item->bil_status }}</td> -->
    <td>
      <a v-modal href="{{ url(sprintf('bills/%s', $item->bil_id)) }}" title="@lang('form.view')"><i class="fa fa-eye"></i></a>
      <a href="{{ urlTenant(sprintf("bills/%s/print", $item->bil_id)) }}" target=_blank><i class="fa fa-print"></i></a>
    </td>
  </tr>
  @endforeach
</tbody>
@endsection

@push('content')
@include('layouts.list', ['count' => $list->total()])
{{ $list->appends(Request::input())->links() }}
@endpush
