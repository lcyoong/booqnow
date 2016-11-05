@extends($layout)

@section('content_above_list')
@include('resource.filter')
@endsection

@section('content_list')
<thead>
  <tr>
    <th>@lang('resource.rs_name')</th>
    <th>@lang('resource.rs_description')</th>
    <th>@lang('resource.rs_price')</th>
    <th>@lang('resource.rs_status')</th>
    <th>@lang('form.actions')</th>
  </tr>
</thead>
<tbody>
  @foreach ($resources as $resource)
  <tr>
    <td>{{ $resource->rs_name }}</td>
    <td>{{ $resource->rs_description }}</td>
    <td>{{ showMoney($resource->rs_price) }}</td>
    <td>{{ $resource->rs_status }}</td>
    <td>
      <a href="{{ urlTenant(sprintf('resources/%s/edit', $resource->rs_id)) }}" title="@lang('form.edit')"><i class="fa fa-edit"></i></a>
      <!-- <a href="{{ urlTenant(sprintf('resources/%s/rate', $resource->rs_id)) }}" title="@lang('form.rate')"><i class="fa fa-dollar"></i></a> -->
    </td>
  </tr>
  @endforeach
</tbody>
@endsection


@push('content')
@include('layouts.list')
{{ $resources->links() }}
@endpush
