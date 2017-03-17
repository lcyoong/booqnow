<table class="table table-hover table-striped">
<thead>
  <tr>
    <th>@lang('report.rep_filter')</th>
    <th>@lang('report.rep_status')</th>
    <th>@lang('report.created_at')</th>
    <th>@lang('form.created_by')</th>
    <th>@lang('form.actions')</th>
  </tr>
</thead>
<tbody>
  @foreach ($list as $item)
  <tr>
    <td>{{ urldecode(http_build_query($item->filter)) }}</td>
    <td>{{ $item->rep_status }}</td>
    <td>{{ $item->created_at }}</td>
    <td>{{ $item->creator->name }}</td>
    <td>@if(isset($item->rep_output_path)) <a href="{{ urlTenant('reports/download/' . $item->rep_id) }}"><i class="fa fa-download"></i></a> @endif</td>
  </tr>
  @endforeach
</tbody>
</table>
