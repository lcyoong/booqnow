@extends($layout)

@section('content_above_list')
@include('agent.filter')
@endsection

@section('content_list')
  <table class="table table-condensed table-striped table-hover">
    <thead>
      <tr>
        <th>@lang('agent.ag_id')</th>
        <th>@lang('agent.ag_name')</th>
        <th>@lang('agent.ag_remarks')</th>
        <th>@lang('agent.ag_status')</th>
        <th>@lang('form.actions')</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($list as $item)
        <tr>
          <td>{{ $item->ag_id }}</td>
          <td>{{ $item->ag_name }}</td>
          <td>{{ $item->ag_remarks }}</td>
          <td>{{ $item->ag_status }}</td>
          <td>
            <a v-modal href="{{ url(sprintf('agents/%s/edit', $item->ag_id)) }}" title="@lang('form.edit')"><i class="fa fa-edit"></i></a>
            <a v-modal href="{{ url(sprintf('trail/agents/%s', $item->ag_id)) }}" title="@lang('form.trail')"><i class="fa fa-history"></i></a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection

@prepend('content')
<div id="agent-list">
@include('layouts.list', ['count' => $list->total()])
{{ $list->appends(Request::input())->links() }}
</div>
@endprepend

@push('scripts')
<script>

new Vue({
  el: '#agent-list',
  components: {
  },
});

</script>
@endpush
