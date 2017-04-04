@extends($layout)

@section('content_above_list')
@include('report.occupancy_by_day_filter')
@endsection

@section('content_list')
@include('report.list', ['list' => $list])
@endsection

@prepend('content')
<div id="daily-new">
@include('layouts.list', ['count' => $list->total()])
{{ $list->appends(Request::input())->links() }}
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#daily-new",

  mixins: [mixForm, mixResponse],
})
</script>
@endprepend
