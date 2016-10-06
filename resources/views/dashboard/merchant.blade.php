@extends('layouts.tenant')
@section('content_tenant')
<div id="calendar"></div>
@endsection
@section('script_tenant')
<script>
$('#calendar').fullCalendar({
    defaultView: 'timelineDay',
    events: [      
        // events go here
    ],
    resources: [
    ],
    slotWidth: "50",
});
</script>
@endsection
