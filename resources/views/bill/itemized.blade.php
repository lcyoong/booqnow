@if(count($items) > 0)
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>@lang('bill.bili_description')</th>
      <th>@lang('bill.bili_date')</th>
      <!-- <th>@lang('bill.bili_print')</th> -->
      <th>@lang('bill.bili_unit_price')</th>
      <th>@lang('bill.bili_unit')</th>
      <th>{{ trans('bill.bili_gross') }}</th>
      @if(!config('myapp.hide_items_tax'))<th>{{ trans('bill.bili_tax') }}</th>@endif
    </tr>
  </thead>
  <tbody>
    @foreach($items as $item)
      <tr>
        <td class="col-md-4">{{ $item->bili_description }}</td>
        <td class="col-md-2">{{ $item->bili_date }}</td>
        <!-- <td class="col-md-2">@lang("form.yesno.{$item->bili_print}")</td> -->
        <td class="col-md-2">{{ showMoney($item->bili_unit_price) }}</td>
        <td class="col-md-2">{{ $item->bili_unit }}</td>
        <td class="col-md-2">{{ showMoney($item->bili_gross) }}</td>
        @if(!config('myapp.hide_items_tax'))<td>{{ showMoney($item->bili_tax) }}</td>@endif
      </tr>
    @endforeach
  </tbody>
</table>
@else
<div class="v_margin_10"><span class="label label-danger">@lang('form.no_item')</span></div>
@endif
