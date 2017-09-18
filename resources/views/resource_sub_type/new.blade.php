@extends($layout)

@push('content')
<div id="resource-sub-type-new">
<form-ajax action = "{{ urlTenant('resource_sub_types/new') }}" method="POST" redirect-on-complete = "{{ urlTenant('resource_sub_types') }}" @startwait="startWait" @endwait="endWait">
  <div class="row">
    {{ Form::bsSelect('rsty_type', trans('resource_sub_type.rsty_type'), $dd_resource_types) }}
    {{ Form::bsText('rsty_name', trans('resource_sub_type.rsty_name')) }}
  </div>
  {{ Form::submit(trans('form.add'), ['class' => 'btn btn-primary']) }}
  {{ Form::close() }}
</form-ajax>
</div>
@endpush

@push('scripts')
<script>
new Vue ({

  el: "#resource-sub-type-new",

  mixins: [mixForm],
})
</script>
@endpush
