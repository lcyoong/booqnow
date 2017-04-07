@extends($layout)

@section('content_above_list')
@include('report.export_receipts_filter')
@endsection

@section('content_list')
@include('report.list', ['list' => $list])
@endsection

@prepend('content')
<div id="export-receipts">
@include('layouts.list', ['count' => $list->total()])
{{ $list->appends(Request::input())->links() }}
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#export-receipts",

  mixins: [mixForm, mixResponse],
})
</script>
@endprepend
