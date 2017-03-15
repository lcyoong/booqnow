@if(count($items) > 0)
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>@lang('addon.add_resource')</th>
      <th>@lang('addon.add_date')</th>
      <!-- <th>@lang('addon.add_pax')</th> -->
      <th>@lang('addon.add_unit')</th>
      <th>@lang('addon.add_reference')</th>
      <th>@lang('addon.add_status')</th>
    </tr>
  </thead>
  <tbody>
    @foreach($items as $item)
    @if($item->resource->rs_type == $type->rty_id)
      <tr>
        <td>{{ $item->resource->rs_name }}</td>
        <td>{{ showDate($item->rc_date) }}</td>
        <!-- <td>{{ $item->add_pax }}</td> -->
        <td>{{ $item->add_unit }}</td>
        <td>{{ $item->add_reference }}</td>
        <td>{{ $add_status[$item->add_status] }}</td>
      </tr>
    @endif
    @endforeach
  </tbody>
</table>
@else
<div class="v_margin_10"><span class="label label-danger">@lang('form.no_itinerary')</span></div>
@endif
<a href="{{ urlTenant(sprintf("addons/%s/new/booking/%s/" . ($type->rty_pos ? '1' : ''), $type->rty_id, $booking->book_id)) }}" v-modal><button class="btn btn-primary btn-sm"><i class="fa {{ config('myapp.icon-' . $type->rty_code) }}"></i> @lang('form.add_itinerary', ['name' => $type->rty_name])</button></a>
