@extends($layout)

@push('content')
@include('resource.basic_info', ['resource' => $resource])

<div id="maintenance-new">
<form-ajax action = "{{ urlTenant('resources/maintenance') }}" method="POST">
{{ Form::hidden('rm_resource', $resource->rs_id) }}
<div class="row">
  {{ Form::bsDate('rm_from', trans('resource.rm_from')) }}
  {{ Form::bsDate('rm_to', trans('resource.rm_to')) }}
  {{ Form::bsText('rm_description', trans('resource.rm_description')) }}
</div>
{{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary']) }}
<redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('resources/' . $resource_type->rty_id) }}"></redirect-btn>
</form-ajax>

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
        <post-ajax post-to="{{ urlTenant(sprintf("resources/%s/maintenance/%s/delete", $item->rm_resource, $item->rm_id)) }}"><i class="fa fa-trash"></i></post-ajax>
        <!-- <a href="#" postto="{{ urlTenant(sprintf("resources/%s/maintenance/%s/delete", $item->rm_resource, $item->rm_id)) }}" successreload><i class="fa fa-trash"></i></a> -->
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
@endpush

@prepend('scripts')
<script>
var now = new Vue({
    el: '#maintenance-new',

    created: function () {
    },

    data: {
      disabled: false,
      data: [],
    },
});
</script>
@endprepend
