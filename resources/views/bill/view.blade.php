@extends($layout)

@push('content')
@include('customer.profile', ['customer' => $bill->customer])
<hr/>
@include('bill.basic', ['bill' => $bill])
<hr/>
@include('bill.itemized', ['items' => $bill->items])
@include('receipt.itemized', ['rcitems' => $bill->receipts])
@endpush
