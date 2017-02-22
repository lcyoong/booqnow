@extends($layout)

@section('content_above_list')
@include('bill.filter')
@endsection

@section('content_list')
  <table class="table table-condensed">
    <thead>
      <tr>
        <th>@lang('bill.bil_id')</th>
        <th>@lang('bill.bil_customer')</th>
        <th>@lang('bill.bil_booking')</th>
        <th>@lang('bill.bil_date')</th>
        <th>{{ appendCurrency(trans('bill.total')) }}</th>
        <th>{{ appendCurrency(trans('bill.outstanding')) }}</th>
        <th>@lang('form.actions')</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($list as $item)
        <tr>
          <td>{{ $item->bil_id }}</td>
          <td>{{ $item->customer->full_name }}</td>
          <td>{{ $item->bil_booking }} : {{ $item->bil_description }}</td>
          <td>{{ $item->bil_date }}</td>
          <td>{{ $item->total_amount }}</td>
          <td>{{ $item->outstanding }}</td>
          <td>
            <a v-modal href="{{ url('bills/' . $item->bil_id) }}" title="@lang('form.view')"><i class="fa fa-eye"></i></a>
            <a v-modal href="{{ url('trail/bills/' . $item->bil_id) }}" title="@lang('form.trail')"><i class="fa fa-history"></i></a>
            <a v-modal href="{{ urlTenant('receipts/new/' . $item->bil_id) }}" title="@lang('form.pay')"><i class="fa fa-money"></i></a>
            <a href="{{ urlTenant(sprintf("bills/%s/print", $item->bil_id)) }}" target=_blank title="@lang('form.print')"><i class="fa fa-print"></i></a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection

@prepend('content')
<div id="bill-list">
@include('layouts.list', ['count' => $list->total()])
{{ $list->appends(Request::input())->links() }}
</div>
@endprepend

@push('scripts')
<script>

new Vue({
  el: '#bill-list',
  components: {
  },
});

</script>
@endpush
