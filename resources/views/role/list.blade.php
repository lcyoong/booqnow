@extends($layout)

@section('content_above_list')
@endsection

@section('content_list')
  <table class="table table-condensed table-striped table-hover">
    <thead>
      <tr>
        <th>@lang('role.id')</th>
        <th>@lang('role.name')</th>
        <th>@lang('role.display_name')</th>
        <th>@lang('form.actions')</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($list as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->name }}</td>
          <td>{{ $item->display_name }}</td>
          <td>
            <a v-modal href="{{ url(sprintf('roles/%s/edit', $item->id)) }}" title="@lang('form.edit')"><i class="fa fa-edit"></i></a>
            <a v-modal href="{{ url(sprintf('roles/%s/permission', $item->id)) }}" title="@lang('form.permission')"><i class="fa fa-lock"></i></a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection

@prepend('content')
<div id="role-list">
@include('layouts.list', ['count' => $list->total()])
{{ $list->appends(Request::input())->links() }}
</div>
@endprepend

@push('scripts')
<script>

new Vue({
  el: '#role-list',
  components: {
  },
});

</script>
@endpush
