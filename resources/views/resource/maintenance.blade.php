@extends($layout)

@push('content')
{{ Form::open(['url' => urlTenant('resources/maintenance'), 'v-ajax', 'successreload']) }}
{{ Form::hidden('rm_resource', $resource->rs_id) }}
<div class="row">
  {{ Form::bsDate('rm_from', trans('resource.rm_from')) }}
  {{ Form::bsDate('rm_to', trans('resource.rm_to')) }}
  {{ Form::bsText('rm_description', trans('resource.rm_description')) }}
</div>
{{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary']) }}
<redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('resources/' . $resource_type->rty_id) }}"></redirect-btn>
{{ Form::close() }}

<table class="table table-condensed">
  <thead>
    <tr>
      <th>@lang('resource.period')</th>
      <th>@lang('resource.rm_description')</th>
      <th>@lang('form.actions')</th>
    </tr>
  </thead>
  <tbody>
    @foreach($maintenance_list as $item)
    <tr>
      <td>{{ showDate($item->rm_from) }} - {{ showDate($item->rm_to) }} <span class="label label-info">{{ dayDiff($item->rm_from, $item->rm_to) }} @lang('resource.maintenance_diff_units')</span></td>
      <td>{{ $item->rm_description }}</td>
      <td>
        <a href="#" postto="{{ urlTenant(sprintf("resources/%s/maintenance/%s/delete", $item->rm_resource, $item->rm_id)) }}" successreload v-post><i class="fa fa-trash"></i></a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endpush
