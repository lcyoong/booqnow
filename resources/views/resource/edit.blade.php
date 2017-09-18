@extends($layout)

@prepend('content')
<div id="resource-edit">
  <!-- <a v-modal href="{{ url(sprintf('trail/resources/%s', $resource->rs_id)) }}" title="@lang('form.trail')"><i class="fa fa-history"></i></a> -->
  <form-ajax action = "{{ urlTenant('resources/update') }}" method="POST" @startwait="startWait" @endwait="endWait">
    {{ Form::hidden('rs_id', $resource->rs_id) }}
    <div class="row">
      {{ Form::bsText('rs_name', trans('resource.rs_name'), $resource->rs_name) }}
      {{ Form::bsText('rs_price', trans('resource.rs_price'), $resource->rs_price) }}
      {{ Form::bsSelect('rs_sub_type', trans('resource.rs_sub_type'), $sub_types, $resource->rs_sub_type) }}
    </div>
    <div class="row">
      {{ Form::bsText('rs_label', trans('resource.rs_label'), $resource->rs_label) }}
      {{ Form::bsTextarea('rs_description', trans('resource.rs_description'), $resource->rs_description) }}
      {{ Form::bsSelect('rs_status', trans('resource.rs_status'), $rs_status, $resource->rs_status, ['class' => 'select2', 'style' => 'width:100%']) }}
    </div>
    {{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary btn-sm']) }}
    <redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('resources/' . $resource_type->rty_id) }}" class="btn-sm"></redirect-btn>
  </form-ajax>
</div>
@endprepend

@prepend('scripts')
<script>
new Vue ({

  el: "#resource-edit",

  mixins: [mixForm],
})
</script>
@endprepend
