@extends($layout)

@section('content_above_list')
<a href="{{ urlTenant('resource_types/new') }}">{{ Form::button(Lang::get('form.new'), ['class' => 'btn btn-primary']) }}</a>
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
  @foreach ($resource_types as $type)
  <tr>
    <td>{{ $type->rty_name }}</td>
    <td>{{ $type->rty_price }}</td>
    <td>
      <a href="{{ urlTenant(sprintf('resource_types/%s/edit', $type->rty_id)) }}" title="@lang('form.edit')"><i class="fa fa-edit"></i></a>
    </td>
  </tr>
  @endforeach
</tbody>
@endsection


@push('content')
@include('layouts.list')
@endpush
