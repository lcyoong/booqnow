@if(count($items) > 0)
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>@lang('bill.bili_description')</th>
      <th>@lang('bill.bili_unit_price')</th>
      <th>@lang('bill.bili_unit')</th>
      <th>{{ appendCurrency(trans('bill.total')) }}</th>
      @if(!config('myapp.hide_items_tax'))<th>{{ appendCurrency(trans('bill.bili_tax')) }}</th>@endif
    </tr>
  </thead>
  <tbody>
    @foreach($items as $item)
      <tr>
        <td class="col-md-3">{{ $item->bili_description }}</td>
        <td class="col-md-2">{{ showMoney($item->bili_unit_price) }}</td>
        <td class="col-md-1">{{ $item->bili_unit }}</td>
        <td class="col-md-2">{{ showMoney($item->total_amount) }}</td>
        @if(!config('myapp.hide_items_tax'))<td>{{ showMoney($item->bili_tax) }}</td>@endif
      </tr>
    @endforeach
  </tbody>
</table>
@else
<div class="v_margin_10"><span class="label label-danger">@lang('form.no_item')</span></div>
@endif
