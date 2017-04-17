@extends($layout)

@prepend('content')
<div id="resource-new">
<form-ajax action = "{{ urlTenant('resources/new') }}" method="POST" redirect-on-complete = "{{ urlTenant('resources/' . $resource_type->rty_id) }}" @startwait="startWait" @endwait="endWait">
  {{ Form::hidden('rs_type', $resource_type->rty_id) }}
  <div class="row">
    {{ Form::bsText('rs_name', trans('resource.rs_name')) }}
    {{ Form::bsText('rs_price', trans('resource.rs_price')) }}
  </div>
  <div class="row">
    {{ Form::bsText('rs_label', trans('resource.rs_label')) }}
    {{ Form::bsTextarea('rs_description', trans('resource.rs_description')) }}
  </div>
  {{ Form::submit(trans('form.add'), ['class' => 'btn btn-primary']) }}
  <redirect-btn label="@lang('form.cancel')" redirect="{{ urlTenant('resources/' . $resource_type->rty_id) }}"></redirect-btn>
</form-ajax>
</div>
@endprepend

@push('scripts')
<script>
new Vue ({

  el: "#resource-new",

  mixins: [mixForm],
})
</script>
@endpush
