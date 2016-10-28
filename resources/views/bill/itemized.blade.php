@if(count($items) > 0)
<table class="table">
  <thead>
    <tr>
      <th>@lang('bill.bili_description')</th>
      <th>@lang('bill.bili_unit_price')</th>
      <th>@lang('bill.bili_unit')</th>
      <th>{{ appendCurrency(trans('bill.bili_gross')) }}</th>
      <th>{{ appendCurrency(trans('bill.bili_tax')) }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach($items as $item)
      <tr>
        <td>{{ $item->bili_description }}</td>
        <td>{{ showMoney($item->bili_unit_price) }}</td>
        <td>{{ $item->bili_unit }}</td>
        <td>{{ showMoney($item->bili_gross) }}</td>
        <td>{{ showMoney($item->bili_tax) }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
@else
<div>@lang('form.na')</div>
@endif
