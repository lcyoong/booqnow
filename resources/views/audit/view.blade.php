@extends($layout)

@push('content')
@include('audit.itemized', ['items' => $trail])
@endpush
