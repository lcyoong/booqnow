@if(count($items) > 0)
<table class="table">
  <thead>
    <tr>
      <th>@lang('addon.add_resource')</th>
      <th>@lang('addon.add_date')</th>
      <th>@lang('addon.add_pax')</th>
      <th>@lang('addon.add_unit')</th>
      <th>@lang('addon.add_reference')</th>
      <th>@lang('addon.add_tracking')</th>
    </tr>
  </thead>
  <tbody>
    @foreach($items as $item)
      <tr>
        <td>{{ $item->resource->rs_name }}</td>
        <td>{{ showDate($item->rc_date) }}</td>
        <td>{{ $item->add_pax }}</td>
        <td>{{ $item->add_unit }}</td>
        <td>{{ $item->add_reference }}</td>
        <td>{{ $item->add_tracking }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
@else
<div class="v_margin_10"><span class="label label-danger">@lang('form.no_itinerary')</span></div>
@endif
