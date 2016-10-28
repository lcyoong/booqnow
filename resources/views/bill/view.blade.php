@extends($layout)

@push('content')
@include('customer.profile')
<hr/>
<div class="row">
  {{ Form::showField($single->bil_booking, trans('bill.bil_booking')) }}
  {{ Form::showField(showDate($single->bil_date), trans('bill.bil_date')) }}
  {{ Form::showField(showMoney($single->bil_gross + $single->bil_tax), trans('bill.total')) }}
  {{ Form::showField($single->bil_status, trans('bill.bil_status')) }}
</div>
<hr/>
@include('bill.itemized', ['items' => $single->items])
<span class="label label-info">@lang('receipt.list')</span>
@include('receipt.itemized', ['rcitems' => $single->receipts])
@endpush
