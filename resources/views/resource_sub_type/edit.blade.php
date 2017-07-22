@extends($layout)

@push('content')
<div id="resource-sub-type-edit">
<form-ajax action = "{{ urlTenant('resource_sub_types/update') }}" method="POST" redload-on-complete = "1" @startwait="startWait" @endwait="endWait">
{{ Form::hidden('rsty_id', $resource_sub_type->rsty_id) }}
<div class="row">
  {{ Form::bsSelect('rsty_type', trans('resource_sub_type.rsty_type'), $dd_resource_types, $resource_sub_type->rsty_type) }}
  {{ Form::bsText('rsty_name', trans('resource_sub_type.rsty_name'), $resource_sub_type->rsty_name) }}
</div>
{{ Form::submit(trans('form.save'), ['class' => 'btn btn-primary']) }}
</form-ajax>
</div>
@endpush

@push('scripts')
<script>
new Vue ({

  el: "#resource-sub-type-edit",

  mixins: [mixForm],
})
</script>
@endpush
