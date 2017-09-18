@extends($layout)

@section('content_above_list')
@endsection

@section('content_list')
<table class="table table-condensed">
<thead>
  <tr>
    <th>@lang('resource_sub_type.rsty_name')</th>
    <th>@lang('resource_sub_type.rsty_type')</th>
    <th>@lang('resource_sub_type.resources')</th>
    <th>@lang('resource_sub_type.rsty_status')</th>
    <th>@lang('form.actions')</th>
  </tr>
</thead>
<tbody>
  @foreach ($resource_sub_types as $type)
  <tr>
    <td>{{ $type->rsty_name }}</td>
    <td>{{ $type->type->rty_name }}</td>
    <td>{{ $type->resources->count() }}</td>
    <td>{{ $type->rsty_status }}</td>
    <td>
      <a href="{{ urlTenant("resource_sub_types/{$type->rsty_id}/edit") }}" title="@lang('form.edit')"><i class="fa fa-edit"></i></a>
    </td>
  </tr>
  @endforeach
</tbody>
</table>
@endsection


@push('content')
@include('layouts.list')
@endpush
