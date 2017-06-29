@extends($layout)

@section('content_above_list')
@include('report.monthly_units_sold_filter')
@endsection

@section('content_list')
@include('report.list', ['list' => $list])
@endsection

@prepend('content')
<div id="monthly-units-sold">
@include('layouts.list', ['count' => $list->total()])
{{ $list->appends(Request::input())->links() }}
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#monthly-units-sold",

  mixins: [mixForm, mixResponse],
})
</script>
@endprepend
