@extends($layout)

@section('content_above_list')
@endsection

@section('content_list')
  <table class="table table-condensed table-striped table-hover">
    <thead>
      <tr>
        <th>@lang('expense_category.exc_id')</th>
        <th>@lang('expense_category.exc_name')</th>
        <th>@lang('expense_category.exc_status')</th>
        <th>@lang('form.actions')</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($list as $item)
        <tr>
          <td>{{ $item->exc_id }}</td>
          <td>{{ $item->exc_name }}</td>
          <td>{{ $item->exc_status }}</td>
          <td>
            <a v-modal href="{{ url(sprintf('expenses_category/%s/edit', $item->exc_id)) }}" title="@lang('form.edit')"><i class="fa fa-edit"></i></a>
            <a v-modal href="{{ url(sprintf('trail/expenses_category/%s', $item->exc_id)) }}" title="@lang('form.trail')"><i class="fa fa-history"></i></a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection

@prepend('content')
<div id="expense-category-list">
@include('layouts.list', ['count' => $list->total()])
{{ $list->appends(Request::input())->links() }}
</div>
@endprepend

@push('scripts')
<script>

new Vue({
  el: '#expense-category-list',
  components: {
  },
});

</script>
@endpush
