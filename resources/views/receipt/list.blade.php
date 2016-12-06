@extends($layout)

@section('content_above_list')
@include('receipt.filter')
@endsection

@section('content_list')
<thead>
  <tr>
    <th>@lang('receipt.rc_id')</th>
    <th>@lang('receipt.rc_customer')</th>
    <th>@lang('receipt.rc_date')</th>
    <th>@lang('receipt.rc_bill')</th>
    <th>{{ appendCurrency(trans('receipt.rc_amount')) }}</th>
    <!-- <th>@lang('form.actions')</th> -->
  </tr>
</thead>
<tbody>
  @foreach ($list as $item)
  <tr>
    <td>{{ $item->rc_id }}</td>
    <td>{{ $item->customer->full_name }}</td>
    <td>{{ showDate($item->rc_date) }}</td>
    <td>{{ $item->rc_bill }} <a href="{{ urlTenant(sprintf("bills/%s/print", $item->rc_bill)) }}" target=_blank><i class="fa fa-print"></i></a></td>
    <td>{{ showMoney($item->rc_amount) }}</td>
    <!-- <td>
      <a v-modal href="{{ url(sprintf('receipts/%s', $item->rc_id)) }}" title="@lang('form.view')"><i class="fa fa-eye"></i></a>
    </td> -->
  </tr>
  @endforeach
</tbody>
@endsection

@push('content')
@include('layouts.list', ['count' => $list->total()])
{{ $list->appends(Request::input())->links() }}
@endpush
