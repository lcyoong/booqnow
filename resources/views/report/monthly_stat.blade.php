@extends($layout)

@section('content_above_list')
@include('report.monthly_stat_filter')
@endsection

@section('content_list')
@include('report.list', ['list' => $list])
@endsection

@prepend('content')
<div id="monthly-stat">
@include('layouts.list', ['count' => $list->total()])
{{ $list->appends(Request::input())->links() }}
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#monthly-stat",

  mixins: [mixForm, mixResponse],
})
</script>
@endprepend
