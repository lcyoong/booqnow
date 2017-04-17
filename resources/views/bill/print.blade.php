@extends($layout)

@push('header')
<div class="float-left" style="width: 50%">
  <table>
    <tr>
      <td>@lang('bill.bil_customer_name')</td><td> : </td><td>{{ $bill->bil_customer_name }}</td>
    </tr>
    <tr>
      <td>@lang('bill.bil_date')</td><td> : </td><td>{{ showDate($bill->bil_date) }}</td>
    </tr>
  </table>
</div>
@if($bill->booking)
<div class="float-right" style="text-align: right; width: 50%">
  <table>
    <tr>
      <td>@lang('booking.book_resource')</td><td> : </td><td>{{ $bill->booking->resource->rs_name}}</td>
    </tr>
    <tr>
      <td>@lang('booking.book_from')</td><td> : </td><td>{{ showDate($bill->booking->book_from) }}</td>
    </tr>
    <tr>
      <td>@lang('booking.book_to')</td><td> : </td><td>{{ showDate($bill->booking->book_to) }}</td>
    </tr>
    <tr>
      <td>@lang('booking.book_reference')</td><td> : </td><td>{{ $bill->booking->book_reference }}</td>
    </tr>
    <!-- <tr>
      <td>@lang('booking.book_tracking')</td><td> : </td><td>{{ $bill->booking->book_tracking }}</td>
    </tr> -->
    <tr>
      <td>@lang('booking.created_by')</td><td> : </td><td>{{ $bill->booking->creator->name }}</td>
    </tr>
  </table>
</div>
@else
-- Walk in --
<div style="clear:both;"></div>
<div class="float-left" style="width: 50%">
  <table>
    <tr>
      <td>@lang('bill.bil_date')</td><td> : </td><td>{{ showDate($bill->bil_date) }}</td>
    </tr>
  </table>
</div>
@endif
<div style="clear:both;"></div>
@endpush

@push('content')
  @foreach ($items->groupBy('rs_type') as $key => $item_group)
  <table width="100%" class="striped">
    <thead>
      <tr>
        <th width="50%">{{ array_get($resource_name, $key) }}</th>
        <th width="10%" class="text-center">@lang('bill.bili_unit')</th>
        <th width="20%" class="text-right">@lang('bill.bili_unit_price')</th>
        <th width="20%" class="text-right">@lang('bill.bili_gross')</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($item_group as $item)
      <tr>
        <td>{{ $item->bili_description }}</td>
        <td class="text-center">{{ $item->bili_unit }}</td>
        <td class="text-right">{{ showMoney($item->bili_unit_price) }}</td>
        <td class="text-right">{{ showMoney($item->bili_gross) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @endforeach

  @if($indie_items->count() > 0)
  <table width="100%" class="striped">
    <thead>
      <tr>
        <th width="50%">@lang('bill.bili_description')</th>
        <th width="10%" class="text-center">@lang('bill.bili_unit')</th>
        <th width="20%" class="text-right">@lang('bill.bili_unit_price')</th>
        <th width="20%" class="text-right">@lang('bill.bili_gross')</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($indie_items as $key => $item)
        <tr>
          <td>{{ $item->bili_description }}</td>
          <td class="text-center">{{ $item->bili_unit }}</td>
          <td class="text-right">{{ showMoney($item->bili_unit_price) }}</td>
          <td class="text-right">{{ showMoney($item->bili_gross) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
  @endif

<table width="100%" style="font-size: 1.1em;">
  <tr>
    <td width="80%" class="text-right bold">{{ appendCurrency(trans('bill.bil_gross')) }}:</td>
    <td width="20%" class="text-right">{{ showMoney($bill->bil_gross, false, 2) }}</td>
  </tr>
  <tr>
    <td width="80%" class="text-right bold">{{ appendCurrency(trans('bill.bil_tax')) }}:</td>
    <td width="20%" class="text-right">{{ showMoney($bill->bil_tax, false, 2) }}</td>
  </tr>
  <tr>
    <td width="80%" class="text-right bold">{{ appendCurrency(trans('bill.grand_total')) }}:</td>
    <td width="20%" class="text-right">{{ showMoney($bill->total_amount, false, 2) }}</td>
  </tr>
  <tr>
    <td width="80%" class="text-right bold">{{ appendCurrency(trans('bill.bil_paid')) }}:</td>
    <td width="20%" class="text-right">{{ showMoney($bill->bil_paid, false, 2) }}</td>
  </tr>
  <tr>
    <td width="80%" class="text-right bold">{{ appendCurrency(trans('bill.outstanding')) }}:</td>
    <td width="20%" class="text-right">{{ showMoney($bill->outstanding, false, 2) }}</td>
  </tr>
</table>
@endpush
