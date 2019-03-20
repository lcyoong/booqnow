@extends($layout)

@push('header')
<div style="width: 50%">
  <table class="float-left" style="width:100%">
    <tr>
      <td width="25%">@lang('bill.bil_customer_name')</td><td width="5%"> : </td><td width="70%">{{ $bill->bil_customer_name }}</td>
    </tr>
    <!-- <tr>
      <td>@lang('bill.bil_date')</td><td> : </td><td>{{ showDate($bill->bil_date) }}</td>
    </tr> -->
  </table>
</div>
@if($bill->booking)
<div class="float-right" style="text-align: right; width: 50%">
  <table style="width:100%">
    <tr>
      <td width="25%">@lang('booking.book_resource')</td><td width="5%"> : </td><td width="70%">{{ $bill->booking->resource->rs_name}} #{{ showBookingNo($bill->booking->book_id) }}</td>
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
<div class="float-right" style="width: 50%">
  -- Walk in --
  <div style="clear:both;"></div>
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
<table width="100%" class="table">
  <thead>
    <tr>
      <th width="50%">Item</th>
      <th width="10%" class="text-center">@lang('bill.bili_unit')</th>
      <th width="20%" class="text-right">@lang('bill.bili_unit_price')</th>
      <th width="20%" class="text-right">{{ appendCurrency(trans('bill.bili_gross')) }}</th>
    </tr>
  </thead>
  <tbody>
    @php
      $gross = 0;
      $tax = 0;
    @endphp
    @if(count($addon_items) > 0)
      @foreach ($addon_items as $key => $item_group)
      <tr class="tr-header">
        <td colspan="4">Day Bill {{ $key }}</td>
      </tr>
      @foreach ($item_group as $item)
      @php
        $gross += $item['bili_gross'];
        $tax += $item['bili_tax'];
      @endphp
      <tr>
        <td>{{ $item['bili_description'] }}
          @if($item['rs_type'] == 2 || $item['rs_type'] == 4)
          <br/>{{ Carbon\Carbon::parse($item['add_date'])->format('d M Y H:i') }} ({{ $item['add_pax'] }} adults, {{ $item['add_pax_child'] }} children)
          @endif
        </td>
        <td class="text-center">{{ $item['bili_unit'] }}</td>
        <td class="text-right">{{ showMoney($item['bili_unit_price']) }}</td>
        <td class="text-right">{{ showMoney($item['bili_gross']) }}</td>
      </tr>
      @endforeach
      @endforeach
    @endif

    @if($indie_items->count() > 0)
      <tr class="tr-header">
        <td colspan="4">Others</td>
      </tr>
      @foreach ($indie_items as $key => $item)
        @php
          $gross += $item->bili_gross;
          $tax += $item->bili_tax;
        @endphp
        <tr>
          <td>{{ $item->bili_description }}</td>
          <td class="text-center">{{ $item->bili_unit }}</td>
          <td class="text-right">{{ showMoney($item->bili_unit_price) }}</td>
          <td class="text-right">{{ showMoney($item->bili_gross) }}</td>
        </tr>
      @endforeach
    @endif


  </tbody>
</table>


<table width="100%" style="font-size: 1.1em;">
  <tr>
    <td width="80%" class="text-right bold">{{ trans('bill.bil_gross') }}:</td>
    <td width="20%" class="text-right">{{ showMoney($gross, false, 2) }}</td>
  </tr>
  @if($bill->bil_with_tax)
  <tr>
    <td width="80%" class="text-right bold">{{ trans('bill.bil_tax') }}:</td>
    <td width="20%" class="text-right">{{ showMoney($tax, false, 2) }}</td>
  </tr>
  <tr>
    <td width="80%" class="text-right bold">{{ trans('bill.grand_total') }}:</td>
    <td width="20%" class="text-right">{{ showMoney($gross + $tax, false, 2) }}</td>
  </tr>
  @endif
  <tr>
    <td width="80%" class="text-right bold">{{ trans('bill.deposit_paid') }}:</td>
    <td width="20%" class="text-right">({{ showMoney($bill->deposit(), false, 2) }})</td>
  </tr>
  <tr>
    <td width="80%" class="text-right bold">{{ trans('bill.others_paid') }}:</td>
    <td width="20%" class="text-right">({{ showMoney($bill->bil_paid - $bill->deposit(), false, 2) }})</td>
  </tr>
  <tr>
    <td width="80%" class="text-right bold">{{ trans('bill.amount_due') }}:</td>
    <td width="20%" class="text-right">{{ showMoney($gross + $tax - $bill->bil_paid - $bill->deposit() , false, 2) }}</td>
  </tr>
</table>
@endpush