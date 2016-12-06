@extends($layout)

@push('content')
@include('booking.status_legend', ['book_status' => $book_status])
<div id="calendar"></div>
@endpush

@push('scripts')
<script>
$('#calendar').fullCalendar({
    defaultView: 'timelineFortnight',
    views: {
        timelineFortnight: {
            type: 'timelineMonth',
            duration: { days: 14 },
            slotDuration: {days: 1},
        }
    },
    // defaultDate: '2014-09-15',
    // slotDuration: {days: 1},
    // snapDuration : '24:00:00',
    // defaultDate: '{{ date('Y-m-d') }}',
    nowIndicator: true,
    // aspectRatio: 2,
    navLinks: true,
    // editable: true,
    resourceLabelText: 'Rooms',
    resourceRender: function(resource, cellEls) {
      cellEls.find('.fc-cell-text').append(' <span class="label label-info">' + resource.price + '</span>');
			cellEls.on('click', function() {
				if (confirm('Are you sure you want to delete ' + resource.title + '?')) {
					$('#calendar').fullCalendar('removeResource', resource);
				}
			});
		},
    resourceAreaWidth: '20%',
    resources: {
				url: '{{ urlTenant('api/v1/resources/1/active') }}',
        type: 'GET',
        // headers: {
        //     "X-CSRF-TOKEN": Laravel.csrfToken,
        // },
				error: function() {
					$('#script-warning').show();
				}
			},
    eventSources: [
      {
        url: '{{ urlTenant('api/v1/bookings/active') }}',
        type: 'GET',
        error: function() {
            console.log('there was an error while fetching events!');
        },
      },
      {
        url: '{{ urlTenant('api/v1/resources/1/maintenance') }}',
        type: 'GET',
        error: function() {
            console.log('there was an error while fetching events!');
        },
      }
    ],
    eventRender: function(event, element, view) {
      if (event.type == "booking") {
        element.find('.fc-title').append(' #' + event.id);
        element.find('.fc-title').prepend('<i class="fa fa-circle status-' + event.status + '"></i> ');
      } else if (event.type == "maintenance") {
        element.find('.fc-title').prepend('<i class="fa fa-wrench"></i> ');
      }
      $(".fc-rows table tbody tr .fc-widget-content div").addClass('fc-resized-row');
      $(".fc-content table tbody tr .fc-widget-content div").addClass('fc-resized-row');
      $(".fc-body .fc-resource-area .fc-cell-content").css('padding', '0px');
      },
    slotWidth: "70",
    selectable: true,
    selectOverlap: false,
    select: function(start, end, jsEvent, view, resource) {
      console.log(end);
      $('#basicModal').find('.modal-content').html('');
      $('#basicModal').modal('show');
      $('#basicModal').find('.modal-content').load('{{ urlTenant('bookings/new') }}?start=' + moment(start).format('Y-MM-D') + '&end=' + moment(end).format('Y-MM-D') + '&resource=' + resource.id);

    },
    eventClick: function(event) {
      if (event.type == "booking") {
        $('#basicModal').find('.modal-content').html('');
        $('#basicModal').modal('show');
        $('#basicModal').find('.modal-content').load('{{ urlTenant('bookings') }}/' + event.id);
      }
    },
});

// $('#calendar').fullCalendar('today');
// $('#calendar').fullCalendar( "gotoDate", 2016, 10, 12 );
// $('#calendar').fullCalendar('gotoDate', '2016-11-30');
</script>
@endpush
