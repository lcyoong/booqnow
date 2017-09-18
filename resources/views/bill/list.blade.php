@extends($layout)

@section('content_above_list')
@include('bill.filter')
@endsection

@section('content_list')
  <table class="table table-condensed table-striped table-hover">
    <thead>
      <tr>
        <th>@lang('bill.bil_id')</th>
        <th>@lang('bill.bil_customer_name')</th>
        <th>@lang('bill.bil_booking')</th>
        <th>@lang('bill.bil_date')</th>
        <th class="text-right">{{ trans('bill.total') }}</th>
        <th class="text-right">{{ trans('bill.outstanding') }}</th>
        <th class="text-center">@lang('bill.bil_status')</th>
        <th>@lang('form.actions')</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($list as $item)
        <tr>
          <td>{{ $item->display_id }}</td>
          <td>{{ $item->bil_customer_name }}</td>
          <td>{{ $item->booking->display_id or 'N/A' }} : {{ $item->bil_description }}</td>
          <td>{{ $item->bil_date }}</td>
          <td class="text-right">{{ $item->total_amount }}</td>
          <td class="text-right">{{ $item->outstanding }}</td>
          <td class="text-center">{{ $item->bil_status }}</td>
          <td>
            <a v-modal href="{{ url('bills/' . $item->bil_id) }}" title="@lang('form.view')"><i class="fa fa-eye"></i></a>
            <a href="{{ url(sprintf('bills/%s/edit', $item->bil_id)) }}" title="@lang('form.edit')"><i class="fa fa-edit"></i></a>
            <a v-modal href="{{ urlTenant('receipts/new/' . $item->bil_id) }}" title="@lang('form.pay')"><i class="fa fa-money"></i></a>
            <a href="{{ urlTenant(sprintf("bills/%s/print?" . str_random(40), $item->bil_id)) }}" target=_blank title="@lang('form.print')"><i class="fa fa-print"></i></a>
            <a v-modal href="{{ url(sprintf('trail/bills/%s', $item->bil_id)) }}" title="@lang('form.trail')"><i class="fa fa-history"></i></a>
            <!-- <a v-modal href="{{ url(sprintf('comments/bills/%s', $item->bil_id)) }}" title="@lang('form.comments')"><i class="fa fa-comment-o"></i></a> -->
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
