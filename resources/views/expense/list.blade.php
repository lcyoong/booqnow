@extends($layout)

@section('content_above_list')
@include('expense.filter')
@endsection

@section('content_list')
  <table class="table table-condensed table-striped table-hover">
    <thead>
      <tr>
        <th>@lang('expense.exp_id')</th>
        <th>@lang('expense.exp_date')</th>
        <th>@lang('expense.exp_description')</th>
        <th class="text-right">{{ trans('expense.exp_amount') }}</th>
        <th>@lang('expense.exp_category')</th>
        <th>@lang('expense.exp_memo')</th>
        <th>@lang('expense.exp_account')</th>
        <th>@lang('expense.exp_status')</th>
        <th>@lang('form.actions')</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($list as $item)
        <tr>
          <td>{{ $item->exp_id }}</td>
          <td>{{ $item->exp_date }}</td>
          <td>{{ $item->exp_description }}</td>
          <td class="text-right">{{ showMoney($item->exp_amount) }}</td>
          <td>{{ $item->exp_category }} - {{ $category[$item->exp_category] }}</td>
          <td>{{ $item->exp_memo }}</td>
          <td>{{ array_get($account, $item->exp_account, '') }}</td>
          <td>{{ $item->exp_status }}</td>
          <td>
            <a v-modal href="{{ url(sprintf('expenses/%s/edit', $item->exp_id)) }}" title="@lang('form.edit')"><i class="fa fa-edit"></i></a>
            <a v-modal href="{{ url(sprintf('trail/expenses/%s', $item->exp_id)) }}" title="@lang('form.trail')"><i class="fa fa-history"></i></a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection

@prepend('content')
<div id="expense-list">
@include('layouts.list', ['count' => $list->total()])
{{ $list->appends(Request::input())->links() }}
</div>
@endprepend

@push('scripts')
<script>

new Vue({
  el: '#expense-list',
  components: {
  },
});

</script>
@endpush
