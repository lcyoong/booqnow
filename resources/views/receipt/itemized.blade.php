@if(count($rcitems) > 0)
<table class="table">
  <thead>
    <tr>
      <th>@lang('receipt.rc_date')</th>
      <th>@lang('receipt.rc_method')</th>
      <th>@lang('receipt.rc_amount')</th>
      <th>@lang('receipt.rc_remark')</th>
    </tr>
  </thead>
  <tbody>
    @foreach($rcitems as $item)
      <tr>
        <td>{{ showDate($item->rc_date) }}</td>
        <td>{{ $item->rc_method }}</td>
        <td>{{ showMoney($item->rc_amount) }}</td>
        <td>{{ $item->rc_remark }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
@else
<div>@lang('form.na')</div>
@endif
