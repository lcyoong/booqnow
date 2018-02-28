<div class="panel panel-default">
  <div class="panel-heading">
    <a data-toggle="collapse" data-parent="#accordion" href="#{{ $id }}">
      <h4>{{ $addons->count() }} {{ $type or '' }}(s)</h4>
    </a>
  </div>
  <div id="{{ $id }}" class="panel-collapse collapse">
    <div class="panel-body">
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>@lang('addon.add_customer_name')</th>
            <th>@lang('addon.add_resource')</th>
            <th>@lang('addon.pax')</th>
            <th>@lang('addon.add_status')</th>
          </tr>
        </thead>
        <tbody>
          @foreach($addons as $addon)
            <tr>
              <td class="col-md-4">{{ $addon->add_customer_name }}
                <div><span class="label label-info">{{ $addon->booking->resource->rs_name or '' }}</span></div>
              </td>
              <td class="col-md-3">{{ $addon->resource->rs_name }} @ {{ $addon->add_date }}
                <div><span class="label label-success">{{ $addon->agent->ag_name or 'N/A' }}</span></div>
              </td>
              <td class="col-md-3">{{ $addon->add_pax }} @lang('addon.add_pax') + {{ $addon->add_pax_child }} @lang('addon.add_pax_child_simple')</td>
              <td class="col-md-2">{{ $addon->add_status }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
