@extends('layouts.common_list')

@section('content_common_list')
<thead>
  <tr>
    <th>@lang('user.name')</th>
    <th>@lang('user.email')</th>
    <th>@lang('form.actions')</th>
  </tr>
</thead>
<tbody>
  @foreach ($merchant_users as $user)
  <tr>
    <td>{{ $user->user->name }}</td>
    <td>{{ $user->user->email }}</td>
    <td>
      <a href="{{ url( implode(Request::segments(), '/') . $user->mus_id . '/delete') }}" title="@lang('form.delete')"><i class="fa fa-trash"></i></a>
    </td>
  </tr>
  @endforeach
</tbody>
@endsection

@section('content_common_above')
<a href="{{ Request::url() . '/new' }}" v-modal>{{ Form::button(Lang::get('form.new'), ['class' => 'btn btn-primary']) }}</a>
@endsection
