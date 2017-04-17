@extends($layout)

@section('content_above_list')
@include('receipt.filter')
@endsection

@section('content_list')
<table class="table table-condensed table-striped table-hover">
  <thead>
    <tr>
      <th>@lang('receipt.rc_id')</th>
      <th>@lang('receipt.rc_customer')</th>
      <th>@lang('receipt.rc_date')</th>
      <th>@lang('receipt.rc_bill')</th>
      <th>@lang('receipt.rc_method')</th>
      <th>@lang('receipt.rc_type')</th>
      <th>@lang('receipt.rc_remark')</th>
      <th>{{ trans('receipt.rc_amount') }}</th>
      <th>@lang('receipt.rc_status')</th>
      <th>@lang('form.actions')</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($list as $item)
    <tr>
      <td>{{ $item->rc_id }}</td>
      <td>{{ $item->bill->bil_customer_name }}</td>
      <td>{{ showDate($item->rc_date) }}</td>
      <td>{{ $item->rc_bill }} <a v-modal href="{{ url ('bills/' . $item->rc_bill) }}"><i class="fa fa-eye"></i></a></td>
      <td>{{ array_get($pay_methods, $item->rc_method) }}</td>
      <td>{{ array_get($rc_type, $item->rc_type) }}</td>
      <td>{{ $item->rc_remark }}</td>
      <td>{{ showMoney($item->rc_amount) }}</td>
      <td>{{ $item->rc_status }}</td>
      <td>
        <a v-modal href="{{ url(sprintf('receipts/%s/edit', $item->rc_id)) }}" title="@lang('form.edit')"><i class="fa fa-edit"></i></a>
        <a v-modal href="{{ url(sprintf('trail/receipts/%s', $item->rc_id)) }}" title="@lang('form.trail')"><i class="fa fa-history"></i></a>
        <!-- <a v-modal href="{{ url(sprintf('comments/receipts/%s', $item->rc_id)) }}" title="@lang('form.comments')"><i class="fa fa-comment-o"></i></a> -->
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection

@prepend('content')
<div id="receipt-list">
@include('layouts.list', ['count' => $list->total()])
{{ $list->appends(Request::input())->links() }}
</div>
@endprepend

@push('scripts')
<script>

new Vue({
  el: '#receipt-list',
  components: {
  },
});

</script>
@endpush
