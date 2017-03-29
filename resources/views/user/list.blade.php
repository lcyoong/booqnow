@extends($layout)

@section('content_above_list')
@include('user.filter')
@endsection

@section('content_list')
  <table class="table table-condensed table-striped table-hover">
    <thead>
      <tr>
        <th>@lang('user.id')</th>
        <th>@lang('user.name')</th>
        <th>@lang('user.email')</th>
        <th>@lang('user.role')</th>
        <th>@lang('form.actions')</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($list as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->name }}</td>
          <td>{{ $item->email }}</td>
          <td>{{ $item->roles->first()->display_name }}</td>
          <td>
            <a v-modal href="{{ url(sprintf('users/%s/edit', $item->id)) }}" title="@lang('form.edit')"><i class="fa fa-edit"></i></a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection

@prepend('content')
<div id="user-list">
@include('layouts.list', ['count' => $list->total()])
{{ $list->appends(Request::input())->links() }}
</div>
@endprepend

@push('scripts')
<script>

new Vue({
  el: '#user-list',
  components: {
  },
});

</script>
@endpush
