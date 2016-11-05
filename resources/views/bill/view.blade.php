@extends($layout)

@push('content')
@include('customer.profile')
<hr/>
@include('bill.basic', ['bill' => $single])
<hr/>
@include('bill.itemized', ['items' => $single->items])
@include('receipt.itemized', ['rcitems' => $single->receipts])
@endpush
