@extends($layout)

@section('content_above_list')
@include('report.daily_tour_filter')
@endsection

@section('content_list')
@include('report.list', ['list' => $list])
@endsection

@prepend('content')
<div id="daily-tour">
@include('layouts.list', ['count' => $list->total()])
{{ $list->appends(Request::input())->links() }}
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#daily-tour",

  mixins: [mixForm, mixResponse],
})
</script>
@endprepend
