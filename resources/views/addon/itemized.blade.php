<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>@lang('addon.add_resource')</th>
      <th>@lang('addon.add_date')</th>
      <!-- <th>@lang('addon.add_pax')</th> -->
      <th>@lang('addon.add_pax')</th>
      <th>@lang('addon.add_pax_child')</th>
      <th>@lang('addon.add_remarks')</th>
      <th>@lang('addon.add_agent')</th>
      <th>@lang('addon.add_status')</th>
    </tr>
  </thead>
  <tbody>
    @foreach($items as $item)
    @if($item->resource->rs_type == $type->rty_id)
      <tr>
        <td>{{ $item->resource->rs_name }}</td>
        <td>{{ showDateTime($item->add_date) }}</td>
        <!-- <td>{{ $item->add_pax }}</td> -->
        <td>{{ $item->add_pax }}</td>
        <td>{{ $item->add_pax_child }}</td>
        <td>{{ $item->add_remarks }}</td>
        <td>{{ isset($item->agent) ? $item->agent->ag_name : trans('form.na') }}</td>
        <td>{{ $add_status[$item->add_status] }}</td>
      </tr>
    @endif
    @endforeach
  </tbody>
</table>
<a href="{{ urlTenant(sprintf("addons/%s/new/booking/%s/" . ($type->rty_pos ? '1' : ''), $type->rty_id, $booking->book_id)) }}" v-modal><button class="btn btn-primary btn-sm">@lang('form.add_itinerary', ['name' => $type->rty_name])</button></a>
