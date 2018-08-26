@extends($layout)

@prepend('content')
@if($bill->customer)
@include('customer.profile', ['customer' => $bill->customer])
@else
<span class="label label-info"><i class="fa fa-blind"></i> @lang('bill.walkin')</span>
@endif
<h4>{{ $bill->bil_description }}</h4>
<div class="panel-group" id="accordion">
<div class="panel panel-default">
  <div class="panel-heading">
    <a data-toggle="collapse" data-parent="#accordion" href="#collapse_bill_items">
      @include('bill.basic', ['bill' => $bill])
    </a>
  </div>
  <div id="collapse_bill_items" class="panel-collapse collapse in">
    <div class="panel-body">
      @include('bill.itemized', ['items' => $bill->items])
    </div>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <a data-toggle="collapse" data-parent="#accordion" href="#collapse_receipts">
      {{ $bill->active_receipts->count() }} receipts
    </a>
  </div>
  <div id="collapse_receipts" class="panel-collapse collapse">
    <div class="panel-body">
      @include('receipt.itemized', ['rcitems' => $bill->active_receipts])
    </div>
  </div>
</div>
</div>
<a href="{{ urlTenant(sprintf("bills/%s/print?" . str_random(40), $bill->bil_id)) }}" target=_blank><i class="fa fa-print"></i> @lang('form.print')</a>
@endprepend
