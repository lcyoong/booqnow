@extends($layout)

@section('content_above_list')
@include('country.filter')
@endsection

@section('content_list')
  <table class="table table-condensed table-striped table-hover">
    <thead>
      <tr>
        <th>@lang('country.coun_name')</th>
        <th>@lang('country.coun_active')</th>
        <th>@lang('form.actions')</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($list as $item)
        <tr>
          <td>{{ $item->coun_name }}</td>
          <td>{{ $item->coun_active }}</td>
          <td>
            <a v-modal href="{{ url(sprintf('countries/%s/edit', $item->coun_code)) }}" title="@lang('form.edit')"><i class="fa fa-edit"></i></a>
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
