@extends($layout)

@section('content_above_list')
@include('report.pnl_filter')
@endsection

@section('content_list')
@include('report.list', ['list' => $list])
@endsection

@prepend('content')
<div id="pnl-new">
@include('layouts.list', ['count' => $list->total()])
{{ $list->appends(Request::input())->links() }}
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#pnl-new",

  mixins: [mixForm, mixResponse],
})
</script>
@endprepend
