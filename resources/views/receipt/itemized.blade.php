@if(count($rcitems) > 0)
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>@lang('receipt.rc_date')</th>
      <th>@lang('receipt.rc_method')</th>
      <th>@lang('receipt.rc_type')</th>
      <th>{{ trans('receipt.rc_amount') }}</th>
      <!-- <th>@lang('receipt.rc_remark')</th> -->
    </tr>
  </thead>
  <tbody>
    @foreach($rcitems as $item)
      <tr>
        <td class="col-md-2">{{ showDate($item->rc_date) }}</td>
        <td class="col-md-2">{{ array_get($pay_methods, $item->rc_method) }}</td>
        <td class="col-md-2">{{ array_get($rc_type, $item->rc_type) }}</td>
        <td class="col-md-2">{{ showMoney($item->rc_amount) }}</td>
        <!-- <td class="col-md-2">{{ $item->rc_remark }}</td> -->
      </tr>
    @endforeach
  </tbody>
</table>
@else
<div class="v_margin_10"><span class="label label-danger">@lang('form.no_receipt')</span></div>
@endif
