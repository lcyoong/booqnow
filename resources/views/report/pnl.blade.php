@extends($layout)

@section('content_above_list')
@include('report.pnl_filter')
@endsection

@section('content_list')
<thead>
  <tr>
    <th>@lang('resource_type.rty_name')</th>
    <th>@lang('resource_type.rty_price')</th>
    <th>@lang('form.actions')</th>
  </tr>
</thead>
<tbody>
</tbody>
@endsection


@push('content')
@include('layouts.list')
@endpush
