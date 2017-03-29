@extends($layout)

@section('content_above_list')
@endsection

@section('content_list')
  <table class="table table-condensed table-striped table-hover">
    <thead>
      <tr>
        <th>@lang('permission.id')</th>
        <th>@lang('permission.name')</th>
        <th>@lang('permission.display_name')</th>
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
            <a v-modal href="{{ url(sprintf('permissions/%s/edit', $item->id)) }}" title="@lang('form.edit')"><i class="fa fa-edit"></i></a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection

@prepend('content')
<div id="permission-list">
@include('layouts.list', ['count' => $list->total()])
{{ $list->appends(Request::input())->links() }}
</div>
@endprepend

@push('scripts')
<script>

new Vue({
  el: '#permission-list',
  components: {
  },
});

</script>
@endpush
