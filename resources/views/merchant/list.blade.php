@extends('layouts.common_list')

@section('content_common_list')
<thead>
  <tr>
    <th>@lang('merchant.mer_name')</th>
    <th>@lang('merchant.mer_country')</th>
    <th>@lang('subscription.sub_plan')</th>
    <th>@lang('form.actions')</th>
  </tr>
</thead>
<tbody>
  @foreach ($merchants as $merchant)
  <tr>
    <td>{{ $merchant->mer_name }}</td>
    <td>{{ $merchant->mer_country }}</td>
    <td>{{ $merchant->subscription->plan->pla_description }}</td>
    <td>
      <a href="{{ url(sprintf('merchants/%s/edit', $merchant->mer_id)) }}" title="@lang('form.edit')"><i class="fa fa-edit"></i></a>
      <a href="{{ url(sprintf('merchants/%s/users', $merchant->mer_id)) }}" title="@lang('form.users')"><i class="fa fa-users"></i></a>
    </td>
  </tr>
  @endforeach
</tbody>
@endsection
