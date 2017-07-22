@extends($layout)

@section('content_above_list')
@include('resource.filter')
@endsection

@section('content_list')
<table class="table table-condensed">
<thead>
  <tr>
    <th>@lang('resource.rs_name')</th>
    <th>@lang('resource.rs_description')</th>
    <th class="text-right">@lang('resource.rs_price')</th>
    <th>@lang('resource.rs_label')</th>
    <th>@lang('resource.rs_sub_type')</th>
    <th class="text-center">@lang('resource.rs_status')</th>
    <th>@lang('form.actions')</th>
  </tr>
</thead>
<tbody>
  @foreach ($resources as $resource)
  <tr>
    <td>{{ $resource->rs_name }}</td>
    <td>{{ $resource->rs_description }}</td>
    <td class="text-right">{{ showMoney($resource->rs_price) }}</td>
    <td>{{ $resource->rs_label }}</td>
    <td>{{ $resource->subType->rsty_name or 'N/A' }}</td>
    <td class="text-center">{{ $resource->rs_status }}</td>
    <td>
      <a href="{{ urlTenant(sprintf('resources/%s/edit', $resource->rs_id)) }}" title="@lang('form.edit')"><i class="fa fa-edit"></i></a>
      <a href="{{ urlTenant(sprintf('resources/%s/maintenance', $resource->rs_id)) }}" title="@lang('form.maintenance')"><i class="fa fa-wrench"></i></a>
      <a href="{{ urlTenant(sprintf('resources/%s/pricing', $resource->rs_id)) }}" title="@lang('form.rate')"><i class="fa fa-dollar"></i></a>
    </td>
  </tr>
  @endforeach
</tbody>
</table>
@endsection


@prepend('content')
@include('layouts.list', ['count' => $resources->count()])
{{ $resources->links() }}
@endprepend
