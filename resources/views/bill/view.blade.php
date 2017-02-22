@extends($layout)

@prepend('content')
@include('customer.profile', ['customer' => $bill->customer])
<hr/>
<h4>{{ $bill->bil_description }}</h4>
@include('bill.basic', ['bill' => $bill])
<hr/>
@include('bill.itemized', ['items' => $bill->items])
@include('receipt.itemized', ['rcitems' => $bill->receipts])
<a href="{{ urlTenant(sprintf("bills/%s/print", $bill->bil_id)) }}" target=_blank><i class="fa fa-print"></i> @lang('form.print')</a>
@endprepend
